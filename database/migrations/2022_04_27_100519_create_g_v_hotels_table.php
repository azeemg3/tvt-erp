<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGVHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_v_hotels', function (Blueprint $table) {
            $table->id();
            $table->string('brn');
            $table->unsignedBigInteger('hotel_id');
            $table->date('service_date');
            $table->decimal('price',20,2);
            $table->bigInteger('qty');
            $table->decimal('total_amount',20,2);
            $table->unsignedBigInteger('GVID');
            $table->timestamps();
            $table->foreign('GVID')->references('id')->on('group_vouchers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('g_v_hotels');
    }
}
