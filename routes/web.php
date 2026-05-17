<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Guest\InvitationController;
use App\Http\Controllers\Guest\RSVPController;
use App\Http\Controllers\Guest\GuestbookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WeddingController;
use App\Http\Controllers\Admin\GuestController;
use Illuminate\Support\Facades\Route;
use App\Exports\GuestsTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

// =============================================================================
// 1. PUBLIC ROUTES (Specific routes FIRST, before catch-all {slug})
// =============================================================================

// Root welcome page
Route::get('/', function () {
    return view('welcome');
});

Route::get('guests/template', function () {
    return Excel::download(new GuestsTemplateExport, 'guests-import-template.xlsx');
})->name('guests.template');

// Health check / test route
Route::get('/test', function() {
    return response()->json([
        'status' => 'OK',
        'laravel' => app()->version(),
        'php' => phpversion(),
        'app' => config('app.name')
    ]);
});

// =============================================================================
// 2. AUTHENTICATION ROUTES (Laravel Breeze)
// =============================================================================
require __DIR__.'/auth.php';

// =============================================================================
// 3. PROTECTED DASHBOARD ROUTES
// =============================================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Wedding Management
    Route::prefix('weddings')->name('weddings.')->group(function () {
        Route::get('/', [WeddingController::class, 'index'])->name('index');
        Route::get('/create', [WeddingController::class, 'create'])->name('create');
        Route::post('/', [WeddingController::class, 'store'])->name('store');
        Route::get('/{wedding}', [WeddingController::class, 'show'])->name('show');
        Route::get('/{wedding}/edit', [WeddingController::class, 'edit'])->name('edit');
        Route::put('/{wedding}', [WeddingController::class, 'update'])->name('update');
        Route::delete('/{wedding}', [WeddingController::class, 'destroy'])->name('destroy');

        // Wedding Actions
        Route::post('/{wedding}/publish', [WeddingController::class, 'publish'])->name('publish');
        Route::post('/{wedding}/events', [WeddingController::class, 'addEvent'])->name('events.store');
        Route::put('/{wedding}/events/{event}', [WeddingController::class, 'updateEvent'])->name('events.update');
        Route::post('/{wedding}/gallery', [WeddingController::class, 'uploadGallery'])->name('gallery.upload');
        Route::post('/{wedding}/bank-account', [WeddingController::class, 'addBankAccount'])->name('bank.store');

        Route::delete('/{wedding}/events/{event}', [WeddingController::class, 'deleteEvent'])->name('events.destroy');
        Route::delete('/{wedding}/gallery/{photo}', [WeddingController::class, 'deleteGallery'])->name('gallery.destroy');
        Route::delete('/{wedding}/bank-account/{bank}', [WeddingController::class, 'deleteBankAccount'])->name('bank.destroy');
    });

    // Guest Management
    Route::prefix('guests')->name('guests.')->group(function () {
        Route::get('/', [GuestController::class, 'index'])->name('index');
        Route::post('/import', [GuestController::class, 'import'])->name('import');
        Route::get('/export', [GuestController::class, 'export'])->name('export');
        Route::get('/{guest}', [GuestController::class, 'show'])->name('show');
        Route::post('/{guest}/send', [GuestController::class, 'sendInvitation'])->name('send');
        Route::post('/bulk-send', [GuestController::class, 'bulkSend'])->name('bulk-send');
        Route::delete('/{guest}', [GuestController::class, 'destroy'])->name('destroy');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =============================================================================
// 4. GUEST INVITATION ROUTES (Catch-all {slug} - MUST BE LAST!)
// =============================================================================

// Constraint: slug hanya boleh berisi huruf, angka, dan tanda hubung
// Exclude reserved words: dashboard, login, register, profile, admin, api, dll
Route::get('/{slug}', [InvitationController::class, 'show'])
    ->name('guest.show')
    ->where('slug', '^(?!dashboard|login|register|profile|admin|api|test|storage|_ignition|_tt|wire|livewire)[a-zA-Z0-9-]+$');

Route::post('/{slug}/rsvp', [RSVPController::class, 'store'])
    ->name('guest.rsvp.store')
    ->middleware(app()->environment('production') ? 'throttle:3,10' : [])
    ->where('slug', '^(?!dashboard|login|register|profile|admin|api|test|storage|_ignition|_tt|wire|livewire)[a-zA-Z0-9-]+$');

Route::get('/{slug}/guestbook', [GuestbookController::class, 'index'])
    ->name('guest.guestbook.index')
    ->where('slug', '^(?!dashboard|login|register|profile|admin|api|test|storage|_ignition|_tt|wire|livewire)[a-zA-Z0-9-]+$');

Route::post('/{slug}/guestbook', [GuestbookController::class, 'store'])
    ->name('guest.guestbook.store')
    ->middleware(app()->environment('production') ? 'throttle:3,10' : [])
    ->where('slug', '^(?!dashboard|login|register|profile|admin|api|test|storage|_ignition|_tt|wire|livewire)[a-zA-Z0-9-]+$');
