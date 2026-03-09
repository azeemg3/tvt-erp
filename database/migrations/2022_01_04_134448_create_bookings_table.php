<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('airline_id');
            $table->string('pnr');
            $table->string('flight');
            $table->date('booking_date');
            $table->unsignedBigInteger('booking_type');
            $table->boolean('booking_by')->comment('e.g 0 guest 1 mean agent');
            $table->unsignedBigInteger('payment_type');
            $table->boolean('status');
            $table->date('departure');
            $table->time('departure_time');
            $table->date('arrival');
            $table->time('arrival_time');
            $table->unsignedBigInteger('booked_by');
            $table->unsignedBigInteger('approved_by');
            $table->unsignedBigInteger('PkgID');
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
        Schema::dropIfExists('bookings');
    }
}
