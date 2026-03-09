<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelAgentPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_agent_prices', function (Blueprint $table) {
            $table->id();
            $table->text('agent');
            $table->boolean('markup_type');
            $table->boolean('markup_value');
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('room_type');
            $table->integer('month');
            $table->text('validity_date_rate');
            $table->unsignedBigInteger('HRID');
            $table->timestamps();
            $table->unique(['agent','month','hotel_id', 'room_type']);
            $table->foreign('HRID')->references('id')
                ->on('hotels_rates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_agent_prices');
    }
}
