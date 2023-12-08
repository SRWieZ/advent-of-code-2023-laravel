<?php

namespace App\Advent\Days;

class Day8
{
    public static array $lr;

    public static array $network;

    public static array $ghosts;

    public static function parseInput($input)
    {
        [$lr, $network] = str($input)
            ->trim()
            ->explode("\n\n")
            ->filter()
            ->map(fn ($v) => trim($v))
            ->toArray();

        static::$lr = str_split($lr);

        static::$network = str($network)
            ->explode("\n")
            ->mapWithKeys(function ($value) {
                [$key, $lr] = explode('=', str_replace([' ', '(', ')'], '', $value));
                [$L, $R] = explode(',', $lr);

                return [$key => compact('L', 'R')];
            })
            ->toArray();

        static::$ghosts = collect(array_keys(static::$network))
            ->filter(fn ($v) => str($v)->endsWith('A'))
            ->values()
            ->toArray();
    }

    public static function resolvePart1($input): int
    {
        static::parseInput($input);

        $steps = 0;
        $pos = 'AAA';
        $max_lr = count(static::$lr);
        do {
            $pos = static::$network[$pos][static::$lr[$steps % $max_lr]];

            $steps++;
        } while ($pos !== 'ZZZ');

        return $steps;
    }

    public static function resolvePart2($input): int
    {
        static::parseInput($input);

        $steps = 0;
        $all_z = false;
        $max_lr = count(static::$lr);

        $ghosts = static::$ghosts;
        do {
            foreach ($ghosts as $k => $pos) {
                $ghosts[$k] = static::$network[$pos][static::$lr[$steps % $max_lr]];
            }

            $steps++;

            $all_z =
                count($ghosts) ==
                count(array_filter($ghosts, fn ($v) => str_ends_with($v, 'Z')));

            // foreach ($ghosts as $pos) {
            //     if ( ! str_ends_with($pos, "Z")) {
            //         continue 2;
            //     }
            // }
            // $all_z = true;

        } while ($all_z == false);

        return $steps;
    }

    // Thanks Internet
    public static function resolvePart2Optimized($input): int
    {
        static::parseInput($input);

        $cnt_starts = count(static::$ghosts);
        $max_lr = count(static::$lr);
        $steps = 0;

        $length_to_z = [];
        do {
            foreach (static::$ghosts as $k => $pos) {
                static::$ghosts[$k] = static::$network[$pos][static::$lr[$steps % $max_lr]];

                if (str_ends_with(static::$ghosts[$k], 'Z')) {
                    $length_to_z[$k] = $steps + 1;
                }
            }

            $steps++;

            if (count($length_to_z) == $cnt_starts) {
                break;
            }

        } while (true);

        return static::lcm_arr($length_to_z);
    }

    public static function lcm_arr($items): int
    {
        while (count($items) >= 2) {
            $items[] = gmp_lcm(array_shift($items), array_shift($items));
        }

        return intval(reset($items));
    }
}
