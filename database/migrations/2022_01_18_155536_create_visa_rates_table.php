<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visa_type');
            $table->string('product_name');
            $table->string('source')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->decimal('currency_rate',20,2)->nullable();
            $table->date('validity_from')->nullable();
            $table->date('validity_to')->nullable();
            $table->text('adult_det')->nullable();
            $table->text('child_det')->nullable();
            $table->text('infant_det')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('visa_rates');
    }
}
