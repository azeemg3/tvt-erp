<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddHierarchicalAccountCodes extends Migration
{
    public function up()
    {
        Schema::table('root_accounts', function (Blueprint $table) {
            $table->string('code', 20)->nullable()->unique()->after('name');
        });

        Schema::table('head_accounts', function (Blueprint $table) {
            $table->string('code', 20)->nullable()->unique()->after('name');
        });

        Schema::table('sub_head_accounts', function (Blueprint $table) {
            $table->string('code', 20)->nullable()->unique()->after('name');
        });

        DB::statement('ALTER TABLE transaction_accounts MODIFY code VARCHAR(20) NOT NULL');

        $this->backfillCodes();
    }

    public function down()
    {
        Schema::table('root_accounts', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        Schema::table('head_accounts', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        Schema::table('sub_head_accounts', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        DB::statement('ALTER TABLE transaction_accounts MODIFY code BIGINT UNSIGNED NOT NULL');
    }

    protected function backfillCodes(): void
    {
        $rootIndex = 1;
        foreach (DB::table('root_accounts')->orderBy('id')->get() as $root) {
            $rootCode = str_pad((string) $rootIndex, 2, '0', STR_PAD_LEFT);
            DB::table('root_accounts')->where('id', $root->id)->update(['code' => $rootCode]);
            $rootIndex++;
        }

        $roots = DB::table('root_accounts')->orderBy('id')->get();
        foreach ($roots as $root) {
            $headIndex = 1;
            foreach (DB::table('head_accounts')->where('RID', $root->id)->orderBy('id')->get() as $head) {
                $headCode = $root->code . str_pad((string) $headIndex, 2, '0', STR_PAD_LEFT);
                DB::table('head_accounts')->where('id', $head->id)->update(['code' => $headCode]);
                $headIndex++;
            }
        }

        $heads = DB::table('head_accounts')->orderBy('id')->get();
        foreach ($heads as $head) {
            $subIndex = 1;
            foreach (DB::table('sub_head_accounts')->where('HID', $head->id)->orderBy('id')->get() as $sub) {
                $subCode = $head->code . str_pad((string) $subIndex, 2, '0', STR_PAD_LEFT);
                DB::table('sub_head_accounts')->where('id', $sub->id)->update(['code' => $subCode]);
                $subIndex++;
            }
        }

        foreach (DB::table('sub_head_accounts')->orderBy('id')->get() as $sub) {
            $transIndex = 1;
            foreach (DB::table('transaction_accounts')->where('PID', $sub->id)->orderBy('id')->get() as $trans) {
                $existing = (string) $trans->code;
                if ($existing !== '' && (str_starts_with($existing, 'SP-') || str_starts_with($existing, 'AG-'))) {
                    continue;
                }
                DB::table('transaction_accounts')->where('id', $trans->id)->update([
                    'code' => $sub->code . (string) $transIndex,
                ]);
                $transIndex++;
            }
        }
    }
}
