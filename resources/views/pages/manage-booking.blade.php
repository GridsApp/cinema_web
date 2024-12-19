@extends('CMSView::layouts.main')

@section('content')
    <div class="container-fixed booking-management">


        <div class="flex flex-col gap-10">
            @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'Select Date'])
                <div class="flex py-1 gap-5 overflow-x-scroll">
                    @foreach ($period as $date)
                        @php
                            $formatted_date = \Carbon\Carbon::parse($date);
                        @endphp
                        <a id="{{ $formatted_date->format('d-m-Y') }}" href="?date={{ $formatted_date->format('d-m-Y') }}"
                            class="day-box {{ $date === $formatted_date->format('Y-m-d') ? 'current-date' : '' }}">
                            <div class="month t-center">{{ $formatted_date->format('M') }}</div>
                            <div class="day font-bold text-center t-center">{{ $formatted_date->format('d') }}</div>
                        </a>
                    @endforeach
                </div>
            @endcomponent


            @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'Select Date'])
                <div>
                    @foreach ($movie_shows as $movie_show)
                        <div>

                        </div>
                    @endforeach
                </div>
            @endcomponent

        </div>

    </div>
@endsection
