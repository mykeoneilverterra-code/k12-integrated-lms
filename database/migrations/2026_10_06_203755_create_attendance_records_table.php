<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_subject_id')
                ->constrained('class_subjects')
                ->restrictOnDelete();

            $table->foreignId('enrollment_id')
                ->constrained('enrollments')
                ->restrictOnDelete();

            $table->date('attendance_date');

            $table->string('status');

            $table->text('remarks')->nullable();

            $table->foreignId('marked_by_teacher_id')
                ->nullable()
                ->constrained('teachers')
                ->nullOnDelete();

            $table->timestamps();

            // IMPORTANT:
            // Give the index a short custom name.
            $table->unique(
                [
                    'class_subject_id',
                    'enrollment_id',
                    'attendance_date',
                ],
                'attendance_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};