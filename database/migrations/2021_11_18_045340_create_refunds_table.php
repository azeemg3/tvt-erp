<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->string('SID');
            $table->tinyInteger('refund_to');
            $table->tinyInteger('refund_type');
            $table->string('pax_name');
            $table->date('inv_date');
            $table->date('refund_date');
            $table->unsignedBigInteger('source')->nullable();
            $table->unsignedBigInteger('airline')->nullable();
            $table->string('sector')->nullable();
            $table->string('refund_sector')->nullable();
            $table->string('ticket_no')->nullable();
            $table->decimal('refund_amount');
            $table->decimal('service_charges')->nullable();
            $table->decimal('refund_taxes')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->text('remarks');
            $table->bigInteger('trans_code')->nullable();
            $table->decimal('com_rec')->nullable();
            $table->decimal('wh_air')->nullable();
            $table->boolean('status');
            $table->unsignedBigInteger('currency');
            $table->decimal('currency_rate',30,2);
            $table->decimal('psf')->nullable();
            $table->decimal('discount')->nullable();
            $table->unsignedBigInteger('rec_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('leadId')->nullable();
            $table->timestamps();
            $table->unique(['SID', 'rec_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refunds');
    }
}
