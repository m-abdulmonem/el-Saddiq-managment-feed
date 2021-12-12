<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBillsSuppliersTable extends Migration {

	public function up()
	{
		Schema::create('bills_suppliers', function(Blueprint $table) {
		    $status =  ['draft', 'scheduled for shipping', 'cancelled', 'accepted', 'preparing for shipment', 'ready for shipment', 'on shipping route', 'shipped',];
			$table->bigIncrements('id');
			$table->integer('code')->nullable();
			$table->integer('number')->nullable()->comment("this is the the supplier bill number ");
			$table->string('driver')->nullable();
			$table->integer('car_number')->nullable();
			$table->float('discount')->nullable();
			$table->float('price')->nullable();
			$table->integer('quantity')->nullable();
			$table->boolean('is_cash')->default(true);
			$table->enum("status",$status)->default("draft")->nullable();
			$table->text('notes')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('bills_suppliers');
	}
}
