<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportAgentPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_agent_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent');
            $table->unsignedBigInteger('from_city');
            $table->unsignedBigInteger('to_city');
            $table->unsignedBigInteger('transport_type');
            $table->integer('month');
            $table->text('validity_date_rate');
            $table->boolean('markup_type')->default(0);
            $table->decimal('markup_value',30,2);
            $table->unsignedBigInteger('TRID');
            $table->timestamps();
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
        Schema::dropIfExists('transport_agent_prices');
    }
}
