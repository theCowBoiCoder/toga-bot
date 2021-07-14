@extends('layout.layout')

@section('content')
    <div class="container mx-auto">
        <header class="flex flex-col items-center justify-center h-screen">
            <div class="mb-4">
                <h1 class="text-7xl text-white uppercase">Welcome {{ Auth::user()->name }}</h1>
            </div>
            <div class="mb-4">
                <h2 class="text-4xl text-white uppercase">You have {{ Auth::user()->points() }} points.</h2>
            </div>
            <div class="flex">

                <div class="flex pt-2 pb-2 pl-4 pr-4 rounded m-2" style="background-color: #7289DA">
                    <a href="/unlink/discord" class="text-center text-white">
                        Unlink Discord
                    </a>
                </div>
                @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                    <div class="flex pt-2 pb-2 pl-4 pr-4 rounded m-2" style="background-color: #00A8FF">
                        <a href="{{route('admin.f1')}}" class="text-center text-white">
                            Update F1 Points
                        </a>
                    </div>
                @endif
                <div class="flex pt-2 pb-2 pl-4 pr-4 rounded m-2" style="background-color: #7289DA">
                    <a href="/logout" class="text-center text-white">
                        Logout
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout ml-2" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"/>
                        <path d="M7 12h14l-3 -3m0 6l3 -3"/>
                    </svg>
                </div>
            </div>
            <small class="text-white uppercase">SOME TIMES MAYBE BE GOOD, SOMETIMES MAYBE BE SHIT!</small>
        </header>
    </div>
@endsection
