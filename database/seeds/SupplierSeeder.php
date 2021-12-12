<?php

use App\Models\Supplier\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::insert([
            ['name' => 'البركة', 'code' => mt_rand(1,100), 'logo'=>null, 'discount' =>250, 'address'=>'جمصة', 'phone'=>'16541564', 'my_code' => '10527'],
            ['name' => 'القائد', 'code' => mt_rand(1,100), 'logo'=>null, 'discount' =>150, 'address'=>'المنصورة', 'phone'=>'12144714', 'my_code' => '2073']
        ]);
    }
}
