<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Normalises human friendly date inputs coming from the UI date pickers
 * (day-month-year, e.g. 04-07-2026) into the ISO format the rest of the
 * application and the database work with (Y-m-d, e.g. 2026-07-04).
 *
 * The date pickers across the app display and submit dates as DD-MM-YYYY, but
 * controllers persist values straight into MySQL date columns and build
 * whereBetween() filters that expect Y-m-d. Converting here keeps every
 * controller untouched and guarantees data integrity regardless of which
 * picker produced the value. Values that are already Y-m-d (or that are not
 * dates at all) are left exactly as they are.
 */
class NormalizeDateInputs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();

        $normalized = $this->normalize($input);

        if ($normalized !== $input) {
            $request->merge($normalized);
        }

        return $next($request);
    }

    /**
     * Recursively walk the input array converting any date-like strings.
     *
     * @param  array  $input
     * @return array
     */
    private function normalize(array $input): array
    {
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $input[$key] = $this->normalize($value);
            } elseif (is_string($value)) {
                $input[$key] = $this->convert($value);
            }
        }

        return $input;
    }

    /**
     * Convert a single string value if it looks like a DD-MM-YYYY date,
     * date-time or a "date / date" range. Anything else is returned untouched.
     *
     * @param  string  $value
     * @return string
     */
    private function convert(string $value): string
    {
        $trimmed = trim($value);

        // Range: "DD-MM-YYYY / DD-MM-YYYY" (separator may or may not have spaces).
        if (preg_match('#^(\d{2}-\d{2}-\d{4})(\s*/\s*)(\d{2}-\d{2}-\d{4})$#', $trimmed, $m)) {
            $from = $this->convertDate($m[1]);
            $to = $this->convertDate($m[3]);

            if ($from !== null && $to !== null) {
                return $from . $m[2] . $to;
            }

            return $value;
        }

        // Date-time: "DD-MM-YYYY HH:MM" or "DD-MM-YYYY HH:MM:SS" (T separator allowed).
        if (preg_match('/^(\d{2})-(\d{2})-(\d{4})[ T](\d{1,2}):(\d{2})(?::(\d{2}))?$/', $trimmed, $m)) {
            if (checkdate((int) $m[2], (int) $m[1], (int) $m[3])) {
                $time = sprintf('%02d:%02d', (int) $m[4], (int) $m[5]);
                if (isset($m[6])) {
                    $time .= ':' . sprintf('%02d', (int) $m[6]);
                }

                return sprintf('%04d-%02d-%02d %s', (int) $m[3], (int) $m[2], (int) $m[1], $time);
            }

            return $value;
        }

        // Plain date: "DD-MM-YYYY".
        $converted = $this->convertDate($trimmed);

        return $converted ?? $value;
    }

    /**
     * Convert a bare DD-MM-YYYY string into Y-m-d, or null if it is not a
     * valid day-month-year date.
     *
     * @param  string  $value
     * @return string|null
     */
    private function convertDate(string $value): ?string
    {
        if (!preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $value, $m)) {
            return null;
        }

        if (!checkdate((int) $m[2], (int) $m[1], (int) $m[3])) {
            return null;
        }

        return sprintf('%04d-%02d-%02d', (int) $m[3], (int) $m[2], (int) $m[1]);
    }
}
