<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $fillable = [
        'class_subject_id',
        'enrollment_id',
        'attendance_date',
        'status',
        'remarks',
        'marked_by_teacher_id',
    ];

    protected $casts = [
        'attendance_date' => 'date',
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