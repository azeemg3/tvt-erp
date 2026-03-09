<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('gender');
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedBigInteger('DID')->nullable();
            $table->unsignedBigInteger('DPID')->nullable();
            $table->date('dob')->nullable();
            $table->string('cnic')->nullable();
            $table->unsignedBigInteger('martial_status')->nullable();
            $table->unsignedBigInteger('emp_status')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('mobile_phone');
            $table->string('work_email');
            $table->string('private_email')->nullable();
            $table->string('address')->nullable();;
            $table->unsignedBigInteger('CID')->nullable();;
            $table->unsignedBigInteger('CTID')->nullable();;
            $table->date('joining_date')->nullable();;
            $table->date('confirmation_date')->nullable();;
            $table->date('terminate_date')->nullable();
            $table->decimal('basic_salary', 30,2)->nullable();;
            $table->decimal('allownces', 30,2)->nullable();;
            $table->decimal('net_salary', 30,2)->nullable();;
            $table->unsignedBigInteger('BID')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();;
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('UID')->nullable();;
            $table->unique(['mobile_phone']);
            $table->timestamps();
            $table->foreign("UID")->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
