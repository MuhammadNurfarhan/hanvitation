<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl font-semibold text-red-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-6 text-stone-900">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-serif font-bold">Selamat Datang, {{ Auth::user()->name }} 🕊️</h3>
                            <p class="text-stone-500 mt-1">Kelola undangan pernikahan digital Anda dari sini.</p>
                        </div>
                        <a href="{{ route('weddings.create') }}" class="inline-flex items-center px-4 py-2 bg-red-900 text-white rounded-xl hover:bg-red-800 transition shadow">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Buat Undangan Baru
                        </a>
                    </div>

                    {{-- Quick Navigation Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        {{-- Weddings Card --}}
                        <a href="{{ route('weddings.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-stone-200 hover:border-red-300 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-stone-500 uppercase tracking-wider font-medium">Wedding Management</p>
                                    <p class="text-3xl font-bold text-red-900 mt-2">{{ $totalWeddings ?? 0 }}</p>
                                    <p class="text-sm text-stone-600 mt-1">Total weddings created</p>
                                </div>
                                <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center group-hover:bg-red-200 group-hover:scale-110 transition-all">
                                    <svg class="w-7 h-7 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center text-amber-700 font-medium group-hover:translate-x-1 transition-transform">
                                <span>Manage Weddings</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>

                        {{-- Guests Card --}}
                        <a href="{{ route('guests.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-stone-200 hover:border-amber-300 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-stone-500 uppercase tracking-wider font-medium">Guest Management</p>
                                    <p class="text-3xl font-bold text-amber-700 mt-2">{{ $totalGuests ?? 0 }}</p>
                                    <p class="text-sm text-stone-600 mt-1">Total guests registered</p>
                                </div>
                                <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center group-hover:bg-amber-200 group-hover:scale-110 transition-all">
                                    <svg class="w-7 h-7 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center text-amber-700 font-medium group-hover:translate-x-1 transition-transform">
                                <span>Manage Guests</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
