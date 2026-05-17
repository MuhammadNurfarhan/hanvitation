<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-serif text-2xl font-semibold text-red-900 leading-tight">
                {{ __('Guest Management') }}
            </h2>
            <div class="flex items-center gap-2">
                {{-- Wedding Filter (Admin only) --}}
                @if(Auth::user()->isAdmin())
                <form method="GET" class="flex items-center gap-2">
                    <select name="wedding_id" onchange="this.form.submit()"
                            class="rounded-xl border-stone-300 text-sm focus:border-amber-600 focus:ring-amber-200">
                        <option value="">All Weddings</option>
                        @foreach($weddings as $w)
                        <option value="{{ $w->id }}" {{ request('wedding_id') == $w->id ? 'selected' : '' }}>
                            {{ $w->groom_first_name }} & {{ $w->bride_first_name }}
                        </option>
                        @endforeach
                    </select>
                </form>
                @endif

                {{-- Import Button --}}
                <button type="button" x-data @click="$dispatch('open-modal', 'import-guests')"
                        class="inline-flex items-center px-4 py-2 bg-amber-700 text-white rounded-xl hover:bg-amber-800 transition shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Import Excel
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 flex items-center justify-between">

                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>

                    {{-- ✅ Tampilkan tombol jika ada wa_link --}}
                    @if(session('wa_link'))
                    <a href="{{ session('wa_link') }}" target="_blank"
                    class="ml-4 px-3 py-1 bg-green-600 text-green-500 text-xs rounded-lg hover:bg-green-700 transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Kirim Sekarang
                    </a>
                    @endif
                </div>

                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @endif

            {{-- ✅ Tampilkan List Link untuk Bulk Send --}}
            @if(session('wa_links'))
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl text-blue-800">
                <div class="flex items-center justify-between mb-2">
                    <p class="font-bold">📋 Link WhatsApp untuk {{ count(session('wa_links')) }} tamu:</p>
                    <button @click="$el.parentElement.remove()" class="text-blue-400 hover:text-blue-600">✕</button>
                </div>
                <ul class="space-y-1 max-h-40 overflow-y-auto pr-2">
                    @foreach(session('wa_links') as $wa)
                    <li>
                        <a href="{{ $wa['link'] }}" target="_blank"
                        class="text-blue-700 hover:text-blue-900 hover:underline text-sm flex items-center gap-2 group">
                            <span class="opacity-0 group-hover:opacity-100 transition">📤</span>
                            <span class="font-medium">{{ $wa['name'] }}</span>
                            <span class="text-xs text-blue-400">({{ $wa['phone'] }})</span>
                        </a>
                    </li>
                    @endforeach 
                </ul>
                <p class="text-xs text-blue-500 mt-2 italic">💡 Klik link untuk buka WhatsApp satu per satu.</p>
            </div>
            @endif

            <div x-data="{ checkedItems: [] }" x-ref="guestCheckboxes" class="space-y-6">

                {{-- Search & Bulk Actions --}}
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-stone-200 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        {{-- Search --}}
                        <form method="GET" class="flex-1 max-w-md">
                            @if(request('wedding_id'))
                            <input type="hidden" name="wedding_id" value="{{ request('wedding_id') }}">
                            @endif
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search guests by name..."
                                    class="w-full pl-10 pr-4 py-2 rounded-xl border border-stone-300 focus:border-amber-600 focus:ring-2 focus:ring-amber-200 outline-none">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-stone-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </form>

                        {{-- Bulk Actions --}}
                        <div x-data="{ bulkAction: '' }" class="flex items-center gap-2">
                            <span class="text-sm text-stone-500" x-show="checkedItems.length > 0">
                                <span x-text="checkedItems.length"></span> selected
                            </span>
                            <select x-model="bulkAction" @change="if(bulkAction) { $dispatch('bulk-action', bulkAction); bulkAction=''; }"
                                    class="rounded-xl border-stone-300 text-sm focus:border-amber-600 focus:ring-amber-200">
                                <option value="">Bulk Actions</option>
                                <option value="send">Send Invitations</option>
                                <option value="export">Export Selected</option>
                            </select>
                            <button @click="$dispatch('bulk-action', 'send')"
                                    class="px-4 py-2 bg-green-700 text-white rounded-xl hover:bg-green-800 transition text-sm">
                                Send WhatsApp
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Import Stats Message --}}
                @if(session('import_stats'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl text-blue-800 flex items-center justify-between">
                    <div>
                        <span class="font-bold">📊 Statistik Import:</span>
                        <span>Total {{ session('import_stats.total') }} data</span>
                        <span class="mx-2">•</span>
                        <span class="text-green-700">+{{ session('import_stats.imported') }} Baru</span>
                        <span class="mx-2">•</span>
                        <span class="text-amber-700">~{{ session('import_stats.updated') }} Diupdate</span>
                    </div>
                    <button @click="show = false" class="text-blue-600 hover:text-blue-800">✕</button>
                </div>
                @endif

                {{-- Guests Table --}}
                <div class="bg-white shadow-sm sm:rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-stone-200">
                            <thead class="bg-stone-50">
                                <tr>
                                    <th class="px-6 py-3 w-10">
                                        <input type="checkbox" @change="
                                            const checkboxes = Array.from($el.closest('table').querySelectorAll('tbody input[type=checkbox]'));
                                            checkedItems = $event.target.checked ? checkboxes.map(cb => cb.value) : [];
                                            checkboxes.forEach(cb => cb.checked = $event.target.checked);
                                        " class="rounded border-stone-300 text-red-900 focus:ring-red-500">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Guest Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Wedding</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Sent</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-stone-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-stone-200">
                                @forelse($guests as $guest)
                                <tr class="hover:bg-stone-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="guest_ids[]" value="{{ $guest->id }}"
                                            @change="if($event.target.checked) checkedItems.push($event.target.value); else checkedItems = checkedItems.filter(id => id !== $event.target.value)"
                                            class="rounded border-stone-300 text-red-900 focus:ring-red-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <p class="font-medium text-stone-900">{{ $guest->name }}</p>
                                            <p class="text-xs text-stone-500">Code: {{ $guest->unique_code }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-700">
                                        <a href="{{ route('weddings.edit', $guest->wedding) }}" class="hover:text-red-900">
                                            {{ $guest->wedding->groom_first_name }} & {{ $guest->wedding->bride_first_name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-stone-700">
                                        @if($guest->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $guest->phone) }}" target="_blank"
                                        class="text-green-700 hover:underline flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                            {{ $guest->phone }}
                                        </a>
                                        @else
                                        <span class="text-stone-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                        $statusColors = [
                                            'pending' => 'bg-stone-100 text-stone-600',
                                            'hadir' => 'bg-green-100 text-green-800',
                                            'tidak_hadir' => 'bg-red-100 text-red-800',
                                            'ragu' => 'bg-amber-100 text-amber-800'
                                        ];
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusColors[$guest->status] ?? 'bg-stone-100' }}">
                                            {{ $guest->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($guest->is_sent)
                                        <span class="text-green-600 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($guest->sent_at)->format('d/m') }}
                                        </span>
                                        @else
                                        <span class="text-stone-400">Not sent</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('guests.show', $guest) }}"
                                            class="text-blue-700 hover:text-blue-900" title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('guests.send', $guest) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-700 hover:text-green-900" title="Send via WhatsApp">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-stone-500">
                                        <svg class="w-16 h-16 mx-auto text-stone-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <p class="text-lg font-medium">No guests found</p>
                                        <p class="text-sm mt-1">Import guests from Excel or add manually to get started.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="px-6 py-4 border-t border-stone-200">
                        {{ $guests->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Import Modal --}}
    <x-modal name="import-guests" :show="$errors->hasAny(['file', 'wedding_id'])" maxWidth="lg">
        <form action="{{ route('guests.import') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <h3 class="text-lg font-medium text-stone-900 mb-4">Import Guests from Excel</h3>

            <div class="space-y-4">
                {{-- Wedding Select (if admin) --}}
                @if(Auth::user()->isAdmin())
                <div>
                    <x-input-label for="wedding_id" value="Select Wedding *" />
                    <select id="wedding_id" name="wedding_id" required
                            class="mt-1 block w-full rounded-xl border-stone-300 focus:border-amber-600 focus:ring-amber-200">
                        <option value="">Choose a wedding...</option>
                        @foreach($weddings as $w)
                        <option value="{{ $w->id }}" {{ request('wedding_id') == $w->id ? 'selected' : '' }}>
                            {{ $w->groom_first_name }} & {{ $w->bride_first_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @else
                <input type="hidden" name="wedding_id" value="{{ Auth::user()->weddings->first()?->id }}">
                @endif

                {{-- File Upload --}}
                <div>
                    <x-input-label for="file" value="Excel/CSV File *" />
                    <input type="file" id="file" name="file" accept=".xlsx,.xls,.csv" required
                           class="mt-1 block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4
                                  file:rounded-xl file:border-0 file:text-sm file:font-medium
                                  file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    <p class="mt-1 text-xs text-stone-500">Columns required: <code>name</code>, <code>phone</code>, <code>email</code> (optional)</p>
                </div>

                {{-- Download Template --}}
                <div class="bg-stone-50 rounded-xl p-4">
                    <p class="text-sm text-stone-700 mb-2">📥 Need a template?</p>
                    <a href="{{ route('guests.template') }}"
                        class="text-amber-700 hover:text-amber-800 text-sm font-medium flex items-center gap-1" target="_blank">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Excel Template
                    </a>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="$dispatch('close')"
                        class="px-4 py-2 bg-white border border-stone-300 rounded-xl text-stone-700 hover:bg-stone-50 transition">
                    Cancel
                </button>
                <x-primary-button type="submit">
                    Import Guests
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    {{-- Bulk Action Handler --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Bulk Action Handler
            document.addEventListener('bulk-action', (e) => {
                const action = e.detail;
                const checked = document.querySelectorAll('input[name="guest_ids[]"]:checked');

                if (checked.length === 0 && action !== 'export') {
                    alert('Pilih minimal 1 tamu untuk aksi ini.');
                    return;
                }

                if (action === 'send') {
                    // ✅ WhatsApp Bulk Send (existing code)
                    if (!confirm(`Kirim undangan ke ${checked.length} tamu via WhatsApp?`)) return;

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('guests.bulk-send') }}";

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = "{{ csrf_token() }}";
                    form.appendChild(csrf);

                    checked.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'guest_ids[]';
                        input.value = cb.value;
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();

                } else if (action === 'export') {
                    // ✅ FIX: Tambah handler untuk Export
                    alert('Fitur export akan segera hadir!');
                    // Atau implementasikan:
                    // window.location.href = "{{ route('guests.export') }}?ids=" + Array.from(checked).map(c => c.value).join(',');
                }
            });
        });
    </script>
</x-app-layout>
