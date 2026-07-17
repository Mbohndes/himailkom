<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Kategori Berita
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Tabel Tag Berita
        Schema::create('news_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 3. Tabel Utama Berita (Posts)
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('news_category_id')->constrained()->cascadeOnDelete();
            
            // Konten
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Ringkasan
            $table->longText('content'); // Isi berita (Rich Text)
            $table->string('thumbnail')->nullable();
            
            // Pengaturan Publikasi
            $table->enum('status', ['Draft', 'Published', 'Scheduled', 'Archived'])->default('Draft');
            $table->dateTime('published_at')->nullable(); // Untuk fitur Scheduled Post
            
            // Pengaturan Tampilan & Flagging
            $table->boolean('is_featured')->default(false); // Tampil di Slider/Highlight
            $table->boolean('is_breaking')->default(false); // Breaking News
            $table->boolean('allow_comments')->default(true);
            
            // SEO (Search Engine Optimization)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Statistik
            $table->unsignedBigInteger('views_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. Tabel Pivot untuk Relasi Many-to-Many (Satu Berita punya banyak Tag)
        Schema::create('news_news_tag', function (Blueprint $table) {
            $table->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $table->foreignId('news_tag_id')->constrained('news_tags')->cascadeOnDelete();
            $table->primary(['news_id', 'news_tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_news_tag');
        Schema::dropIfExists('news');
        Schema::dropIfExists('news_tags');
        Schema::dropIfExists('news_categories');
    }
};