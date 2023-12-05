<?php

namespace App\Advent\Days;

class Day1
{
    public static function resolvePart1($input): int
    {
        return str($input)
            ->explode("\n")
            ->map(fn ($value) => static::combineFirstAndLastDigit($value))
            ->sum();
    }

    public static function resolvePart2($input): int
    {
        return str($input)
            ->explode("\n")
            ->map(fn ($value) => static::combineFirstAndLastDigitSpelled($value))
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

    public static function combineFirstAndLastDigitSpelled($value): int
    {
        $search = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $first_pos = $first = $last = $last_pos = null;
        foreach ($search as $digit) {
            $pos = strpos($value, $digit);
            if ($pos !== false && (is_null($first_pos) || $pos < $first_pos)) {
                $first_pos = $pos;
                $first = self::convertToInt($digit);
            }

            $pos = strrpos($value, $digit);
            if ($pos !== false && (is_null($last_pos) || $pos > $last_pos)) {
                $last_pos = $pos;
                $last = self::convertToInt($digit);
            }
        }

        return intval($first.$last);
    }

    public static function combineFirstAndLastDigitWithRegex($value): int
    {
        $re = '/([1-9]|one|two|three|four|five|six|seven|eight|nine)/';

        preg_match_all($re, $value, $matches, PREG_SET_ORDER, 0);

        $matches = collect($matches)
            ->map(fn ($val) => $val[0])
            ->map(fn ($val) => self::convertToInt($val))
            ->filter();

        return intval($matches->first().$matches->last());
    }

    public static function convertToInt($v): int
    {
        return is_numeric($v)
            ? intval($v)
            : match ($v) {
                'one' => 1,
                'two' => 2,
                'three' => 3,
                'four' => 4,
                'five' => 5,
                'six' => 6,
                'seven' => 7,
                'eight' => 8,
                'nine' => 9,
                //"zero" => 0
            };
    }
}
