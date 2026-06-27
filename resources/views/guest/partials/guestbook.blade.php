<section id="guestbook" class="py-16 sm:py-20 px-6 bg-white section-fade">
    <div class="max-w-lg mx-auto">
        <div class="text-center mb-10">
            <p class="text-xs uppercase tracking-[0.3em] text-stone-400 mb-2">Wishes & Prayers</p>
            <h2 class="font-script text-4xl sm:text-5xl text-gradient mb-2">Buku Tamu</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
        </div>

        {{-- Guestbook Form --}}
        <form @submit.prevent="submitGuestbook()" class="bg-gradient-to-br from-stone-50 to-amber-50/30 rounded-2xl p-5 shadow-lg mb-8 space-y-4">

            {{-- Hidden input untuk unique_code --}}
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
            <button type="submit"
                    :disabled="guestbookLoading"
                    class="w-full bg-stone-800 hover:bg-stone-700 disabled:bg-stone-400 text-white py-3 rounded-xl font-medium transition-all text-sm flex items-center justify-center gap-2">
                <svg x-show="guestbookLoading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span x-show="!guestbookLoading">Kirim Ucapan</span>
                <span x-show="guestbookLoading">Mengirim...</span>
            </button>
        </form>

        {{-- Messages List - Menggunakan Alpine.js (bukan Blade @forelse) --}}
        <div class="space-y-3">

            {{-- Loading State --}}
            <div x-show="guestbookLoading && guestbookMessages.length === 0" class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-amber-200 border-t-amber-600"></div>
                <p class="text-stone-500 text-sm mt-2">Memuat ucapan...</p>
            </div>

            {{-- Messages - Render via Alpine.js x-for --}}
            <template x-for="msg in guestbookMessages" :key="msg.id">
                <div class="bg-stone-50 rounded-xl p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-xs font-bold" x-text="msg.sender_name.charAt(0).toUpperCase()"></span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-stone-800 text-sm" x-text="msg.sender_name"></p>
                            <p class="text-[10px] text-stone-400" x-text="msg.diff_for_humans"></p>
                            <!--<p class="text-[10px] text-stone-400" x-text="new Date(msg.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'})"></p>-->
                        </div>
                        {{-- Attendance Badge --}}
                        <template x-if="msg.attendance_status">
                            <span class="px-2 py-1 text-[10px] rounded-full"
                                  :class="{
                                      'bg-green-100 text-green-800': msg.attendance_status === 'hadir',
                                      'bg-red-100 text-red-800': msg.attendance_status === 'tidak_hadir',
                                      'bg-amber-100 text-amber-800': msg.attendance_status === 'ragu'
                                  }"
                                  x-text="msg.attendance_status === 'hadir' ? '✅ Hadir' : (msg.attendance_status === 'tidak_hadir' ? '❌ Tidak Hadir' : '🤔 Ragu')">
                            </span>
                        </template>
                    </div>
                    <p class="text-stone-600 text-sm italic leading-relaxed ml-11">
                        "<span x-text="msg.message"></span>"
                    </p>
                </div>
            </template>

            {{-- Empty State --}}
            <div x-show="!guestbookLoading && guestbookMessages.length === 0" class="text-center py-8">
                <p class="text-stone-400 text-sm">Belum ada ucapan. Jadilah yang pertama!</p>
            </div>

            {{-- Load More Button --}}
            <div x-show="hasMorePages" x-cloak class="text-center pt-6">
                <button @click="loadMoreMessages()"
                        :disabled="loadingMore"
                        class="px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 disabled:from-stone-300 disabled:to-stone-300 text-white rounded-xl font-medium transition-all shadow-md hover:shadow-lg disabled:shadow-none flex items-center gap-2 mx-auto">
                    <svg x-show="loadingMore" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span x-show="!loadingMore" class="text-stone-400">📥 Muat Lebih Banyak Ucapan</span>
                    <span x-show="loadingMore" class="text-stone-500">Memuat...</span>
                </button>
                <p class="text-xs text-stone-400 mt-2">
                    Menampilkan <span x-text="guestbookMessages.length"></span> dari <span x-text="currentPage"></span>/<span x-text="lastPage"></span> halaman
                </p>
            </div>

            {{-- No More Messages --}}
            <div x-show="!hasMorePages && guestbookMessages.length > 0" x-cloak class="text-center pt-6 pb-2">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-stone-100 rounded-full">
                    <span class="text-stone-500 text-xs">✨ Semua ucapan telah ditampilkan</span>
                </div>
            </div>
        </div>
    </div>
</section>
