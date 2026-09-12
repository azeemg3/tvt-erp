<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ConvertAirlineCountryNamesToIds extends Migration
{
    /**
     * Store country as countries.id so the airline form can use the existing dropdown.
     */
    public function up()
    {
        $airlines = DB::table('airlines')
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->get(['id', 'country']);

        foreach ($airlines as $airline) {
            if (is_numeric($airline->country)) {
                continue;
            }

            $country = DB::table('countries')
                ->whereRaw('LOWER(name) = ?', [strtolower(trim($airline->country))])
                ->first();

            DB::table('airlines')->where('id', $airline->id)->update([
                'country' => $country ? $country->id : null,
            ]);
        }
    }

    public function down()
    {
        $airlines = DB::table('airlines')
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->get(['id', 'country']);

        foreach ($airlines as $airline) {
            if (! is_numeric($airline->country)) {
                continue;
            }

            $country = DB::table('countries')->where('id', $airline->country)->first();
            DB::table('airlines')->where('id', $airline->id)->update([
                'country' => $country ? $country->name : null,
            ]);
        }
    }
}
