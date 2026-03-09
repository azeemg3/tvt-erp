<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_vouchers', function (Blueprint $table) {
            $table->id();
            $table->date('trans_date');
            $table->date('posting_date')->nullable();
            $table->unsignedBigInteger('payment_to')->nullable();
            $table->unsignedBigInteger('payment_from')->nullable();
            $table->unsignedBigInteger('payment_type')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('cheque')->nullable();
            $table->unsignedBigInteger('currency')->nullable();
            $table->decimal('conversion_rate')->nullable();
            $table->string('ref')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('status')->default(0);
            $table->unsignedSmallInteger('Created_by')->nullable();
            $table->unsignedSmallInteger('Updated_by')->nullable();
            $table->unsignedSmallInteger('BID')->default(1);
            $table->bigInteger('trans_code');
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
        Schema::dropIfExists('journal_vouchers');
    }
}
