<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBillsClientsTable extends Migration {

	public function up()
	{
		Schema::create('bills_clients', function(Blueprint $table) {

            $status = ['draft', 'scheduled for delivery', 'cancelled', 'accepted', 'preparing for delivery', 'ready for delivery', 'on delivery route', 'delivered',];

		    $table->bigIncrements('id');
			$table->integer('code')->nullable();
			$table->float('discount')->nullable();
			$table->float('price')->nullable();
			$table->enum('status',['draft','loaded','onWay','delivered','canceled'])->default("draft")->nullable();
			$table->integer('quantity')->nullable();
			$table->text('notes')->nullable();
//			$table->enum("status",$status)->default("draft");
			$table->boolean('is_cash')->default(true);
		});
	}

	public function down()
	{
		Schema::drop('bills_clients');
	}
}
