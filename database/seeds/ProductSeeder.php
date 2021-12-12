<?php


use App\Models\Product\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $names = collect([['23%',1],['21%',1], ["23%",2], ["21%",2]]);
//        $i = 0;
//
//        $names->eachSpread(function ($product_name,$supplier_id) use($i){
//
//            Product::insert([
//                'code' => 1,
//                'name' => $product_name,
//                'notes' => $product_name,
//                'supplier_id' => $supplier_id,
//                'discount' => ($product_name== "23%" ? 150 : null),
//                'weight' => 25,
//                'category_id' => 1,
//                'user_id' => 1,
//                'unit_id' => 1
//            ]);
//
//        });//end of eachSpread
    }
}
