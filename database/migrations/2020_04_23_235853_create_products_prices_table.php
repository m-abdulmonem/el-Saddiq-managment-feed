<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsPricesTable extends Migration {

	public function up()
	{
		Schema::create('products_prices', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->float('price')->nullable();
			$table->float('sale_price')->nullable();
			$table->integer('quantity')->nullable();
			$table->string('value')->nullable();
			$table->boolean('is_cheaper')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('products_prices');
	}
}
