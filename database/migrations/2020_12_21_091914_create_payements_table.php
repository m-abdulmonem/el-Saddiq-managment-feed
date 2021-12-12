<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->enum("payment",['cash','cheque']);
            $table->enum('payment_type',['expenses','bank_deposit','pay_for_supplier']);
            $table->float("paid");
            $table->foreignId("bill_id")->nullable()->constrained("bills_suppliers");
            $table->foreignId("client_bill_id")->nullable()->constrained("bills_clients_return");
            $table->integer("balance_id")->nullable();
            $table->foreignId("supplier_id")->nullable()->constrained();
            $table->foreignId("bank_id")->nullable()->constrained();
            $table->foreignId("expense_id")->nullable()->constrained();
            $table->foreignId("client_id")->nullable()->constrained();
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
        Schema::dropIfExists('payments');
    }
}
