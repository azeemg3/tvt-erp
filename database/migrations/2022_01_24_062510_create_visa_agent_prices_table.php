<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaAgentPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_agent_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rate_type');
            $table->text('agents');
            $table->boolean('markup_type')->default(0);
            $table->boolean('markup_value');
            $table->unsignedBigInteger('VRID');
            $table->timestamps();
            $table->foreign('VRID')->references('id')
                ->on('visa_rates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visa_agent_prices');
    }
}
