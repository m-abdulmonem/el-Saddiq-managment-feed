<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBalancesSuppliersTable extends Migration {

	public function up()
	{
		Schema::create('balances_suppliers', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer("code")->nullable();
			$table->float('remaining_amount')->nullable();
			$table->float('paid')->nullable();
            $table->float('opening_balance')->nullable();
            $table->enum('type', ['receive','prev_balance','payment','sale','buy','mashal','tip'])->nullable();
            $table->text('notes')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('balances_suppliers');
	}
}
