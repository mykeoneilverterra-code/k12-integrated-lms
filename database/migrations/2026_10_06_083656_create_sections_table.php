<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_year_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('grade_level_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('adviser_teacher_id')
                ->nullable()
                ->constrained('teachers')
                ->nullOnDelete();

            $table->string('name');

            $table->timestamps();

            $table->unique([
                'school_year_id',
                'grade_level_id',
                'name'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};