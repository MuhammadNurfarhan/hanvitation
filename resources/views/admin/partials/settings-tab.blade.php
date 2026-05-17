<div class="space-y-6">

    {{-- Publish Status --}}
    <div class="p-4 rounded-xl {{ $wedding->is_published ? 'bg-green-50 border border-green-200' : 'bg-amber-50 border border-amber-200' }}">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="font-medium text-stone-900">Publish Status</h4>
                <p class="text-sm text-stone-600 mt-1">
                    {{ $wedding->is_published
                        ? '✅ Invitation is LIVE and accessible via public link.'
                        : '📝 Invitation is in DRAFT mode. Only you can see it.' }}
                </p>
            </div>
            @if($wedding->is_published)
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Published</span>
            @else
                <form action="{{ route('weddings.publish', $wedding) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-xl hover:bg-green-800 transition">
                        Publish Now
                    </button>
                </form>
            @endif
        </div>
        @if($wedding->is_published)
        <div class="mt-3 p-3 bg-white rounded-lg border border-green-200">
            <p class="text-xs text-stone-500 mb-1">Public Link:</p>
            <div class="flex items-center gap-2">
                <input type="text" readonly value="{{ $wedding->getInvitationUrlAttribute() }}"
                    class="flex-1 px-3 py-1.5 text-sm bg-stone-50 border border-stone-200 rounded font-mono">
                <button onclick="navigator.clipboard.writeText('{{ $wedding->getInvitationUrlAttribute() }}'); this.textContent='Copied!'; setTimeout(() => this.textContent='📋', 2000)"
                        class="px-3 py-1.5 text-sm bg-amber-700 text-white rounded hover:bg-amber-800 transition">
                    📋 Copy
                </button>
            </div>
        </div>
        @endif
    </div>

    {{-- Wedding URL Slug --}}
    <div class="p-4 bg-stone-50 rounded-xl">
        <h4 class="font-medium text-stone-900 mb-2">Invitation URL</h4>
        <p class="text-sm text-stone-600 mb-3">This slug is used in your public invitation link:</p>
        <div class="flex items-center gap-2 p-3 bg-white rounded-lg border border-stone-200">
            <span class="text-stone-500 text-sm">{{ url('/') }}/</span>
            <code class="font-mono text-amber-700">{{ $wedding->slug }}</code>
        </div>
        <p class="text-xs text-stone-500 mt-2">⚠️ Changing the slug will break existing links. Contact support if you need to update it.</p>
    </div>

    {{-- Danger Zone --}}
    <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
        <h4 class="font-medium text-red-900 mb-2 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            Danger Zone
        </h4>
        <p class="text-sm text-red-700 mb-4">
            Deleting this wedding will <strong>permanently remove</strong> all associated data including:
        </p>
        <ul class="text-sm text-red-700 list-disc list-inside mb-4 space-y-1">
            <li>{{ $wedding->guests->count() }} guest records</li>
            <li>{{ $wedding->events->count() }} event schedules</li>
            <li>{{ $wedding->gallery->count() }} gallery photos</li>
            <li>{{ $wedding->bankAccounts->count() }} bank accounts</li>
            <li>All guest messages & RSVPs</li>
        </ul>
        <form action="{{ route('weddings.destroy', $wedding) }}" method="POST" class="inline"
            onsubmit="return confirm('⚠️ This action cannot be undone!\n\nAre you sure you want to delete this wedding?')">
            @csrf @method('DELETE')
            <x-danger-button type="submit">Delete Wedding Permanently</x-danger-button>
        </form>
    </div>

</div>
