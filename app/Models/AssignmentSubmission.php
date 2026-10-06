<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $fillable = [
        'assignment_id',
        'enrollment_id',
        'file_path',
        'notes',
        'submitted_at',
        'status',
        'score',
        'feedback',
        'graded_at',
        'graded_by_teacher_id',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(
            Assignment::class
        );
    }

    public function enrollment()
    {
        return $this->belongsTo(
            Enrollment::class
        );
    }

    public function gradedBy()
    {
        return $this->belongsTo(
            Teacher::class,
            'graded_by_teacher_id'
        );
    }
}