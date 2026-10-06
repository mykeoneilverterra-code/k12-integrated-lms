<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function gradeLevels()
    {
        return $this->belongsToMany(
            GradeLevel::class,
            'curriculum_subject'
        )->withTimestamps();
    }

    public function classSubjects()
    {
        return $this->hasMany(ClassSubject::class);
    }
}