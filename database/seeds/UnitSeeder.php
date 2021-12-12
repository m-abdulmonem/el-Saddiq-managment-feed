<?php

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::insert([
            ['name' => 'طن', 'value' => '1000','symbol' => 'طن' ,'query'=> '*','min'=>'ك'],
            ['name' => 'قطعة', 'value' => '1','symbol' => 'ق','query'=> null, 'min' => null],
            ['name' => 'كيس', 'value' => '1','symbol' => 'كيس','query'=> null, 'min' => null],
            ['name' => 'علبة', 'value' => '1','symbol' => 'ع','query'=> null, 'min' => null],
//            ['name' => '', 'value' => '','symbol' => ''],
        ]);

    }
}
