<?php

namespace App\Helpers;

use App\Models\Accounts\HeadAccount;
use App\Models\Accounts\RootAccount;
use App\Models\Accounts\SubHeadAccount;
use App\Models\Accounts\TransactionAccount;

class AccountCodeHelper
{
    public const ROOT_SUFFIX_LEN = 2;

    public const HEAD_SUFFIX_LEN = 2;

    public const SUBHEAD_SUFFIX_LEN = 2;

    public static function pad(int $number, int $length): string
    {
        return str_pad((string) $number, $length, '0', STR_PAD_LEFT);
    }

    public static function nextRootCode(): string
    {
        return self::nextPaddedSiblingCode(
            '',
            RootAccount::query()->whereNotNull('code'),
            self::ROOT_SUFFIX_LEN
        );
    }

    public static function nextHeadCode(int $rootId): string
    {
        $parent = RootAccount::findOrFail($rootId);
        $parentCode = self::ensureRootCode($parent);

        return self::nextPaddedSiblingCode(
            $parentCode,
            HeadAccount::where('RID', $rootId)->whereNotNull('code'),
            self::HEAD_SUFFIX_LEN
        );
    }

    public static function nextSubHeadCode(int $headId): string
    {
        $parent = HeadAccount::findOrFail($headId);
        $parentCode = self::ensureHeadCode($parent);

        return self::nextPaddedSiblingCode(
            $parentCode,
            SubHeadAccount::where('HID', $headId)->whereNotNull('code'),
            self::SUBHEAD_SUFFIX_LEN
        );
    }

    /**
     * Transaction codes append a numeric suffix to the subhead code (e.g. 010101 + 1 => 0101011).
     */
    public static function nextTransactionCode(int $subHeadId): string
    {
        $parent = SubHeadAccount::findOrFail($subHeadId);
        $parentCode = self::ensureSubHeadCode($parent);

        $maxSuffix = 0;
        $prefixLen = strlen($parentCode);

        foreach (TransactionAccount::where('PID', $subHeadId)->whereNotNull('code')->pluck('code') as $code) {
            $code = (string) $code;
            if (! self::isHierarchicalChildCode($code, $parentCode)) {
                continue;
            }
            $suffix = substr($code, $prefixLen);
            if ($suffix !== '' && ctype_digit($suffix)) {
                $maxSuffix = max($maxSuffix, (int) $suffix);
            }
        }

        return $parentCode . (string) ($maxSuffix + 1);
    }

    public static function ensureRootCode(RootAccount $root): string
    {
        if (! empty($root->code)) {
            return (string) $root->code;
        }

        $code = self::pad((int) $root->id, self::ROOT_SUFFIX_LEN);
        $root->update(['code' => $code]);

        return $code;
    }

    public static function ensureHeadCode(HeadAccount $head): string
    {
        if (! empty($head->code)) {
            return (string) $head->code;
        }

        $code = self::nextHeadCode((int) $head->RID);
        $head->update(['code' => $code]);

        return $code;
    }

    public static function ensureSubHeadCode(SubHeadAccount $subHead): string
    {
        if (! empty($subHead->code)) {
            return (string) $subHead->code;
        }

        $code = self::nextSubHeadCode((int) $subHead->HID);
        $subHead->update(['code' => $code]);

        return $code;
    }

    protected static function nextPaddedSiblingCode(string $parentCode, $query, int $suffixLen): string
    {
        $expectedLen = strlen($parentCode) + $suffixLen;
        $maxSuffix = 0;

        foreach ($query->pluck('code') as $code) {
            $code = (string) $code;
            if ($parentCode === '') {
                if (preg_match('/^\d{' . $suffixLen . '}$/', $code)) {
                    $maxSuffix = max($maxSuffix, (int) $code);
                }
                continue;
            }

            if (strlen($code) === $expectedLen && str_starts_with($code, $parentCode)) {
                $suffix = substr($code, -$suffixLen);
                if (ctype_digit($suffix)) {
                    $maxSuffix = max($maxSuffix, (int) $suffix);
                }
            }
        }

        return $parentCode . self::pad($maxSuffix + 1, $suffixLen);
    }

    protected static function isHierarchicalChildCode(string $code, string $parentCode): bool
    {
        if ($parentCode === '' || ! str_starts_with($code, $parentCode)) {
            return false;
        }

        $suffix = substr($code, strlen($parentCode));

        return $suffix !== '' && ctype_digit($suffix);
    }
}
