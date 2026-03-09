<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('SID');
            $table->string('passport')->nullable();
            $table->string('pax_name');
            $table->string('mobile')->nullable();
            $table->unsignedBigInteger('pax_type');
            $table->decimal('rate',30,2);
            $table->unsignedBigInteger('payable_id')->nullable();
            $table->bigInteger('vehicle_type')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->unsignedBigInteger('receiveable_id')->nullable();
            $table->decimal('psf',30,2)->nullable();
            $table->decimal('f_agent',30,2)->nullable();
            $table->decimal('s_agent',30,2)->nullable();
            $table->decimal('discount',30,2)->nullable();
            $table->decimal('pst',30,2)->nullable();
            $table->decimal('payable',30,2)->nullable();
            $table->decimal('receiveable',30,2)->nullable();
            $table->decimal('profit',30,2)->nullable();
            $table->unsignedBigInteger('currency')->nullable();
            $table->decimal('currency_rate',30,2)->nullable();
            $table->bigInteger('trans_code');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('SID')->references('id')
                ->on('sale_invoices')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transports');
    }
}
