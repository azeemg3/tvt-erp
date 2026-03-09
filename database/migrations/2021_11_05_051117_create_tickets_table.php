<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('SID');
            $table->string('passport');
            $table->string('pax_name');
            $table->string('mobile')->nullable();
            $table->bigInteger('pax_type');
            $table->unsignedBigInteger('source');
            $table->unsignedBigInteger('airline')->nullable();
            $table->string('sector')->nullable();
            $table->tinyInteger('route');
            $table->date('fourtnite_date')->nullable();
            $table->date('departure_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('pnr')->nullable();
            $table->string('ticket_no');
            $table->decimal('basic_fare', 50,2);
            $table->decimal('taxes', 50,2);
            $table->decimal('receiveable', 50,2);
            $table->unsignedBigInteger('currency')->nullable();
            $table->decimal('currency_rate')->nullable();
            $table->unsignedBigInteger('payable_id')->nullable();
            $table->string('flight_no')->nullable();
            $table->bigInteger('class')->nullable();
            $table->bigInteger('ticket_type')->nullable();
            $table->decimal('sp_yi_tax',50,2)->nullable();
            $table->decimal('rg_cvt_tax',50,2)->nullable();
            $table->decimal('yq_tax',50,2)->nullable();
            $table->decimal('ced_tax',50,2)->nullable();
            $table->decimal('pb_adv_tax',50,2)->nullable();
            $table->decimal('xz_tax',50,2)->nullable();
            $table->decimal('yd_tax',50,2)->nullable();
            $table->decimal('xt_ur_tax',50,2)->nullable();
            $table->decimal('other_taxes',50,2)->nullable();
            $table->decimal('total_taxes',50,2)->nullable();
            $table->decimal('com_rec',50,2)->nullable();
            $table->decimal('com_paid',50,2)->nullable();
            $table->decimal('wh_air',50,2)->nullable();
            $table->decimal('pst_paid',50,2)->nullable();
            $table->decimal('psf',50,2)->nullable();
            $table->decimal('discount',50,2)->nullable();
            $table->decimal('wh_client',50,2)->nullable();
            $table->decimal('fare_inc',50,2)->nullable();
            $table->decimal('taxes_inc',50,2)->nullable();
            $table->decimal('agent_amount',50,2)->nullable();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->decimal('payable',50,2)->nullable();
            $table->decimal('profit',50,2)->nullable();
            $table->bigInteger('trans_code')->nullable();
            $table->timestamps();
            $table->unique(['ticket_no']);
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
        Schema::dropIfExists('tickets');
    }
}
