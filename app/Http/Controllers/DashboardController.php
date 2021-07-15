<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Point;
use App\Models\Track;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function f1()
    {
        $tracks = Track::all();
        $drivers = Driver::all();
        return view('f1.points', [
            'tracks' => $tracks,
            'drivers' => $drivers
        ]);
    }

    public function f1PointsTable()
    {
        $tracks = Track::all();
        $drivers = Driver::query()->get();

        $drivers = $drivers->sort(function($a, $b) {
            return ($a->points() > $b->points()) ? -1 : 1;
        });

        return view('f1.table', [
            'tracks' => $tracks,
            'drivers' => $drivers
        ]);
    }

    public function f1Points(Request $request)
    {
        $track_id = $request->track;

        //Check if points have been allocated
        $checkPoints = Point::query()->where('track_id', $track_id)->first();
        if ($checkPoints != null) {
            return redirect()->back()->with('failed', 'Sorry points have already been allocated to this track');
        }

        $fastest = [];

        foreach ($request->drivers as $key => $driver) {
            Point::query()->updateOrCreate([
                'driver_id' => $key,
                'track_id' => $track_id,
                'point' => $driver,
                'fastest_lap' => ($request->fastest_lap == $key) ? 1 : 0
            ]);
        }

    }
}
