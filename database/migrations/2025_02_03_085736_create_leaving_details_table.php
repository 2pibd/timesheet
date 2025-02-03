<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeavingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaving_details', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('employer_id')->nullable();
            $table->string('personal_ref')->nullable();
            $table->string('leaving_date')->nullable();
            $table->string('leaving_reason')->nullable();
            $table->string('status')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('leaving_details');
    }
}
