<?php

use App\Livewire\Admin;
use App\Livewire\Dashboard;
use App\Livewire\PrintCoupon;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');
Route::get('dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('print', PrintCoupon::class)->middleware(['auth', 'verified'])->name('print.coupon');
// Route::get('/admin/user', Admin\User::class)->middleware(['auth', 'verified'])->name('admin.user');
Route::get('/admin/program', Admin\Program::class)->middleware(['auth', 'verified', 'admin'])->name('admin.program');
Route::get('/admin/user', Admin\User::class)->middleware(['auth', 'verified', 'admin'])->name('admin.user');
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
