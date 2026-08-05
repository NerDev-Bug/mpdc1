<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'body',
        'image_path',
        'alt_text',
        'sort_order',
        'is_active',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function scopePublicationReady(Builder $query): Builder
    {
        return $query
            ->whereNotNull('title')
            ->whereRaw("TRIM(title) <> ''")
            ->whereNotNull('slug')
            ->whereRaw("TRIM(slug) <> ''")
            ->whereNotNull('body')
            ->whereRaw("TRIM(body) <> ''")
            ->whereNotNull('alt_text')
            ->whereRaw("TRIM(alt_text) <> ''")
            ->whereNotNull('published_at');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->publicationReady()
            ->where('is_active', true)
            ->where('published_at', '<=', now());
    }

    public function isPublicationReady(): bool
    {
        return $this->hasText($this->title)
            && $this->hasText($this->slug)
            && $this->hasText($this->body)
            && $this->hasText($this->alt_text)
            && $this->published_at !== null;
    }

    public function isPublished(): bool
    {
        return $this->is_active
            && $this->isPublicationReady()
            && $this->published_at->lessThanOrEqualTo(now());
    }

    public function hasArticleDraft(): bool
    {
        return $this->hasText($this->slug)
            || $this->hasText($this->body)
            || $this->published_at !== null
            || $this->hasText($this->meta_title)
            || $this->hasText($this->meta_description);
    }

    public function imageUrlPath(): ?string
    {
        $path = str_replace('\\', '/', trim((string) $this->image_path));

        if (! str_starts_with($path, 'news/')) {
            return null;
        }

        $filename = substr($path, strlen('news/'));

        if (! preg_match('/\A[A-Za-z0-9][A-Za-z0-9._-]*\z/', $filename)) {
            return null;
        }

        return route('news.image', ['filename' => $filename], absolute: false);
    }

    /**
     * Explicit slug bindings are public article bindings. Default ID bindings
     * (used by the admin routes) retain their existing behavior.
     */
    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        $query = parent::resolveRouteBindingQuery($query, $value, $field);

        return $field === 'slug' ? $query->published() : $query;
    }

    private function hasText(?string $value): bool
    {
        return $value !== null && trim($value) !== '';
    }
}
