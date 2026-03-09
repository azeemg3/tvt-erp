<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_city');
            $table->unsignedBigInteger('to_city');
            $table->unsignedBigInteger('source');
            $table->unsignedBigInteger('transport_type');
            $table->decimal('purchase',20,2);
            $table->decimal('sale_tax',20,2)->nullable();
            $table->decimal('vat',20,2)->nullable();
            $table->decimal('wh',20,2)->nullable();
            $table->decimal('oc',20,2)->nullable();
            $table->decimal('net_purchase',20,2)->nullable();
            $table->string('contact_number')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->decimal('currency_rate',20,2 )->nullable();
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
        Schema::dropIfExists('transport_rates');
    }
}
