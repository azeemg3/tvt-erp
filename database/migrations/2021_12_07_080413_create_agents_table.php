<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code');
            $table->string('agent_name');
            $table->string('agent_mobile');
            $table->string('agent_email');
            $table->unsignedBigInteger('agent_country')->nullable();
            $table->unsignedBigInteger('agent_province')->nullable();
            $table->unsignedBigInteger('agent_city')->nullable();
            $table->string('agent_address')->nullable();
            $table->string('agent_other_details')->nullable();
            $table->boolean('agent_type');
            $table->unsignedBigInteger('agentID')->nullable();
            $table->unsignedBigInteger('PID');
            $table->unsignedBigInteger('ARID')->default(0)->nullable();
            $table->unsignedBigInteger('mosqueID')->default(0)->nullable();
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('UID')->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('seen')->default(0);
            $table->timestamps();
            $table->unique(['agent_name','agentID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
    }
}
