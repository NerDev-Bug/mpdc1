<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\NewsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // News CRUD
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::post('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

    // Inquiries
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::delete('/inquiries/service/{inquiry}', [InquiryController::class, 'destroyService'])->name('inquiries.destroy-service');
    Route::delete('/inquiries/private/{inquiry1}', [InquiryController::class, 'destroyPrivate'])->name('inquiries.destroy-private');
    Route::delete('/inquiries/contact/{contact}', [InquiryController::class, 'destroyContact'])->name('inquiries.destroy-contact');
    Route::delete('/inquiries/booking/{booking}', [InquiryController::class, 'destroyBooking'])->name('inquiries.destroy-booking');
});
