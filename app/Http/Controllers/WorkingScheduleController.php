<?php

namespace App\Http\Controllers;

use App\Models\WorkingSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkingScheduleController extends Controller
{
    /**
     * Get the date until the nearest opening.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date ? new Carbon($request->date) : Carbon::now();
        $initialDate = new Carbon($date);

        $until = WorkingSchedule::untilOpened($date);
        return response([
            'until' => $until,
            'openedAtInitialDate' => $initialDate->toDateString() === $until->toDateString()
        ]);
    }
}
