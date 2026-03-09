<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuarantinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quarantines', function (Blueprint $table) {
            $table->id();
            $table->string('pkg_name');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('airline_id')->nullable();
            $table->string('inclusions')->nullable();
            $table->decimal('guest_price',20);
            $table->text('pkg_details');
            $table->text('quarantine_information');
            $table->string('hotel_name')->nullable();
            $table->date('checkin_date')->nullable();
            $table->time('checkin_time')->nullable();
            $table->date('checkout_date')->nullable();
            $table->time('checkout_time')->nullable();
            $table->bigInteger('hotel_star')->nullable();
            $table->string('hotel_images')->nullable();
            $table->unsignedBigInteger('transport_type')->nullable();
            $table->unsignedBigInteger('transport_city')->nullable();
            $table->date('transport_date')->nullable();
            $table->string('transport_image')->nullable();
            $table->unsignedBigInteger('BID')->default(1);
            $table->unsignedBigInteger('creatd_by')->nullable();
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
        Schema::dropIfExists('quarantines');
    }
}
