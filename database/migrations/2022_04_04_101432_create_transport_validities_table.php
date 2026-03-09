<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportValiditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_validities', function (Blueprint $table) {
            $table->id();
            $table->date('validity_date');
            $table->unsignedBigInteger('TRID');
            $table->integer('month');
            $table->decimal('rate',20,2);
            $table->timestamps();
            $table->unique(['validity_date','TRID']);
            $table->foreign('TRID')->references('id')
                ->on('transport_rates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transport_validities');
    }
}
