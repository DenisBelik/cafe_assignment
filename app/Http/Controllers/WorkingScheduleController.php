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
    public function index()
    {
        return response([
            'until' => WorkingSchedule::untilOpened(Carbon::now())
        ]);
    }
}
