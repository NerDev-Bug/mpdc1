<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->longText('body')->nullable()->after('description');
            $table->timestamp('published_at')->nullable()->after('is_active');
            $table->string('meta_title')->nullable()->after('published_at');
            $table->string('meta_description')->nullable()->after('meta_title');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn([
                'slug',
                'body',
                'published_at',
                'meta_title',
                'meta_description',
            ]);
        });
    }
};
