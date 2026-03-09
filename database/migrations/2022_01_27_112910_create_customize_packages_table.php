<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomizePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customize_packages', function (Blueprint $table) {
            $table->id();
            $table->string('pkg_name');
            $table->decimal('price',20,2);
            $table->string('makkah_hotel');
            $table->string('madina_hotel');
            $table->integer('duraion');
            $table->integer('makkah_night');
            $table->integer('madina_night');
            $table->date('traveling_df')->nullable();
            $table->date('traveling_dt')->nullable();
            $table->text('pkg_details');
            $table->text('pkg_images')->nullable();
            $table->text('brochure_image')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('BID')->default(1);
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
        Schema::dropIfExists('customize_packages');
    }
}
