<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('description')->nullable();
            $table->string('escalation_frequency_id')->nullable();
            $table->string('email_wet_signature')->nullable();
            $table->string('email_approval_signature')->nullable();
            $table->string('sso_link_expiry_days')->nullable();
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
        Schema::drop('workflows');
    }
}
