<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("log",function(Blueprint $table){
            $table->increments('id');

            $table->string("method", 10);
            $table->text("request");
            $table->text("response");
            $table->integer('status_code');
            $table->string("url", 1024);
            $table->string("ip", 16);

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
        Schema::dropIfExists('log');
    }
}
