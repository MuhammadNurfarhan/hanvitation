<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl font-semibold text-red-900 leading-tight">
            {{ __('Create New Wedding') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl p-6">
                <form action="{{ route('weddings.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-8">
                    @csrf

                    {{-- Section: Couple Information --}}
                    <div>
                        <h3 class="text-lg font-medium text-stone-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Couple Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Groom --}}
                            <div class="space-y-4">
                                <h4 class="font-medium text-stone-700 border-b border-stone-200 pb-2">🤵 Groom</h4>

                                <div>
                                    <x-input-label for="groom_name" value="Full Name *" />
                                    <x-text-input id="groom_name" name="groom_name" type="text"
                                        class="mt-1 block w-full" :value="old('groom_name')"
                                        placeholder="Nama Lengkap Mempelai Pria" required />
                                    <x-input-error :messages="$errors->get('groom_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="groom_first_name" value="First Name (for URL) *" />
                                    <x-text-input id="groom_first_name" name="groom_first_name" type="text"
                                        class="mt-1 block w-full" :value="old('groom_first_name')"
                                        placeholder="Nama Panggilan Untuk URL" required />
                                    <x-input-error :messages="$errors->get('groom_first_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="groom_father_name" value="Father's Name *" />
                                    <x-text-input id="groom_father_name" name="groom_father_name" type="text"
                                        class="mt-1 block w-full" :value="old('groom_father_name')"
                                        placeholder="Nama Ayah Mempelai Pria" required />
                                    <x-input-error :messages="$errors->get('groom_father_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="groom_mother_name" value="Mother's Name *" />
                                    <x-text-input id="groom_mother_name" name="groom_mother_name" type="text"
                                        class="mt-1 block w-full" :value="old('groom_mother_name')"
                                        placeholder="Nama Ibu Mempelai Pria" required />
                                    <x-input-error :messages="$errors->get('groom_mother_name')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Bride --}}
                            <div class="space-y-4">
                                <h4 class="font-medium text-stone-700 border-b border-stone-200 pb-2">👰 Bride</h4>

                                <div>
                                    <x-input-label for="bride_name" value="Full Name *" />
                                    <x-text-input id="bride_name" name="bride_name" type="text"
                                        class="mt-1 block w-full" :value="old('bride_name')"
                                        placeholder="Nama Lengkap Mempelai Wanita" required />
                                    <x-input-error :messages="$errors->get('bride_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="bride_first_name" value="First Name (for URL) *" />
                                    <x-text-input id="bride_first_name" name="bride_first_name" type="text"
                                        class="mt-1 block w-full" :value="old('bride_first_name')"
                                        placeholder="Nama Panggilan Untuk URL" required />
                                    <x-input-error :messages="$errors->get('bride_first_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="bride_father_name" value="Father's Name *" />
                                    <x-text-input id="bride_father_name" name="bride_father_name" type="text"
                                        class="mt-1 block w-full" :value="old('bride_father_name')"
                                        placeholder="Nama Ayah Mempelai Wanita" required />
                                    <x-input-error :messages="$errors->get('bride_father_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="bride_mother_name" value="Mother's Name *" />
                                    <x-text-input id="bride_mother_name" name="bride_mother_name" type="text"
                                        class="mt-1 block w-full" :value="old('bride_mother_name')"
                                        placeholder="Nama Ibu Mempelai Wanita" required />
                                    <x-input-error :messages="$errors->get('bride_mother_name')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Event Details --}}
                    <div>
                        <h3 class="text-lg font-medium text-stone-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Event Details
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="event_date" value="Wedding Date (Tanggal Pernikahan) *" />
                                <x-text-input id="event_date" name="event_date" type="datetime-local"
                                    class="mt-1 block w-full" :value="old('event_date')" required />
                                <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="quote" value="Quote / Ayat" />
                                <textarea id="quote" name="quote" rows="3" class="mt-1 block w-full rounded-xl"
                                    placeholder="Love is patient, love is kind...">{{ old('quote', $wedding?->quote ?? '') }}</textarea>
                                <x-input-error :messages="$errors->get('quote')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="quote_source" value="Quote Source (Sumber Ayat)" />
                                <x-text-input id="quote_source" name="quote_source" type="text"
                                    class="mt-1 block w-full" :value="old('quote_source')"
                                    placeholder="Corinthians 13:4" />
                                <x-input-error :messages="$errors->get('quote_source')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- Section: Media --}}
                    <div>
                        <h3 class="text-lg font-medium text-stone-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Cover Image & Music
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Cover Image (halaman undangan) --}}
                            <div>
                                <x-input-label for="cover_image" value="Foto Cover (Halaman Dalam Undangan)" />
                                <input type="file" id="cover_image" name="cover_image" accept="image/*" class="mt-1 block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4
                                              file:rounded-xl file:border-0 file:text-sm file:font-medium
                                              file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                                <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                                <p class="mt-1 text-xs text-stone-500">Recommended: 1200x800px, max 5MB</p>

                                {{-- Image Preview --}}
                                <img id="cover_preview" class="mt-4 w-full max-w-xs rounded-xl shadow hidden" src="#"
                                    alt="Preview" />
                            </div>

                            {{-- Envelope Image (halaman amplop) --}}
                            <div>
                                <x-input-label for="envelope_image" value="Foto Background Amplop (Halaman Pembuka)" />
                                <input type="file" id="envelope_image" name="envelope_image"
                                    accept="image/jpeg,image/png,image/jpg,image/webp" class="mt-1 block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4
                                                   file:rounded-xl file:border-0 file:text-sm file:font-medium
                                                   file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                                <x-input-error :messages="$errors->get('envelope_image')" class="mt-2" />
                                <img id="envelope_preview" class="mt-4 w-full max-w-xs rounded-xl shadow hidden" src="#"
                                    alt="Preview" />
                            </div>

                            {{-- Music File --}}
                            <div>
                                <x-input-label value="Background Music (Upload File)" />

                                {{-- Upload Input --}}
                                <input type="file" name="music_file" accept="audio/mp3,audio/mpeg,audio/wav,audio/ogg"
                                    class="mt-2 block w-full text-sm text-stone-500
                                            file:mr-4 file:py-2 file:px-4 file:rounded-xl
                                            file:border-0 file:text-sm file:font-medium
                                            file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                                <x-input-error :messages="$errors->get('music_file')" class="mt-2" />

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
                            {{ __('Create Wedding') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Image Preview Script --}}
    <script>
        function bindPreview(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (!input || !preview) return;

            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        preview.src = ev.target.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.classList.add('hidden');
                }
            });
        }

        bindPreview('cover_image', 'cover_preview');
        bindPreview('envelope_image', 'envelope_preview');
    </script>
</x-app-layout>