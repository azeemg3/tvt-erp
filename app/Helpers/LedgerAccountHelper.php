<?php

namespace App\Helpers;

use App\Models\Accounts\SubHeadAccount;
use App\Models\Accounts\TransactionAccount;
use Illuminate\Support\Facades\Auth;

/**
 * Helper responsible for keeping a Client / Vendor in sync with its
 * corresponding ledger (transaction) account.
 *
 * Mapping to the existing transaction_accounts table:
 *   account_name   => Trans_Acc_Name
 *   account_code   => code
 *   group_id       => PID (sub head account id)
 *   reference_id   => reference_id
 *   reference_type => reference_type
 */
class LedgerAccountHelper
{
    /** Candidate sub head names + fallback id used for Client receivable accounts. */
    public const CLIENT_GROUP_NAMES = ['Customer / Receivable', 'Customer/Receivables', 'Customer / Receivables'];
    public const CLIENT_GROUP_FALLBACK_ID = 2;

    /** Candidate sub head names + fallback id used for Vendor / Supplier accounts. */
    public const VENDOR_GROUP_NAMES = ['Vendor / Supplier', 'Payable & Vendors', 'Vendor/Supplier'];
    public const VENDOR_GROUP_FALLBACK_ID = 9;

    public static function clientGroupId(): int
    {
        return self::resolveGroupId(self::CLIENT_GROUP_NAMES, ['Receivable', 'Customer'], self::CLIENT_GROUP_FALLBACK_ID);
    }

    public static function vendorGroupId(): int
    {
        return self::resolveGroupId(self::VENDOR_GROUP_NAMES, ['Vendor', 'Payable', 'Supplier'], self::VENDOR_GROUP_FALLBACK_ID);
    }

    /**
     * Create a transaction account under the given sub head group and link it
     * back to the owning record. Returns the new transaction account id.
     */
    public static function createForReference(int $groupId, string $accountName, int $referenceId, string $referenceType, ?float $openingBalance = null): int
    {
        $account = TransactionAccount::create([
            'Trans_Acc_Name' => $accountName,
            'PID'            => $groupId,
            'code'           => AccountCodeHelper::nextTransactionCode($groupId),
            'reference_id'   => $referenceId,
            'reference_type' => $referenceType,
            'status'         => 1,
            'editable'       => 0,
            'OB'             => $openingBalance !== null ? (string) $openingBalance : null,
            'Created_BY'     => Auth::id(),
        ]);

        return (int) $account->id;
    }

    /**
     * Keep the ledger account name aligned with the source record name.
     */
    public static function syncName(?int $accountId, string $accountName): void
    {
        if (! $accountId) {
            return;
        }

        TransactionAccount::where('id', $accountId)->update([
            'Trans_Acc_Name' => $accountName,
            'Updated_By'     => Auth::id(),
        ]);
    }

    /**
     * Mark the related ledger account as active / inactive.
     */
    public static function setStatus(?int $accountId, int $status): void
    {
        if (! $accountId) {
            return;
        }

        TransactionAccount::where('id', $accountId)->update(['status' => $status]);
    }

    protected static function resolveGroupId(array $exactNames, array $likeKeywords, int $fallbackId): int
    {
        $query = SubHeadAccount::query()->where(function ($q) use ($exactNames, $likeKeywords) {
            $q->whereIn('name', $exactNames);
            foreach ($likeKeywords as $keyword) {
                $q->orWhere('name', 'like', '%'.$keyword.'%');
            }
        });

        $subHead = $query->orderBy('id')->first();

        if ($subHead) {
            return (int) $subHead->id;
        }

        return $fallbackId;
    }
}
