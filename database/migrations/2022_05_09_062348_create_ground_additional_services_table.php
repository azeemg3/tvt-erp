<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroundAdditionalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ground_additional_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->decimal('adult_rate')->nullable();
            $table->decimal('child_rate')->nullable();
            $table->decimal('infant_rate')->nullable();
            $table->bigInteger('adult_qty')->default(0);
            $table->bigInteger('child_qty')->default(0);
            $table->bigInteger('infant_qty')->default(0);
            $table->unsignedBigInteger('GSID');
            $table->foreign('GSID')->references('id')
                ->on('ground_services')->onDelete('cascade');
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
        Schema::dropIfExists('ground_additional_services');
    }
}
