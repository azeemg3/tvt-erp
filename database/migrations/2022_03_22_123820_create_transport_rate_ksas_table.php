<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportRateKsasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_rate_ksas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('UID');
            $table->bigInteger('ack_by');
            $table->bigInteger('total_pax');
            $table->bigInteger('total_vehicle');
            $table->decimal('rate',30,2);
            $table->decimal('total',30,2);
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('transport_rate_ksas');
    }
}
