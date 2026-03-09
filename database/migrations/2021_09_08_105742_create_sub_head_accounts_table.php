<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubHeadAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_head_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('HID');
            $table->timestamps();
            $table->unique(['name', 'HID']);
            $table->foreign('HID')->references('id')->on('head_accounts')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_head_accounts');
    }
}
