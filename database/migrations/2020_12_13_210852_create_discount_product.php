<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDiscountProduct extends Migration
{
    public function up()
    {
        Schema::create('discount_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('discount')->nullable();
            $table->foreignId('product_id')->nullable()->constrained();
            $table->foreignId('bill_id')->nullable()->constrained("bills_clients");
            $table->foreignId("user_id")->nullable()->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discount_products');
    }
}
