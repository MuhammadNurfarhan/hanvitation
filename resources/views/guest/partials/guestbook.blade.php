<section id="guestbook" class="py-16 sm:py-20 px-6 bg-white section-fade">
    <div class="max-w-lg mx-auto">
        <div class="text-center mb-10">
            <p class="text-xs uppercase tracking-[0.3em] text-stone-400 mb-2">Wishes & Prayers</p>
            <h2 class="font-script text-4xl sm:text-5xl text-gradient mb-2">Buku Tamu</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
        </div>

        {{-- Guestbook Form --}}
        <form @submit.prevent="submitGuestbook()" class="bg-gradient-to-br from-stone-50 to-amber-50/30 rounded-2xl p-5 shadow-lg mb-8 space-y-4">

            {{-- Hidden input untuk unique_code (SAMA PERSIS seperti di RSVP) --}}
            @php
                $guestNameFromUrl = request()->get('untuk', '');
                $matchedGuest = null;
                if ($guestNameFromUrl) {
                    $matchedGuest = $wedding->guests()
                        ->whereRaw('LOWER(name) = ?', [strtolower(trim($guestNameFromUrl))])
                        ->first();
                }
                $uniqueCode = $matchedGuest?->unique_code ?? '';
            @endphp
            <input type="hidden" name="unique_code" value="{{ $uniqueCode }}">

            <div>
                <label class="block font-serif-custom text-lg text-stone-800 mb-2">Nama Anda</label>
                <input type="text"
                    x-model="guestbookForm.name"
                    {{ $matchedGuest ? 'readonly' : '' }}
                    required
                    placeholder="Masukkan nama lengkap"
                    class="w-full px-4 py-3 rounded-xl border border-stone-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all bg-white {{ $matchedGuest ? 'bg-stone-100 cursor-not-allowed' : '' }}">
            </div>
            <div>
                <textarea x-model="guestbookForm.message" required rows="3" placeholder="Tulis ucapan dan doa..."
                          class="w-full px-4 py-3 rounded-xl border border-stone-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all bg-white resize-none text-sm"></textarea>
            </div>
            <button type="submit" class="w-full bg-stone-800 hover:bg-stone-700 text-white py-3 rounded-xl font-medium transition-all text-sm">
                Kirim Ucapan
            </button>
        </form>

        {{-- Messages List --}}
        <div class="space-y-3">
            @forelse($wedding->guestMessages->take(5) as $msg)
            <div class="bg-stone-50 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-xs font-bold">{{ strtoupper(substr($msg->sender_name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-stone-800 text-sm">{{ $msg->sender_name }}</p>
                        <p class="text-[10px] text-stone-400">{{ \Carbon\Carbon::parse($msg->created_at)->diffForHumans() }}</p>
                    </div>
                </div>
                <p class="text-stone-600 text-sm italic leading-relaxed ml-11">"{{ $msg->message }}"</p>
            </div>
            @empty
            <div class="text-center py-8">
                <p class="text-stone-400 text-sm">Belum ada ucapan. Jadilah yang pertama!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
