<?php

require __DIR__.'/vendor/autoload.php';
$start = now();

$input = '
LR

11A = (11B, XXX)
11B = (XXX, 11Z)
11Z = (11B, XXX)
22A = (22B, XXX)
22B = (22C, 22C)
22C = (22Z, 22Z)
22Z = (22B, 22B)
XXX = (XXX, XXX)
';

$input = file_get_contents('resources/advent_inputs/day_8.txt');
//
$output = null;

$expect = 6;

// Part1

[$lr, $network] = str($input)
    ->trim()
    ->explode("\n\n")
    ->filter()
    ->map(fn ($v) => trim($v))
    ->toArray();

$lr = str_split($lr);
// dump($lr);

$network = str($network)
    ->explode("\n")
    ->mapWithKeys(function ($value) {
        [$key, $lr] = explode('=', str_replace([' ', '(', ')'], '', $value));
        [$L, $R] = explode(',', $lr);

        return [$key => compact('L', 'R')];
    })
    ->toArray();

$starts = collect(array_keys($network))
    ->filter(fn ($v) => str($v)->endsWith('A'))
    ->values()
    ->toArray();

//dump($starts);

$steps = 0;
$all_z = false;
$cnt_starts = count($starts);
$max_k_lr = count($lr);

$length_to_z = [];
do {
    foreach ($starts as $k => $pos) {
        $starts[$k] = $network[$pos][$lr[$steps % $max_k_lr]];

        if (str_ends_with($starts[$k], 'Z')) {
            $length_to_z[$k] = $steps + 1;
        }
    }

    $steps++;

    if (count($length_to_z) == $cnt_starts) {
        break;
    }

} while (true);
dump($length_to_z);
function lcm_arr($items)
{
    while (count($items) >= 2) {
        $items[] = gmp_lcm(array_shift($items), array_shift($items));
    }

    return reset($items);
}

$output = lcm_arr($length_to_z);
$end = now();

if ($output == $expect) {
    echo 'Yeah 🎉'."\n";
} else {
    echo "Ouput: $output \n"; //
}
echo 'Time to result : '.$end->diffForHumans($start)."\n";
