<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_sms', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignId("sms_id")->nullable()->constrained();
            $table->foreignId("booking_id")->nullable()->constrained("booking_chicks");
            $table->foreignId("client_id")->nullable()->constrained();
            $table->timestamp("send_at");
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
        Schema::dropIfExists('booking_sms');
    }
}
