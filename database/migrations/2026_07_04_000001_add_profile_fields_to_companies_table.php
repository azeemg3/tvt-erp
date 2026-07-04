<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToCompaniesTable extends Migration
{
    /**
     * Default company address used to seed the initial configuration.
     */
    const DEFAULT_ADDRESS = 'UG-9, Big City Plaza, Liberty Round About, Gulberg III, Lahore, PK';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('companies', 'contact_name')) {
                $table->string('contact_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('companies', 'contact_mobile')) {
                $table->string('contact_mobile', 50)->nullable()->after('contact_name');
            }
            if (!Schema::hasColumn('companies', 'phone')) {
                $table->string('phone', 50)->nullable()->after('contact_mobile');
            }
            if (!Schema::hasColumn('companies', 'email')) {
                $table->string('email')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('companies', 'website')) {
                $table->string('website')->nullable()->after('email');
            }
            if (!Schema::hasColumn('companies', 'address')) {
                $table->text('address')->nullable()->after('website');
            }
        });

        // Seed a single default company profile so the address is available immediately.
        $existing = DB::table('companies')->orderBy('id')->first();

        if (!$existing) {
            DB::table('companies')->insert([
                'name' => config('app.name', 'Company'),
                'address' => self::DEFAULT_ADDRESS,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif (empty($existing->address)) {
            DB::table('companies')->where('id', $existing->id)->update([
                'name' => $existing->name ?: config('app.name', 'Company'),
                'address' => self::DEFAULT_ADDRESS,
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
            foreach (['name', 'contact_name', 'contact_mobile', 'phone', 'email', 'website', 'address'] as $column) {
                if (Schema::hasColumn('companies', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
