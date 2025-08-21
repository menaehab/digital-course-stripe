<?php

use Livewire\Volt\Volt;
use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Livewire\CourseShow;
use App\Livewire\CancelPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Route::view('/', 'dashboard')->name('home');

Route::get('/', HomePage::class)->name('home');
Route::get('/course/{slug}', CourseShow::class)->name('course.show');
Route::get('/cart', CartPage::class)->name('cart');


Route::middleware(['auth'])->group(function () {

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'checkout'])->name('index');
        Route::get('/non-stripe-products', [CheckoutController::class, 'checkoutNonStripeProducts'])->name('non-stripe-products');
        Route::get('/enable-coupon', [CheckoutController::class, 'enableCoupon'])->name('enable-coupon');
        Route::get('/line-items', [CheckoutController::class, 'lineItems'])->name('line-items');
        Route::get('/success', SuccessPage::class)->name('success');
        Route::get('/cancel', CancelPage::class)->name('cancel');
    });
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
