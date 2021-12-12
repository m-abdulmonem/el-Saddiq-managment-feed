<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsProductsTable extends Migration {

	public function up()
	{
		Schema::create('clients_products', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('quantity');
            $table->float('price')->nullable();
            $table->float('piece_price')->nullable();
            $table->float('purchase_price')->nullable();
            $table->float('discount')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients_products');
	}
}
