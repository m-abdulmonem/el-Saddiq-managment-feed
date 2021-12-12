<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalaries extends Migration
{
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float("salary")->nullable();
            $table->float("increase")->nullable();
            $table->float("discount")->nullable();
            $table->float("notes")->nullable();
            $table->foreignId("user_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}
