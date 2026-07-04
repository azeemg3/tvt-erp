<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddFooterFieldsToCompaniesTable extends Migration
{
    /**
     * Default print-footer details used to seed the company profile.
     */
    const DEFAULTS = [
        'powered_by' => 'Al-Hussain Int',
        'contact_no' => '+92 021 35210452 - +92 333 2071887',
        'website' => 'www.uotrips.com',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'powered_by')) {
                $table->string('powered_by')->nullable()->after('ntn');
            }
            if (!Schema::hasColumn('companies', 'contact_no')) {
                $table->string('contact_no')->nullable()->after('powered_by');
            }
        });

        // Seed the default footer details onto the single company row, only filling
        // fields that are still empty so we never clobber saved values.
        $company = DB::table('companies')->orderBy('id')->first();

        if (!$company) {
            DB::table('companies')->insert(array_merge(self::DEFAULTS, [
                'name' => config('app.name', 'Company'),
                'address' => 'UG-9, Big City Plaza, Liberty Round About, Gulberg III, Lahore, PK',
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            return;
        }

        $updates = [];
        foreach (self::DEFAULTS as $column => $value) {
            if (empty($company->{$column})) {
                $updates[$column] = $value;
            }
        }

        if (!empty($updates)) {
            $updates['updated_at'] = now();
            DB::table('companies')->where('id', $company->id)->update($updates);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            foreach (['powered_by', 'contact_no'] as $column) {
                if (Schema::hasColumn('companies', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
