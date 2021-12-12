<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsSuppliersTable extends Migration {

	public function up()
	{
		Schema::create('products_suppliers', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('quantity');
            $table->string('price')->nullable();
            $table->string('piece_price')->nullable();
			$table->text('notes')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('products_suppliers');
	}
}
