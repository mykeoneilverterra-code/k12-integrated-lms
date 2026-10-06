<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'class_subject_id',
        'teacher_id',
        'title',
        'body',
        'published_at',
    ];

    protected $casts = [
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