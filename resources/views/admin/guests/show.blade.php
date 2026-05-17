<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-serif text-2xl font-semibold text-red-900 leading-tight">
                Guest Details
            </h2>
            <a href="{{ route('guests.index', ['wedding_id' => $guest->wedding_id]) }}"
               class="text-stone-600 hover:text-stone-900 flex items-center gap-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Guest Card --}}
            <div class="bg-white shadow-sm sm:rounded-2xl overflow-hidden">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-red-900 to-amber-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-serif font-bold text-white">{{ $guest->name }}</h3>
                            <p class="text-amber-100 text-sm mt-1">Unique Code: <span class="font-mono">{{ $guest->unique_code }}</span></p>
                        </div>
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-white/20 text-white">
                            {{ $guest->status_label }}
                        </span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 space-y-6">

                    {{-- Wedding Info --}}
                    <div>
                        <h4 class="text-sm font-medium text-stone-500 uppercase tracking-wider mb-3">Wedding</h4>
                        <div class="flex items-center gap-4 p-4 bg-stone-50 rounded-xl">
                            @if($guest->wedding->cover_image)
                            <img src="{{ asset('storage/' . $guest->wedding->cover_image) }}"
                                 class="w-16 h-16 rounded-lg object-cover" alt="Cover">
                            @else
                            <div class="w-16 h-16 bg-stone-200 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                            <div>
                                <p class="font-serif font-semibold text-stone-900">
                                    {{ $guest->wedding->groom_first_name }} & {{ $guest->wedding->bride_first_name }}
                                </p>
                                <p class="text-sm text-stone-600">
                                    {{ \Carbon\Carbon::parse($guest->wedding->event_date)->format('d F Y') }}
                                </p>
                                <a href="{{ route('weddings.edit', $guest->wedding) }}"
                                   class="text-sm text-amber-700 hover:text-amber-800 mt-1 inline-block">
                                    Edit Wedding →
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Info --}}
                    <div>
                        <h4 class="text-sm font-medium text-stone-500 uppercase tracking-wider mb-3">Contact Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-stone-50 rounded-xl">
                                <p class="text-xs text-stone-500 uppercase">Phone / WhatsApp</p>
                                @if($guest->phone)
                                <p class="font-medium text-stone-900 mt-1">{{ $guest->phone }}</p>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $guest->phone) }}" target="_blank"
                                   class="text-sm text-green-700 hover:underline flex items-center gap-1 mt-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    Send WhatsApp
                                </a>
                                @else
                                <p class="text-stone-400 mt-1">Not provided</p>
                                @endif
                            </div>
                            <div class="p-4 bg-stone-50 rounded-xl">
                                <p class="text-xs text-stone-500 uppercase">Email</p>
                                @if($guest->email)
                                <p class="font-medium text-stone-900 mt-1">{{ $guest->email }}</p>
                                <a href="mailto:{{ $guest->email }}"
                                   class="text-sm text-blue-700 hover:underline mt-2 inline-block">
                                    Send Email →
                                </a>
                                @else
                                <p class="text-stone-400 mt-1">Not provided</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- RSVP Details --}}
                    <div>
                        <h4 class="text-sm font-medium text-stone-500 uppercase tracking-wider mb-3">RSVP Details</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-stone-50 rounded-xl">
                                <p class="text-xs text-stone-500 uppercase">Attendance</p>
                                <p class="font-medium text-stone-900 mt-1">{{ $guest->status_label }}</p>
                            </div>
                            <div class="p-4 bg-stone-50 rounded-xl">
                                <p class="text-xs text-stone-500 uppercase">Guest Count</p>
                                <p class="font-medium text-stone-900 mt-1">{{ $guest->guest_count }} person(s)</p>
                            </div>
                        </div>
                        @if($guest->message)
                        <div class="mt-4 p-4 bg-amber-50 rounded-xl border border-amber-200">
                            <p class="text-xs text-amber-700 uppercase mb-2">Message / Doa</p>
                            <p class="text-stone-800 italic">"{{ $guest->message }}"</p>
                        </div>
                        @endif
                    </div>

                    {{-- Invitation Link --}}
                    <div>
                        <h4 class="text-sm font-medium text-stone-500 uppercase tracking-wider mb-3">Invitation Link</h4>
                        <div class="flex items-center gap-2 p-4 bg-stone-50 rounded-xl">
                            <input type="text" readonly value="{{ $guest->invitation_url }}"
                                   class="flex-1 px-3 py-2 bg-white border border-stone-300 rounded-lg text-sm font-mono text-stone-700">
                            <button onclick="navigator.clipboard.writeText('{{ $guest->invitation_url }}');
                                             this.textContent='Copied!';
                                             setTimeout(() => this.textContent='Copy', 2000)"
                                    class="px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 transition text-sm">
                                Copy
                            </button>
                        </div>
                        <p class="text-xs text-stone-500 mt-2">
                            Share this unique link with the guest for personalized invitation experience.
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-between pt-4 border-t border-stone-200">
                        <form action="{{ route('guests.destroy', $guest) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tamu {{ $guest->name }}? Tindakan ini tidak dapat dibatalkan.');">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this guest?')"
                                    class="text-red-700 hover:text-red-900 text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Guest
                            </button>
                        </form>

                        <div class="flex items-center gap-2">
                            @if(!$guest->is_sent && $guest->phone)
                            <form action="{{ route('guests.send', $guest) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="px-4 py-2 bg-green-700 text-white rounded-xl hover:bg-green-800 transition text-sm flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    Send Invitation
                                </button>
                            </form>
                            @endif

                            <a href="{{ $guest->invitation_url }}" target="_blank"
                               class="px-4 py-2 bg-blue-700 text-white rounded-xl hover:bg-blue-800 transition text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Preview
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
