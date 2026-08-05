<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class NewsSeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('app.url', 'https://example.test');
        config()->set('inertia.ssr.enabled', false);
    }

    public function test_only_complete_active_articles_published_by_the_current_time_are_public(): void
    {
        $published = $this->createNews([
            'title' => 'Published update',
            'slug' => 'published-update',
            'body' => "First paragraph.\n\nSecond paragraph.",
            'alt_text' => 'Exterior view of the property',
            'published_at' => now()->subMinute(),
        ]);

        $scheduled = $this->createNews([
            'title' => 'Scheduled update',
            'slug' => 'scheduled-update',
            'body' => 'This article is not public yet.',
            'alt_text' => 'Scheduled article image',
            'published_at' => now()->addDay(),
        ]);

        $inactive = $this->createNews([
            'title' => 'Inactive update',
            'slug' => 'inactive-update',
            'body' => 'This article is inactive.',
            'alt_text' => 'Inactive article image',
            'published_at' => now()->subDay(),
            'is_active' => false,
        ]);

        $carouselOnly = $this->createNews([
            'title' => 'Carousel-only update',
            'alt_text' => null,
        ]);

        $this->get('/news')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('news/Index')
                ->has('articles', 1)
                ->where('articles.0.id', $published->id)
                ->where('articles.0.slug', 'published-update')
                ->where('articles.0.meta_title', 'Published update')
                ->missing('articles.0.body'));

        $this->get('/news/published-update')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('news/Show')
                ->where('article.id', $published->id)
                ->where('article.body', "First paragraph.\n\nSecond paragraph.")
                ->where('article.canonical_path', '/news/published-update'));

        $this->get('/news/'.$scheduled->slug)->assertNotFound();
        $this->get('/news/'.$inactive->slug)->assertNotFound();
        $this->get('/news/'.$carouselOnly->id)->assertNotFound();
    }

    public function test_sitemap_and_homepage_link_only_to_published_articles(): void
    {
        $published = $this->createNews([
            'title' => 'Published update',
            'slug' => 'published-update',
            'body' => 'Published article body.',
            'alt_text' => 'Published article image',
            'published_at' => now()->subHour(),
            'sort_order' => 1,
        ]);

        $this->createNews([
            'title' => 'Carousel update',
            'alt_text' => 'Carousel image',
            'sort_order' => 2,
        ]);

        $this->createNews([
            'title' => 'Future update',
            'slug' => 'future-update',
            'body' => 'Scheduled article body.',
            'alt_text' => 'Future article image',
            'published_at' => now()->addHour(),
            'sort_order' => 3,
        ]);

        $sitemap = $this->get('/sitemap.xml')->assertOk()->getContent();

        $this->assertStringContainsString('<loc>https://example.test/news</loc>', $sitemap);
        $this->assertStringContainsString('<loc>https://example.test/news/published-update</loc>', $sitemap);
        $this->assertStringNotContainsString('/news/future-update', $sitemap);

        $this->get('/')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->where('newsSlides.0.id', $published->id)
                ->where('newsSlides.0.url', '/news/published-update')
                ->where('newsSlides.1.url', null)
                ->where('newsSlides.2.url', null));
    }

    public function test_public_article_uses_the_uploaded_images_real_dimensions(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put(
            'news/measured.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='),
        );

        $this->createNews([
            'slug' => 'measured-image',
            'body' => 'Article body.',
            'alt_text' => 'Measured test image',
            'image_path' => 'news/measured.png',
            'published_at' => now()->subMinute(),
        ]);

        $this->get('/news/measured-image')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->where('article.image_width', 1)
                ->where('article.image_height', 1));
    }

    public function test_admin_cannot_set_a_publication_date_without_complete_article_fields(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $news = $this->createNews([
            'title' => null,
            'alt_text' => null,
        ]);

        $this->actingAs($admin)
            ->from(route('admin.news.index'))
            ->post(route('admin.news.update', $news), [
                'published_at' => now()->format('Y-m-d H:i:s'),
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.news.index'))
            ->assertSessionHasErrors(['title', 'slug', 'body', 'alt_text']);

        $this->assertNull($news->fresh()->published_at);
    }

    public function test_admin_can_publish_a_complete_article_without_breaking_the_existing_slide(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $news = $this->createNews([
            'title' => 'Existing slide',
            'description' => 'Existing summary',
            'alt_text' => 'Existing image description',
            'sort_order' => 4,
        ]);

        $publishedAt = now()->subMinute()->format('Y-m-d H:i:s');

        $this->actingAs($admin)
            ->post(route('admin.news.update', $news), [
                'title' => 'Complete Article',
                'slug' => 'Complete Article',
                'description' => 'Existing summary',
                'body' => 'The complete, plain-text article body.',
                'alt_text' => 'Existing image description',
                'sort_order' => 4,
                'is_active' => true,
                'published_at' => $publishedAt,
                'meta_title' => 'Complete Article Details',
                'meta_description' => 'A concise description of this complete article.',
            ])
            ->assertRedirect(route('admin.news.index'));

        $news->refresh();

        $this->assertSame('complete-article', $news->slug);
        $this->assertSame('news/example.jpg', $news->image_path);
        $this->assertSame('The complete, plain-text article body.', $news->body);
        $this->assertTrue($news->isPublished());
    }

    private function createNews(array $attributes = []): News
    {
        return News::create(array_merge([
            'title' => 'News item',
            'description' => 'News summary',
            'image_path' => 'news/example.jpg',
            'alt_text' => 'News image',
            'sort_order' => 0,
            'is_active' => true,
        ], $attributes));
    }
}
