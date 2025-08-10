<?php

use Livewire\Volt\Volt;
use App\Livewire\HomePage;
use App\Livewire\CourseShow;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Route::view('/', 'dashboard')->name('home');

Route::get('/', HomePage::class)->name('home');
Route::get('/course/{slug}', CourseShow::class)->name('course.show');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';