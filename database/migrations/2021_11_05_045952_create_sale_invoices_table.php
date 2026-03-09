<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leadId');
            $table->tinyInteger('type');
            $table->date('inv_date');
            $table->date('fourtnite')->nullable();
            $table->date('due_date')->nullable();
            $table->tinyInteger('payment_type');
            $table->text('remarks');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->unsignedBigInteger('BID')->default(1);
            $table->bigInteger('trans_code');
            $table->unsignedBigInteger('ledger')->nullable();
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_invoices');
    }
}
