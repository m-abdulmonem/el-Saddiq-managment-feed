<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmsBodies extends Migration
{
    public function up()
    {
        Schema::create('sms_bodies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('text');
            $table->text('body');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sms_bodies');
    }
}
