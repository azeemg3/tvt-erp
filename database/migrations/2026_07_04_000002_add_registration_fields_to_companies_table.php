<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddRegistrationFieldsToCompaniesTable extends Migration
{
    /**
     * Default company contact / registration details used to seed the profile.
     */
    const DEFAULTS = [
        'phone' => '4298765432',
        'email' => 'sales@uotrips.co',
        'govt_lic_no' => '321',
        'iata_no' => '133',
        'ntn' => '85212',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'govt_lic_no')) {
                $table->string('govt_lic_no', 100)->nullable()->after('website');
            }
            if (!Schema::hasColumn('companies', 'iata_no')) {
                $table->string('iata_no', 100)->nullable()->after('govt_lic_no');
            }
            if (!Schema::hasColumn('companies', 'ntn')) {
                $table->string('ntn', 100)->nullable()->after('iata_no');
            }
        });

        // Seed the default contact / registration details onto the single company row,
        // only filling fields that are still empty so we never clobber saved values.
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
            foreach (['govt_lic_no', 'iata_no', 'ntn'] as $column) {
                if (Schema::hasColumn('companies', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
