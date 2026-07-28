<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketBreakdownFieldsToRefundsTable extends Migration
{
    public function up()
    {
        Schema::table('refunds', function (Blueprint $table) {
            if (!Schema::hasColumn('refunds', 'payable')) {
                $table->decimal('payable', 15, 2)->nullable()->after('net_refund');
            }
            if (!Schema::hasColumn('refunds', 'com_paid')) {
                $table->decimal('com_paid', 15, 2)->nullable()->after('com_rec');
            }
            if (!Schema::hasColumn('refunds', 'pst_paid')) {
                $table->decimal('pst_paid', 15, 2)->nullable()->after('wh_air');
            }
            if (!Schema::hasColumn('refunds', 'wh_client')) {
                $table->decimal('wh_client', 15, 2)->nullable()->after('discount');
            }
            if (!Schema::hasColumn('refunds', 'agent_amount')) {
                $table->decimal('agent_amount', 15, 2)->nullable()->after('wh_client');
            }
            if (!Schema::hasColumn('refunds', 'agent_id')) {
                $table->unsignedBigInteger('agent_id')->nullable()->after('agent_amount');
            }
        });
    }

    public function down()
    {
        Schema::table('refunds', function (Blueprint $table) {
            foreach (['payable', 'com_paid', 'pst_paid', 'wh_client', 'agent_amount', 'agent_id'] as $col) {
                if (Schema::hasColumn('refunds', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}
