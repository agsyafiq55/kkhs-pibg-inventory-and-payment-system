<?php

namespace Database\Seeders;

use App\Models\Stream;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StreamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $streams = [
            ['stream_name' => 'Science', 'description' => 'Science stream includes Physics, Chemistry, Biology'],
            ['stream_name' => 'Arts', 'description' => 'Arts stream includes Literature, History, Geography'],
            ['stream_name' => 'Business', 'description' => 'Business stream includes Business Studies, Economics'],
            ['stream_name' => 'Accounts', 'description' => 'Accounts stream includes Principles of Accounting, Business'],
            ['stream_name' => 'Computer Science', 'description' => 'Computer Science stream includes Programming, IT'],
        ];

        foreach ($streams as $stream) {
            Stream::updateOrCreate(
                ['stream_name' => $stream['stream_name']],
                $stream
            );
        }
    }
}
