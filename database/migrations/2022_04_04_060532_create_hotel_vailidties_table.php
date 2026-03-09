<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelVailidtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_vailidties', function (Blueprint $table) {
            $table->id();
            $table->date('validity_date');
            $table->unsignedBigInteger('HRID');
            $table->integer('month');
            $table->decimal('rate',20,2);
            $table->timestamps();
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
        Schema::dropIfExists('hotel_vailidties');
    }
}
