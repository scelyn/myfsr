<?php

namespace App\Helpers;

class NumberHelper
{
    /**
     * Format a number for Indonesian financial display.
     *
     * Rules:
     * - Integers show no decimals: 150.000
     * - Decimals show only significant digits: 1,5 / 2,75
     * - Thousand separator: dot (.)
     * - Decimal separator: comma (,)
     * - Never show trailing .00
     *
     * @param  float|int|string  $value
     * @return string
     */
    public static function format($value): string
    {
        $value = floatval($value);

        // Check if value is a whole number
        if (floor($value) == $value) {
            return number_format($value, 0, ',', '.');
        }

        // Format with 2 decimals, then trim trailing zeros
        $formatted = number_format($value, 2, ',', '.');

        // Remove trailing zeros after comma: "1,50" → "1,5", "1,00" → "1"
        $formatted = rtrim($formatted, '0');
        $formatted = rtrim($formatted, ',');

        return $formatted;
    }

    /**
     * Format as Rupiah with "Rp " prefix.
     *
     * @param  float|int|string  $value
     * @return string
     */
    public static function rupiah($value): string
    {
        return 'Rp ' . self::format($value);
    }
}
