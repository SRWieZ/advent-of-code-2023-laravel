<?php

use App\Advent\Days\Day3;

dataset('input', ['
467..114..
...*......
..35..633.
......#...
617*......
.....+.58.
..592.....
......755.
...$.*....
.664.598..']);

describe('part 1', function () {
    it('can solve part 1', function ($input) {
        expect(Day3::resolvePart1($input))
            ->toBe(4361);
    })->with('input');
});

describe('part 2', function () {
    it('can solve part 2', function ($input) {
        expect(Day3::resolvePart2($input))
            ->toBe(467835);
    })->with('input');
});
