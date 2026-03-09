<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroundServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ground_services', function (Blueprint $table) {
            $table->id();
            $table->boolean('ground_services_type')->default(0);
            $table->string('company_name');
            $table->string('license_no')->nullable();
            $table->string('contact_person');
            $table->string('contact_number')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('web_address');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('purchased_by')->nullable();
            $table->text('repersentative_contact');
            $table->text('ground_services_address')->nullable();
            $table->decimal('service_contact_person')->nullable();
            $table->string('external_agent')->nullable();
            $table->string('service_license_no')->nullable();
            $table->string('umrah_company')->nullable();
            $table->decimal('adult_rate',20,2)->nullable();
            $table->decimal('child_rate',20,2)->nullable();
            $table->decimal('infant_rate',20,2)->nullable();
            $table->bigInteger('adult_qty')->default(0);
            $table->bigInteger('child_qty')->default(0);
            $table->bigInteger('infant')->default(0);
            $table->decimal('insurance_adult_rate',20,2)->nullable();
            $table->decimal('insurance_child_rate',20,2)->nullable();
            $table->decimal('insurance_infant_rate',20,2)->nullable();
            $table->string('insured_person')->nullable();
            $table->bigInteger('insured_adult')->nullable();
            $table->bigInteger('insured_child')->nullable();
            $table->bigInteger('insured_infant')->nullable();
            $table->decimal('grand_total',20,2)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
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
        Schema::dropIfExists('ground_services');
    }
}
