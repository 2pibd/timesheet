<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBoundaryValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boundary_validations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('division_id')->nullable();
            $table->string('hour_day')->nullable();
            $table->string('days_day')->nullable();
            $table->string('hour_week')->nullable();
            $table->string('days_week')->nullable();
            $table->string('hour_month')->nullable();
            $table->string('days_month')->nullable();
            $table->string('hour_year')->nullable();
            $table->string('days_year')->nullable();
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
        Schema::drop('boundary_validations');
    }
}
