<section id="cover" class="min-h-screen flex items-center justify-center relative overflow-hidden pt-16 pb-20">
    {{-- Background --}}
    <div class="absolute inset-0 overflow-hidden">
        @if($wedding->cover_image)
        <img src="{{ asset('storage/' . $wedding->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-white/40 via-white/20 to-stone-50"></div>
        @else
        <div class="w-full h-full bg-gradient-to-br from-red-50 via-amber-50 to-stone-100"></div>
        @endif
    </div>

    {{-- Content --}}
    <div class="relative z-10 text-center px-6 max-w-md mx-auto section-fade">

        <p class="text-xl sm:text-xl uppercase tracking-[0.3em] text-black mb-2">The Wedding Of</p>

        <h1 class="font-script text-5xl sm:text-6xl md:text-7xl text-gradient mb-4 leading-tight">
            {{ $wedding->groom_first_name }} & {{ $wedding->bride_first_name }}
        </h1>

        <div class="w-24 h-px bg-gradient-to-r from-transparent via-amber-500 to-transparent mx-auto mb-4"></div>

        <p class="text-white text-base sm:text-base font-medium">
            {{ \Carbon\Carbon::parse($wedding->event_date)->isoFormat('dddd, D MMMM YYYY') }}
        </p>

        {{-- Countdown --}}
        <div class="mt-8 rounded-2xl p-5 shadow-lg">
            <div class="grid grid-cols-4 gap-2 sm:gap-3">
                <div class="text-center">
                    <div class="bg-white/80 rounded-lg p-2 sm:p-3 shadow-sm">
                        <span x-text="countdown.days"
                            class="text-xl sm:text-2xl md:text-3xl font-bold text-red-900 font-serif-custom">00</span>
                    </div>
                    <span class="text-[10px] sm:text-xs text-red-900 uppercase mt-1 block">Hari</span>
                </div>
                <div class="text-center">
                    <div class="bg-white/80 rounded-lg p-2 sm:p-3 shadow-sm">
                        <span x-text="countdown.hours"
                            class="text-xl sm:text-2xl md:text-3xl font-bold text-red-900 font-serif-custom">00</span>
                    </div>
                    <span class="text-[10px] sm:text-xs text-red-900 uppercase mt-1 block">Jam</span>
                </div>
                <div class="text-center">
                    <div class="bg-white/80 rounded-lg p-2 sm:p-3 shadow-sm">
                        <span x-text="countdown.minutes"
                            class="text-xl sm:text-2xl md:text-3xl font-bold text-red-900 font-serif-custom">00</span>
                    </div>
                    <span class="text-[10px] sm:text-xs text-red-900 uppercase mt-1 block">Menit</span>
                </div>
                <div class="text-center">
                    <div class="bg-white/80 rounded-lg p-2 sm:p-3 shadow-sm">
                        <span x-text="countdown.seconds"
                            class="text-xl sm:text-2xl md:text-3xl font-bold text-red-900 font-serif-custom">00</span>
                    </div>
                    <span class="text-[10px] sm:text-xs text-red-900 uppercase mt-1 block">Detik</span>
                </div>
            </div>
        </div>

        <button @click="scrollToSection('quote')"
            class="mt-8 inline-flex items-center gap-2 text-stone-600 hover:text-red-900 transition-colors animate-bounce">
            <span class="text-sm">Scroll Down</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </button>
    </div>
</section>