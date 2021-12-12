<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendancesTable extends Migration {

	public function up()
	{
		Schema::create('attendances', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timeTz('time_in')->nullable();
			$table->timeTz('time_out')->nullable();
			$table->timestamp('date')->nullable();
			$table->text('details')->nullable();
			$table->boolean('is_exist')->default(true);
			$table->boolean('is_holiday')->default(false);
		});
	}

	public function down()
	{
		Schema::drop('attendances');
	}
}
