<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcrTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcr_tests', function (Blueprint $table) {
            $table->id();
            $table->date('test_date')->nullable();
            $table->string('pax_name');
            $table->unsignedBigInteger('pax_type');
            $table->string('lab_name')->nullable();
            $table->unsignedBigInteger('airline_id')->nullable();
            $table->decimal('rate',20,2)->nullable();
            $table->decimal('receiveable',20,2)->nullable();
            $table->decimal('discount',20,2)->nullable();
            $table->unsignedBigInteger('receiveable_id')->nullable();
            $table->decimal('currency_rate',20,2)->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('SID')->nullable();
            $table->decimal('payable',20,2)->nullable();
            $table->unsignedBigInteger('payable_id')->nullable();
            $table->bigInteger('trans_code')->nullable();
            $table->decimal('profit',20,2)->nullable();
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
        Schema::dropIfExists('pcr_tests');
    }
}
