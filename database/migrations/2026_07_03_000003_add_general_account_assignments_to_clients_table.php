<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeneralAccountAssignmentsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            // General Account designations assigned to a client.
            $table->unsignedBigInteger('spo_id')->nullable()->after('recovery_officer_id');
            $table->unsignedBigInteger('ro_id')->nullable()->after('spo_id');
            $table->unsignedBigInteger('marketing_officer_id')->nullable()->after('ro_id');

            $table->foreign('spo_id')->references('id')->on('general_accounts')->onDelete('set null');
            $table->foreign('ro_id')->references('id')->on('general_accounts')->onDelete('set null');
            $table->foreign('marketing_officer_id')->references('id')->on('general_accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['spo_id']);
            $table->dropForeign(['ro_id']);
            $table->dropForeign(['marketing_officer_id']);
            $table->dropColumn(['spo_id', 'ro_id', 'marketing_officer_id']);
        });
    }
}
