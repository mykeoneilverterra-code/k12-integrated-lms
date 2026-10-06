<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'assignment_submissions',
            function (Blueprint $table) {

                $table->id();

                $table->foreignId('assignment_id')
                    ->constrained()
                    ->restrictOnDelete();

                $table->foreignId('enrollment_id')
                    ->constrained()
                    ->restrictOnDelete();

                $table->string('file_path')
                    ->nullable();

                $table->text('notes')
                    ->nullable();

                $table->timestamp('submitted_at')
                    ->nullable();

                $table->string('status')
                    ->default('submitted');

                $table->decimal(
                    'score',
                    8,
                    2
                )->nullable();

                $table->text('feedback')
                    ->nullable();

                $table->timestamp('graded_at')
                    ->nullable();

                $table->foreignId(
                    'graded_by_teacher_id'
                )
                    ->nullable()
                    ->constrained('teachers')
                    ->nullOnDelete();

                $table->timestamps();

                $table->unique([
                    'assignment_id',
                    'enrollment_id'
                ]);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'assignment_submissions'
        );
    }
};