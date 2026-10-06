<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'class_subject_id',
        'teacher_id',
        'title',
        'description',
        'file_path',
        'video_url',
        'is_published',
        'published_at',
    ];

    protected $casts = [
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
}