<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product');
            $table->date('validity_from');
            $table->date('validity_to');
            $table->unsignedBigInteger('currency');
            $table->unsignedBigInteger('SAID')->comment('sub admin id');
            $table->decimal('total_commission')->default(0)->nullable();
            $table->decimal('subadmin_commission')->default(0)->nullable();
            $table->decimal('agent_commission')->default(0)->nullable();
            $table->decimal('go_commission')->default(0)->nullable();
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
        Schema::dropIfExists('agent_commissions');
    }
}
