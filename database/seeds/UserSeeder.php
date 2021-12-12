<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'code' => '1',
                'name' => config('app.name') . ' Admin',
                'username' => 'admin',
                'email' => config('app.name') . '@example.com',
                'password' => Hash::make('admin'),
                'phone' => '01099647084',
                'address' => 'بلجاى',
                'holidays' => 'الجمعة',
                'job_id' => 1,
                'salary'=>100,
                'salary_type' => 'daily',
                'created_at' => now()
            ],
            [
                'code' => '1254',
                'name' => 'احمد الكيلانى',
                'username' => 'الكيلانى',
                'email' => 'a@a.com',
                'password' => Hash::make(123456),
                'phone' => '63485464134',
                'address' => 'عزبة خلف',
                'holidays' => 'الجمعة',
                'job_id' => 3,
                'salary'=>300,
                'salary_type' => 'monthly',
                'created_at' => now()
            ]
        ]);

    }
}
