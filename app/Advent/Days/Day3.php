<?php

namespace App\Advent\Days;

use Illuminate\Support\Collection;

class Day3
{
    public static Collection $part_numbers;

    public static string $input;

    public static array $twodmap;

    public static array $symbols = [];

    public static int $rows;

    public static int $cols;

    public static function resolvePart1($input)
    {
        static::$input = $input;
        static::make2DMap();
        static::extractInfosFrom2DMap();

        return static::$part_numbers
            ->filter(function ($infos) use (&$symbols) {
                $y_range = range(
                    start: $infos['start']['y'] - 1,
                    end: $infos['end']['y'] + 1
                );
                $x_range = range(
                    start: $infos['start']['x'] - 1,
                    end: $infos['end']['x'] + 1
                );

                $return = false;
                foreach ($y_range as $y) {
                    foreach ($x_range as $x) {
                        if (isset(static::$symbols[$y][$x])) {
                            $return = true;
                            static::$symbols[$y][$x][] = $infos['number'];
                        }
                    }
                }

                return $return;
            })
            ->sum('number');
    }

    public static function resolvePart2($input)
    {
        static::resolvePart1($input);

        return collect(static::$symbols)
            ->flatten(1)
            ->filter(fn ($parts) => count($parts) == 2)
            ->map(fn ($parts) => array_product($parts))
            ->sum();
    }

    public static function make2DMap()
    {
        static::$twodmap = str(static::$input)
            ->trim()
            ->explode("\n")
            ->filter()
            ->map(fn ($l) => str_split($l))
            ->toArray();

        static::$rows = count(static::$twodmap);
        static::$cols = count(static::$twodmap[0]);

    }

    public static function extractInfosFrom2DMap()
    {

        static::$part_numbers = collect();

        $part = '';
        $part_start_at = 0;
        for ($y = 0; $y < static::$rows; $y++) {
            for ($x = 0; $x < static::$cols; $x++) {
                $chr = static::$twodmap[$y][$x];

                if (is_numeric($chr)) {
                    // Part number composition
                    if (empty($part)) {
                        $part_start_at = $x;
                    }
                    $part .= $chr;
                } else {
                    // Save part number if next character is not numeric
                    if (! empty($part)) {
                        static::$part_numbers->push([
                            'number' => $part,
                            'start' => ['y' => $y, 'x' => $part_start_at],
                            'end' => ['y' => $y, 'x' => $x - 1],
                        ]);
                        $part = '';
                    }

                    // Saving symbols in a 2D map
                    if ($chr != '.') {
                        static::$symbols[$y][$x] = [];
                    }
                }
            }

            // Save part number if we change line
            if (! empty($part)) {
                static::$part_numbers->push([
                    'number' => intval($part),
                    'start' => ['y' => $y, 'x' => $part_start_at],
                    'end' => ['y' => $y, 'x' => $x - 1],
                ]);
                $part = '';
            }
        }
    }
}
