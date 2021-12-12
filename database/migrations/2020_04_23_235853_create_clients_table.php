<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->bigIncrements('id');
            $table->integer('code')->nullable();
            $table->string('name')->nullable();
			$table->string('picture')->nullable();
			$table->string('discount')->nullable();
			$table->text('address')->nullable();
			$table->text('phone')->nullable();
			$table->float('credit_limit')->nullable();
			$table->integer('maximum_repayment_period')->nullable();
			$table->boolean('is_trader')->default(false);
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
