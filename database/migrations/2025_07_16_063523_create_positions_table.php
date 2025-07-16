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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('code')->unique();
            $table->unsignedInteger('row')->default(1);
            $table->unsignedInteger('col')->default(1);
            $table->unsignedInteger('width')->default(12);
            $table->unsignedInteger('width_sm')->nullable(); // ví dụ mobile
            $table->unsignedInteger('width_md')->nullable(); // tablet
            $table->unsignedInteger('width_lg')->nullable(); // desktop // 12 là full width
            $table->enum('align', ['left', 'center', 'right'])->default('left');
            $table->unsignedInteger('order')->default(0); // ex: home_top, footer_left
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
