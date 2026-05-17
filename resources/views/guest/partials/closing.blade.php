<section id="closing" class="py-20 sm:py-24 px-6 bg-gradient-to-b from-stone-50 to-white section-fade">
    <div class="max-w-lg mx-auto text-center">
        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
        </div>

        <p class="text-xs uppercase tracking-[0.3em] text-stone-400 mb-3">With Love</p>
        <h2 class="font-script text-4xl sm:text-5xl text-gradient mb-6">Thank You</h2>

        <div class="w-16 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto mb-6"></div>

        <p class="text-stone-600 leading-relaxed mb-8">
            Merupakan suatu kebahagiaan dan kehormatan bagi kami,<br>
            apabila Bapak/Ibu/Saudara/i berkenan hadir<br>
            untuk memberikan doa restu kepada kami.
        </p>

        <div class="font-script text-3xl sm:text-4xl text-red-900 mb-2">
            {{ $wedding->groom_first_name }} & {{ $wedding->bride_first_name }}
        </div>
        <p class="text-stone-400 text-sm">& Keluarga Besar</p>
    </div>
</section>
