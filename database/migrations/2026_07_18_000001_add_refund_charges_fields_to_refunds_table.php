<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefundChargesFieldsToRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refunds', function (Blueprint $table) {
            if (!Schema::hasColumn('refunds', 'vendor_charges')) {
                // airline/vendor cancellation charges deducted from the refund
                $table->decimal('vendor_charges', 15, 2)->nullable()->after('service_charges');
            }
            if (!Schema::hasColumn('refunds', 'net_refund')) {
                // refund_amount - vendor_charges - service_charges (amount returned to client)
                $table->decimal('net_refund', 15, 2)->nullable()->after('vendor_charges');
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
        Schema::table('refunds', function (Blueprint $table) {
            if (Schema::hasColumn('refunds', 'vendor_charges')) {
                $table->dropColumn('vendor_charges');
            }
            if (Schema::hasColumn('refunds', 'net_refund')) {
                $table->dropColumn('net_refund');
            }
        });
    }
}
