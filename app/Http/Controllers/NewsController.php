<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(): Response
    {
        $articles = News::published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get()
            ->map(fn (News $article) => $this->articleData($article));

        return Inertia::render('news/Index', [
            'articles' => $articles,
        ]);
    }

    public function show(News $news): Response
    {
        abort_unless($news->isPublished(), 404);

        return Inertia::render('news/Show', [
            'article' => $this->articleData($news, includeBody: true),
        ]);
    }

    private function articleData(News $article, bool $includeBody = false): array
    {
        $summary = $this->plainTextSummary($article);
        $canonicalPath = route('news.show', ['news' => $article->slug], absolute: false);
        $siteUrl = rtrim((string) config('app.url'), '/');
        $canonicalUrl = $siteUrl.$canonicalPath;
        $imageUrl = $siteUrl.'/storage/'.ltrim($article->image_path, '/');
        [$imageWidth, $imageHeight] = $this->imageDimensions($article);

        $data = [
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'description' => $article->description,
            'summary' => $summary,
            'image_url' => $imageUrl,
            'image_width' => $imageWidth,
            'image_height' => $imageHeight,
            'alt_text' => $article->alt_text,
            'published_at' => $article->published_at->toIso8601String(),
            'updated_at' => $article->updated_at->toIso8601String(),
            'canonical_path' => $canonicalPath,
            'canonical_url' => $canonicalUrl,
            'meta_title' => $article->meta_title ?: Str::limit($article->title, 55, ''),
            'meta_description' => $article->meta_description ?: Str::limit($summary, 160, ''),
        ];

        if ($includeBody) {
            $data['body'] = $article->body;
        }

        return $data;
    }

    private function plainTextSummary(News $article): string
    {
        $source = $article->description ?: $article->body;

        return Str::limit(Str::squish(strip_tags((string) $source)), 220);
    }

    private function imageDimensions(News $article): array
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($article->image_path)) {
            return [null, null];
        }

        $dimensions = getimagesize($disk->path($article->image_path));

        if ($dimensions === false) {
            return [null, null];
        }

        return [(int) $dimensions[0], (int) $dimensions[1]];
    }
}
