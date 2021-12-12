<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("to")->nullable();
            $table->string("message_id");
            $table->float("remaining_balance");
            $table->float("message_price");
            $table->integer("network");
            $table->integer("status");
            $table->string("error_text")->nullable();
            $table->string("provider")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms');
    }
}
