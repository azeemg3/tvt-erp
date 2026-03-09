<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroundHandleAgentPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ground_handle_agent_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rate_type');
            $table->text('agents');
            $table->boolean('markup_type')->default(0);
            $table->boolean('markup_value');
            $table->unsignedBigInteger('GHID');
            $table->timestamps();
            $table->foreign('GHID')->references('id')
                ->on('ground_handle_rates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ground_handle_agent_prices');
    }
}
