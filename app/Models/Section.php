<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_year_id',
        'grade_level_id',
        'adviser_teacher_id',
        'name',
    ];

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function adviser()
    {
        return $this->belongsTo(
            Teacher::class,
            'adviser_teacher_id'
        );
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function classSubjects()
    {
        return $this->hasMany(ClassSubject::class);
    }
}