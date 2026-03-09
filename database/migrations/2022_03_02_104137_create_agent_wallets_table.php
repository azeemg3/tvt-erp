<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agentID');
            $table->date('trans_date');
            $table->date('posting_date')->nullable();
            $table->unsignedBigInteger('payment_from');
            $table->unsignedBigInteger('agentID');
            $table->text('narration');
            $table->decimal('amount',30,2);
            $table->string('cheque')->nullable();
            $table->unsignedBigInteger('currency_id')->default(0)->nullable();
            $table->decimal('conversion_rate')->default(0)->nullable();
            $table->text('attach_file')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->dateTime('approved_time')->nullable();
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
        Schema::dropIfExists('agent_wallets');
    }
}
