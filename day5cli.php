<?php

require __DIR__.'/vendor/autoload.php';

use App\Advent\Days\Day5;

// ini_set('memory_limit', '-1');
ini_set('memory_limit', '8G');
$input = file_get_contents('resources/advent_inputs/day_5.txt');
$result = Day5::resolvePart2Async($input);
//298472081 too high

echo "Result: $result \n";
