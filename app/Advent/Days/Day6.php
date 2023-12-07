<?php

namespace App\Advent\Days;

class Day6
{
    public static string $input;

    public static array $seeds;

    public static array $maps;

    public static function resolvePart1($input)
    {
        $races = array_combine(
            ...str($input)
                ->trim()
                ->explode("\n")
                ->filter()
                ->map(function ($val) {
                    [, $data] = explode(':', $val);

                    return array_map('intval', array_filter(explode(' ', $data)));
                })
                ->toArray()
        );

        $ways = [];
        foreach ($races as $time => $distance) {
            $count = 0;
            for ($charge = 1; $charge <= $time; $charge++) {
                $remaining = $time - $charge;
                if ($charge * $remaining > $distance) {
                    $count++;
                }
            }
            $ways[] = $count;
        }

        return array_product($ways);
    }

    public static function resolvePart2($input)
    {
        [$time, $distance] = str($input)
            ->trim()
            ->explode("\n")
            ->filter()
            ->map(function ($val) {
                [, $data] = explode(':', $val);

                return intval(str_replace(' ', '', trim($data)));
            });

        for ($i = 1; $i <= $time; $i++) {
            $remaining = $time - $i;
            if ($i * $remaining > $distance) {
                break;
            }
        }

        return $time - ($i * 2) + 1;
    }
}
