<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'quiz_answers',
            function (Blueprint $table) {

                $table->id();

                $table->foreignId(
                    'quiz_attempt_id'
                )
                    ->constrained()
                    ->cascadeOnDelete();

                $table->foreignId(
                    'quiz_question_id'
                )
                    ->constrained()
                    ->restrictOnDelete();

                $table->foreignId(
                    'quiz_choice_id'
                )
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();

                $table->text('answer_text')
                    ->nullable();

                $table->decimal(
                    'points_awarded',
                    6,
                    2
                )->default(0);

                $table->timestamps();

                $table->unique([
                    'quiz_attempt_id',
                    'quiz_question_id'
                ]);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'quiz_answers'
        );
    }
};