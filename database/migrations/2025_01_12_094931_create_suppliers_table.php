<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('employer_id')->nullable();
            $table->string('supplier_ref')->nullable();
            $table->string('business_name')->nullable();
            $table->string('department')->nullable();
            $table->string('division')->nullable();
            $table->string('legal_status')->nullable();
            $table->string('supplier_type')->nullable();
            $table->string('remittance_to')->nullable();
            $table->string('payment_option')->nullable();
            $table->string('incorpotrate_date')->nullable();
            $table->string('company_reg_no')->nullable();
            $table->string('schedule_date')->nullable();
            $table->string('number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('vat_area')->nullable();
            $table->string('vat_rate')->nullable();
            $table->string('payment_terms')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('suppliers');
    }
}
