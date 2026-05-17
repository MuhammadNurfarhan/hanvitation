<nav class="fixed bottom-0 left-0 right-0 glass border-t border-stone-200/50 z-40 pb-safe">
    <div class="max-w-lg mx-auto px-2">
        <div class="flex items-center justify-around py-2">
            <button @click="scrollToSection('cover')"
                    class="flex flex-col items-center gap-0.5 p-2 transition-colors"
                    :class="activeSection === 'cover' ? 'text-red-900' : 'text-stone-400'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="text-[10px] font-medium">Home</span>
            </button>

            <button @click="scrollToSection('couple')"
                    class="flex flex-col items-center gap-0.5 p-2 transition-colors"
                    :class="activeSection === 'couple' ? 'text-red-900' : 'text-stone-400'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="text-[10px] font-medium">Couple</span>
            </button>

            <button @click="scrollToSection('events')"
                    class="flex flex-col items-center gap-0.5 p-2 transition-colors"
                    :class="activeSection === 'events' ? 'text-red-900' : 'text-stone-400'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-[10px] font-medium">Events</span>
            </button>

            <button @click="scrollToSection('rsvp')"
                    class="flex flex-col items-center gap-0.5 p-2 transition-colors"
                    :class="activeSection === 'rsvp' ? 'text-red-900' : 'text-stone-400'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="text-[10px] font-medium">RSVP</span>
            </button>

            <button @click="scrollToSection('gift')"
                    class="flex flex-col items-center gap-0.5 p-2 transition-colors"
                    :class="activeSection === 'gift' ? 'text-red-900' : 'text-stone-400'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                </svg>
                <span class="text-[10px] font-medium">Gift</span>
            </button>
        </div>
    </div>
</nav>
