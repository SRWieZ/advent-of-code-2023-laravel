<?php

namespace App\Advent;

class Day
{
    private static string $resource_path = 'advent_inputs/';

    private int $id;

    public function __construct($id)
    {
        $ids = self::getFinishedDays();

        if (! in_array($id, $ids)) {
            abort(404);
        }

        $this->id = $id;
    }

    public function input()
    {
        return once(fn () => file_get_contents($this->inputPath()));
    }

    public function inputPath(): string
    {
        return resource_path(self::$resource_path.'day_'.$this->id.'.txt');
    }

    public static function getFinishedDays(): array
    {
        $dir = resource_path(self::$resource_path);
        $ext = '.txt';

        return array_map(function ($value) use ($dir, $ext) {
            return str_replace([$dir.'day_', $ext], '', $value);
        }, glob($dir.'day_*'.$ext));
    }
}
