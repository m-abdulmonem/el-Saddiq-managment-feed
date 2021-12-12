<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BillsClientsReturn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills_clients_return', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('price')->nullable();
            $table->string('quantity')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("bills_clients_return");
    }
}
