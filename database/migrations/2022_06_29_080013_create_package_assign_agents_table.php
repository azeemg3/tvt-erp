<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageAssignAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_assign_agents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pkg_type');
            $table->unsignedBigInteger('pkg_id');
            $table->string('validity');
            $table->string('agents');
            $table->unsignedBigInteger('discount_type');
            $table->decimal('discount',20,2);
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
        Schema::dropIfExists('package_assign_agents');
    }
}
