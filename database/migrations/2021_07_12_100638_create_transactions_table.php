<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',50,2)->nullable();
            $table->boolean('dr_cr');
            $table->tinyInteger('vt');
            $table->bigInteger('trans_code');
            $table->unsignedBigInteger('trans_acc_id');
            $table->date('trans_date');
            $table->date('posting_date');
            $table->date('rec_date');
            $table->text('narration');
            $table->tinyInteger('status');
            $table->unsignedBigInteger('SID')->nullable();
            $table->unsignedBigInteger('Created_By');
            $table->unsignedBigInteger('Updated_By');
            $table->unsignedBigInteger('BID');
            $table->unsignedBigInteger('payment_type');
            $table->unsignedBigInteger('currency');
            $table->decimal('conversion_rate');
            $table->unsignedBigInteger('financial_year');
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
        Schema::dropIfExists('transactions');
    }
}
