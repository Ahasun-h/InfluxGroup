<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_management', function (Blueprint $table) {
            $table->id();
            $table->string('page_name')->nullable(); // e.g., 'home_page', 'about_page'
            $table->string('section_name'); // e.g., 'hero_section'
            $table->string('section_item_name'); // e.g., 'hero_section_badge_text'
            $table->text('section_content')->nullable(); // The main content/text
            $table->json('attributes')->nullable(); // SEO attributes or other metadata
            $table->json('media_files')->nullable(); // File information like source_file
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['page_name', 'section_name', 'section_item_name'], 'cm_page_sec_item_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_management');
    }
};
