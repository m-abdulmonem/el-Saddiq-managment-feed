<?php

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::insert([
            [
                'name' => 'مدير',
                'created_at' => now()
            ],
            [
                'name' => 'عامل',
                'created_at' => now()
            ],
            [
                'name' => 'بائع',
                'created_at' => now()
            ]

        ]);
    }
}
