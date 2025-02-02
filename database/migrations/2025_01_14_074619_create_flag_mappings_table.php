<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFlagMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flag_mappings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('ref_code')->nullable();
            $table->string('status')->nullable();
            $table->string('details')->nullable();
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
        Schema::drop('flag_mappings');
    }
}
