
    <div x-data="GeneralFunctions.initManageBooking('{{$states}}')" class="container-fixed booking-management">


        <div class="flex flex-col gap-10">
            @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'Select Date' ])
                <div class="flex py-1 gap-5 overflow-x-scroll">
                 
      
                    @foreach ($period as $date)
                        @php
                            $formatted_date = \Carbon\Carbon::parse($date);
                        @endphp
                        <a href="?date={{ $formatted_date->format('d-m-Y') }}" wire:navigate class="day-box @if(request()->input('date') == $formatted_date->format('d-m-Y')) day-box-active @endif">
                            <div class="month t-center">{{ $formatted_date->format('M') }}</div>
                            <div class="day font-bold text-center t-center">{{ $formatted_date->format('d') }}</div>
                        </a>
                    @endforeach
                </div>
            @endcomponent
        
                @forelse ($movie_shows->groupBy('branch_id') as $grouped_movie_shows)
                    @php
                        $grouped_movie_show = $grouped_movie_shows[0] ?? null;
                        if (!$grouped_movie_show) {
                            continue;
                        }
                    @endphp
                    @component('CMSView::components.panels.default', [
                        'classes' => '', 
                        'title' => $grouped_movie_show['branch_name'],
                        'actions' => view('components.form.toggle' , ['model' => 'toggle.'.$grouped_movie_show['branch_identifier']])->render()
                    ])
                        <div class="flex flex-col gap-5">
                            @foreach ($grouped_movie_shows->groupBy('movie_id') as $grouped_movies)
                                @php
                                    $grouped_movie = $grouped_movies[0] ?? null;
                                   
                                    if (!$grouped_movie) {
                                        continue;
                                    }
                                @endphp

                                <div class="flex gap-4">
                                    <div class="w-[150px]">
                                        <img src="{{ $grouped_movie['movie_image'] }}" alt="" class="rounded-lg">
                                    </div>
                                    <div class="flex-1 gap-10">
                                        <div class="flex flex-col gap-6">
                                            
                                            
                                            <div class="flex items-center justify-between">
                                                <div class="title-label">{{ $grouped_movie['movie_name'] }}</div>
                                            

                                                @include('components.form.toggle', ['model' => 'toggle.'.$grouped_movie['movie_identifier']])
                                            </div>
                                           
                                            
                                            <div class="grid grid-cols-5 gap-4">
                                                @foreach ($grouped_movies as $movie_show)

                                                    @php


$date = now()->parse($movie_show["movie_show_date"]);


$theater_id = $movie_show['theater_id'];

$date_from = (clone $date)->format('l') == 'Thursday' ? $date  : (clone $date)->previous(\Carbon\Carbon::THURSDAY);

$date_to = (clone $date_from)->addDays(6);  

$date_from = $date_from->format('d-m-Y');
$date_to = $date_to->format('d-m-Y');

$link = "/movie-shows?theater_id=$theater_id&date_from=$date_from&date_to=$date_to";

                                                    

                                                    @endphp

                                                    <div class="border relative border-gray-200 px-4 py-4 rounded-lg">

                                                        <a  class="absolute top-[15px] right-[15px]" href="{{$link}}"><i class="fa-light fa-pen-to-square"></i></a>

                                                        <div class="text-label pr-[20px]">
                                                            <span class="font-bold">Theater:</span>
                                                            {{ $movie_show['theater_label'] }}
                                                        </div>
                                                        <div class="text-label">
                                                            <span class="font-bold">Time:</span> {{ convertTo12HourFormat($movie_show['time_label']) }}
                                                        </div>
                                                        <div class="text-label">
                                                            <span class="font-bold">Screen type:</span>
                                                            {{ $movie_show['screen_type_label'] }}
                                                        </div>

                                                        <div class="flex items-center gap-2">
                                                            @include('components.form.toggle' , ['model' => 'toggle.'.$movie_show['movie_show_identifier']])
                                                            <span class="text-xs">Enable Book</span>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endcomponent

                    @empty

                    @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'Movie Shows'])
                    <p class="text-xs ">No available shows on this date.</p>
                @endcomponent

                @endforelse
    
        </div>

    </div>

