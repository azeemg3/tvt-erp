<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportBrnSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_brn_sectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_city');
            $table->unsignedBigInteger('to_city');
            $table->date('sector_date');
            $table->time('sector_time')->nullable();
            $table->unsignedBigInteger('TRBID')->comment('transport reservation id');

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
        Schema::dropIfExists('transport_brn_sectors');
    }
}
