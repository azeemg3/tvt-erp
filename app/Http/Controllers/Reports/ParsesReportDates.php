<?php

namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use InvalidArgumentException;

trait ParsesReportDates
{
    /**
     * Normalize report filter dates from DD-MM-YYYY (UI) or YYYY-MM-DD to Y-m-d.
     */
    protected function parseReportDateRange(Request $request): array
    {
        $df = $this->parseReportDate($request->input('df'), 'From Date');
        $dt = $this->parseReportDate($request->input('dt'), 'To Date');

        if ($dt < $df) {
            throw new InvalidArgumentException('To Date must be on or after From Date.');
        }

        return [$df, $dt];
    }

    /**
     * Replace df/dt on the request with normalized Y-m-d values when both are present.
     */
    protected function mergeParsedReportDates(Request $request): void
    {
        if (!$request->filled('df') || !$request->filled('dt')) {
            return;
        }

        [$df, $dt] = $this->parseReportDateRange($request);
        $request->merge(['df' => $df, 'dt' => $dt]);
    }

    protected function parseReportDate(?string $value, string $label): string
    {
        $value = trim((string) $value);
        if ($value === '') {
            throw new InvalidArgumentException($label . ' is required.');
        }

        foreach (['Y-m-d', 'd-m-Y', 'd/m/Y', 'm/d/Y'] as $format) {
            try {
                $parsed = Carbon::createFromFormat($format, $value);
                if ($parsed !== false) {
                    return $parsed->format('Y-m-d');
                }
            } catch (\Throwable $e) {
                continue;
            }
        }

        $timestamp = strtotime($value);
        if ($timestamp !== false) {
            return date('Y-m-d', $timestamp);
        }

        throw new InvalidArgumentException('Invalid ' . $label . ' format.');
    }
}
