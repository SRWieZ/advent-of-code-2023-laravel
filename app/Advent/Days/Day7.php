<?php

namespace App\Advent\Days;

use Illuminate\Support\Collection;

class Day7
{
    public static array $cards =
        ['2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];

    public static array $types = [
        'high',
        'onepair',
        'twopairs',
        'threeofakind',
        'fullhouse',
        'fourofakind',
        'fiveofakind',
    ];

    public static array $maps;

    public static function parseInput($input)
    {
        return str($input)
            ->trim()
            ->explode("\n")
            ->filter();
    }

    public static function resolvePart1($input): int
    {
        $hands = static::parseInput($input);
        $hands = $hands->map(function ($value) {
            [$cards, $bid] = explode(' ', $value);

            $cards = str_split($cards);
            $counts = [];
            foreach ($cards as $card) {
                $counts[$card] = ($counts[$card] ?? 0) + 1;
            }

            $type = static::matchType($counts);

            return compact('cards', 'bid', 'type');
        });

        return static::sortAndSum($hands);
    }

    public static function resolvePart2($input): int
    {
        static::introduceJoker();

        $hands = static::parseInput($input);
        $hands = $hands->map(function ($value) {
            [$cards, $bid] = explode(' ', $value);

            $cards = str_split($cards);
            $counts = [];
            foreach ($cards as $card) {
                $counts[$card] = ($counts[$card] ?? 0) + 1;
            }
            arsort($counts);

            // Let introduce the joker !
            $jokers = array_keys($cards, 'J');
            if (count($jokers)) {
                // Put all the J force to the strongest card
                unset($counts['J']);
                $strg = array_key_first($counts);
                $counts[$strg] += count($jokers);
            }

            $type = static::matchType($counts);

            return compact('cards', 'bid', 'type');
        });

        return static::sortAndSum($hands);
    }

    public static function introduceJoker(): void
    {
        unset(static::$cards[array_search('J', static::$cards)]);
        array_unshift(static::$cards, 'J');
    }

    public static function matchType(array $counts): string
    {
        return match (true) {
            in_array(5, $counts) => 'fiveofakind',
            in_array(4, $counts) => 'fourofakind',
            in_array(3, $counts) && in_array(2, $counts) => 'fullhouse',
            in_array(3, $counts) => 'threeofakind',
            count(array_keys($counts, 2)) === 2 => 'twopairs',
            count(array_keys($counts, 2)) === 1 => 'onepair',
            default => 'high'
        };
    }

    public static function sortAndSum(Collection $hands): int
    {
        return $hands
            ->sort(function ($a, $b) {
                $sa = array_search($a['type'], static::$types);
                $sb = array_search($b['type'], static::$types);

                if ($sa === $sb) {
                    for ($i = 0; $i < 5; $i++) {
                        $sa = array_search($a['cards'][$i], static::$cards);
                        $sb = array_search($b['cards'][$i], static::$cards);
                        if ($sa === $sb) {
                            continue;
                        }

                        return $sa <=> $sb;
                    }

                    return $sa <=> $sb;
                }

                return $sa <=> $sb;
            })
            ->values()
            ->map(fn ($v, $k) => ($k + 1) * $v['bid']) // Multiply by its rank
            ->sum();
    }
}
