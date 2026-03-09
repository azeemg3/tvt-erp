<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('hotel_id');
            $table->string('contact');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('currency_rate');
            $table->unsignedBigInteger('source');
            $table->unsignedBigInteger('room_type');
            $table->decimal('purchase',20,2);
            $table->decimal('sale_tax',20,2)->nullable();
            $table->decimal('vat',20,2)->nullable();
            $table->decimal('wh',20,2)->nullable();
            $table->decimal('oc',20,2)->nullable();
            $table->decimal('net_purchase',20,2)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('hotel_id')->references('id')
                ->on('hotels')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels_rates');
    }
}
