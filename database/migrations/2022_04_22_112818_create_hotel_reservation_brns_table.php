<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelReservationBrnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_reservation_brns', function (Blueprint $table) {
            $table->id();
            $table->date('booking_date');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('hotel_id');
            $table->date('checkin');
            $table->bigInteger('nights');
            $table->date('checkout');
            $table->unsignedBigInteger('room_type');
            $table->integer('no_room');
            $table->unsignedBigInteger('purchased_by');
            $table->unsignedBigInteger('currency')->nullable();
            $table->decimal('currency_rate',20,2)->nullable();
            $table->decimal('purchase_rate',20,2);
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
        Schema::dropIfExists('hotel_reservation_brns');
    }
}
