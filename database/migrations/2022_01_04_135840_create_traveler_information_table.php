<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelerInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traveler_information', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('iqama_border_no')->nullable();
            $table->unsignedBigInteger('nationality');
            $table->string('passport_number');
            $table->string('nic');
            $table->string('flight_no')->nullable();
            $table->string('dep_city')->nullable();
            $table->string('ticket_no')->nullable();
            $table->string('passport_images')->nullable();
            $table->string('nic_images')->nullable();
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
        Schema::dropIfExists('traveler_information');
    }
}
