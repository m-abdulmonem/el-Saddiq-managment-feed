<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBalancesClientsTable extends Migration {

	public function up()
	{
		Schema::create('balances_clients', function(Blueprint $table) {
			$table->bigIncrements('id');
            $table->integer("code")->nullable();
			$table->float('remaining_amount')->nullable();
			$table->float('paid')->nullable();
            $table->enum('type', ['prev_balance','catch','payment','sale','buy',"deposit"])->nullable();
            $table->text('notes')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('balances_clients');
	}
}
