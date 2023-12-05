<?php

namespace App\Advent\Days;

use Illuminate\Support\Collection;

class Day2
{
    public static $maxs = [
        'red' => 12,
        'green' => 13,
        'blue' => 14,
    ];

    public static function resolvePart1($input)
    {
        $games = static::extractMaxForEachColorsPerGame($input);

        return $games
            ->filter(function ($cubes) {
                foreach (static::$maxs as $color => $max) {
                    if ($cubes->get($color) > $max) {
                        return false;
                    }
                }

                return true;
            })
            ->keys()
            ->sum();
    }

    public static function resolvePart2($input)
    {
        $games = static::extractMaxForEachColorsPerGame($input);

        return $games
            ->map(fn ($el) => array_product($el->toArray()))
            ->sum();
    }

    public static function extractMaxForEachColorsPerGame($input): Collection
    {
        $games = array_filter(explode("\n", $input));

        $new_games = collect();
        foreach ($games as $game) {
            $split = explode(':', $game);
            [, $game_id] = explode(' ', $split[0]);

            $sets = str($split[1])
                ->explode(';')
                ->mapWithKeys(function ($set, $key) {
                    return [
                        $key => str($set)
                            ->explode(',')
                            ->map(fn ($v) => trim($v))
                            ->mapWithKeys(function ($item) {
                                [$number, $color] = explode(' ', $item);

                                return [$color => intval($number)];
                            }),
                    ];
                });

            $new_games->put(
                $game_id,
                collect([
                    'red' => $sets->max('red'),
                    'green' => $sets->max('green'),
                    'blue' => $sets->max('blue'),
                ])
            );
        }

        return $new_games;
    }
}
