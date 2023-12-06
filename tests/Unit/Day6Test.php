<?php

use App\Advent\Days\Day6;

dataset('input', ['
Time:      7  15   30
Distance:  9  40  200']);

describe('part 1', function () {
    it('can solve part 1', function ($input) {
        expect(Day6::resolvePart1($input))
            ->toBe(288);
    })->with('input');
});

describe('part 2', function () {
    it('can solve part 2', function ($input) {
        expect(Day6::resolvePart2($input))
            ->toBe(71503);
    })->with('input');
});
