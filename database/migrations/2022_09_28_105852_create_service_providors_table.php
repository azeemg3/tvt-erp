<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProvidorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email');
            $table->unsignedBigInteger('country');
            $table->unsignedBigInteger('province')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->boolean('status')->default(0);
            $table->text('address')->nullable();
            $table->string('product_includes');
            $table->text('term_condition');
            $table->unsignedBigInteger('UID')->nullable();
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
        Schema::dropIfExists('service_providors');
    }
}
