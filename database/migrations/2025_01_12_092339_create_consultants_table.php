<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsultantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('user_id')->nullable();
            $table->string('user_ref')->nullable();
            $table->string('ref_code')->nullable();
            $table->string('access_code')->nullable();
            $table->string('officeial_id')->nullable();
            $table->string('work_telephone')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('address_line3')->nullable();
            $table->string('address_line4')->nullable();
            $table->string('post_code')->nullable();
            $table->string('office_manager')->nullable();
            $table->string('security_admin')->nullable();
            $table->string('read_only_access')->nullable();
            $table->string('template_id')->nullable();
            $table->string('language_id')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('consultants');
    }
}
