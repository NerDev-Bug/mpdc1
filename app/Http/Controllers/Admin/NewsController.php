<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Inertia\Inertia;

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
        $news = News::orderBy('sort_order')->get()->map(function ($item) {
            $item->image_url = $item->image_path ? asset('storage/' . $item->image_path) : null;
            return $item;
        });

        return Inertia::render('admin/NewsIndex', [
            'news' => $news,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:20480',
            'alt_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $path = $this->optimizeAndStore($request->file('image'));

        News::create([
            'title' => $validated['title'] ?? null,
            'description' => $validated['description'] ?? null,
            'image_path' => $path,
            'alt_text' => $validated['alt_text'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'News slide created successfully.']);
        }
        return redirect()->route('admin.news.index')->with('success', 'News slide created successfully.');
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'alt_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $validated['image_path'] = $this->optimizeAndStore($request->file('image'));
        }

        $news->update([
            'title' => $validated['title'] ?? $news->title,
            'description' => $validated['description'] ?? $news->description,
            'image_path' => $validated['image_path'] ?? $news->image_path,
            'alt_text' => $validated['alt_text'] ?? $news->alt_text,
            'sort_order' => $validated['sort_order'] ?? $news->sort_order,
            'is_active' => $validated['is_active'] ?? $news->is_active,
        ]);

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

        $filename = 'news/' . Str::uuid() . '.jpg';

        Storage::disk('public')->put($filename, (string) $encoded);

        return $filename;
    }
}
