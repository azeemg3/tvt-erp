<?php

namespace App\Http\Controllers\Accounts;

use App\Helpers\Account;
use App\Helpers\LedgerAccountHelper;
use App\Http\Controllers\Controller;
use App\Models\Accounts\TransactionAccount;

class AccountDashboardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:accounts_dashboard_view', ['only' => ['index']]);
    }

    /**
     * Accounts dashboard: live receivable, payable and bank balances from the COA.
     */
    public function index()
    {
        $asOn = date('Y-m-d');

        $receivableAccounts = $this->ledgersByGroup(LedgerAccountHelper::receivableGroupIds());
        $payableAccounts    = $this->ledgersByGroup([LedgerAccountHelper::vendorGroupId()]);
        $bankAccounts       = $this->ledgersByGroup([LedgerAccountHelper::cashBankGroupId()]);

        $allIds = $receivableAccounts->pluck('id')
            ->merge($payableAccounts->pluck('id'))
            ->merge($bankAccounts->pluck('id'))
            ->unique()
            ->values()
            ->all();

        $balances = Account::closingBalances($allIds, $asOn);

        $receivableTotal = $this->sumSide($receivableAccounts, $balances, 'dr');
        $payableTotal    = $this->sumSide($payableAccounts, $balances, 'cr');
        $bankTotal       = $this->sumNet($bankAccounts, $balances);

        $receivableChart = $this->chartPoints($receivableAccounts, $balances, 'dr', 20);
        $payableChart    = $this->chartPoints($payableAccounts, $balances, 'cr', 15);
        $bankChart       = $this->chartPoints($bankAccounts, $balances, 'net', 20);

        return view('Accounts.index', [
            'asOn'             => $asOn,
            'receivableBox'    => Account::box_bal($receivableTotal),
            'payableBox'       => Account::box_bal(-1 * $payableTotal),
            'bankBox'          => Account::box_bal($bankTotal),
            'receivableChart'  => $receivableChart,
            'payableChart'     => $payableChart,
            'bankChart'        => $bankChart,
            'clientsUrl'       => route('clients.index'),
            'vendorsUrl'       => route('vendors.index'),
            'cashBankUrl'      => route('cash_bank_statement.index'),
        ]);
    }

    /**
     * @param  int[]  $groupIds
     */
    protected function ledgersByGroup(array $groupIds)
    {
        $groupIds = array_values(array_filter(array_map('intval', $groupIds)));

        if (! $groupIds) {
            return collect();
        }

        return TransactionAccount::query()
            ->whereIn('PID', $groupIds)
            ->orderBy('Trans_Acc_Name')
            ->get(['id', 'Trans_Acc_Name', 'PID']);
    }

    /**
     * @param  \Illuminate\Support\Collection  $accounts
     * @param  array<int,float>  $balances
     */
    protected function sumSide($accounts, array $balances, string $side): float
    {
        $total = 0.0;

        foreach ($accounts as $account) {
            $bal = (float) ($balances[$account->id] ?? 0);
            if ($side === 'dr' && $bal > 0.005) {
                $total += $bal;
            }
            if ($side === 'cr' && $bal < -0.005) {
                $total += abs($bal);
            }
        }

        return $total;
    }

    /**
     * @param  \Illuminate\Support\Collection  $accounts
     * @param  array<int,float>  $balances
     */
    protected function sumNet($accounts, array $balances): float
    {
        $total = 0.0;

        foreach ($accounts as $account) {
            $total += (float) ($balances[$account->id] ?? 0);
        }

        return $total;
    }

    /**
     * @param  \Illuminate\Support\Collection  $accounts
     * @param  array<int,float>  $balances
     * @return array<int, array{name:string,y:float}>
     */
    protected function chartPoints($accounts, array $balances, string $side, int $limit): array
    {
        $points = [];

        foreach ($accounts as $account) {
            $bal = (float) ($balances[$account->id] ?? 0);

            if ($side === 'dr' && $bal <= 0.005) {
                continue;
            }
            if ($side === 'cr' && $bal >= -0.005) {
                continue;
            }
            if ($side === 'net' && abs($bal) < 0.005) {
                continue;
            }

            $points[] = [
                'name' => $account->Trans_Acc_Name,
                'y'    => round($side === 'dr' ? $bal : abs($bal), 2),
            ];
        }

        usort($points, function ($a, $b) {
            return $b['y'] <=> $a['y'];
        });

        return array_slice($points, 0, $limit);
    }
}
