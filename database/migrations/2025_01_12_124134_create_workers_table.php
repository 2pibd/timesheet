<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('user_login_id')->nullable();
            $table->string('emp_ref')->nullable();
            $table->string('personal_ref')->nullable();
            $table->string('first_forename')->nullable();
            $table->string('second_forename')->nullable();
            $table->string('third_forename')->nullable();
            $table->string('surname')->nullable();
            $table->string('paye_code')->nullable();
            $table->string('ni_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('address_line3')->nullable();
            $table->string('address_line4')->nullable();
            $table->string('address_line5')->nullable();
            $table->string('post_code')->nullable();
            $table->string('country_id')->nullable();
            $table->string('tel_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->string('dob')->nullable();
            $table->string('worker_type')->nullable();
            $table->string('awr_type')->nullable();
            $table->string('non_cis_utr')->nullable();
            $table->string('known_as')->nullable();
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
        Schema::drop('workers');
    }
}
