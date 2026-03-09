<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leadId')->nullable();
            $table->date('transaction_date');
            $table->date('posting_date')->nullable();
            $table->unsignedBigInteger('branch')->default(1);
            $table->tinyInteger('payment_type');
            $table->unsignedBigInteger('payment_to')->nullable();
            $table->unsignedBigInteger('payment_from')->nullable();
            $table->text('particulars');
            $table->unsignedBigInteger('SID')->nullable();
            $table->decimal('amount',50,2)->nullable();
            $table->decimal('balance',50,2)->nullable();
            $table->string('cheque_no')->nullable();
            $table->unsignedBigInteger('currency')->nullable();
            $table->decimal('currency_rate')->nullable();
            $table->bigInteger('trans_code');
            $table->boolean('status');
            $table->text('attach_file')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('update_by')->nullable();
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
        Schema::dropIfExists('receipts');
    }
}
