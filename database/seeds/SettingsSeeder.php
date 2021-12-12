<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Setting::create([
            'name_ar' => 'مؤسسة الصديق للاعلاف',
            'address' => 'قرية بلجاى مركز المنصورة - الدقهلية',
            'phone' => '01003871444 - 01099647084',
            'manger' => 'إدارة: الشيخ عبد المنعم خيرى وولده محمد'
        ]);
    }
}
