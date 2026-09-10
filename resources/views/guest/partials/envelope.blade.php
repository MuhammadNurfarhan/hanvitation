<div x-show="showEnvelope" x-cloak x-transition:leave="transition ease-in duration-500"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[100] bg-gradient-to-br from-stone-100 via-stone-50 to-amber-50 flex flex-col items-center justify-center p-6">

    {{-- Music Toggle --}}
    <button @click="toggleMusic()"
        class="absolute top-6 right-6 w-12 h-12 rounded-full bg-white/80 backdrop-blur shadow-lg flex items-center justify-center hover:scale-110 transition-transform z-50"
        :class="{ 'music-pulse': isPlaying }">
        <svg x-show="!isPlaying" class="w-5 h-5 text-amber-700" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0115 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
        </svg>
        <svg x-show="isPlaying" class="w-5 h-5 text-amber-700" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </button>

    {{-- Decorative Hearts --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-20 h-20 opacity-20 animate-pulse text-red-300">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
            </svg>
        </div>
        <div class="absolute top-32 right-16 w-14 h-14 opacity-15 animate-pulse text-amber-300"
            style="animation-delay: 0.5s;">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
            </svg>
        </div>
        <div class="absolute bottom-40 left-20 w-10 h-10 opacity-10 animate-pulse text-red-200"
            style="animation-delay: 1s;">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
            </svg>
        </div>
    </div>

    {{-- ✅ Main Card: Cover Image + Text Below --}}
    <div class="relative w-full max-w-xs sm:max-w-sm transform transition-all duration-500"
        :class="invitationOpened ? 'scale-95 opacity-0' : 'scale-100 opacity-100'">

        {{-- Card Container --}}
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden ring-1 ring-stone-200/50">

            {{-- Cover Image --}}
            <div class="relative h-72 sm:h-80 w-full overflow-hidden bg-stone-100">
                @if($wedding?->envelope_image)
                <img src="{{ asset('storage/' . $wedding->envelope_image) }}" class="w-full h-full object-cover"
                    alt="Wedding Cover">
                @else
                <div class="w-full h-full bg-gradient-to-br from-red-100 to-amber-50 flex items-center justify-center">
                    <svg class="w-16 h-16 text-red-900/20" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                    </svg>
                </div>
                @endif
                {{-- Soft gradient transition to white section --}}
                <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white to-transparent"></div>
            </div>

            {{-- Text Content Below Cover --}}
            <div class="px-6 pb-8 pt-4 text-center relative -mt-2">
                {{-- Small Decorative Icon --}}
                <div class="w-10 h-10 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm">
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>

                <p class="text-xs text-stone-500 tracking-[0.2em] mb-1">Kepada Yth.</p>
                <p class="text-xs text-stone-600 font-medium">Bapak/Ibu/Saudara/i</p>

                {{-- Guest Name (Dynamic) --}}
                <h2 class="font-serif-custom text-xl sm:text-2xl font-bold text-red-900 mt-2 leading-tight px-2">
                    {{ $guestName ?: 'Tamu Undangan' }}
                </h2>

                <p class="mt-6 text-[10px] italic sm:text-sm text-stone-400 text-center max-w-xs leading-tight">
                    *Mohon maaf apabila terdapat kesalahan penulisan nama / gelar.
                </p>

                {{-- Decorative Divider --}}
                <div class="w-16 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto mt-4">
                </div>
            </div>
        </div>
    </div>

    {{-- Open Button --}}
    <button @click="openInvitation()" x-show="!invitationOpened"
        x-transition:enter="transition ease-out duration-300 delay-200"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        class="mt-8 mb-2 bg-gradient-to-r from-red-900 to-red-800 hover:from-red-800 hover:to-red-700 text-white px-8 py-4 rounded-full font-medium shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 text-sm sm:text-base cursor-pointer">
        <span>BUKA UNDANGAN</span>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
        </svg>
    </button>
</div>