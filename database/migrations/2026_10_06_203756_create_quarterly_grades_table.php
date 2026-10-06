<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quarterly_grades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_subject_id')
                ->constrained('class_subjects')
                ->restrictOnDelete();

            $table->foreignId('enrollment_id')
                ->constrained('enrollments')
                ->restrictOnDelete();

            $table->unsignedTinyInteger('quarter');

            $table->decimal('grade', 5, 2);

            $table->text('remarks')->nullable();

            $table->string('status')
                ->default('draft');

            $table->timestamp('finalized_at')
                ->nullable();

            $table->foreignId('graded_by_teacher_id')
                ->nullable()
                ->constrained('teachers')
                ->nullOnDelete();

            $table->timestamps();

            $table->unique(
                [
                    'class_subject_id',
                    'enrollment_id',
                    'quarter',
                ],
                'quarterly_grade_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quarterly_grades');
    }
};