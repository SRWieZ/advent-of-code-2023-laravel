<?php

use App\Advent\Day;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Laravel\Folio\name;
use function Laravel\Folio\render;

name('day.show');

// render(function (View $view, Day $day) {
render(function (View $view, $day) {
    $day = new Day($day);
    return $view->with('input', $day->input());
});
?>
<div>
    @dump($input)
</div>
