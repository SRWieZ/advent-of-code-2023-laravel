<?php

//
// namespace App\Advent\Days;
//
// class Day5Alt
// {
//
//     public function __construct()
//     {
//         $input = '
// seeds: 79 14 55 13
//
// seed-to-soil map:
// 50 98 2
// 52 50 48
//
// soil-to-fertilizer map:
// 0 15 37
// 37 52 2
// 39 0 15
//
// fertilizer-to-water map:
// 49 53 8
// 0 11 42
// 42 0 7
// 57 7 4
//
// water-to-light map:
// 88 18 7
// 18 25 70
//
// light-to-temperature map:
// 45 77 23
// 81 45 19
// 68 64 13
//
// temperature-to-humidity map:
// 0 69 1
// 1 0 69
//
// humidity-to-location map:
// 60 56 37
// 56 93 4';
//
//         // ini_set('memory_limit', '-1');
//         $input = file_get_contents(resource_path('advent_inputs/day_5.txt'));
//
//         $output = null;
//         $output_part2 = null;
//
//         $expect = 35;
//         $expect_part2 = 0;
//
//         $maps = str($input)
//             ->trim()
//             ->explode("\n\n")
//             ->filter()
//             // ->dump()
//             ->mapWithKeys(function ($infos, $key) {
//                 [$key, $maps] = array_map('trim', explode(':', $infos));
//                 $key = str_replace(['-', ' map'], ['_', ''], $key);
//
//                 if ($key == 'seeds') {
//                     return [$key => explode(' ', $maps)];
//                 }
//
//                 $maps = explode("\n", $maps);
//                 foreach ($maps as $k => $range) {
//                     $range = explode(' ', $range);
//                     $source_range = range($range[1], $range[1] + $range[2] - 1);
//                     $dest_range = range($range[0], $range[0] + $range[2] - 1);
//                     $map = array_combine($source_range, $dest_range);
//                     // if ($key == "fertilizer_to_water") {
//                     //   dump($map);
//                     // }
//                     // $ranges[$k] = $map;
//                 }
//                 dd($ranges);
//                 // $max = max(...array_merge(...$ranges));
//                 // $base = array_combine(range(0, $max), range(0, $max));
//                 // $correspondance = array_replace($base, ...$ranges);
//                 $correspondance = array_replace(...$ranges);
//                 ksort($correspondance);
//
//                 return [$key => $correspondance];
//             })
//             // ->dump()
//             ->toArray();
//
//         // extract($maps);
//         $seeds = array_shift($maps);
//         // dd($maps);
//
//         // //Seed number 79 corresponds to soil number 81.
//         // echo $maps['seed_to_soil'][79] == 81 ? "79 => 81 Yeah 🎉" : "😡 do better code";
//         // // Seed number 14 corresponds to soil number 14.
//         // echo $maps['seed_to_soil'][14] == 14 ? "14 => 14 Yeah 🎉" : "😡 do better code";
//         // // Seed number 55 corresponds to soil number 57.
//         // echo $maps['seed_to_soil'][55] == 57 ? "55 => 57 Yeah 🎉" : "😡 do better code";
//         // // Seed number 13 corresponds to soil number 13.
//         // echo $maps['seed_to_soil'][13] == 13 ? "13 => 13 Yeah 🎉" : "😡 do better code";
//
//         $seeds_to_locations = collect($seeds)
//             ->mapWithKeys(function ($seed) use ($maps) {
//                 $location = $seed;
//                 // if ($seed == 14) {
//                 //   dump($seed);
//                 // }
//                 foreach ($maps as $k => $map) {
//                     $location = $map[$location] ?? $location;
//                     // if ($seed == 14) {
//                     //   dump($k, $location);
//                     //   if ($k == "fertilizer_to_water") {
//                     //     dump($map);
//                     //   }
//                     // }
//                 }
//
//                 // if ($seed == 14) {
//                 //   die();
//                 // }
//                 return [$seed => $location];
//             })
//             ->dump();
//
//         $output = $seeds_to_locations->min();
//
//         if ($output === $expect) {
//             echo 'Yeah 🎉';
//         }
//         else {
//             echo "Ouput: $output"; //
//         }
//
//         if ($output_part2 === $expect_part2) {
//             echo 'Yeah 🎉';
//         }
//         else {
//             echo "Ouput: $output_part2"; //
//         }
//
//     }
// }
