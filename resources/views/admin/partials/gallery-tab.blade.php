<div class="space-y-6">

    {{-- Upload Form --}}
    <form action="{{ route('weddings.gallery.upload', $wedding) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <x-input-label for="photos" value="📸 Upload Photos" />
            <input type="file" name="photos[]" multiple accept="image/*" required
                class="mt-1 block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
            <p class="mt-1 text-xs text-stone-500">Select multiple images (JPG/PNG, max 5MB each)</p>
        </div>
        {{-- <div>
            <x-input-label for="caption" value="Caption (Optional)" />
            <x-text-input name="caption" type="text" class="mt-1 block w-full" placeholder="Pre-wedding at the beach..." />
        </div> --}}
        <x-primary-button type="submit">Upload Photos</x-primary-button>
    </form>

    {{-- Gallery Grid --}}
    <div>
        <h4 class="font-medium text-stone-900 mb-3">Existing Photos ({{ $wedding->gallery->count() }})</h4>
        @if($wedding->gallery->isEmpty())
            <p class="text-center text-stone-500 py-8 bg-stone-50 rounded-xl">No photos uploaded yet.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($wedding->gallery as $photo)
                <div class="relative group aspect-square">
                    {{-- ✅ Gunakan langsung $photo->url (sudah full URL dari accessor) --}}
                    <img src="{{ $photo->url }}"
                        class="w-full h-full object-cover rounded-xl shadow-sm"
                        alt="Gallery" loading="lazy"
                        onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';">

                    @if($photo->caption)
                    <div class="absolute bottom-0 left-0 right-0 bg-black/60 text-white text-xs p-2 rounded-b-xl truncate">
                        {{ $photo->caption }}
                    </div>
                    @endif

                    <form action="{{ route('weddings.gallery.destroy', [$wedding, $photo]) }}" method="POST" class="absolute top-2 right-2">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-700" onclick="return confirm('Delete this photo?')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
