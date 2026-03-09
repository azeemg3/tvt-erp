<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('int_tours', function (Blueprint $table) {
            $table->id();
            $table->string('pkg_name');
            $table->unsignedBigInteger('country_id');
            $table->decimal('starting_price',20,2)->nullable();
            $table->bigInteger('duration')->nullable();
            $table->date('validity_from')->nullable();
            $table->date('validity_to')->nullable();
            $table->text('pkg_images')->nullable();
            $table->text('explore_details')->nullable();
            $table->text('your_info')->nullable();
            $table->decimal('adult_visa_price',20,2)->nullable();
            $table->decimal('child_visa_price',20,2)->nullable();
            $table->decimal('infant_visa_price',20,2)->nullable();
            $table->unsignedBigInteger('visa_vendor')->nullable();
            $table->text('transports')->nullable();
            $table->text('hotels')->nullable();
            $table->text('departure_details')->nullable();
            $table->text('highlights')->nullable();
            $table->text('term_conditions')->nullable();
            $table->unsignedBigInteger('gs_vendor')->nullable();
            $table->decimal('gs_rate',30,2)->nullable();
            $table->text('ground_handeling_details')->nullable();
            $table->decimal('markup')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('int_tours');
    }
}
