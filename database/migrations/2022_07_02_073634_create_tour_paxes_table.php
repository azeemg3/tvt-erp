<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourPaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_paxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('title')->nullable();
            $table->string('pax_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('gender')->nullable();
            $table->unsignedBigInteger('pax_type')->nullable();
            $table->date('dob')->nullable();
            $table->bigInteger('age')->nullable();
            $table->string('cnic')->nullable();
            $table->unsignedBigInteger('nationality')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('passport_type')->nullable();
            $table->string('passport')->nullable();
            $table->unsignedBigInteger('passport_country')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expire_date')->nullable();
            $table->unsignedBigInteger('tour_id');
            $table->unsignedBigInteger('tour_type');
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
        Schema::dropIfExists('tour_paxes');
    }
}
