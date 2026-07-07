<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateSaleTicketFormFields extends Migration
{
    public function up()
    {
        Schema::table('sale_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('spo_id')->nullable()->after('ledger');
            $table->foreign('spo_id')->references('id')->on('general_accounts')->onDelete('set null');
        });

        DB::statement('ALTER TABLE tickets MODIFY passport VARCHAR(255) NULL');
        DB::statement('ALTER TABLE sale_invoices MODIFY remarks TEXT NULL');
    }

    public function down()
    {
        Schema::table('sale_invoices', function (Blueprint $table) {
            $table->dropForeign(['spo_id']);
            $table->dropColumn('spo_id');
        });

        DB::statement('ALTER TABLE tickets MODIFY passport VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE sale_invoices MODIFY remarks TEXT NOT NULL');
    }
}
