<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'quiz_attempts',
            function (Blueprint $table) {

                $table->id();

                $table->foreignId('quiz_id')
                    ->constrained()
                    ->restrictOnDelete();

                $table->foreignId('enrollment_id')
                    ->constrained()
                    ->restrictOnDelete();

                $table->decimal(
                    'score',
                    8,
                    2
                )->nullable();

                $table->timestamp('started_at')
                    ->nullable();

                $table->timestamp('submitted_at')
                    ->nullable();

                $table->string('status')
                    ->default('in_progress');

                $table->timestamps();

                $table->unique([
                    'quiz_id',
                    'enrollment_id'
                ]);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'quiz_attempts'
        );
    }
};