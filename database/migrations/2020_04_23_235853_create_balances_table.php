<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBalancesTable extends Migration {

	public function up()
	{
		Schema::create('balances', function(Blueprint $table) {
			$table->bigIncrements('id');
//            ['remaining','paid','type','notes','is_salary','supplier_bill_id','client_bill_id','user_id'];
			$table->float("remaining")->default(0);
			$table->float('paid')->nullable()->comment("payment value");
            $table->enum('type',['electricity_bill','water_bill','internet_bill','donation'])->nullable();
            $table->text('notes')->nullable();
			$table->boolean("is_salary")->default(false);
		});
	}

	public function down()
	{
		Schema::drop('balances');
	}
}
