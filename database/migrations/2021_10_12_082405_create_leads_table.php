<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('contact_name');
            $table->string('code')->nullable();
            $table->string('mobile');
            $table->string('email');
            $table->string('cnic')->nullable();
            $table->unsignedBigInteger('spo');
            $table->date('travel_date_from')->nullable();
            $table->date('travel_date_to')->nullable();
            $table->unsignedBigInteger('CID')->nullable();
            $table->unsignedBigInteger('CTID')->nullable();
            $table->string('services')->nullable();
            $table->string('sector')->nullable();
            $table->integer('source_of_query')->nullable();
            $table->text('other_details')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('ledger')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('current_lead_owner')->nullable();
            $table->boolean('close_status')->nullable();
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
        Schema::dropIfExists('leads');
    }
}
