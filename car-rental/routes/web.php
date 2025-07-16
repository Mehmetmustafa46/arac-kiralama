<?php
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\CarGalleryController;
use App\Http\Controllers\Admin\VehicleController;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [CarController::class, 'index'])->name('home');
Route::resource('cars', CarController::class)->only(['index', 'show']);

// Auth routes
Auth::routes();

// Profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Reservation routes
Route::middleware(['auth'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{carId}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{id}/pay', [ReservationController::class, 'pay'])->name('reservations.pay');
    Route::put('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
});

// Payment routes
Route::middleware(['auth'])->group(function () {
    Route::get('/payments/create/{reservationId}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
});

// Review routes
Route::middleware(['auth'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Password reset routes
Route::get('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Admin Routes - Tüm admin rotalarını tek bir grupta topladım
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Dashboard ve kullanıcı yönetimi
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
    Route::patch('/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('admin.users.status');
    
    // Kullanıcı detay ve düzenleme rotaları
    Route::get('/users/{user}/show', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    
    // Araç yönetimi
    Route::resource('cars', AdminCarController::class)->names('admin.cars');
    
    // Araç galeri yönetimi
    Route::get('/cars/{carId}/gallery', [CarGalleryController::class, 'index'])->name('admin.gallery.index');
    Route::get('/cars/{carId}/gallery/create', [CarGalleryController::class, 'create'])->name('admin.gallery.create');
    Route::post('/cars/{carId}/gallery', [CarGalleryController::class, 'store'])->name('admin.gallery.store');
    Route::get('/cars/{carId}/gallery/{id}/edit', [CarGalleryController::class, 'edit'])->name('admin.gallery.edit');
    Route::put('/cars/{carId}/gallery/{id}', [CarGalleryController::class, 'update'])->name('admin.gallery.update');
    Route::delete('/cars/{carId}/gallery/{id}', [CarGalleryController::class, 'destroy'])->name('admin.gallery.destroy');
    
    // Araç (vehicles) yönetimi
    Route::resource('vehicles', VehicleController::class)->names('admin.vehicles');
    
    // Rezervasyon yönetimi - resource route ile çakışma yaratmaması için admin.reservation prefix'i kullanıyoruz
    Route::get('/admin-reservations', [\App\Http\Controllers\Admin\ReservationController::class, 'index'])->name('admin.reservations.index');
    Route::get('/admin-reservations/{reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'show'])->name('admin.reservations.show');
    Route::get('/admin-reservations/{reservation}/edit', [\App\Http\Controllers\Admin\ReservationController::class, 'edit'])->name('admin.reservations.edit');
    Route::put('/admin-reservations/{reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'update'])->name('admin.reservations.update');
    Route::delete('/admin-reservations/{reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'destroy'])->name('admin.reservations.destroy');
});

