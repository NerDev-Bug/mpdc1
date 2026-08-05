<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SeoInfrastructureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('app.url', 'https://example.test');
        config()->set('inertia.ssr.enabled', false);
    }

    public function test_form_routes_only_expose_their_named_store_actions(): void
    {
        foreach (['contacts.store', 'inquiry.store', 'inquiry1s.store', 'table_booking.store'] as $routeName) {
            $route = Route::getRoutes()->getByName($routeName);

            $this->assertNotNull($route);
            $this->assertSame(['POST'], $route->methods());
        }
    }

    public function test_retired_resource_get_urls_return_not_found(): void
    {
        $paths = [
            '/contacts',
            '/contacts/create',
            '/contacts/123',
            '/contacts/123/edit',
            '/contacts/nested/path',
            '/inquiry',
            '/inquiry/create',
            '/inquiry/123',
            '/inquiry/123/edit',
            '/inquiry1s',
            '/inquiry1s/create',
            '/inquiry1s/123',
            '/inquiry1s/123/edit',
            '/table_booking',
            '/table_booking/create',
            '/table_booking/123',
            '/table_booking/123/edit',
        ];

        foreach ($paths as $path) {
            $this->get($path)->assertNotFound();
        }
    }

    public function test_sitemap_contains_only_absolute_public_urls(): void
    {
        $response = $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $xml = $response->getContent();
        $paths = [
            '/',
            '/about',
            '/citadines',
            '/location',
            '/amenities',
            '/serviced-residence',
            '/private-residence',
            '/for-partners-and-brokers',
            '/contact-us',
            '/data-privacy',
        ];

        $this->assertSame(10, substr_count($xml, '<url>'));

        foreach ($paths as $path) {
            $this->assertStringContainsString('<loc>https://example.test'.$path.'</loc>', $xml);
        }

        $this->assertStringNotContainsString('/login', $xml);
        $this->assertStringNotContainsString('/admin', $xml);
        $this->assertStringNotContainsString('/news', $xml);
        $this->assertFalse($response->headers->has('X-Robots-Tag'));
        $this->assertFalse($response->headers->has('Set-Cookie'));
    }

    public function test_private_and_utility_responses_are_marked_noindex(): void
    {
        foreach (['/login', '/register', '/forgot-password', '/dashboard', '/settings', '/admin', '/up'] as $path) {
            $this->get($path)->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');
        }
    }
}
