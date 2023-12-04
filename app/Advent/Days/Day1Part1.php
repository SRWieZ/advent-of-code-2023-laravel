<?php

namespace App\Advent\Days;

class Day1Part1
{
    public static function resolve($input)
    {
        return str($input)
            ->explode("\n")
            ->map(fn ($value) => self::combineFirstAndLastDigit($value))
            ->sum();
    }

    public static function combineFirstAndLastDigit($value): int
    {
        $first_digit = null;
        $last_digit = null;
        foreach (str_split($value) as $character) {
            if (! is_numeric($character)) {
                continue;
            }

            if (is_null($first_digit)) {
                $first_digit = $character;
            }

            $last_digit = $character;
        }

        return intval($first_digit.$last_digit);
    }
}
