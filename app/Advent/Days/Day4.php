<?php

namespace App\Advent\Days;

use Illuminate\Support\Collection;

class Day4
{
    public static Collection $cards_games;

    public static string $input;

    public static function resolvePart1($input)
    {
        static::$input = $input;
        static::parseCardGames();

        return static::$cards_games
            ->map(function ($game) {
                $points = 0;
                foreach ($game['numbers'] as $number) {
                    if (in_array($number, $game['winning'])) {
                        $points = $points === 0 ? 1 : $points << 1;
                    }
                }
                $game['points'] = $points;

                return $game;
            })
            ->sum('points');
    }

    public static function resolvePart2($input)
    {
        static::parseCardGames();
        $cards_games = static::$cards_games->toArray();
        foreach ($cards_games as $game_id => &$game) {
            // Winning numbers
            $points = 0;
            foreach ($game['numbers'] as $number) {
                if (in_array($number, $game['winning'])) {
                    $points++;
                }
            }

            for ($pt = 1; $pt <= $points; $pt++) {
                $next_id = intval($game_id) + $pt;

                // Security
                if (! isset($cards_games[$next_id])) {
                    break;
                }

                // Duplicate winning cards
                $cards_games[$next_id]['copies'] += $game['copies'];
            }
        }

        return collect($cards_games)
            ->sum('copies');
    }

    public static function parseCardGames()
    {
        static::$cards_games = str(static::$input)
            ->trim()
            ->explode("\n")
            ->filter()
            ->mapWithKeys(function ($game) {
                $split = explode(':', $game);
                [$winning, $numbers] = explode('|', $split[1]);

                $game_id = intval(trim(str_replace('Card', '', $split[0])));

                $winning = static::parseCards($winning);
                $numbers = static::parseCards($numbers);
                $copies = 1;

                return [$game_id => compact('game_id', 'winning', 'numbers', 'copies')];
            });
    }

    public static function parseCards($cards)
    {
        return array_map(
            'intval',
            array_values(array_filter(explode(' ', $cards)))
        );
    }
}
