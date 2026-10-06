<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'class_subject_id',
        'teacher_id',
        'title',
        'description',
        'duration_minutes',
        'opens_at',
        'closes_at',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'opens_at' => 'datetime',
        'closes_at' => 'datetime',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function classSubject()
    {
        return $this->belongsTo(
            ClassSubject::class
        );
    }

    public function teacher()
    {
        return $this->belongsTo(
            Teacher::class
        );
    }

    public function questions()
    {
        return $this->hasMany(
            QuizQuestion::class
        );
    }

    public function attempts()
    {
        return $this->hasMany(
            QuizAttempt::class
        );
    }

    public function getTotalPointsAttribute()
    {
        return $this
            ->questions()
            ->sum('points');
    }
}