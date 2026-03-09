<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigIncrements('code');
            $table->string('Trans_Acc_Name');
            $table->unsignedBigInteger('PID');
            $table->unsignedBigInteger('Parent_Type')->nullable();
            $table->string('OB')->nullable();
            $table->tinyInteger('OB_Type')->nullable();
            $table->unsignedBigInteger('BID')->default(1);
            $table->boolean('editable')->default(0);
            $table->unsignedBigInteger('Created_BY')->nullable();
            $table->unsignedBigInteger('Updated_By')->nullable();
            $table->time('Last_Activity')->nullable();
            $table->foreign('PID')->references('id')->on('sub_head_accounts')->onDelete('restrict');
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
        Schema::dropIfExists('transaction_accounts');
    }
}
