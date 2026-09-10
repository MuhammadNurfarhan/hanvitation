<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WeddingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Base query
        $query = $user->isAdmin()
            ? Wedding::query()
            : $user->weddings();

        // Hitung stats SEBELUM pagination (menggunakan query builder, bukan collection)
        $totalWeddings = (clone $query)->count();

        $publishedWeddings = (clone $query)->where('is_published', true)->count();

        // Untuk total guests, kita perlu join/subquery karena relasi
        $totalGuests = (clone $query)
            ->withCount('guests')
            ->get()
            ->sum('guests_count');

        // Pagination untuk table display
        $weddings = $query->withCount('guests')->latest()->paginate(10);

        return view('admin.weddings.index', compact(
            'weddings',
            'totalWeddings',      // ✅ Pass sebagai variable terpisah
            'publishedWeddings',  // ✅
            'totalGuests'         // ✅
        ));
    }

    public function create()
    {
        return view('admin.weddings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'groom_name' => 'required|string|max:255',
            'groom_first_name' => 'required|string|max:100',
            'groom_father_name' => 'required|string|max:255',
            'groom_mother_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'bride_first_name' => 'required|string|max:100',
            'bride_father_name' => 'required|string|max:255',
            'bride_mother_name' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'quote' => 'nullable|string|max:500',
            'quote_source' => 'nullable|string|max:100',
            'cover_image' => 'nullable|image|max:5048',
            'envelope_image' => 'nullable|image|max:5048',
            'music_file' => 'nullable|file|mimes:mp3,wav,ogg|max:10480',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('weddings/covers', 'public');
        }

        // Handle envelope image upload
        if ($request->hasFile('envelope_image')) {
            $validated['envelope_image'] = $request->file('envelope_image')->store('weddings/envelopes', 'public');
        }

        // Handle music upload
        if ($request->hasFile('music_file')) {
            $validated['music_file'] = $request->file('music_file')->store('weddings/music', 'public');
        }

        $wedding = Auth::user()->weddings()->create([
            ...$validated,
            'user_id' => Auth::id(),
            'slug' => Str::slug($validated['groom_first_name'] . '-' . $validated['bride_first_name']) . '-' . Str::random(5),
        ]);

        return redirect()->route('weddings.edit', $wedding)
            ->with('success', '✅ Wedding created successfully!');
    }

    public function show(Wedding $wedding)
    {
        // Authorization: hanya owner atau admin yang bisa lihat
        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        $wedding->load(['events', 'guests', 'gallery', 'bankAccounts']);
        return view('admin.weddings.show', compact('wedding'));
    }

    public function edit(Wedding $wedding)
    {
        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        return view('admin.weddings.edit', compact('wedding'));
    }

    public function update(Request $request, Wedding $wedding)
    {
        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'groom_name' => 'required|string|max:255',
            'groom_first_name' => 'required|string|max:100',
            'groom_father_name' => 'required|string|max:255',
            'groom_mother_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'bride_first_name' => 'required|string|max:100',
            'bride_father_name' => 'required|string|max:255',
            'bride_mother_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'quote' => 'nullable|string|max:500',
            'quote_source' => 'nullable|string|max:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'envelope_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'groom_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'bride_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'music_file' => 'nullable|file|mimes:mp3,wav,ogg|max:10480',
            'is_published' => 'boolean',
        ]);

        // Handle envelope image update (hapus file lama dulu)
        if ($request->hasFile('envelope_image')) {
            if ($wedding->envelope_image) {
                Storage::disk('public')->delete($wedding->envelope_image);
            }
            $validated['envelope_image'] = $request->file('envelope_image')->store('weddings/envelopes', 'public');
        }

        // Opsional: hapus envelope image (kembali fallback ke cover)
        if ($request->has('delete_envelope_image') && $wedding->envelope_image) {
            Storage::disk('public')->delete($wedding->envelope_image);
            $validated['envelope_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($wedding->cover_image) {
                Storage::disk('public')->delete($wedding->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('weddings/covers', 'public');
        }

        if ($request->hasFile('groom_photo')) {
            if ($wedding->groom_photo) {
                Storage::disk('public')->delete($wedding->groom_photo);
            }
            $validated['groom_photo'] = $request->file('groom_photo')->store('weddings/couple', 'public');
        }

        if ($request->hasFile('bride_photo')) {
            if ($wedding->bride_photo) {
                Storage::disk('public')->delete($wedding->bride_photo);
            }
            $validated['bride_photo'] = $request->file('bride_photo')->store('weddings/couple', 'public');
        }

        // Cek jika user ingin menghapus musik
        if ($request->has('delete_music') && $wedding->music_file) {
            Storage::disk('public')->delete($wedding->music_file);
            $validated['music_file'] = null;
        }

        // Cek jika ada file baru diupload
        if ($request->hasFile('music_file')) {
            if ($wedding->music_file) {
                Storage::disk('public')->delete($wedding->music_file);
            }
            $validated['music_file'] = $request->file('music_file')->store('weddings/music', 'public');
        }

        $wedding->update($validated);

        return redirect()->route('weddings.edit', $wedding)
            ->with('success', '✅ Wedding updated successfully!');
    }

    public function destroy(Wedding $wedding)
    {
        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete cover image
        if ($wedding->cover_image) {
            Storage::disk('public')->delete($wedding->cover_image);
        }

        $wedding->delete();

        return redirect()->route('weddings.index')
            ->with('success', '✅ Wedding deleted successfully!');
    }

    public function publish(Wedding $wedding)
    {
        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        // ✅ VALIDASI: Foto mempelai wajib ada sebelum publish
        $missingPhotos = [];

        if (!$wedding->groom_photo) {
            $missingPhotos[] = 'foto mempelai putra';
        }
        if (!$wedding->bride_photo) {
            $missingPhotos[] = 'foto mempelai putri';
        }

        if (!empty($missingPhotos)) {
            return redirect()->route('weddings.edit', $wedding)
                ->with('error',
                    'Tidak dapat publish: ' . implode(' dan ', $missingPhotos) . ' belum diupload. ' .
                    'Silakan upload foto di tab "Couple" terlebih dahulu.'
                );
        }

        // ✅ Semua validasi lolos, publish wedding
        $wedding->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        return redirect()->route('weddings.edit', $wedding)
            ->with('success', '🎉 Undangan berhasil dipublish! Link: ' . $wedding->getInvitationUrlAttribute());
    }

    public function addEvent(Request $request, $weddingId)
    {
        // Find wedding manually
        $wedding = Wedding::findOrFail($weddingId);

        // Authorization
        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|in:misa,resepsi,akad,ramah_tamah',
            'venue_name' => 'required|string|max:255',
            'address' => 'required|string',
            'maps_link' => 'nullable|url',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'description' => 'nullable|string|max:500',
        ]);

        $wedding->events()->create($validated);

        return redirect()->route('weddings.edit', $wedding)
            ->with('success', '✅ Event added successfully!');
    }

    public function updateEvent(Request $request, $weddingId, $eventId)
    {
        // Find wedding manually
        $wedding = Wedding::findOrFail($weddingId);

        // Authorization
        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        // Find event manually dengan filter wedding_id
        $event = $wedding->events()->findOrFail($eventId);

        $validated = $request->validate([
            'type' => 'required|in:misa,resepsi,akad,ramah_tamah',
            'venue_name' => 'required|string|max:255',
            'address' => 'required|string',
            'maps_link' => 'nullable|url',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'description' => 'nullable|string|max:500',
        ]);

        $event->update($validated);

        return redirect()->route('weddings.edit', $wedding)
            ->with('success', '✅ Event updated successfully!');
    }

    public function uploadGallery(Request $request, Wedding $wedding)
    {
        // Authorization
        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:5048', // Max 5MB
            'caption' => 'nullable|string|max:255',
        ]);

        foreach ($request->file('photos') as $photo) {
            // Generate unique filename to avoid collision
            $filename = time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('weddings/gallery', $filename, 'public');

            $wedding->gallery()->create([
                'url' => $path,  // ✅ Sekarang aman karena 'url' sudah di $fillable
                'caption' => $request->caption ?? null,
                'order' => $wedding->gallery()->count(), // Auto-order
            ]);
        }

        return redirect()->route('weddings.edit', $wedding)
            ->with('success', '✅ Photos uploaded successfully!');
    }

    public function addBankAccount(Request $request, Wedding $wedding)
    {
        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:255',
        ]);

        $wedding->bankAccounts()->create($validated);

        return redirect()->route('weddings.edit', $wedding)
            ->with('success', '✅ Bank account added successfully!');
    }

    /**
     * Delete an event from wedding
     */
    public function deleteEvent($weddingId, $eventId)
    {
        // Find wedding manually
        $wedding = Wedding::findOrFail($weddingId);

        // Authorization
        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        // Find event dengan filter wedding_id (pastikan event milik wedding ini)
        $event = $wedding->events()->findOrFail($eventId);

        $event->delete();

        return redirect()->route('weddings.edit', $wedding)
            ->with('success', '✅ Event deleted successfully!');
    }

    /**
     * Delete a gallery photo from wedding
     */
    public function deleteGallery($weddingId, $photoId)
    {
        $wedding = Wedding::findOrFail($weddingId);

        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        $photo = $wedding->gallery()->findOrFail($photoId);

        if ($photo->url && Storage::disk('public')->exists($photo->url)) {
            Storage::disk('public')->delete($photo->url);
        }

        $photo->delete();

        return redirect()->route('weddings.edit', $wedding)
            ->with('success', '✅ Photo deleted successfully!');
    }

    /**
     * Delete a bank account from wedding
     */
    public function deleteBankAccount($weddingId, $bankId)
    {
        $wedding = Wedding::findOrFail($weddingId);

        if (!Auth::user()->isAdmin() && $wedding->user_id !== Auth::id()) {
            abort(403);
        }

        $bank = $wedding->bankAccounts()->findOrFail($bankId);
        $bank->delete();

        return redirect()->route('weddings.edit', $wedding)
            ->with('success', '✅ Bank account deleted successfully!');
    }
}
