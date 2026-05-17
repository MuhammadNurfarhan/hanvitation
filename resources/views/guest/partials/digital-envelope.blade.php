<section id="gift" class="py-16 sm:py-20 px-6 bg-gradient-to-b from-stone-50 to-white section-fade">
    <div class="max-w-lg mx-auto">
        <div class="text-center mb-10">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs uppercase tracking-[0.3em] text-stone-400 mb-2">Wedding Gift</p>
            <h2 class="font-script text-4xl sm:text-5xl text-gradient mb-2">Digital Envelope</h2>
            <div class="w-16 h-px bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto"></div>
            <p class="text-stone-500 text-sm mt-3 leading-relaxed">
                Kehadiran dan doa restu Anda adalah hadiah terindah bagi kami.<br>
                Namun jika Anda ingin memberikan tanda kasih, kami menyediakan amplop digital di bawah ini.
            </p>
        </div>

        {{-- Bank Accounts --}}
        <div class="space-y-4">
            @foreach($wedding->bankAccounts as $bank)
            <div class="bg-white rounded-2xl p-5 shadow-lg border border-stone-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-stone-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif-custom text-lg font-bold text-stone-800">{{ $bank->bank_name }}</h3>
                </div>

                <div class="space-y-2 mb-4">
                    <div>
                        <p class="text-[10px] text-stone-400 uppercase tracking-wider">Nomor Rekening</p>
                        <p class="font-mono text-xl font-bold text-stone-800 tracking-wider">{{ $bank->account_number }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-stone-400 uppercase tracking-wider">Atas Nama</p>
                        <p class="font-medium text-stone-700">{{ $bank->account_holder }}</p>
                    </div>
                </div>

                <button @click="copyToClipboard('{{ $bank->account_number }}', '{{ $bank->bank_name }}')"
                        class="w-full bg-gradient-to-r from-red-900 to-red-800 hover:from-red-800 hover:to-red-700 text-white py-3 rounded-xl font-medium transition-all flex items-center justify-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Salin No. Rekening
                </button>
            </div>
            @endforeach
        </div>

        {{-- QR Code (optional) --}}
        @if($wedding->qr_code)
        <div class="mt-8 text-center">
            <p class="text-stone-500 text-sm italic mb-4">Atau scan QR Code di bawah ini:</p>
            <div class="inline-block bg-white p-4 rounded-2xl shadow-lg">
                <img src="{{ asset('storage/' . $wedding->qr_code) }}" alt="QR Code" class="w-40 h-40 object-contain">
            </div>
        </div>
        @endif
    </div>
</section>
