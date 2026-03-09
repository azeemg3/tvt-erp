<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelBrnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_brns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('HTBRN');
            $table->bigInteger('no_pax');
            $table->unsignedBigInteger('GRID');
            $table->unique(['HTBRN','GRID']);
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
        Schema::dropIfExists('hotel_brns');
    }
}
