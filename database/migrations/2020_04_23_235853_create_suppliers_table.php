<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSuppliersTable extends Migration {

	public function up()
	{
		Schema::create('suppliers', function(Blueprint $table) {
			$table->bigIncrements('id');
            $table->integer('code')->nullable();
            $table->string('my_code')->nullable();
            $table->string('name')->nullable();
            $table->string('logo')->nullable();
            $table->float('discount')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('suppliers');
	}
}
