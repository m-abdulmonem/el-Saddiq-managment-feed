<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
            $table->softDeletes();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('address')->nullable();
            $table->string('manger')->nullable();
            $table->string('logo')->nullable();
            $table->string('icon')->nullable();
            $table->enum('lang', array(''))->nullable();
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->enum('status', array('open','closed','maintenance'))->nullable()->default("maintenance");
            $table->integer('paginate')->default(10);
            $table->text('maintenance_message')->nullable();
            $table->timestamp('maintenance_start_at')->nullable();
            $table->timestamp('maintenance_end_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('fb')->nullable();
            $table->string('tw')->nullable();
            $table->string('android_app_link')->nullable();
            $table->string('ios_app_link')->nullable();
            $table->integer('min_products_alert')->nullable();
            $table->timeTz('time_in')->nullable();
            $table->timeTz('time_out')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
