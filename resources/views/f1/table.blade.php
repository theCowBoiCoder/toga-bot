@extends('layout.layout')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col items-center justify-center mt-6">

            <h1 class="text-7xl text-white uppercase">F1 Points Table</h1>
            <div class="flex pt-2 pb-2 pl-4 pr-4 rounded m-2" style="background-color: #7289DA">
                <a href="/dashboard" class="text-center text-white">
                    Dashboard
                </a>
            </div>
        </div>
        <div class="flex my-3">
            <table class="table-auto border-8 border border-white">
                <thead>
                <tr class="text-white">
                    <th class="border border-white border-8"></th>
                    @foreach($tracks as $track)
                        <th class="border border-white uppercase border-8 px-3">{{\Illuminate\Support\Str::substr($track->country,0,3)}}</th>
                    @endforeach
                    <th class="border border-white border-8">TOTAL</th>
                </tr>
                </thead>
                <tbody>
                @foreach($drivers as $driver)
                    <tr>
                        <td class="border border-white border-8 text-center text-white px-3 font-bold text-sm">{{$driver->name}} (#{{$driver->team_number}})</td>
                        @for($i = 1; $i<=24; $i++)
                            <td class="border-8 border border-white text-center text-white">{{$driver->tablePoints($i) ?? 0}}</td>
                        @endfor
                        <td class="border border-white border-8 text-center text-white px-3 font-bold text-sm">{{$driver->points()}}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
