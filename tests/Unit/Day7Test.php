<?php

use App\Advent\Days\Day7;

dataset('input', ['
32T3K 765
T55J5 684
KK677 28
KTJJT 220
QQQJA 483']);

describe('part 1', function () {
    it('can solve part 1', function ($input) {
        expect(Day7::resolvePart1($input))
            ->toBe(6440);
    })->with('input');
});

describe('part 2', function () {
    it('can solve part 2', function ($input) {
        expect(Day7::resolvePart2($input))
            ->toBe(5905);
    })->with('input');
});
