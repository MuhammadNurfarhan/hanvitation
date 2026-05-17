<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuestsImport;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Filter wedding (admin bisa pilih, couple hanya wedding sendiri)
        $weddingId = $request->query('wedding_id');

        if ($user->isAdmin()) {
            $weddings = Wedding::all();
            $query = Guest::query();

            if ($weddingId) {
                $query->where('wedding_id', $weddingId);
            }
        } else {
            $weddings = $user->weddings;
            $query = Guest::whereIn('wedding_id', $user->weddings->pluck('id'));
        }

        $guests = $query->with('wedding')
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->latest()
            ->paginate(25);

        return view('admin.guests.index', compact('guests', 'weddings', 'weddingId'));
    }

    public function import(Request $request)
    {
        Log::info('=== IMPORT START ===', [
            'file_name' => $request->file('file')?->getClientOriginalName(),
            'file_mime' => $request->file('file')?->getMimeType(),
            'file_extension' => $request->file('file')?->getClientOriginalExtension(),
        ]);

        $request->validate([
            'wedding_id' => 'required|exists:weddings,id',
            // ✅ Gunakan extensions: untuk validasi lebih reliable
            'file' => 'required|extensions:xlsx,xls,csv|max:10240',
        ]);

        $wedding = Wedding::findOrFail($request->wedding_id);

        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            $import = new GuestsImport($wedding->id);

            Log::info('Starting Excel::import()');
            Excel::import($import, $request->file('file'));
            Log::info('Excel::import() completed', ['stats' => $import->stats]);

            $stats = $import->stats;
            $total = $stats['imported'] + $stats['updated'];

            if ($total === 0) {
                Log::warning('Import completed but 0 rows processed');
                return back()->with('error', '⚠️ Tidak ada data yang diimport. Pastikan file Excel memiliki header: name, phone, email, guest_count');
            }

            return redirect()->route('guests.index', ['wedding_id' => $wedding->id])
                ->with('success', "✅ Import Berhasil! Total: {$total} data (Baru: {$stats['imported']}, Diupdate: {$stats['updated']})");

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            Log::warning('Import validation failed', ['errors' => array_slice($errors, 0, 5)]);

            return back()->with('error', '⚠️ Validasi Gagal:<br>' . implode('<br>', array_slice($errors, 0, 3)))
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Import exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', config('app.debug')
                ? "❌ Error: {$e->getMessage()}"
                : 'Import gagal. Cek log untuk detail.');
        }
    }

    public function export(Request $request)
    {
        // Simple export to CSV for now
        $guests = Auth::user()->isAdmin()
            ? Guest::with('wedding')->get()
            : Guest::whereHas('wedding', fn($q) => $q->where('user_id', Auth::id()))
                ->with('wedding')
                ->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=guests-export-".date('Y-m-d').".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Name', 'Phone', 'Email', 'Wedding', 'Status', 'Guest Count', 'Unique Code'];

        $callback = function() use ($guests, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($guests as $guest) {
                fputcsv($file, [
                    $guest->name,
                    $guest->phone,
                    $guest->email,
                    $guest->wedding?->groom_first_name . ' & ' . $guest->wedding?->bride_first_name,
                    $guest->status_label,
                    $guest->guest_count,
                    $guest->unique_code
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function show(Guest $guest)
    {
        if (!Auth::user()->isAdmin() && $guest->wedding->user_id !== Auth::id()) {
            abort(403);
        }

        return view('admin.guests.show', compact('guest'));
    }

    /**
     * Generate WhatsApp link untuk kirim undangan ke 1 tamu
     */
    public function sendInvitation(Guest $guest)
    {
        // Authorization
        if (!Auth::user()->isAdmin() && $guest->wedding->user_id !== Auth::id()) {
            abort(403);
        }

        // Validasi phone
        if (!$guest->phone) {
            return back()->with('error', 'Nomor WhatsApp tamu belum diisi.');
        }

        // Format phone: hapus non-digit, pastikan format internasional
        $phone = preg_replace('/[^0-9]/', '', $guest->phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1); // 0812... → 62812...
        }

        // Generate pesan WhatsApp
        $wedding = $guest->wedding;
        $eventDate = \Carbon\Carbon::parse($wedding->event_date)->isoFormat('dddd, D MMMM YYYY');

        $message = urlencode(
            "Yth. Bapak/Ibu/Sdr/i \n" .
            "{$guest->name}\n\n" .
            "Assalamu'alaikum Wr. Wb. / Salam Sejahtera Bagi Kita Semua, \n\n" .
            "Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i {$guest->name} untuk menghadiri acara pernikahan kami.\n\n" .
            "{$wedding->groom_name}\n" .
            "       &\n" .
            "{$wedding->bride_name}\n\n" .
            "Berikut link undangan kami:\n" .
            "{$guest->invitation_url}\n\n" .
            "Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\n" .
            "Terimakasih banyak atas perhatiannya.\n\n" .
            "Hormat Kami,\n" .
            "{$wedding->groom_first_name} & {$wedding->bride_first_name}"
        );

        // Generate WhatsApp link
        $waLink = "https://wa.me/{$phone}?text={$message}";

        // Update status: sudah dikirim
        $guest->update(['is_sent' => true, 'sent_at' => now()]);

        return redirect()->back()
            ->with('success', 'Undangan siap dikirim ke WhatsApp!')
            ->with('wa_link', $waLink)
            ->with('guest_name', $guest->name);
    }

    /**
     * Generate WhatsApp link untuk kirim ke banyak tamu (bulk)
     */
    public function bulkSend(Request $request)
    {
        $request->validate([
            'guest_ids' => 'required|array',
            'guest_ids.*' => 'exists:guests,id',
        ]);

        $guests = Guest::whereIn('id', $request->guest_ids)
            ->whereHas('wedding', function($q) {
                if (!Auth::user()->isAdmin()) {
                    $q->where('user_id', Auth::id());
                }
            })
            ->with('wedding')
            ->get();

        if ($guests->isEmpty()) {
            return back()->with('error', 'Tidak ada tamu yang valid untuk dikirim.');
        }

        // Generate list link WhatsApp
        $waLinks = [];
        foreach ($guests as $guest) {
            if (!$guest->phone) continue;

            $phone = preg_replace('/[^0-9]/', '', $guest->phone);
            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            }

            $wedding = $guest->wedding;
            $eventDate = \Carbon\Carbon::parse($wedding->event_date)->isoFormat('dddd, D MMMM YYYY');

            $message = urlencode(
                "Yth. Bapak/Ibu/Sdr/i \n" .
                "{$guest->name}\n\n" .
                "Assalamu'alaikum Wr. Wb. / Salam Sejahtera Bagi Kita Semua, \n\n" .
                "Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i {$guest->name} untuk menghadiri acara pernikahan kami.\n\n" .
                "{$wedding->groom_name}\n" .
                "       &\n" .
                "{$wedding->bride_name}\n\n" .
                "Berikut link undangan kami:\n" .
                "{$guest->invitation_url}\n\n" .
                "Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\n" .
                "Terimakasih banyak atas perhatiannya.\n\n" .
                "Hormat Kami,\n" .
                "{$wedding->groom_first_name} & {$wedding->bride_first_name}"
            );

            $waLinks[] = [
                'name' => $guest->name,
                'phone' => $phone,
                'link' => "https://wa.me/{$phone}?text={$message}"
            ];

            // Update status
            $guest->update(['is_sent' => true, 'sent_at' => now()]);
        }

        return redirect()->back()
            ->with('success', "{$guests->count()} undangan siap dikirim via WhatsApp!")
            ->with('wa_links', $waLinks);
    }

    public function destroy(Guest $guest)
    {
        // Authorization: pastikan user berhak menghapus
        if (!Auth::user()->isAdmin() && $guest->wedding->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus guest (pastikan tidak ada foreign key constraint)
        // $guest->messages()->delete();
        // $guest->rsvps()->delete();
        $guest->delete();

        return redirect()->route('guests.index')
            ->with('success', '✅ Guest deleted successfully!');
    }
}
