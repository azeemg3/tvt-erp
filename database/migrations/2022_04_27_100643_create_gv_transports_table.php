<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGvTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gv_transports', function (Blueprint $table) {
            $table->id();
            $table->string('brn');
            $table->unsignedBigInteger('TCID')->comment('Transport Company');
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
        Schema::dropIfExists('gv_transports');
    }
}
