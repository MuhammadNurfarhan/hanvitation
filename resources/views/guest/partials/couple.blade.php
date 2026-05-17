<section id="couple" class="py-16 sm:py-20 px-6 bg-gradient-to-b from-stone-50 to-white section-fade">
    <div class="max-w-lg mx-auto">
        <div class="text-center mb-10">
            <p class="text-xs uppercase tracking-[0.3em] text-stone-400 mb-2">With Joyful Hearts</p>
            <h2 class="font-script text-4xl sm:text-5xl text-gradient mb-2">The Bride & Groom</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
        </div>

        {{-- Groom --}}
        <div class="text-center mb-10">
            <div class="relative inline-block mb-4">
                <div class="absolute inset-0 bg-amber-200 rounded-full transform rotate-6 scale-105"></div>
                @if($wedding->groom_photo)
                <img src="{{ asset('storage/' . $wedding->groom_photo) }}"
                     alt="{{ $wedding->groom_name }}"
                     class="relative w-36 h-36 sm:w-40 sm:h-40 object-cover rounded-full shadow-xl border-4 border-white">
                @else
                <div class="relative w-36 h-36 sm:w-40 sm:h-40 bg-gradient-to-br from-stone-200 to-stone-300 rounded-full shadow-xl border-4 border-white flex items-center justify-center">
                    <svg class="w-16 h-16 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                @endif
            </div>

            <h3 class="font-serif-custom text-2xl sm:text-3xl font-bold text-red-900 mb-1">{{ $wedding->groom_name }}</h3>
            <p class="text-xs uppercase tracking-wider text-stone-400 mb-3">The Groom</p>

            <div class="w-12 h-px bg-amber-400 mx-auto mb-3"></div>

            <p class="text-stone-600 text-sm leading-relaxed">
                Putra dari<br>
                <span class="font-medium text-stone-800">Bapak {{ $wedding->groom_father_name }}</span><br>
                <span class="text-stone-500">&</span><br>
                <span class="font-medium text-stone-800">Ibu {{ $wedding->groom_mother_name }}</span>
            </p>

            @if($wedding->groom_instagram)
            <a href="{{ $wedding->groom_instagram }}" target="_blank"
               class="inline-flex items-center gap-1 mt-4 text-amber-700 hover:text-amber-800 text-sm transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                </svg>
                <span>{{ $wedding->groom_instagram }}</span>
            </a>
            @endif
        </div>

        {{-- Heart Divider --}}
        <div class="flex justify-center mb-10">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
        </div>

        {{-- Bride --}}
        <div class="text-center">
            <div class="relative inline-block mb-4">
                <div class="absolute inset-0 bg-amber-200 rounded-full transform -rotate-6 scale-105"></div>
                @if($wedding->bride_photo)
                <img src="{{ asset('storage/' . $wedding->bride_photo) }}"
                     alt="{{ $wedding->bride_name }}"
                     class="relative w-36 h-36 sm:w-40 sm:h-40 object-cover rounded-full shadow-xl border-4 border-white">
                @else
                <div class="relative w-36 h-36 sm:w-40 sm:h-40 bg-gradient-to-br from-stone-200 to-stone-300 rounded-full shadow-xl border-4 border-white flex items-center justify-center">
                    <svg class="w-16 h-16 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                @endif
            </div>

            <h3 class="font-serif-custom text-2xl sm:text-3xl font-bold text-red-900 mb-1">{{ $wedding->bride_name }}</h3>
            <p class="text-xs uppercase tracking-wider text-stone-400 mb-3">The Bride</p>

            <div class="w-12 h-px bg-amber-400 mx-auto mb-3"></div>

            <p class="text-stone-600 text-sm leading-relaxed">
                Putri dari<br>
                <span class="font-medium text-stone-800">Bapak {{ $wedding->bride_father_name }}</span><br>
                <span class="text-stone-500">&</span><br>
                <span class="font-medium text-stone-800">Ibu {{ $wedding->bride_mother_name }}</span>
            </p>

            @if($wedding->bride_instagram)
            <a href="{{ $wedding->bride_instagram }}" target="_blank"
               class="inline-flex items-center gap-1 mt-4 text-amber-700 hover:text-amber-800 text-sm transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                </svg>
                <span>{{ $wedding->bride_instagram }}</span>
            </a>
            @endif
        </div>
    </div>
</section>
