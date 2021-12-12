<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->bigIncrements('id');
            $table->integer('code')->nullable();
            $table->string('name')->nullable();
			$table->string('image')->nullable();
            $table->float('weight')->nullable();
            $table->float('profit')->default(5);
            $table->float('discount')->nullable();
            $table->text('notes')->nullable();
            $table->string("valid_for")->nullable();
            $table->boolean('is_printed')->default(true);
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}
