<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the legacy, unused "vendors" table if present. Guarded so we only
        // ever drop the old schema (has vendor_address, no vendor_name) and never
        // a populated/compatible table.
        if (Schema::hasTable('vendors')
            && Schema::hasColumn('vendors', 'vendor_address')
            && ! Schema::hasColumn('vendors', 'vendor_name')) {
            Schema::dropIfExists('vendors');
        }

        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor_code', 50)->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->string('vendor_name');
            $table->string('vendor_type', 100)->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('iata_code', 20)->nullable();
            $table->string('airline_code', 20)->nullable();
            $table->string('gst_vat_no', 100)->nullable();
            $table->decimal('credit_limit', 18, 2)->default(0);
            $table->integer('credit_days')->default(0);
            $table->decimal('opening_balance', 18, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('transaction_accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
