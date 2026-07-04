<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddLogoToCompaniesTable extends Migration
{
    /**
     * Default logo asset path used to seed the company profile.
     */
    const DEFAULT_LOGO = 'public/dist/img/company-logo.png';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'logo')) {
                $table->string('logo')->nullable()->after('name');
            }
        });

        $company = DB::table('companies')->orderBy('id')->first();

        if (!$company) {
            DB::table('companies')->insert([
                'name' => config('app.name', 'Company'),
                'logo' => self::DEFAULT_LOGO,
                'address' => 'UG-9, Big City Plaza, Liberty Round About, Gulberg III, Lahore, PK',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return;
        }

        if (empty($company->logo)) {
            DB::table('companies')->where('id', $company->id)->update([
                'logo' => self::DEFAULT_LOGO,
                'updated_at' => now(),
            ]);
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
            if (Schema::hasColumn('companies', 'logo')) {
                $table->dropColumn('logo');
            }
        });
    }
}
