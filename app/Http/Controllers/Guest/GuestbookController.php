<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Wedding;
use App\Models\GuestMessage;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GuestbookController extends Controller
{
    public function index($slug)
    {
        $wedding = Wedding::where('slug', $slug)->firstOrFail();

        $messages = GuestMessage::where('wedding_id', $wedding->id)
            ->where('is_approved', true)
            ->whereNotNull('message')
            ->where('message', '!=', '')
            ->latest()
            ->paginate(10);

        $messages->getCollection()->transform(function ($message) {
            $message->diff_for_humans = \Carbon\Carbon::parse($message->created_at)->diffForHumans();
            return $message;
        });

        return response()->json([
            'success' => true,
            'messages' => $messages->items(),
            'pagination' => [
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total(),
                'has_more' => $messages->hasMorePages(),
                'next_page' => $messages->currentPage() < $messages->lastPage()
                    ? $messages->currentPage() + 1
                    : null,
            ]
        ]);
    }

    public function store($slug, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'attendance_status' => 'nullable|in:hadir,tidak_hadir,ragu',
            'unique_code' => 'nullable|string|exists:guests,unique_code',
        ]);

        $wedding = Wedding::where('slug', $slug)->firstOrFail();

        // STRATEGI MATCHING: Cari guest yang sesuai
        $guest = null;

        if (!empty($validated['unique_code'])) {
            $guest = Guest::where('wedding_id', $wedding->id)
                ->where('unique_code', $validated['unique_code'])
                ->first();
        }

        if (!$guest && !empty($validated['name'])) {
            // Fallback: match by name (case-insensitive)
            $guest = Guest::where('wedding_id', $wedding->id)
                ->whereRaw('LOWER(name) = ?', [strtolower(trim($validated['name']))])
                ->first();
        }

        // CHECK: Apakah tamu sudah kirim pesan? (opsional, bisa di-remove jika ingin izinkan multiple)
        if ($guest) {
            $existingMessage = GuestMessage::where('wedding_id', $wedding->id)
                ->where('guest_id', $guest->id)
                ->where('message', '!=', null) // Hanya cek jika ada pesan sebelumnya
                ->first();

            if ($existingMessage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mengirim ucapan sebelumnya. Terima kasih!'
                ], 409);
            }
        }

        // AUTO-SYNC ATTENDANCE STATUS
        $finalAttendanceStatus = $validated['attendance_status'];
        if ($guest && empty($finalAttendanceStatus)) {
            $finalAttendanceStatus = $guest->status;
        }

        try {
            DB::beginTransaction();

            $guestMessage = GuestMessage::updateOrCreate(
                [
                    'wedding_id' => $wedding->id,
                    'guest_id' => $guest?->id,
                    // Jika guest tidak ditemukan, match by sender_name
                    'sender_name' => $guest?->name ?? $validated['name'],
                ],
                [
                    'message' => $validated['message'],
                    'attendance_status' => $finalAttendanceStatus,
                    'is_approved' => true,
                ]
            );

            // Update guest data jika ditemukan
            if ($guest) {
                $guest->update([
                    'message' => $validated['message'],
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ucapan berhasil dikirim!',
                'action' => $guestMessage->wasRecentlyCreated ? 'created' : 'updated'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Guestbook store failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi.'
            ], 500);
        }
    }
}
