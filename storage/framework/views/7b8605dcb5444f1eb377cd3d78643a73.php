<section id="rsvp" class="py-16 sm:py-20 px-6 bg-white section-fade">
    <div class="max-w-lg mx-auto">
        <div class="text-center mb-10">
            <p class="text-xs uppercase tracking-[0.3em] text-stone-400 mb-2">Kindly Respond</p>
            <h2 class="font-script text-4xl sm:text-5xl text-gradient mb-2">RSVP</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
            <p class="text-stone-500 text-sm mt-3">Mohon konfirmasi kehadiran Anda sebelum tanggal acara.</p>
        </div>

        
        <div x-show="rsvpSubmitted"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             class="text-center py-12 bg-green-50 rounded-2xl border border-green-200">

            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="font-serif-custom text-xl font-bold text-green-800 mb-2">Terima Kasih!</h3>
            <p class="text-green-600 text-sm">RSVP Anda telah kami terima. Kami sangat menantikan kehadiran Anda.</p>

            
            
        </div>

        
        <div x-show="!rsvpSubmitted"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100">

            <form @submit.prevent="submitRSVP()" class="bg-gradient-to-br from-stone-50 to-amber-50/30 rounded-2xl p-6 shadow-lg space-y-5">

                
                <?php
                    // Ambil nama dari URL parameter 'untuk'
                    $guestNameFromUrl = request()->get('untuk', '');

                    // Lookup guest berdasarkan nama (case-insensitive)
                    $matchedGuest = null;
                    if ($guestNameFromUrl) {
                        $matchedGuest = $wedding->guests()
                            ->whereRaw('LOWER(name) = ?', [strtolower(trim($guestNameFromUrl))])
                            ->first();
                    }

                    // Ambil unique_code jika guest ditemukan
                    $uniqueCode = $matchedGuest?->unique_code ?? '';
                ?>

                <input type="hidden" name="unique_code" value="<?php echo e($uniqueCode); ?>">

                <div>
                    <label class="block font-serif-custom text-lg text-stone-800 mb-2">Nama</label>
                    <input type="text"
                        x-model="rsvpForm.name"
                        <?php echo e($matchedGuest ? 'readonly' : ''); ?>

                        required
                        placeholder="Masukkan Nama"
                        class="w-full px-4 py-3 rounded-xl border border-stone-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all bg-white <?php echo e($matchedGuest ? 'bg-stone-100 cursor-not-allowed' : ''); ?>">
                </div>

                <div>
                    <label class="block font-serif-custom text-lg text-stone-800 mb-3">Konfirmasi Kehadiran</label>
                    <div class="space-y-2">
                        <label class="flex items-center justify-between p-3 bg-white rounded-xl border-2 cursor-pointer transition-all"
                               :class="rsvpForm.attendance === 'hadir' ? 'border-green-500 bg-green-50' : 'border-stone-200 hover:border-amber-400'">
                            <span class="font-medium text-stone-700">✅ Hadir</span>
                            <input type="radio" name="attendance" value="hadir" x-model="rsvpForm.attendance" class="sr-only">
                        </label>
                        <label class="flex items-center justify-between p-3 bg-white rounded-xl border-2 cursor-pointer transition-all"
                               :class="rsvpForm.attendance === 'tidak_hadir' ? 'border-red-500 bg-red-50' : 'border-stone-200 hover:border-amber-400'">
                            <span class="font-medium text-stone-700">❌ Tidak Hadir</span>
                            <input type="radio" name="attendance" value="tidak_hadir" x-model="rsvpForm.attendance" class="sr-only">
                        </label>
                    </div>
                </div>

                <div x-show="rsvpForm.attendance === 'hadir'" x-transition>
                    <label class="block font-serif-custom text-lg text-stone-800 mb-2">Jumlah Tamu</label>
                    <select x-model="rsvpForm.guest_count"
                            class="w-full px-4 py-3 rounded-xl border border-stone-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all bg-white">
                        <option value="1">1 Orang</option>
                        <option value="2">2 Orang</option>
                        <option value="3">3 Orang</option>
                        <option value="4">4 Orang</option>
                        <option value="5">5 Orang</option>
                    </select>
                </div>

                <button type="submit" :disabled="rsvpLoading"
                        class="w-full bg-gradient-to-r from-red-900 to-red-800 hover:from-red-800 hover:to-red-700 disabled:from-stone-400 disabled:to-stone-400 text-white py-4 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                    <svg x-show="rsvpLoading" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span x-show="!rsvpLoading">Kirim RSVP</span>
                    <span x-show="rsvpLoading">Mengirim...</span>
                </button>
            </form>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\hanvitation\resources\views/guest/partials/rsvp.blade.php ENDPATH**/ ?>