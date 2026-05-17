<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Wedding;
use App\Models\Guest;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    /**
     * Show the guest invitation page
     */
    public function show($slug, Request $request)
    {
        // Load wedding dengan semua relationships yang dibutuhkan frontend
        $wedding = Wedding::with([
            'events',                    // Semua event (untuk fallback)
            'churchEvent',               // Misa pernikahan (khusus)
            'receptionEvent',            // Resepsi (khusus)
            'gallery' => function($q) {  // Gallery diurutkan
                $q->orderBy('order')->orderBy('created_at');
            },
            'bankAccounts' => function($q) { // Rekening diurutkan
                $q->orderBy('order')->where('is_active', true);
            },
            'guestMessages' => function($q) { // Buku tamu: approved, terbaru, limit 50
                $q->where('is_approved', true)
                  ->latest()
                  ->limit(50);
            }
        ])
        ->where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

        // Ambil nama tamu dari query parameter
        $guestName = $request->query('untuk', '');

        // Optional: Track view/analytics
        // You can add: $wedding->increment('view_count');

        // Return view yang sesuai dengan file yang kita buat
        return view('guest.invitation', compact('wedding', 'guestName'));
    }
}
