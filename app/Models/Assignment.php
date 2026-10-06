<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'class_subject_id',
        'teacher_id',
        'title',
        'instructions',
        'total_points',
        'due_at',
        'attachment_path',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'due_at' => 'datetime',
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

    public function submissions()
    {
        return $this->hasMany(
            AssignmentSubmission::class
        );
    }
}