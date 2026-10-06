<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuarterlyGrade extends Model
{
    protected $fillable = [
        'class_subject_id',
        'enrollment_id',
        'quarter',
        'grade',
        'remarks',
        'status',
        'finalized_at',
        'graded_by_teacher_id',
    ];

    protected $casts = [
        'finalized_at' => 'datetime',
    ];

    public function classSubject()
    {
        return $this->belongsTo(
            ClassSubject::class
        );
    }

    public function enrollment()
    {
        return $this->belongsTo(
            Enrollment::class
        );
    }
}