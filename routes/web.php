<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\Inquiry1Controller;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\NewsController as PublicNewsController;
use App\Http\Controllers\NewsImageController;
use App\Models\News;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::withoutMiddleware([
    \Illuminate\Cookie\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
])->group(function () {
    // A working public/storage link is served by the web server before Laravel.
    // This scoped fallback handles the same URL when that deployment link is
    // missing, while taking precedence over Laravel's private storage catch-all.
    Route::get('/storage/news/{filename}', NewsImageController::class)
        ->where('filename', '[A-Za-z0-9][A-Za-z0-9._-]*')
        ->name('news.image');
});

Route::get('/', function () {
    $newsSlides = News::where('is_active', true)
        ->orderBy('sort_order')
        ->get()
        ->map(fn ($item) => [
            'id' => $item->id,
            'title' => $item->title,
            'description' => $item->description,
            'src' => $item->imageUrlPath(),
            'alt' => $item->alt_text ?? '',
            'url' => $item->isPublished()
                ? route('news.show', ['news' => $item->slug], absolute: false)
                : null,
        ]);

    return Inertia::render('Dashboard', [
        'newsSlides' => $newsSlides,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('home');
})->name('dashboard');

Route::post('/contacts', [ContactsController::class, 'store'])->name('contacts.store');
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
Route::post('/inquiry1s', [Inquiry1Controller::class, 'store'])->name('inquiry1s.store');
Route::post('/table_booking', [BookingController::class, 'store'])->name('table_booking.store');

// These prefixes previously exposed empty resource-controller pages. Keep the
// form POST endpoints above, but make every unsupported crawlable URL a 404.
foreach (['contacts', 'inquiry', 'inquiry1s', 'table_booking'] as $formEndpoint) {
    Route::get("/{$formEndpoint}/{path?}", static fn () => abort(404))
        ->where('path', '.*');
}

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

Route::get('/serviced-residence', function () {
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

Route::get('/data-privacy', function () {
    return Inertia::render('dpc/DataPrivacy'); // Or whatever the appropriate controller is
})->name('DataPrivacy');

Route::get('/news', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [PublicNewsController::class, 'show'])->name('news.show');

Route::get('/sitemap.xml', function () {
    $siteUrl = rtrim((string) config('app.url'), '/');
    $publicRoutes = [
        'home',
        'about',
        'citadines',
        'Location',
        'Amenities',
        'ServiceResidence',
        'PrivateServiceResidence',
        'FBP',
        'ContactUs',
        'DataPrivacy',
    ];

    $publishedArticles = News::published()
        ->orderBy('id')
        ->get(['slug']);

    if ($publishedArticles->isNotEmpty()) {
        $publicRoutes[] = 'news.index';
    }

    $urls = array_map(
        static fn (string $routeName): string => $siteUrl.route($routeName, absolute: false),
        $publicRoutes,
    );

    $articleUrls = $publishedArticles
        ->pluck('slug')
        ->map(
            static fn (string $slug): string => $siteUrl.route(
                'news.show',
                ['news' => $slug],
                absolute: false,
            ),
        )
        ->all();

    $urls = [...$urls, ...$articleUrls];

    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

    foreach ($urls as $url) {
        $xml .= '    <url><loc>'.htmlspecialchars($url, ENT_XML1 | ENT_QUOTES, 'UTF-8').'</loc></url>'."\n";
    }

    $xml .= '</urlset>'."\n";

    return response($xml, 200, [
        'Cache-Control' => 'public, max-age=3600',
        'Content-Type' => 'application/xml; charset=UTF-8',
    ]);
})->withoutMiddleware([
    \Illuminate\Cookie\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
])->name('sitemap');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
