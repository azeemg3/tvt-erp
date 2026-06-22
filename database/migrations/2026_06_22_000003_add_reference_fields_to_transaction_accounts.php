<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceFieldsToTransactionAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds polymorphic reference + status columns so transaction accounts can be
     * linked back to the source record (Client / Vendor) that created them.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_accounts', function (Blueprint $table) {
            if (! Schema::hasColumn('transaction_accounts', 'reference_id')) {
                $table->unsignedBigInteger('reference_id')->nullable()->after('Parent_Type');
            }
            if (! Schema::hasColumn('transaction_accounts', 'reference_type')) {
                $table->string('reference_type', 100)->nullable()->after('reference_id');
            }
            if (! Schema::hasColumn('transaction_accounts', 'status')) {
                $table->tinyInteger('status')->default(1)->after('reference_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_accounts', function (Blueprint $table) {
            if (Schema::hasColumn('transaction_accounts', 'reference_id')) {
                $table->dropColumn('reference_id');
            }
            if (Schema::hasColumn('transaction_accounts', 'reference_type')) {
                $table->dropColumn('reference_type');
            }
            if (Schema::hasColumn('transaction_accounts', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}
