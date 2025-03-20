<?php

use App\Http\Controllers\ContactUsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('home');

Route::resource('contact_us', ContactUsController::class);

Route::get('/about', function () {
    return Inertia::render('about/AboutUs'); // Adjusted to match the folder structure
})->name('about');

Route::get('/citadines', function () {
    return Inertia::render('citidine/Citadines');
})->name('citadines');

Route::get('/location', function () {
    return Inertia::render('location/Location'); // Or whatever the appropriate controller is
})->name('Location');

Route::get('/amenities', function () {
    return Inertia::render('amenities/Amenities'); // Or whatever the appropriate controller is
})->name('Amenities');

Route::get('/service-residence', function () {
    return Inertia::render('residence1/ServiceResidence'); // Or whatever the appropriate controller is
})->name('ServiceResidence');

Route::get('/private-residence', function () {
    return Inertia::render('residence2/PrivateResidence'); // Or whatever the appropriate controller is
})->name('PrivateServiceResidence');

Route::get('/for-partners-and-brokers', function () {
    return Inertia::render('fpb/FBP'); // Or whatever the appropriate controller is
})->name('FBP');

Route::get('/contact-us', function () {
    return Inertia::render('contact/ContactUs'); // Or whatever the appropriate controller is
})->name('ContactUs');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
