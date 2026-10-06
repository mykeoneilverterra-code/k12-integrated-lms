<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'school_year_id',
        'section_id',
        'status',
        'enrolled_at',
    ];

    protected $casts = [
        'enrolled_at' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function assignmentSubmissions()
    {
        return $this->hasMany(
            AssignmentSubmission::class
        );
    }

    public function quizAttempts()
    {
        return $this->hasMany(
            QuizAttempt::class
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
}