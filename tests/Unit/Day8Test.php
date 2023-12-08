<?php

use App\Advent\Days\Day8;

dataset('input_part1', ['
LLR

AAA = (BBB, BBB)
BBB = (AAA, ZZZ)
ZZZ = (ZZZ, ZZZ)']);
dataset('input_part2', ['
LR

11A = (11B, XXX)
11B = (XXX, 11Z)
11Z = (11B, XXX)
22A = (22B, XXX)
22B = (22C, 22C)
22C = (22Z, 22Z)
22Z = (22B, 22B)
XXX = (XXX, XXX)']);

describe('part 1', function () {
    it('can solve part 1', function ($input) {
        expect(Day8::resolvePart1($input))
            ->toBe(6);
    })->with('input_part1');
});

describe('part 2', function () {
    it('can solve part 2', function ($input) {
        expect(Day8::resolvePart2($input))
            ->toBe(6);
    })->with('input_part2');

    // Thanks Internet
    it('can solve part 2 with lcm', function ($input) {
        expect(Day8::resolvePart2Optimized($input))
            ->toBe(6);
    })->with('input_part2');
});
