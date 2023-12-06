<?php

namespace App\Advent\Days;

use Spatie\Async\Pool;
use Throwable;

class Day5
{
    public static string $input;

    public static array $seeds;

    public static array $maps;

    public static function resolvePart1($input)
    {
        static::$input = $input;
        static::extractSeedsAndMaps();

        return collect(static::$seeds)
            ->map(fn ($seed) => static::seedToLocation($seed))
            ->min();
    }

    public static function resolvePart2($input)
    {
        static::$input = $input;
        static::extractSeedsAndMaps();

        $ranges = self::seedsToRangesOfSeeds(static::$seeds);

        $min = null;
        foreach ($ranges as $range) {
            foreach (static::rangeGenerator($range['start'], $range['end']) as $seed) {
                $loc = static::seedToLocation($seed);

                if (is_null($min) || $loc < $min) {
                    $min = $loc;
                }
            }
        }

        return $min;
    }

    public static function resolvePart2Async($input)
    {
        static::$input = $input;
        static::extractSeedsAndMaps();

        $ranges = static::seedsToRangesOfSeeds(static::$seeds);

        $result = null;

        $pool = Pool::create()
            ->timeout(60 * 60 * 60 * 2)
            ->saveMemory();
        // ->sleepTime(50000 / 2)
        // ->concurrency(32);

        // 2427978056 Too high

        $maps = static::$maps;
        foreach ($ranges as $k => $range) {

            $pool
                ->add(function () use ($maps, $range) {
                    $result = null;
                    foreach (static::rangeGenerator($range['start'], $range['end']) as $seed) {
                        $output = static::seedToLocation($seed, maps: $maps);

                        if (is_null($result) || $output < $result) {
                            $result = $output;
                            // echo "[$k] ".$result."\n";
                        }
                    }

                    return $result;
                })
                ->then(function ($output) use (&$result) {
                    echo $output."\n";
                    if (is_null($result) || $output < $result) {
                        $result = $output;
                        echo 'Min: '.$result."\n";
                    }
                    gc_collect_cycles();
                })
                ->catch(function (Throwable $exception) {
                    echo $exception->getMessage();
                })
                ->timeout(function () {
                    echo "Timeout\n";
                });
        }
        $pool->wait();

        return $result;
    }

    public static function extractSeedsAndMaps(): void
    {
        static::$maps = str(static::$input)
            ->trim()
            ->explode("\n\n")
            ->filter()
            ->mapWithKeys(function ($infos) {
                [$key, $maps] = array_map('trim', explode(':', $infos));
                $key = str_replace(['-', ' map'], ['_', ''], $key);

                if ($key == 'seeds') {
                    return [$key => explode(' ', $maps)];
                }

                $maps = explode("\n", $maps);
                foreach ($maps as $range) {
                    $range = array_map('intval', explode(' ', $range));

                    $ranges[$range[1]] = [
                        'start' => $range[1],
                        'end' => $range[1] + $range[2] - 1,
                        'diff' => $range[0] - $range[1],
                    ];
                }

                // Sorted array are more pleasant to eyes :)
                ksort($ranges);
                $ranges = array_values($ranges);

                return [$key => $ranges];
            })
            ->toArray();

        static::$seeds = array_shift(static::$maps);
    }

    public static function convertWithMap(array $map, int $source): int
    {
        foreach ($map as $range) {
            if ($range['start'] <= $source && $source <= $range['end']) {
                return $source + $range['diff'];
            }
        }

        return $source;
    }

    public static function seedToLocation($seed, $maps = null)
    {
        if (is_null($maps)) {
            $maps = static::$maps;
        }

        $location = $seed;
        foreach ($maps as $map) {
            $location = static::convertWithMap($map, $location);
        }

        return $location;
    }

    public static function rangeGenerator($start, $end)
    {
        for ($i = $start; $i <= $end; $i++) {
            yield $i;
        }
    }

    public static function seedsToRangesOfSeeds($seeds): array
    {
        return collect($seeds)
            ->chunk(2)
            ->map(function ($infos) {
                $infos = $infos->values()->toArray();

                return [
                    'start' => $infos[0],
                    'end' => $infos[0] + $infos[1],
                ];
            })
            ->toArray();
    }
}
