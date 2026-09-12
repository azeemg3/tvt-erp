<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EnhanceAirlinesTable extends Migration
{
    /**
     * Expand the airline master with codes, country, status and audit fields.
     */
    public function up()
    {
        Schema::table('airlines', function (Blueprint $table) {
            if (! Schema::hasColumn('airlines', 'iata_code')) {
                $table->string('iata_code', 3)->nullable()->after('name');
            }
            if (! Schema::hasColumn('airlines', 'icao_code')) {
                $table->string('icao_code', 4)->nullable()->after('iata_code');
            }
            if (! Schema::hasColumn('airlines', 'numeric_code')) {
                $table->string('numeric_code', 3)->nullable()->after('icao_code');
            }
            if (! Schema::hasColumn('airlines', 'country')) {
                $table->string('country', 100)->nullable()->after('numeric_code');
            }
            if (! Schema::hasColumn('airlines', 'remarks')) {
                $table->text('remarks')->nullable()->after('country');
            }
            if (! Schema::hasColumn('airlines', 'status')) {
                $table->tinyInteger('status')->default(1)->after('remarks');
            }
            if (! Schema::hasColumn('airlines', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('status');
            }
            if (! Schema::hasColumn('airlines', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
            if (! Schema::hasColumn('airlines', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        $this->backfillKnownAirlines();
    }

    public function down()
    {
        Schema::table('airlines', function (Blueprint $table) {
            $columns = ['iata_code', 'icao_code', 'numeric_code', 'country', 'remarks', 'status', 'created_by', 'updated_by', 'deleted_at'];
            $drop = array_filter($columns, fn ($column) => Schema::hasColumn('airlines', $column));
            if ($drop) {
                $table->dropColumn($drop);
            }
        });
    }

    protected function backfillKnownAirlines(): void
    {
        $known = [
            'PIA' => ['iata_code' => 'PK', 'icao_code' => 'PIA', 'numeric_code' => '214', 'country' => 'Pakistan'],
            'Air Blue' => ['iata_code' => 'PA', 'icao_code' => 'ABQ', 'numeric_code' => '615', 'country' => 'Pakistan'],
            'Sareen Air' => ['iata_code' => 'ER', 'icao_code' => 'SEP', 'numeric_code' => '817', 'country' => 'Pakistan'],
        ];

        foreach ($known as $name => $codes) {
            DB::table('airlines')
                ->where('name', $name)
                ->whereNull('iata_code')
                ->update($codes + ['status' => 1]);
        }
    }
}
