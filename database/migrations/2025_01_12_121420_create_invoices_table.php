<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_contact')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('employer_ref')->nullable();
            $table->string('tax_year')->nullable();
            $table->string('posted_to')->nullable();
            $table->string('invoice_printed')->nullable();
            $table->string('invoice_net')->nullable();
            $table->string('invoice_vat')->nullable();
            $table->string('invoice_total')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoices');
    }
}
