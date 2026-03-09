<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agentID');
            $table->string('country');
            $table->string('group_code');
            $table->string('group_name');
            $table->unsignedBigInteger('embassy');
            $table->string('voucherID')->nullable();
            $table->date('mofa_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->unique(['group_code']);
            $table->boolean('seen')->default(0);
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
        Schema::dropIfExists('group_details');
    }
}
