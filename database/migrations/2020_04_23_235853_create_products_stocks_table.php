<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsStocksTable extends Migration {

	public function up()
	{
		Schema::create('products_stocks', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('ton_price')->nullable();
			$table->string('piece_price')->nullable();
			$table->string('sale_price')->nullable();
			$table->float('quantity')->nullable();
			$table->float('min_quantity')->nullable();
            $table->text('notes')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('products_stocks');
	}
}
