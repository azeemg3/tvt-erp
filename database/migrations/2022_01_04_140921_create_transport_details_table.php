<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transport_type');
            $table->unsignedBigInteger('city');
            $table->date('transport_date');
            $table->unsignedBigInteger('BookingId');
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
        Schema::dropIfExists('transport_details');
    }
}
