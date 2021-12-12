<?php

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stocks = collect([
            'مخزن 1' => 'بلجاى',
            'مخزن 2' => 'بلجاى',
            'مخزن 3' => 'بلجاى',
        ]);

        $stocks->each(function ($address,$name){
            Stock::create([
                'code' => Stock::code(),
                'name' => $name,
                'address' => $address
            ]);
        });
    }
}
