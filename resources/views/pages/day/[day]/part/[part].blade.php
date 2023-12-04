<?php

use App\Advent\Day;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Laravel\Folio\name;
use function Laravel\Folio\render;

name('day.part.show');

render(function (Request $request, View $view, $day, $part) {
    $day = new Day($day);
    return $view->with('input', $day->input());
});
?>
<div>
    //
</div>
