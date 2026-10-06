<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'subject_id',
        'teacher_id',
    ];

    public function section()
    {
        return $this->belongsTo(
            Section::class
        );
    }

    public function subject()
    {
        return $this->belongsTo(
            Subject::class
        );
    }

    public function teacher()
    {
        return $this->belongsTo(
            Teacher::class
        );
    }

    public function enrollments()
    {
        return $this->hasMany(
            Enrollment::class,
            'section_id',
            'section_id'
        );
    }

    public function lessons()
    {
        return $this->hasMany(
            Lesson::class
        );
    }

    public function assignments()
    {
        return $this->hasMany(
            Assignment::class
        );
    }

    public function quizzes()
    {
        return $this->hasMany(
            Quiz::class
        );
    }

    public function attendanceRecords()
    {
        return $this->hasMany(
            AttendanceRecord::class
        );
    }

    public function quarterlyGrades()
    {
        return $this->hasMany(
            QuarterlyGrade::class
        );
    }

    public function announcements()
    {
        return $this->hasMany(
            Announcement::class
        );
    }
}