<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_no')->nullable()->unique();
            $table->string('customer_name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->unsignedBigInteger('pkg_id');
            $table->integer('adult')->default(0);
            $table->integer('child')->default(0);
            $table->integer('infant')->default(0);
            $table->boolean('payment_status')->default(0);
            $table->decimal('receiveable_amout');
            $table->text('other_details')->nullable();
            $table->unsignedBigInteger('payment_via')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
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
        Schema::dropIfExists('tour_bookings');
    }
}
