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
        return view('f1', [
            'tracks' => $tracks,
            'drivers' => $drivers
        ]);
    }

    public function f1Points(Request $request)
    {
        $fastest = [];
        $track_id = $request->track;
        foreach ($request->drivers as $key => $driver) {
            Point::query()->updateOrCreate([
                'driver_id' => $key,
                'track_id' => $track_id,
                'point' => $driver,
                'fastest_lap' => ($request->fastest_lap == $key) ? 1 : 0
            ]);
        }

        dd($request->all());
    }
}
