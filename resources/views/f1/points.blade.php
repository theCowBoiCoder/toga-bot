@extends('layout.layout')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col items-center justify-center mt-6">

            <h1 class="text-7xl text-white uppercase">Update F1 Points</h1>
            <div class="flex pt-2 pb-2 pl-4 pr-4 rounded m-2" style="background-color: #7289DA">
                <a href="/dashboard" class="text-center text-white">
                    Dashboard
                </a>
            </div>
        </div>
        @if(Session::has('failed'))
            <div class="bg-red-800 my-3 rounded p-3">
                <p class="alert text-white">{{ Session::get('failed') }}</p>
            </div>

        @endif
        <div class="flex my-3">
            <form class="w-full max-w-sm" method="post" action="{{route('admin.f1.points')}}">
                @csrf
                <select name="track" id=""
                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight mb-3">
                    <option value="0">Please Select</option>
                    @foreach($tracks as $track)
                        <option value="{{$track->id}}">{{$track->name}}</option>
                    @endforeach
                </select>
                @foreach($drivers as $driver)
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-2/3">
                            <input
                                class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight"
                                id="inline-full-name" type="text" name="drivers[{{$driver->id}}]"
                                placeholder="{{$driver->name}}">
                        </div>
                        <div class="md:w-2/3 px-5">
                            <label class="text-white">Fastest Lap?</label>
                            <input type="radio" id="{{$driver->id}}" value="1" name="fastest_lap">
                        </div>
                    </div>
                @endforeach
                <input type="submit" value="Update Points"
                       class="flex-shrink-0 border-transparent border-4 text-sm py-1 px-2 rounded">
            </form>
        </div>
    </div>
@endsection
