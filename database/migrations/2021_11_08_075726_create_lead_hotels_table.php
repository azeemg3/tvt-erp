<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('SID');
            $table->string('passport')->nullable();
            $table->string('pax_name');
            $table->string('mobile')->nullable();
            $table->unsignedBigInteger('pax_type');
            $table->string('group_no')->nullable();
            $table->unsignedBigInteger('hotels');
            $table->date('checkin');
            $table->date('checkout');
            $table->integer('nights');
            $table->string('room_no')->nullable();
            $table->tinyInteger('room_type')->nullable();
            $table->unsignedBigInteger('payable_id')->nullable();
            $table->unsignedBigInteger('receiveable_id')->nullable();
            $table->string('confirmation')->nullable();
            $table->string('int_ref')->nullable();
            $table->integer('guest_beds')->nullable();
            $table->boolean('meal')->default(0);
            $table->decimal('rate_night',30,2);
            $table->decimal('amount',30,2);
            $table->decimal('com_rec',30,2)->nullable();
            $table->decimal('com_paid',30,2)->nullable();
            $table->decimal('wh_air',30,2)->nullable();
            $table->decimal('pst_paid',30,2)->nullable();
            $table->decimal('psf',30,2)->nullable();
            $table->decimal('agent_amount',30,2)->nullable();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->decimal('discount',30,2)->nullable();
            $table->decimal('pst',30,2)->nullable();
            $table->decimal('payable',30,2)->nullable();
            $table->decimal('receiveable',30,2)->nullable();
            $table->unsignedBigInteger('currency')->nullable();
            $table->decimal('currency_rate',30,2)->nullable();
            $table->bigInteger('trans_code');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->decimal('profit',30,2)->nullable();
            $table->timestamps();
            $table->foreign('SID')->references('id')
                ->on('sale_invoices')->onDelete('restrict');
            $table->foreign('hotels')->references('id')
                ->on('hotels')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_hotels');
    }
}
