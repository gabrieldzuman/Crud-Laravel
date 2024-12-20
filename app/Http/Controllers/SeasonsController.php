<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\View\View;

class SeasonsController extends Controller
{
    /**
     * Display the seasons and their episodes for a given series.
     *
     * @param Series $series The series for which seasons are being retrieved.
     * @return View The seasons index view.
     */
    public function index(Series $series): View
    {
        $seasons = $series->seasons()->with('episodes')->get();

        return view('seasons.index', [
            'seasons' => $seasons,
            'series' => $series,
        ]);
    }
}
