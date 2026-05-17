<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\GuestMessage;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RSVPController extends Controller
{
    public function store($slug, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'attendance' => 'required|in:hadir,tidak_hadir,ragu',
            'guest_count' => 'nullable|integer|min:1|max:10',
            'unique_code' => 'nullable|string|exists:guests,unique_code',
        ]);

        $wedding = Wedding::where('slug', $slug)->firstOrFail();

        // STRATEGI MATCHING: Prioritaskan unique_code
        $guest = null;

        if (!empty($validated['unique_code'])) {
            // Match by unique_code (paling akurat)
            $guest = Guest::where('wedding_id', $wedding->id)
                ->where('unique_code', $validated['unique_code'])
                ->first();
        }

        // Fallback: Match by name (case-insensitive)
        if (!$guest) {
            $guest = Guest::where('wedding_id', $wedding->id)
                ->whereRaw('LOWER(name) = ?', [strtolower(trim($validated['name']))])
                ->first();
        }

        try {
            DB::beginTransaction();

            if ($guest) {
                // UPDATE existing guest (bukan blokir)
                $guest->update([
                    'status' => $validated['attendance'],
                    'guest_count' => $validated['guest_count'] ?? $guest->guest_count,
                    'updated_at' => now(),
                ]);

                $message = 'RSVP berhasil diupdate. Terima kasih!';
            } else {
                // Create new guest (tamu baru)
                $guest = Guest::create([
                    'wedding_id' => $wedding->id,
                    'name' => $validated['name'],
                    'status' => $validated['attendance'],
                    'guest_count' => $validated['guest_count'] ?? 1,
                    'unique_code' => Str::random(8),
                ]);

                $message = 'RSVP berhasil dikirim. Terima kasih!';
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'guest' => $guest->only(['id', 'name', 'status', 'unique_code'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('RSVP store failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi.'
            ], 500);
        }
    }
}
