<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatchPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catch_purchases', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->enum("type",['cash','bank']);
            $table->float("paid");
            $table->foreignId("bill_id")->nullable()->constrained("bills_suppliers");
            $table->foreignId("invoice_id")->nullable()->constrained("bills_clients");
            $table->integer("balance_id")->nullable();
            $table->foreignId("bank_id")->nullable()->constrained();
            $table->foreignId("user_id")->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catch_purchases');
    }
}
