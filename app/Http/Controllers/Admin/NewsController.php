<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Intervention\Image\Laravel\Facades\Image;
use RuntimeException;
use Throwable;

class NewsController extends Controller
{
    /**
     * Max width for optimized images (px).
     */
    private const MAX_WIDTH = 1920;

    /**
     * JPEG/WebP quality for compression (1-100).
     */
    private const QUALITY = 80;

    public function index()
    {
        $news = News::orderBy('sort_order')->get()->map(fn (News $item) => [
            'id' => $item->id,
            'title' => $item->title,
            'slug' => $item->slug,
            'description' => $item->description,
            'body' => $item->body,
            'image_path' => $item->image_path,
            'image_url' => $item->image_path ? asset('storage/'.$item->image_path) : null,
            'alt_text' => $item->alt_text,
            'sort_order' => $item->sort_order,
            'is_active' => $item->is_active,
            'published_at' => $item->published_at?->setTimezone('Asia/Manila')->format('Y-m-d\TH:i'),
            'meta_title' => $item->meta_title,
            'meta_description' => $item->meta_description,
            'article_status' => $this->articleStatus($item),
            'article_url' => $item->isPublished()
                ? route('news.show', ['news' => $item->slug], absolute: false)
                : null,
        ]);

        return Inertia::render('admin/NewsIndex', [
            'news' => $news,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateNews($request);

        $path = $this->optimizeAndStore($request->file('image'));

        try {
            News::create([
                'title' => $validated['title'] ?? null,
                'slug' => $validated['slug'] ?? null,
                'description' => $validated['description'] ?? null,
                'body' => $validated['body'] ?? null,
                'image_path' => $path,
                'alt_text' => $validated['alt_text'] ?? null,
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_active' => $validated['is_active'] ?? true,
                'published_at' => $validated['published_at'] ?? null,
                'meta_title' => $validated['meta_title'] ?? null,
                'meta_description' => $validated['meta_description'] ?? null,
            ]);
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($path);

            throw $exception;
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'News slide created successfully.']);
        }

        return redirect()->route('admin.news.index')->with('success', 'News slide created successfully.');
    }

    public function update(Request $request, News $news)
    {
        $validated = $this->validateNews($request, $news);

        $updates = [];
        foreach ([
            'title',
            'slug',
            'description',
            'body',
            'alt_text',
            'sort_order',
            'is_active',
            'published_at',
            'meta_title',
            'meta_description',
        ] as $field) {
            if (array_key_exists($field, $validated)) {
                $updates[$field] = $validated[$field];
            }
        }

        $newImagePath = null;
        $oldImagePath = null;

        if ($request->hasFile('image')) {
            $newImagePath = $this->optimizeAndStore($request->file('image'));
            $oldImagePath = $news->image_path;
            $updates['image_path'] = $newImagePath;
        }

        try {
            $news->update($updates);
        } catch (Throwable $exception) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            throw $exception;
        }

        if ($newImagePath && $oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'News slide updated successfully.']);
        }

        return redirect()->route('admin.news.index')->with('success', 'News slide updated successfully.');
    }

    public function destroy(News $news)
    {
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News slide deleted successfully.');
    }

    /**
     * Optimize an uploaded image: scale down if wider than MAX_WIDTH,
     * convert to JPEG at QUALITY compression, and store to public disk.
     */
    private function optimizeAndStore($file): string
    {
        $image = Image::read($file->getRealPath());

        // Scale down if wider than max width, maintaining aspect ratio
        if ($image->width() > self::MAX_WIDTH) {
            $image->scaleDown(width: self::MAX_WIDTH);
        }

        // Encode as JPEG with quality compression
        $encoded = $image->toJpeg(self::QUALITY);

        $filename = 'news/'.Str::uuid().'.jpg';

        $stored = Storage::disk('public')->put($filename, (string) $encoded);

        if (! $stored) {
            throw new RuntimeException('Unable to store the optimized news image.');
        }

        return $filename;
    }

    private function validateNews(Request $request, ?News $news = null): array
    {
        if ($request->filled('slug')) {
            $request->merge([
                'slug' => Str::slug((string) $request->input('slug')),
            ]);
        }

        $requiresArticleFields = $request->filled('published_at');

        $validated = $request->validate([
            'title' => [Rule::requiredIf($requiresArticleFields), 'nullable', 'string', 'max:191'],
            'slug' => [
                Rule::requiredIf($requiresArticleFields),
                'nullable',
                'string',
                'max:191',
                'alpha_dash:ascii',
                Rule::unique('news', 'slug')->ignore($news),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'body' => [Rule::requiredIf($requiresArticleFields), 'nullable', 'string', 'max:100000'],
            'image' => [$news ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
            'alt_text' => [Rule::requiredIf($requiresArticleFields), 'nullable', 'string', 'max:191'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
        ]);

        if (! empty($validated['published_at'])) {
            $validated['published_at'] = CarbonImmutable::parse(
                $validated['published_at'],
                'Asia/Manila',
            )->utc();
        }

        return $validated;
    }

    private function articleStatus(News $news): string
    {
        if ($news->isPublished()) {
            return 'published';
        }

        if ($news->isPublicationReady()) {
            return $news->is_active ? 'scheduled' : 'inactive';
        }

        return $news->hasArticleDraft() ? 'draft' : 'carousel_only';
    }
}
