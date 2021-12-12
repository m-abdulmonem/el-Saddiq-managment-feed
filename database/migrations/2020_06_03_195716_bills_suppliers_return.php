<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BillsSuppliersReturn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills_suppliers_return', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->nullable();
            $table->string('number')->nullable();
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
        Schema::drop('bills_suppliers_return');
    }
}
