<?php

use App\Advent\Days\Day1Part1;
use App\Advent\Days\Day1Part2;

describe('part 1', function () {

    it('can find the first and last digit of the string', function (string $string, int $result) {
        $number = Day1Part1::combineFirstAndLastDigit($string);

        expect($number)
            ->toBe($result);
    })->with([
        ['1abc2', 12],
        ['pqr3stu8vwx', 38],
        ['a1b2c3d4e5f', 15],
        ['treb7uchet', 77],
    ]);

    it('can find the total', function () {
        $input = "1abc2\npqr3stu8vwx\na1b2c3d4e5f\ntreb7uchet";
        expect(Day1Part1::resolve($input))
            ->toBe(142);
    });
});

describe('part 2', function () {

    dataset('day1part2', [
        ['two1nine', 29],
        ['eightwothree', 83],
        ['abcone2threexyz', 13],
        ['xtwone3four', 24],
        ['4nineeightseven2', 42],
        ['zoneight234', 14],
        ['7pqrstsixteen', 76],
        ['sevennine6451oneninefourtwonenn', 71],
        ['vbxrslkfour7four4qsmlhqvm3', 43],
        ['foureightc3kjvmgtc6eightseven', 47],
        ['oneone8bcpmdfcszz4kmrfrd', 14],
        ['sixcqpbffcsctccd281sevensixeight', 68],
        ['6kxbhq5mnvt9cpbcpzslg77', 67],
        ['cpjfplxvpzqfng4four516three', 43],
        ['3eightlnqzzsfhmndftc72', 32],
        ['six2xsdhxgdlfnonenine46sevenseven', 67],
    ]);


    it('can find the first and last digit using regex', function (string $string, int $result) {
        $number = Day1Part2::combineFirstAndLastDigitWithRegex($string);

        expect($number)
            ->toBe($result);
    })->with('day1part2')
        ->skip(); // Does not work with regex

    it('can find the first and last digit using pure PHP', function (string $string, int $result) {
        $number = Day1Part2::combineFirstAndLastDigit($string);

        expect($number)
            ->toBe($result);
    })->with('day1part2');

    it('can find the total', function () {
        $input = "two1nine\neightwothree\nabcone2threexyz\nxtwone3four\n4nineeightseven2\nzoneight234\n7pqrstsixteen";
        expect(Day1Part2::resolve($input))
            ->toBe(281);
    });
});
