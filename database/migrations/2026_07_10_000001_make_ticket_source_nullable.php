<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MakeTicketSourceNullable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE tickets MODIFY source BIGINT UNSIGNED NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE tickets MODIFY source BIGINT UNSIGNED NOT NULL');
    }
}
