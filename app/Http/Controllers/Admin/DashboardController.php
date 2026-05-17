<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wedding;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admin: lihat semua data
            $totalWeddings = Wedding::count();
            $totalGuests = Guest::count();
            $confirmedGuests = Guest::where('status', 'hadir')->count();
            $recentWeddings = Wedding::withCount('guests')->latest()->take(5)->get();
        } else {
            // Couple: hanya lihat wedding miliknya
            $totalWeddings = $user->weddings()->count();

            // Hitung total guests dengan query yang lebih aman
            $totalGuests = $user->weddings()
                ->withCount('guests')
                ->get()
                ->sum('guests_count');

            $confirmedGuests = Guest::whereIn('wedding_id', $user->weddings()->pluck('id'))
                ->where('status', 'hadir')
                ->sum('guest_count');

            $recentWeddings = $user->weddings()->withCount('guests')->latest()->take(5)->get();
        }

        return view('dashboard', compact(
            'totalWeddings',
            'totalGuests',
            'confirmedGuests',
            'recentWeddings'
        ));
    }
}
