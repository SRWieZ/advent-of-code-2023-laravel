<?php

use App\Advent\Days\Day2;

dataset('input', ['Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue
Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red
Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red
Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green']);

describe('part 1', function () {
    it('can extract max value of each color in each game', function ($input) {
        $games = Day2::extractMaxForEachColorsPerGame($input);

        expect($games->get(1)->toArray())->toBe([
            'red' => 4,
            'green' => 2,
            'blue' => 6,
        ])
            ->and($games->get(2)->toArray())->toBe([
                'red' => 1,
                'green' => 3,
                'blue' => 4,
            ])
            ->and($games->get(3)->toArray())->toBe([
                'red' => 20,
                'green' => 13,
                'blue' => 6,
            ])
            ->and($games->get(4)->toArray())->toBe([
                'red' => 14,
                'green' => 3,
                'blue' => 15,
            ])
            ->and($games->get(5)->toArray())->toBe([
                'red' => 6,
                'green' => 3,
                'blue' => 2,
            ]);
    })->with('input');

    it('can find games that are possible', function ($input) {
        expect(Day2::resolvePart1($input))
            ->toBe(8);
    })->with('input');
});

describe('part 2', function () {
    it('can find the power of a set of cubes, then sum', function ($input) {
        expect(Day2::resolvePart2($input))
            ->toBe(2286);
    })->with('input');
});
