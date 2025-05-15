<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classNames = [
            'AMANAH',
            'BESTARI',
            'CERIA',
            'DINAMIK',
            'KREATIF',
            'MULIA',
            'RAJIN',
            'SABAR',
            'TEKUN'
        ];

        $forms = [1, 2, 3, 4, 5];

        foreach ($classNames as $className) {
            foreach ($forms as $form) {
                $fullClassName = $form . ' ' . $className;
                
                Classroom::updateOrCreate(
                    ['class_name' => $fullClassName],
                    ['class_name' => $fullClassName]
                );
            }
        }
    }
}
