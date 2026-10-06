<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use App\Models\SchoolYear;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@school.test'
            ],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('Admin123!'),
                'role' => 'admin',
            ]
        );

        SchoolYear::updateOrCreate(
            [
                'name' => '2026-2027'
            ],
            [
                'starts_on' => '2026-06-01',
                'ends_on' => '2027-03-31',
                'status' => 'active',
            ]
        );

        for ($level = 1; $level <= 6; $level++) {

            GradeLevel::updateOrCreate(
                [
                    'level' => $level
                ],
                [
                    'name' => "Grade {$level}",
                    'education_stage' => 'elementary',
                ]
            );
        }

        $subjects = [
            [
                'code' => 'MATH',
                'name' => 'Mathematics'
            ],
            [
                'code' => 'ENG',
                'name' => 'English'
            ],
            [
                'code' => 'FIL',
                'name' => 'Filipino'
            ],
            [
                'code' => 'SCI',
                'name' => 'Science'
            ],
            [
                'code' => 'AP',
                'name' => 'Araling Panlipunan'
            ],
            [
                'code' => 'MAPEH',
                'name' => 'MAPEH'
            ],
            [
                'code' => 'EPP',
                'name' => 'EPP'
            ],
            [
                'code' => 'ESP',
                'name' => 'EsP'
            ],
        ];

        foreach ($subjects as $subject) {

            Subject::updateOrCreate(
                [
                    'code' => $subject['code']
                ],
                [
                    'name' => $subject['name'],
                    'is_active' => true,
                ]
            );
        }
    }
}