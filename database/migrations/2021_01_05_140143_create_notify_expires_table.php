<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifyExpiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify_expires', function (Blueprint $table) {
            $table->id();
            $table->string("text")->nullable();
            $table->integer("remaining_days");
            $table->integer("quantity");
            $table->boolean("is_read")->default(false);
            $table->foreignId("user_id")->constrained();
            $table->foreignId("sms_id")->nullable()->constrained();
            $table->foreignId("product_stock_id")->constrained("products_stocks");
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
        Schema::dropIfExists('notify_expires');
    }
}
