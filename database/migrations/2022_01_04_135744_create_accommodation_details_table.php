<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_details', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('hotel_name');
            $table->unsignedBigInteger('hotel_type');
            $table->boolean('food')->nullable();
            $table->date('checkin');
            $table->date('checkout');
            $table->integer('nights');
            $table->decimal('price',20)->nullable();
            $table->unsignedBigInteger('BookingID');
            $table->foreign('BookingID')->references('id')
                ->on('bookings')->onDelete('cascade');
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
        Schema::dropIfExists('accommodation_details');
    }
}
