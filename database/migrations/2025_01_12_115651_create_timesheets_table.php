<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('worker_id')->nullable();
            $table->string('assignment_id')->nullable();
            $table->string('timesheet_date')->nullable();
            $table->string('timesheet_number')->nullable();
            $table->string('tax_year')->nullable();
            $table->string('timesheet_authoriser_id')->nullable();
            $table->string('start_week')->nullable();
            $table->string('additional_expense')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timesheets');
    }
}
