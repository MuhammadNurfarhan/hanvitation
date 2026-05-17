<section id="gallery" class="py-16 sm:py-20 px-6 bg-stone-50 section-fade">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <p class="text-xs uppercase tracking-[0.3em] text-stone-400 mb-2">Moments of Grace</p>
            <h2 class="font-script text-4xl sm:text-5xl text-gradient mb-2">Our Gallery</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
        </div>

        @if($wedding->gallery->isNotEmpty())

        {{-- ✅ Grid Layout: 2 kolom, maksimal 4 baris (8 foto) --}}
        <div class="grid grid-cols-2 gap-3 sm:gap-4">
            @foreach($wedding->gallery->take(8) as $index => $photo)
            @php
                $url = $photo->url;
                if (!str_starts_with($url, 'http')) {
                    $url = asset('storage/' . $url);
                }
            @endphp

            {{-- Grid Item --}}
            <div class="relative group overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 {{ $index >= 6 ? 'hidden sm:block' : '' }}">
                <div class="aspect-square bg-stone-100">
                    <img src="{{ $url }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                         loading="lazy"
                         alt="Gallery {{ $index + 1 }}">
                </div>

                {{-- Overlay on Hover --}}
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    {{-- <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                    </svg> --}}
                </div>

                {{-- Caption (jika ada) --}}
                @if($photo->caption)
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <p class="text-white text-xs text-center">{{ Str::limit($photo->caption, 50) }}</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        {{-- Show More Button (jika foto lebih dari 8) --}}
        @if($wedding->gallery->count() > 8)
        <div class="text-center mt-6">
            <button onclick="document.getElementById('full-gallery').classList.toggle('hidden')"
                    class="px-6 py-3 bg-gradient-to-r from-red-900 to-red-800 hover:from-red-800 hover:to-red-700 text-white rounded-full font-medium shadow-lg hover:shadow-xl transition-all text-sm">
                Lihat Semua Foto ({{ $wedding->gallery->count() }})
            </button>

            {{-- Full Gallery Modal/Grid --}}
            <div id="full-gallery" class="hidden mt-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach($wedding->gallery as $photo)
                    @php
                        $url = $photo->url;
                        if (!str_starts_with($url, 'http')) {
                            $url = asset('storage/' . $url);
                        }
                    @endphp
                    <div class="relative group overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all">
                        <div class="aspect-square bg-stone-100">
                            <img src="{{ $url }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                 loading="lazy">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @else
        <div class="text-center py-12 bg-white rounded-2xl shadow-sm">
            <svg class="w-16 h-16 text-stone-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-stone-400">Gallery coming soon</p>
        </div>
        @endif
    </div>
</section>
