<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->bigIncrements('id');
            $table->integer('code')->nullable();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('picture')->nullable();
            $table->float('salary')->default(0)->nullable();
            $table->enum('salary_type', ['monthly','weekly', 'daily'])->nullable();
            $table->float('credit_limit')->nullable();
            $table->float('discount_limit')->nullable();
            $table->string('holidays')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('device_token')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}
