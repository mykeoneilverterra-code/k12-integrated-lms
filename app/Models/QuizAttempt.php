<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_id',
        'enrollment_id',
        'score',
        'started_at',
        'submitted_at',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    public function quiz()
    {
        return $this->belongsTo(
            Quiz::class
        );
    }

    public function enrollment()
    {
        return $this->belongsTo(
            Enrollment::class
        );
    }

    public function answers()
    {
        return $this->hasMany(
            QuizAnswer::class
        );
    }
}