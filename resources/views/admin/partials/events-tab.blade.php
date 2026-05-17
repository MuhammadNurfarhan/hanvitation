<div class="space-y-6" x-data="{
    modalOpen: false,
    modalMode: 'create',
    form: {
        id: null,
        type: 'misa',
        venue_name: '',
        address: '',
        maps_link: '',
        start_time: '',
        end_time: '',
        description: ''
    },
    errors: {},

    openCreateModal() {
        this.modalMode = 'create';
        this.resetForm();
        this.modalOpen = true;
    },

    // ✅ FIX 1: Terima object event yang sudah diformat dari Blade
    openEditModal(event) {
        this.modalMode = 'edit';
        this.form = {
            id: event.id,
            type: event.type,
            venue_name: event.venue_name,
            address: event.address,
            maps_link: event.maps_link,
            // ✅ FIX 2: Tanggal sudah diformat 'Y-m-d\TH:i' dari Blade, tinggal assign
            start_time: event.start_time_formatted,
            end_time: event.end_time_formatted,
            description: event.description
        };
        this.errors = {};
        this.modalOpen = true;
    },

    confirmDelete(eventId, typeLabel, venueName) {
        const message = `Hapus event '${typeLabel}' di ${venueName}?`;
        if (confirm(message)) {
            const form = document.getElementById(`delete-form-${eventId}`);
            if (form) {
                form.submit();
            } else {
                alert('Form delete tidak ditemukan. Silakan refresh halaman.');
            }
        }
    },

    closeModal() {
        this.modalOpen = false;
        this.resetForm();
        this.errors = {};
    },

    resetForm() {
        this.form = {
            id: null, type: 'misa', venue_name: '', address: '',
            maps_link: '', start_time: '', end_time: '', description: ''
        };
    },

    get showEndTime() {
        return ['resepsi', 'akad', 'ramah_tamah'].includes(this.form.type);
    },

    // ✅ FIX 3: Gunakan hidden input 'event_id' untuk update, tidak perlu manipulasi URL
    get formAction() {
        return this.modalMode === 'edit'
            ? `{{ route('weddings.events.update', [$wedding, '__ID__']) }}`.replace('__ID__', this.form.id)
            : `{{ route('weddings.events.store', $wedding) }}`;
    },

    get formMethod() {
        return this.modalMode === 'edit' ? 'PUT' : 'POST';
    },

    get modalTitle() {
        return this.modalMode === 'create' ? '➕ Add New Event' : '✏️ Edit Event';
    },

    get submitText() {
        return this.modalMode === 'create' ? '💾 Add Event' : '💾 Update Event';
    },


}">

    {{-- ✅ Unified Modal --}}
    <div x-show="modalOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         @click.self="closeModal()"
         @keydown.escape.window="closeModal()"
         x-cloak>

        <div x-show="modalOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-4 border-b border-stone-200 sticky top-0 bg-white rounded-t-2xl z-10">
                <h3 class="font-serif-custom text-lg font-bold text-red-900" x-text="modalTitle"></h3>
                <button @click="closeModal()" class="text-stone-400 hover:text-stone-600 p-1 transition-colors" title="Close">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Modal Body - Form --}}
            <form :action="formAction" method="POST" class="p-4 space-y-4">
                @csrf
                <template x-if="modalMode === 'edit'">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="form_type" value="Event Type *" />
                        <select name="type" x-model="form.type" required class="mt-1 block w-full rounded-xl border-stone-300 focus:border-amber-600 focus:ring-amber-200">
                            <option value="misa">⛪ Misa Pernikahan</option>
                            <option value="resepsi">🎉 Resepsi</option>
                            <option value="akad">💍 Akad Nikah</option>
                            <option value="ramah_tamah">🤝 Ramah Tamah</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="form_venue_name" value="Venue Name *" />
                        <x-text-input name="venue_name" x-model="form.venue_name" placeholder="Nama Tempat" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('venue_name')" class="mt-1" />
                    </div>
                </div>

                <div>
                    <x-input-label for="form_address" value="Full Address *" />
                    <textarea name="address" x-model="form.address" placeholder="Alamat" rows="2" required class="mt-1 block w-full rounded-xl border-stone-300 focus:border-amber-600 focus:ring-amber-200"></textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-1" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="form_maps_link" value="Google Maps Link" />
                        <x-text-input name="maps_link" x-model="form.maps_link" placeholder="https://maps.google.com/..." type="url" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('maps_link')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="form_start_time" value="Start Time *" />
                        <x-text-input name="start_time" x-model="form.start_time" type="datetime-local" required class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('start_time')" class="mt-1" />
                    </div>
                </div>

                <template x-if="showEndTime">
                    <div x-transition>
                        <x-input-label for="form_end_time" value="End Time (Optional)" />
                        <x-text-input name="end_time" x-model="form.end_time" type="datetime-local" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('end_time')" class="mt-1" />
                    </div>
                </template>

                <div>
                    <x-input-label for="form_description" value="Description" />
                    <textarea name="description" x-model="form.description" placeholder="Tambahan informasi" rows="2" class="mt-1 block w-full rounded-xl border-stone-300 focus:border-amber-600 focus:ring-amber-200"></textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <div class="flex gap-3 justify-end pt-4 border-t border-stone-200 sticky bottom-0 bg-white">
                    <button type="button" @click="closeModal()" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl font-medium transition-colors text-sm">Batal</button>
                    <x-primary-button type="submit" x-text="submitText"></x-primary-button>
                </div>
            </form>
        </div>
    </div>

    {{-- Trigger Button: Add Event --}}
    <div class="bg-stone-50 rounded-xl p-4">
        <div class="flex items-center justify-between mb-3">
            <h4 class="font-medium text-stone-900">📅 Wedding Events</h4>
            <button type="button" @click="openCreateModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-red-900 hover:bg-red-800 text-white rounded-xl font-medium transition-colors text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Event
            </button>
        </div>

        {{-- Events List --}}
        @forelse($wedding->events->sortBy('order') as $event)
        <div class="flex items-center justify-between p-4 bg-white rounded-xl mb-3 border border-stone-100 hover:border-amber-200 hover:shadow-sm transition-all">
            <div class="flex-1 min-w-0">
                <p class="font-medium text-stone-900">
                    <span class="px-2 py-0.5 text-xs rounded-full {{
                        $event->type === 'misa' ? 'bg-red-100 text-red-800' :
                        ($event->type === 'resepsi' ? 'bg-amber-100 text-amber-800' :
                        ($event->type === 'akad' ? 'bg-pink-100 text-pink-800' :
                        'bg-green-100 text-green-800'))
                    }}">{{ $event->type_label }}</span>
                    <span class="ml-2 font-normal">{{ $event->venue_name }}</span>
                </p>
                <p class="text-sm text-stone-600 mt-1">
                    🕐 {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, H:i') }}
                    @if($event->end_time) - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} @else - Selesai @endif
                </p>
                @if($event->address)<p class="text-xs text-stone-500 mt-1 truncate">📍 {{ Str::limit($event->address, 50) }}</p>@endif
            </div>

            <div class="flex items-center gap-1 ml-4">
                {{-- ✅ FIX 4: Gunakan Js::from() untuk aman passing data --}}
                <button type="button" class="text-amber-700 hover:text-amber-900 p-2 flex items-center gap-1 text-sm" title="Edit"
                        @click="openEditModal({{ Js::from([
                            'id' => $event->id,
                            'type' => $event->type,
                            'venue_name' => $event->venue_name,
                            'address' => $event->address,
                            'maps_link' => $event->maps_link,
                            'description' => $event->description,
                            // ✅ FIX 5: Format tanggal di Blade agar cocok dengan input HTML
                            'start_time_formatted' => $event->start_time?->format('Y-m-d\TH:i'),
                            'end_time_formatted' => $event->end_time?->format('Y-m-d\TH:i'),
                        ]) }})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span class="hidden sm:inline">Edit</span>
                </button>

                {{-- Delete Button --}}
                <button type="button"
                        class="text-red-700 hover:text-red-900 p-2 flex items-center gap-1 text-sm"
                        title="Delete"
                        @click="confirmDelete({{ Js::from($event->id) }}, {{ Js::from($event->type_label) }}, {{ Js::from($event->venue_name) }})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span class="hidden sm:inline">Delete</span>
                </button>

                <form id="delete-form-{{ $event->id }}" action="{{ route('weddings.events.destroy', [$wedding, $event]) }}" method="POST" class="hidden">
                    @csrf @method('DELETE')
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-8 bg-stone-50 rounded-xl border-2 border-dashed border-stone-200">
            <p class="text-stone-500 text-sm mb-3">Belum ada event ditambahkan.</p>
            <button type="button" @click="openCreateModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-red-900 hover:bg-red-800 text-white rounded-xl font-medium transition-colors text-sm">Tambah Event Pertama</button>
        </div>
        @endforelse
    </div>
</div>
