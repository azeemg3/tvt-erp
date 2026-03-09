<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportReservationBrnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_reservation_brns', function (Blueprint $table) {
            $table->id();
            $table->date('booking_date');
            $table->unsignedBigInteger('transport_co')->nullable();
            $table->unsignedBigInteger('cycle');
            $table->unsignedBigInteger('vehicle_type');
            $table->date('arrival_date');
            $table->bigInteger('total_capacity');
            $table->unsignedBigInteger('purchased_by');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('currency')->nullable();
            $table->decimal('currency_rate',20,2)->nullable();
            $table->decimal('purchase_rate',20,2);
            $table->text('sector_details')->nullable();
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
        Schema::dropIfExists('transport_reservation_brns');
    }
}
