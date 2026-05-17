<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-serif text-2xl font-semibold text-red-900 leading-tight">
                {{ __('Edit Wedding') }}: {{ $wedding->groom_first_name }} & {{ $wedding->bride_first_name }}
            </h2>
            <div class="flex items-center gap-2">
                @if(!$wedding->is_published)
                <form action="{{ route('weddings.publish', $wedding) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-xl hover:bg-green-800 transition shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Publish
                    </button>
                </form>
                @else
                <a href="{{ $wedding->getInvitationUrlAttribute() }}" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-blue-700 text-white rounded-xl hover:bg-blue-800 transition shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Preview Live
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div x-data="{ activeTab: 'basic' }" x-cloak class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
            <div x-data="{ show: true, init() { setTimeout(() => this.show = false, 5000) } }" x-show="show" x-transition
                class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="text-green-600 hover:text-green-800">✕</button>
            </div>
            @endif

            {{-- Error Message --}}
            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button @click="show = false" class="text-red-600 hover:text-red-800">✕</button>
            </div>
            @endif

            {{-- ⚠️ Warning: Foto Mempelai Belum Lengkap --}}
            @if(!$wedding->groom_photo || !$wedding->bride_photo)
            <div class="mb-4 p-4 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="font-medium">Foto Mempelai Belum Lengkap</h3>
                    <p class="text-sm mt-1">
                        @if(!$wedding->groom_photo)
                            • Upload foto mempelai putra<br>
                        @endif
                        @if(!$wedding->bride_photo)
                            • Upload foto mempelai putri
                        @endif
                    </p>
                    <p class="text-xs text-amber-600 mt-2">
                        💡 Klik tab <strong>"Basic Info"</strong> untuk upload foto. Foto wajib lengkap sebelum undangan bisa dipublish.
                    </p>
                </div>
                <button @click="$el.parentElement.remove()" class="text-amber-600 hover:text-amber-800 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @endif

            {{-- Tabs Navigation (now inside x-data scope) --}}
            <div class="mb-6">
                <div class="border-b border-stone-200">
                    <nav class="flex space-x-4 overflow-x-auto pb-1" aria-label="Tabs">
                        <button type="button" @click="activeTab = 'basic'"
                                :class="activeTab === 'basic' ? 'border-red-700 text-red-700' : 'border-transparent text-stone-500 hover:text-stone-700 hover:border-stone-300'"
                                class="whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                            Basic Info
                        </button>
                        <button type="button" @click="activeTab = 'events'"
                                :class="activeTab === 'events' ? 'border-red-700 text-red-700' : 'border-transparent text-stone-500 hover:text-stone-700 hover:border-stone-300'"
                                class="whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                            Events ({{ $wedding->events->count() }})
                        </button>
                        <button type="button" @click="activeTab = 'gallery'"
                                :class="activeTab === 'gallery' ? 'border-red-700 text-red-700' : 'border-transparent text-stone-500 hover:text-stone-700 hover:border-stone-300'"
                                class="whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                            Gallery ({{ $wedding->gallery->count() }})
                        </button>
                        <button type="button" @click="activeTab = 'gifts'"
                                :class="activeTab === 'gifts' ? 'border-red-700 text-red-700' : 'border-transparent text-stone-500 hover:text-stone-700 hover:border-stone-300'"
                                class="whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                            Digital Gifts
                        </button>
                        <button type="button" @click="activeTab = 'settings'"
                                :class="activeTab === 'settings' ? 'border-red-700 text-red-700' : 'border-transparent text-stone-500 hover:text-stone-700 hover:border-stone-300'"
                                class="whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm transition-colors cursor-pointer">
                            Settings
                        </button>
                    </nav>
                </div>
            </div>

            {{-- Tab Content (now inside x-data scope) --}}
            <div class="bg-white shadow-sm sm:rounded-2xl p-6">

                {{-- Tab: Basic Info --}}
                <div x-show="activeTab === 'basic'" x-transition.opacity>
                    @include('admin.partials.wedding-form', [
                        'wedding' => $wedding,
                        'action' => route('weddings.update', $wedding),
                        'method' => 'PUT'
                    ])
                </div>

                {{-- Tab: Events --}}
                <div x-show="activeTab === 'events'" x-transition.opacity>
                    @include('admin.partials.events-tab', ['wedding' => $wedding])
                </div>

                {{-- Tab: Gallery --}}
                <div x-show="activeTab === 'gallery'" x-transition.opacity>
                    @include('admin.partials.gallery-tab', ['wedding' => $wedding])
                </div>

                {{-- Tab: Digital Gifts --}}
                <div x-show="activeTab === 'gifts'" x-transition.opacity>
                    @include('admin.partials.gifts-tab', ['wedding' => $wedding])
                </div>

                {{-- Tab: Settings --}}
                <div x-show="activeTab === 'settings'" x-transition.opacity>
                    @include('admin.partials.settings-tab', ['wedding' => $wedding])
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
