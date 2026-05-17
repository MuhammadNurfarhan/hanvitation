<header class="fixed top-0 left-0 right-0 z-40 glass border-b border-stone-200/50">
    <div class="max-w-lg mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-red-900" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm0 12.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
            </svg>
            <span class="font-script text-xl text-red-900">Hanvitation</span>
        </div>

        <button @click="toggleMusic()"
                class="relative w-10 h-10 rounded-full bg-stone-100 flex items-center justify-center hover:bg-stone-200 transition-colors"
                :class="{ 'music-pulse text-amber-700': isPlaying, 'text-stone-500': !isPlaying }">
            <svg x-show="!isPlaying" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/>
            </svg>
            <svg x-show="isPlaying" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
            </svg>
        </button>
    </div>
</header>
