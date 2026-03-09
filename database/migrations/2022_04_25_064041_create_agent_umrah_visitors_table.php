<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentUmrahVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_umrah_visitors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code')->nullable();
            $table->unsignedBigInteger('title')->nullable();
            $table->string('pax_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('gender')->nullable();
            $table->unsignedBigInteger('pax_type')->nullable();
            $table->date('dob')->nullable();
            $table->bigInteger('age')->nullable();
            $table->string('mehram')->nullable();
            $table->string('visa')->nullable();
            $table->string('mofa')->nullable();
            $table->string('cnic')->nullable();
            $table->unsignedBigInteger('nationality')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('passport_type')->nullable();
            $table->string('passport')->nullable();
            $table->unsignedBigInteger('passport_country')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expire_date')->nullable();
            $table->unsignedBigInteger('group_id');
//            $table->foreign('group_id')->references('id')->on('group_details')
//                ->onDelete('restrict');
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
        Schema::dropIfExists('agent_umrah_visitors');
    }
}
