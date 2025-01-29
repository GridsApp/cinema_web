@extends('website.layouts.main')

@section('content')
    <div class="main-container main-spacing">
        <div class="flex justify-center w-full pt-7">
            @include('website.components.title', ['title' => 'Max 1 Seat Map'])
        </div>


        <div class="w-full flex justify-center theater-info mt-7 ">

            <div class="flex flex-row max-w-[70%] gap-20 border p-3 justify-between">

                {{-- @dd($result['movie_show']) --}}
                <div class="title">
                    Movie: <span class="subtitle">
                      {{$result['movie_show']->movie['name']}}
                    </span>
                </div>

                <div class="title">
                    Theatre: <span class="subtitle"> {{$result['movie_show']->theater['label']}}</span>
                </div>

                <div class="title">
                    Time:<span class="subtitle"> {{$result['movie_show']->time['label']}}</span>
                </div>


                <div class="title">
                    date:<span class="subtitle">{{$result['movie_show']->date}}</span>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-5">
            <div class="grid grid-cols-{{ count($result['columns']) }} gap-2  p-4 ">
                @foreach ($result['rows'] as $row)
                    @foreach ($result['columns'] as $column)
                        @php
                            $seatCode = $row . $column;
                            $seat = $result['map'][$seatCode] ?? null;
                        @endphp

                        @if ($column === '')
                            <div class="w-7 h-7"></div>
                        @elseif($seat)
                            {{-- @dd($seat); --}}
                            {{-- <button 
                            class="w-10 h-10 rounded bg-[{{ $seat['color'] }}] text-white flex items-center justify-center"
                            @if (!$seat['available']) disabled @endif
                            data-seat="{{ $seatCode }}">
                            {{ $seatCode }}
                        </button> --}}

                            <svg xmlns="http://www.w3.org/2000/svg" width="30.369" height="20.585" viewBox="0 0 34.369 31.585">
                                <g id="noun-seat-2029648" transform="translate(0)">
                                    <path id="Path_828" data-name="Path 828" d="M168.74,365.22h20.094v7H168.74Z"
                                        transform="translate(-161.602 -340.634)" fill="{{ $seat['color'] }}"
                                        fill-rule="evenodd" />
                                    <path id="Path_829" data-name="Path 829"
                                        d="M144.461,0h18.131a3,3,0,0,1,2.766,3.212v7.495a4.025,4.025,0,0,0-1.537,3.391v8.138H143.232V14.1a4.024,4.024,0,0,0-1.537-3.391V3.212A3,3,0,0,1,144.461,0Z"
                                        transform="translate(-136.341)" fill="{{ $seat['color'] }}" fill-rule="evenodd" />
                                    <path id="Path_830" data-name="Path 830"
                                        d="M65.884,167.578v18.148H60.53V167.578C60.53,164.175,65.884,164.175,65.884,167.578Z"
                                        transform="translate(-60.53 -154.14)" fill="{{ $seat['color'] }}"
                                        fill-rule="evenodd" />
                                    <path id="Path_831" data-name="Path 831"
                                        d="M544.723,167.578v18.148H539.37V167.578C539.37,164.175,544.723,164.175,544.723,167.578Z"
                                        transform="translate(-510.354 -154.14)" fill="{{ $seat['color'] }}"
                                        fill-rule="evenodd" />
                                </g>
                            </svg>





                            {{-- <i class="fa-solid fa-couch"></i> --}}
                        @else
                            {{-- Empty cell (optional) --}}
                            <div class="w-7 h-7 bg-gray-300"></div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
