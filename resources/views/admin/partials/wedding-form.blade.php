<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method($method ?? 'PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Groom --}}
        <div class="space-y-4">
            <h4 class="font-medium text-stone-700 border-b border-stone-200 pb-2">🤵 Groom</h4>

            <div>
                <x-input-label for="groom_name" value="Full Name *" />
                <x-text-input id="groom_name" name="groom_name" type="text"
                              class="mt-1 block w-full" :value="old('groom_name', $wedding->groom_name ?? '')" required />
                <x-input-error :messages="$errors->get('groom_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="groom_first_name" value="First Name (for URL) *" />
                <x-text-input id="groom_first_name" name="groom_first_name" type="text"
                              class="mt-1 block w-full" :value="old('groom_first_name', $wedding->groom_first_name ?? '')" required />
                <x-input-error :messages="$errors->get('groom_first_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="groom_father_name" value="Father's Name *" />
                <x-text-input id="groom_father_name" name="groom_father_name" type="text"
                              class="mt-1 block w-full" :value="old('groom_father_name', $wedding->groom_father_name ?? '')" required />
                <x-input-error :messages="$errors->get('groom_father_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="groom_mother_name" value="Mother's Name *" />
                <x-text-input id="groom_mother_name" name="groom_mother_name" type="text"
                              class="mt-1 block w-full" :value="old('groom_mother_name', $wedding->groom_mother_name ?? '')" required />
                <x-input-error :messages="$errors->get('groom_mother_name')" class="mt-2" />
            </div>
        </div>

        {{-- Bride --}}
        <div class="space-y-4">
            <h4 class="font-medium text-stone-700 border-b border-stone-200 pb-2">👰 Bride</h4>

            <div>
                <x-input-label for="bride_name" value="Full Name *" />
                <x-text-input id="bride_name" name="bride_name" type="text"
                              class="mt-1 block w-full" :value="old('bride_name', $wedding->bride_name ?? '')" required />
                <x-input-error :messages="$errors->get('bride_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="bride_first_name" value="First Name (for URL) *" />
                <x-text-input id="bride_first_name" name="bride_first_name" type="text"
                              class="mt-1 block w-full" :value="old('bride_first_name', $wedding->bride_first_name ?? '')" required />
                <x-input-error :messages="$errors->get('bride_first_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="bride_father_name" value="Father's Name *" />
                <x-text-input id="bride_father_name" name="bride_father_name" type="text"
                              class="mt-1 block w-full" :value="old('bride_father_name', $wedding->bride_father_name ?? '')" required />
                <x-input-error :messages="$errors->get('bride_father_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="bride_mother_name" value="Mother's Name *" />
                <x-text-input id="bride_mother_name" name="bride_mother_name" type="text"
                              class="mt-1 block w-full" :value="old('bride_mother_name', $wedding->bride_mother_name ?? '')" required />
                <x-input-error :messages="$errors->get('bride_mother_name')" class="mt-2" />
            </div>
        </div>
    </div>

    {{-- Event Details --}}
    <div class="border-t border-stone-200 pt-6">
        <h4 class="font-medium text-stone-700 mb-4">📅 Event Details</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="event_date" value="Wedding Date (Tanggal Undangan) *" />
                <x-text-input id="event_date" name="event_date" type="datetime-local"
                              class="mt-1 block w-full"
                              :value="old('event_date', $wedding->event_date?->format('Y-m-d\TH:i') ?? '')" required />
                <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="quote" value="Quote / Ayat *" />
                <textarea id="quote"
                    name="quote"
                    rows="3"
                    class="mt-1 block w-full rounded-xl"
                    placeholder="Love is patient, love is kind..."
                    required>{{ old('quote', $wedding?->quote ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('quote')" class="mt-2" />
            </div>

            <div class="md:col-span-2">
                <x-input-label for="quote_source" value="Quote Source (Sumber Ayat) *" />
                <x-text-input id="quote_source" name="quote_source" type="text"
                              class="mt-1 block w-full" :value="old('quote_source', $wedding->quote_source ?? '')"
                              placeholder="Corinthians 13:4" required />
                <x-input-error :messages="$errors->get('quote_source')" class="mt-2" />
            </div>
        </div>
    </div>

    {{-- Media --}}
    <div class="border-t border-stone-200 pt-6">
        <h4 class="font-medium text-stone-700 mb-4">🎨 Media</h4>

        {{-- ✅ TAMBAHKAN BAGIAN INI: Couple Photos --}}
        <div class="mb-6 p-4 bg-stone-50 rounded-xl border border-stone-200">
            <h5 class="font-medium text-stone-800 mb-4 text-sm uppercase tracking-wide">👫 Couple Photos</h5>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Groom Photo --}}
                <div>
                    <x-input-label for="groom_photo" value="Foto Mempelai Putra" />
                    <input type="file" id="groom_photo" name="groom_photo" accept="image/*"
                           class="mt-1 block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4
                                  file:rounded-xl file:border-0 file:text-sm file:font-medium
                                  file:bg-red-50 file:text-red-700 hover:file:bg-red-100" />
                    <x-input-error :messages="$errors->get('groom_photo')" class="mt-2" />

                    @if(isset($wedding) && $wedding->groom_photo)
                    <div class="mt-3">
                        <p class="text-xs text-stone-500 mb-2">Foto saat ini:</p>
                        <div class="relative w-24 h-24 rounded-full overflow-hidden border-2 border-white shadow-lg bg-stone-200">
                            <img src="{{ asset('storage/' . $wedding->groom_photo) }}"
                                 class="w-full h-full object-cover" alt="Groom">
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Bride Photo --}}
                <div>
                    <x-input-label for="bride_photo" value="Foto Mempelai Putri" />
                    <input type="file" id="bride_photo" name="bride_photo" accept="image/*"
                           class="mt-1 block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4
                                  file:rounded-xl file:border-0 file:text-sm file:font-medium
                                  file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100" />
                    <x-input-error :messages="$errors->get('bride_photo')" class="mt-2" />

                    @if(isset($wedding) && $wedding->bride_photo)
                    <div class="mt-3">
                        <p class="text-xs text-stone-500 mb-2">Foto saat ini:</p>
                        <div class="relative w-24 h-24 rounded-full overflow-hidden border-2 border-white shadow-lg bg-stone-200">
                            <img src="{{ asset('storage/' . $wedding->bride_photo) }}"
                                 class="w-full h-full object-cover" alt="Bride">
                        </div>
                    </div>
                    @endif
                </div>

            </div>
            <p class="text-xs text-stone-400 mt-4">
                💡 Format: JPG, PNG, WebP. Maksimal 5MB. Disarankan foto potret (vertical).
            </p>
        </div>

        {{-- Existing Cover Image & Music --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="cover_image" value="Cover Image (Background Utama)" />
                <input type="file" id="cover_image" name="cover_image" accept="image/*"
                       class="mt-1 block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4
                              file:rounded-xl file:border-0 file:text-sm file:font-medium
                              file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />

                @if(isset($wedding) && $wedding->cover_image)
                <div class="mt-3">
                    <p class="text-xs text-stone-500 mb-2">Current cover:</p>
                    <img src="{{ asset('storage/' . $wedding->cover_image) }}"
                         class="w-32 h-20 object-cover rounded-lg shadow" alt="Current cover">
                </div>
                @endif
            </div>

            {{-- Music File --}}
            <div>
                <x-input-label value="Background Music (Upload File)" />

                {{-- Upload Input --}}
                <input type="file"
                    name="music_file"
                    accept="audio/mp3,audio/mpeg,audio/wav,audio/ogg"
                    class="mt-2 block w-full text-sm text-stone-500
                            file:mr-4 file:py-2 file:px-4 file:rounded-xl
                            file:border-0 file:text-sm file:font-medium
                            file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                <x-input-error :messages="$errors->get('music_file')" class="mt-2" />

                {{-- Info File Saat Ini --}}
                @if(isset($wedding) && $wedding->music_file)
                <div class="mt-3 p-3 bg-green-50 rounded-lg border border-green-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                            <span class="text-sm text-green-700 font-medium">{{ basename($wedding->music_file) }}</span>
                        </div>

                        {{-- Checkbox Hapus --}}
                        <label class="flex items-center gap-1 cursor-pointer">
                            <input type="checkbox" name="delete_music" class="rounded text-red-600 focus:ring-red-500">
                            <span class="text-xs text-red-600">Hapus</span>
                        </label>
                    </div>
                </div>
                @endif

                <p class="mt-2 text-xs text-stone-400">
                    Format: MP3, WAV, OGG. Max 10MB.
                </p>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center justify-end gap-4 pt-6 border-t border-stone-200">
        <a href="{{ route('weddings.index') }}"
           class="px-4 py-2 bg-white border border-stone-300 rounded-xl text-stone-700 hover:bg-stone-50 transition">
            Cancel
        </a>
        <x-primary-button>
            {{ $buttonText ?? 'Save Changes' }}
        </x-primary-button>
    </div>
</form>
