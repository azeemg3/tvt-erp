<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_code', 50)->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->string('client_name');
            $table->string('email')->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('co_spo')->nullable();
            $table->unsignedBigInteger('assigned_user_id')->nullable();
            $table->unsignedBigInteger('recovery_officer_id')->nullable();
            $table->enum('category', ['Walk-In Customer', 'Corporate', 'Agent'])->default('Walk-In Customer');
            $table->decimal('credit_limit', 18, 2)->default(0);
            $table->integer('credit_days')->default(0);
            $table->text('address')->nullable();
            $table->text('remarks')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('transaction_accounts')->onDelete('set null');
            $table->foreign('assigned_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('recovery_officer_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
