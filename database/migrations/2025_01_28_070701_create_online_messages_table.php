<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOnlineMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('message_type')->nullable();
            $table->string('offline_title')->nullable();
            $table->string('offline_message')->nullable();
            $table->string('message')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('online_messages');
    }
}
