<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher');
            $table->string('total_amount')->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('GID')->comment('group id');
            $table->bigInteger('trans_code')->nullable();
            $table->unsignedBigInteger('currency')->nullable();
            $table->decimal('currency_rate',20,2)->nullable();
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
        Schema::dropIfExists('group_vouchers');
    }
}
