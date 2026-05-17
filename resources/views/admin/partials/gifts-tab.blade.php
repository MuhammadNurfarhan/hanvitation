<div class="space-y-6">

    {{-- Add Bank Account Form --}}
    <div class="bg-stone-50 rounded-xl p-4">
        <h4 class="font-medium text-stone-900 mb-3">➕ Add Bank Account</h4>
        <form action="{{ route('weddings.bank.store', $wedding) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <x-input-label for="bank_name" value="Bank Name *" />
                    <x-text-input name="bank_name" type="text" required class="mt-1 block w-full" placeholder="BCA" />
                </div>
                <div>
                    <x-input-label for="account_number" value="Account Number *" />
                    <x-text-input name="account_number" type="text" required class="mt-1 block w-full font-mono" placeholder="1234567890" />
                </div>
                <div>
                    <x-input-label for="account_holder" value="Account Holder *" />
                    <x-text-input name="account_holder" type="text" required class="mt-1 block w-full" placeholder="John Doe" />
                </div>
            </div>
            <x-primary-button type="submit">Add Account</x-primary-button>
        </form>
    </div>

    {{-- Bank Accounts List --}}
    <div>
        <h4 class="font-medium text-stone-900 mb-3">Existing Accounts ({{ $wedding->bankAccounts->count() }})</h4>
        @forelse($wedding->bankAccounts as $bank)
        <div class="flex items-center justify-between p-4 bg-stone-50 rounded-xl mb-3">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div>
                    <p class="font-medium text-stone-900">{{ $bank->bank_name }}</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <code class="text-sm font-mono text-stone-700">{{ $bank->account_number }}</code>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $bank->account_number }}'); this.textContent='✓'; setTimeout(() => this.textContent='📋', 1500)"
                                class="text-xs text-amber-700 hover:text-amber-800">📋Salin</button>
                    </div>
                    <p class="text-xs text-stone-500">{{ $bank->account_holder }}</p>
                </div>
            </div>
            <form action="{{ route('weddings.bank.destroy', [$wedding, $bank]) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-700 hover:text-red-900 p-2" title="Delete" onclick="return confirm('Delete this bank account?')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </form>
        </div>
        @empty
        <p class="text-center text-stone-500 py-8 bg-stone-50 rounded-xl">No bank accounts added yet.</p>
        @endforelse
    </div>
</div>
