<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_subject_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('teacher_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');

            $table->text('description')
                ->nullable();

            $table->string('file_path')
                ->nullable();

            $table->string('video_url')
                ->nullable();

            $table->boolean('is_published')
                ->default(false);

            $table->timestamp('published_at')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};