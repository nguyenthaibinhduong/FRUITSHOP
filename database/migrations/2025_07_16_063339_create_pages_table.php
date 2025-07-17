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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('css');
            $table->longText('script');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->enum('type', ['block', 'product', 'category', 'post', 'contact']);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', [0, 1]); // mac dinh
            $table->unsignedInteger('row')->default(1);
            $table->unsignedInteger('col')->default(1);
            $table->unsignedInteger('width')->default(12);
            $table->unsignedInteger('width_sm')->default(12); // ví dụ mobile
            $table->unsignedInteger('width_md')->default(12); // tablet
            $table->unsignedInteger('width_lg')->default(12); // desktop // 12 là full width
            $table->enum('align', ['left', 'center', 'right'])->default('left');
            $table->unsignedInteger('order')->default(1); // ex: home_top, footer_left
            $table->timestamps();
        });

        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code');
            $table->enum('type', ['html', 'image', 'text']); // html, image, video, ...
            $table->longText('content');
            $table->string('class');
            $table->boolean('status')->default(true);
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('position_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('page_section', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('blocks');
        Schema::dropIfExists('page_section');
    }
};
