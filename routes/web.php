<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('landing');

// Auth Routes (dari Breeze)
require __DIR__.'/auth.php';

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Users
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    
    // CRUD Terapis
    Route::resource('terapis', App\Http\Controllers\Admin\TerapisController::class);
    
    // CRUD Services
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class);

    // CRUD Service Categories
    Route::resource('service-categories', App\Http\Controllers\Admin\ServiceCategoryController::class);
    
    // CRUD Locations
    Route::resource('locations', App\Http\Controllers\Admin\LocationController::class);
    
    // Kelola Bookings
    Route::resource('bookings', App\Http\Controllers\Admin\BookingController::class);
    Route::patch('bookings/{booking}/confirm-payment', [App\Http\Controllers\Admin\BookingController::class, 'confirmPayment'])->name('bookings.confirm-payment');
    Route::patch('bookings/{booking}/reject-payment', [App\Http\Controllers\Admin\BookingController::class, 'rejectPayment'])->name('bookings.reject-payment');
    
    // Lihat Comments
    Route::get('comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
});

// Midtrans Webhook (no auth needed)
Route::post('/midtrans/callback', [App\Http\Controllers\Customer\BookingController::class, 'midtransCallback'])->name('midtrans.callback');

// Midtrans Redirect URLs (dari Midtrans Dashboard — no auth middleware)
Route::get('/payment/finish', [App\Http\Controllers\Customer\BookingController::class, 'paymentFinish'])->name('payment.finish');
Route::get('/payment/error',  [App\Http\Controllers\Customer\BookingController::class, 'paymentError'])->name('payment.error');

// Customer Routes
Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');

    // Services
    Route::get('/services', [App\Http\Controllers\Customer\ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [App\Http\Controllers\Customer\ServiceController::class, 'show'])->name('services.show');

    // Bookings
    Route::resource('bookings', App\Http\Controllers\Customer\BookingController::class);
    Route::patch('bookings/{booking}/cancel', [App\Http\Controllers\Customer\BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('bookings/{booking}/payment', [App\Http\Controllers\Customer\BookingController::class, 'uploadPayment'])->name('bookings.payment');
    Route::post('bookings/{booking}/comment', [App\Http\Controllers\Customer\BookingController::class, 'storeComment'])->name('bookings.comment');
    Route::get('/bookings/slots', [App\Http\Controllers\Customer\BookingController::class, 'getBookedSlots'])->name('bookings.slots');

    // Profile
    Route::get('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('profile.update');
});

// Terapis Routes
Route::prefix('terapis')->name('terapis.')->middleware(['auth', 'terapis'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Terapis\DashboardController::class, 'index'])->name('dashboard');
    
    // Bookings
    Route::get('/bookings', [App\Http\Controllers\Terapis\BookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/confirm', [App\Http\Controllers\Terapis\BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('/bookings/{booking}/update-status', [App\Http\Controllers\Terapis\BookingController::class, 'updateStatus'])->name('bookings.update-status');
    
    // Schedule
    Route::get('/schedule', [App\Http\Controllers\Terapis\BookingController::class, 'schedule'])->name('schedule');
    
    // Ratings & Comments
    Route::get('/ratings', [App\Http\Controllers\Terapis\ProfileController::class, 'ratings'])->name('ratings');
    
    // Profile
    Route::get('/profile', [App\Http\Controllers\Terapis\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Terapis\ProfileController::class, 'update'])->name('profile.update');
});

// Unauthorized Page
Route::get('/unauthorized', function () {
    return view('errors.unauthorized');
})->name('unauthorized');
