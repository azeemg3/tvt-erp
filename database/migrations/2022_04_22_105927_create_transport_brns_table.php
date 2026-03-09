<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportBrnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_brns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('TRBRN');
            $table->bigInteger('no_pax');
            $table->unsignedBigInteger('GRID');
            $table->unique(['TRBRN','GRID']);
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
        Schema::dropIfExists('transport_brns');
    }
}
