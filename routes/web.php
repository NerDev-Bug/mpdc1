<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('home');

Route::get('/about', function () {
    return Inertia::render('about/AboutUs'); // Adjusted to match the folder structure
})->name('about');

Route::get('/citadines', function () {
    return Inertia::render('citidine/Citadines');
})->name('citadines');

Route::get('/location', function () {
    return Inertia::render('location/Location'); // Or whatever the appropriate controller is
})->name('location');

Route::get('/amenities', function () {
    return Inertia::render('amenities/Amenities'); // Or whatever the appropriate controller is
})->name('amenities');

Route::get('/service-residence', function () {
    return Inertia::render('residence1/ServiceResidence'); // Or whatever the appropriate controller is
})->name('residence1');

Route::get('/private-service-residence', function () {
    return Inertia::render('residence2/PrivateServiceResidence'); // Or whatever the appropriate controller is
})->name('residence2');

Route::get('/news-and-update', function () {
    return Inertia::render('news/NewsUpdate'); // Or whatever the appropriate controller is
})->name('news');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
