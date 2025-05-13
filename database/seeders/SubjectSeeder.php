<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Core subjects
        $coreSubjects = [
            ['subject_code' => 'BM', 'subject_name' => 'BAHASA MALAYSIA', 'type' => 'core'],
            ['subject_code' => 'BI', 'subject_name' => 'BAHASA INGGERIS', 'type' => 'core'],
            ['subject_code' => 'SEJ', 'subject_name' => 'SEJARAH', 'type' => 'core'],
            ['subject_code' => 'MAT', 'subject_name' => 'MATEMATIK', 'type' => 'core'],
            ['subject_code' => 'PJPK', 'subject_name' => 'PJPK', 'type' => 'core'],
            ['subject_code' => 'GEO', 'subject_name' => 'GEOGRAFI', 'type' => 'core'],
            ['subject_code' => 'PSV', 'subject_name' => 'PSV', 'type' => 'core'],
            ['subject_code' => 'SN', 'subject_name' => 'SAINS', 'type' => 'core'],
            ['subject_code' => 'FIZ', 'subject_name' => 'FIZIK', 'type' => 'core'],
            ['subject_code' => 'KIM', 'subject_name' => 'KIMIA', 'type' => 'core'],
            ['subject_code' => 'BIO', 'subject_name' => 'BIOLOGI', 'type' => 'core'],
        ];

        // Elective subjects
        $electiveSubjects = [
            ['subject_code' => 'RBT', 'subject_name' => 'RBT', 'type' => 'elective'],
            ['subject_code' => 'ASK', 'subject_name' => 'ASK', 'type' => 'elective'],
            ['subject_code' => 'PM', 'subject_name' => 'PENDIDIKAN MORAL', 'type' => 'elective', 'for_non_muslim_only' => true],
            ['subject_code' => 'PI', 'subject_name' => 'PENDIDIKAN ISLAM', 'type' => 'elective', 'for_muslim_only' => true],
            ['subject_code' => 'BC', 'subject_name' => 'BAHASA CINA', 'type' => 'elective'],
            ['subject_code' => 'PPK', 'subject_name' => 'PRINSIP PERAKAUNAN', 'type' => 'elective'],
            ['subject_code' => 'PER', 'subject_name' => 'PERNIAGAAN', 'type' => 'elective'],
        ];

        $allSubjects = array_merge($coreSubjects, $electiveSubjects);

        foreach ($allSubjects as $subject) {
            Subject::updateOrCreate(
                ['subject_code' => $subject['subject_code']],
                $subject
            );
        }
    }
}
