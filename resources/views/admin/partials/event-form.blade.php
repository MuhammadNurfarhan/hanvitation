@props(['event' => null, 'wedding'])

<form action="{{ $event ? route('events.update', $event) : route('weddings.events.store', $wedding) }}"
      method="POST" class="space-y-4" x-data="{ type: '{{ $event?->type ?? 'misa' }}' }">
    @csrf
    @if($event) @method('PUT') @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Event Type --}}
        <div>
            <x-input-label for="type" value="Event Type *" />
            <select id="type" name="type" x-model="type" required
                    class="mt-1 block w-full rounded-xl border-stone-300 focus:border-amber-600 focus:ring-amber-200">
                <option value="misa">Misa Pernikahan (Church)</option>
                <option value="resepsi">Resepsi (Reception)</option>
                <option value="akad">Akad Pernikahan (Marriage Covenant)</option>
                <option value="ramah_tamah">Ramah Tamah (Welcome Reception)</option>
            </select>
            <x-input-error :messages="$errors->get('type')" class="mt-2" />
        </div>

        {{-- Venue Name --}}
        <div>
            <x-input-label for="venue_name" value="Venue Name *" />
            <x-text-input id="venue_name" name="venue_name" type="text" required
                          class="mt-1 block w-full"
                          :value="old('venue_name', $event?->venue_name ?? '')"
                          placeholder="St. Maria Cathedral" />
            <x-input-error :messages="$errors->get('venue_name')" class="mt-2" />
        </div>
    </div>

    {{-- Address --}}
    <div>
        <x-input-label for="address" value="Full Address *" />
        <textarea id="address" name="address" rows="2" required
                  class="mt-1 block w-full rounded-xl border-stone-300 focus:border-amber-600 focus:ring-amber-200"
                  :placeholder="$type === 'misa' ? 'Jl. Gereja No. 123, Jakarta' : 'Jl. Resepsi No. 456, Jakarta'">{{ old('address', $event?->address ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Maps Link --}}
        <div>
            <x-input-label for="maps_link" value="Google Maps Link (Optional)" />
            <x-text-input id="maps_link" name="maps_link" type="url"
                          class="mt-1 block w-full"
                          :value="old('maps_link', $event?->maps_link ?? '')"
                          placeholder="https://maps.google.com/..." />
            <x-input-error :messages="$errors->get('maps_link')" class="mt-2" />
        </div>

        {{-- Start Time --}}
        <div>
            <x-input-label for="start_time" value="Start Time *" />
            <x-text-input id="start_time" name="start_time" type="datetime-local" required
                          class="mt-1 block w-full"
                          :value="old('start_time', $event?->start_time?->format('Y-m-d\TH:i') ?? '')" />
            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
        </div>
    </div>

    {{-- End Time (only for resepsi) --}}
    <div x-show="type === 'resepsi'">
        <x-input-label for="end_time" value="End Time (Optional)" />
        <x-text-input id="end_time" name="end_time" type="datetime-local"
                      class="mt-1 block w-full"
                      :value="old('end_time', $event?->end_time?->format('Y-m-d\TH:i') ?? '')" />
        <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
    </div>

    {{-- Description --}}
    <div>
        <x-input-label for="description" value="Description / Notes (Optional)" />
        <textarea id="description" name="description" rows="3"
                  class="mt-1 block w-full rounded-xl border-stone-300 focus:border-amber-600 focus:ring-amber-200"
                  placeholder="Additional information about the ceremony or reception...">{{ old('description', $event?->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    {{-- Actions --}}
    <div class="flex items-center justify-end gap-3 pt-4">
        @if($event)
        <button type="button" @click="$dispatch('close-modal', 'edit-event-{{ $event->id }}')"
                class="px-4 py-2 bg-white border border-stone-300 rounded-xl text-stone-700 hover:bg-stone-50 transition">
            Cancel
        </button>
        @endif
        <x-primary-button type="submit">
            {{ $event ? 'Update Event' : 'Add Event' }}
        </x-primary-button>
    </div>
</form>

<script>
// Auto-hide end_time field when switching to 'misa'
document.addEventListener('alpine:init', () => {
    Alpine.effect(() => {
        const type = Alpine.store('eventType');
        // Handle conditional display via Alpine
    });
});
</script>
