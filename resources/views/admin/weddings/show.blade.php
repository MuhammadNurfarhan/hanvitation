<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-serif text-2xl font-semibold text-red-900 leading-tight">
                    Wedding Preview
                </h2>
                <p class="text-stone-600 mt-1">
                    {{ $wedding->groom_first_name }} & {{ $wedding->bride_first_name }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('weddings.edit', $wedding) }}"
                   class="px-4 py-2 bg-white border border-stone-300 rounded-xl text-stone-700 hover:bg-stone-50 transition flex items-center gap-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ $wedding->getInvitationUrlAttribute() }}" target="_blank"
                   class="px-4 py-2 bg-red-900 text-white rounded-xl hover:bg-red-800 transition flex items-center gap-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Open Live
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Status Banner --}}
            <div class="p-4 rounded-xl {{ $wedding->is_published ? 'bg-green-50 border border-green-200' : 'bg-amber-50 border border-amber-200' }}">
                <div class="flex items-center gap-3">
                    @if($wedding->is_published)
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-green-900">Published & Live</p>
                        <p class="text-sm text-green-700">Invitation is accessible at:
                            <a href="{{ $wedding->getInvitationUrlAttribute() }}" target="_blank" class="underline">
                                {{ $wedding->getInvitationUrlAttribute() }}
                            </a>
                        </p>
                    </div>
                    @else
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-amber-900">Draft Mode</p>
                        <p class="text-sm text-amber-700">This invitation is not yet published. Publish to make it accessible.</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Cover Preview --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                @if($wedding->cover_image)
                <img src="{{ asset('storage/' . $wedding->cover_image) }}"
                     class="w-full h-64 object-cover" alt="Cover">
                @else
                <div class="w-full h-64 bg-gradient-to-br from-red-100 to-amber-100 flex items-center justify-center">
                    <svg class="w-20 h-20 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                @endif
                <div class="p-6 text-center">
                    <p class="text-sm uppercase tracking-[0.2em] text-stone-500">The Wedding Of</p>
                    <h1 class="font-serif text-4xl font-bold text-red-900 mt-2">
                        {{ $wedding->groom_first_name }} & {{ $wedding->bride_first_name }}
                    </h1>
                    <p class="text-stone-600 mt-3">
                        {{ \Carbon\Carbon::parse($wedding->event_date)->isoFormat('dddd, D MMMM YYYY') }}
                    </p>
                    @if($wedding->quote)
                    <blockquote class="font-serif italic text-stone-700 mt-4 border-l-4 border-amber-600 pl-4">
                        "{{ $wedding->quote }}"
                        @if($wedding->quote_source)
                        <cite class="not-italic text-sm text-stone-500 block mt-1">— {{ $wedding->quote_source }}</cite>
                        @endif
                    </blockquote>
                    @endif
                </div>
            </div>

            {{-- Events Preview --}}
            @if($wedding->events->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-serif text-xl font-bold text-red-900 mb-4">Event Schedule</h3>
                <div class="space-y-4">
                    @foreach($wedding->events as $event)
                    <div class="flex items-start gap-4 p-4 bg-stone-50 rounded-xl">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0
                                    {{ $event->type === 'misa' ? 'bg-red-900' : 'bg-amber-700' }}">
                            @if($event->type === 'misa')
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            @else
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/>
                            </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-serif font-semibold text-stone-900">{{ $event->type_label }}</h4>
                            <p class="text-sm text-stone-600 mt-1">
                                🕐 {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, H:i') }}
                                @if($event->end_time)
                                - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB
                                @endif
                            </p>
                            <p class="text-sm text-stone-700 mt-2 font-medium">{{ $event->venue_name }}</p>
                            <p class="text-sm text-stone-500">{{ $event->address }}</p>
                            @if($event->maps_link)
                            <a href="{{ $event->maps_link }}" target="_blank"
                               class="text-sm text-amber-700 hover:text-amber-800 mt-1 inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Open in Maps
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Gallery Preview --}}
            @if($wedding->gallery->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-serif text-xl font-bold text-red-900 mb-4">Gallery Preview</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($wedding->gallery->take(8) as $photo)
                    <img src="{{ asset('storage/' . $photo->url) }}"
                         class="w-full h-24 object-cover rounded-lg shadow-sm hover:shadow-md transition"
                         alt="Gallery">
                    @endforeach
                </div>
                @if($wedding->gallery->count() > 8)
                <p class="text-sm text-stone-500 mt-3 text-center">
                    + {{ $wedding->gallery->count() - 8 }} more photos
                </p>
                @endif
            </div>
            @endif

            {{-- Digital Gifts Preview --}}
            @if($wedding->bankAccounts->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-serif text-xl font-bold text-red-900 mb-4">Digital Envelope</h3>
                <div class="space-y-3">
                    @foreach($wedding->bankAccounts as $bank)
                    <div class="p-4 bg-stone-50 rounded-xl flex items-center justify-between">
                        <div>
                            <p class="font-medium text-stone-900">{{ $bank->bank_name }}</p>
                            <p class="text-sm font-mono text-stone-700">{{ $bank->account_number }}</p>
                            <p class="text-xs text-stone-500">{{ $bank->account_holder }}</p>
                        </div>
                        <button onclick="navigator.clipboard.writeText('{{ $bank->account_number }}')"
                                class="px-3 py-1 text-xs bg-red-900 text-white rounded-lg hover:bg-red-800 transition">
                            Copy
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Quick Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm text-center">
                    <p class="text-3xl font-bold text-red-900">{{ $wedding->guests->count() }}</p>
                    <p class="text-xs text-stone-500 uppercase">Total Guests</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm text-center">
                    <p class="text-3xl font-bold text-green-700">{{ $wedding->guests->where('status', 'hadir')->count() }}</p>
                    <p class="text-xs text-stone-500 uppercase">Confirmed</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm text-center">
                    <p class="text-3xl font-bold text-amber-700">{{ $wedding->gallery->count() }}</p>
                    <p class="text-xs text-stone-500 uppercase">Photos</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm text-center">
                    <p class="text-3xl font-bold text-blue-700">{{ $wedding->guestMessages->count() }}</p>
                    <p class="text-xs text-stone-500 uppercase">Wishes</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
