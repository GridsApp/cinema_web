@extends('website.layouts.main')

@section('content')
    {{-- @dd($movie_details); --}}
    <div class=" main-spacing movie-details-page">
        <div class="grid grid-cols-12  ">
            <div class="col-span-6 relative">
                {{-- @if (isset($movie_details['cover_image'])) --}}
                <div class="relative">
                    <div class="asp asp-3-2">
                        <img src={{ $movie_details['cover_image'] }} alt="" class="bg-gray-200 ">
                    </div>
                    <div class="overlaying"></div>
                    <div class="main-container absolute bottom-10 z-20" onclick="GeneralFunctions.openYoutube('{{ $movie_details['youtube_video'] }}')">
                        <div class="youtube-btn">
                          <div class="play-icon">
                            <i class="fa-solid fa-play"></i>
                          </div>
                            <span class="play-text">
                                Watch trailer
                            </span>
    
    
                        </div>
                    </div>
                </div>
             
                {{-- @endif --}}
            </div>

            <div class="col-span-6">
                <div class="h-full  !mt-[5%] right !pl-0 main-container flex flex-row gap-4">
                    @if (isset($movie_details['main_image']))
                        <div class="card-cont ">

                            <div class="movie-card">
                                <div class="no-overflow">

                                    <div class="asp asp-2-3 img-div">
                                        <img src="	{{ $movie_details['main_image'] }}" alt="" class="bg-gray-200">
                                    </div>

                                </div>

                                <div class="card-bottom">
                                    <div class="flex flex-wrap gap-1">

                                        @foreach ($movie_details['genres'] as $genre)
                                            @if (isset($genre))
                                                <div class="border border-gray-300 px-3 py-1 text-[12px] rounded-full">
                                                    {{ $genre['label'] }}
                                                </div>
                                            @endif
                                        @endforeach


                                    </div>
                                    <div>
                                        <div class="title">
                                            {{ $movie_details['name'] }}
                                        </div>
                                        <div class="italic text-[12px]">
                                            {{ $movie_details['duration'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    @endif

                    <div class="details">
                        @if (isset($movie_details['release_date']))
                            <div class="flex  gap-8">
                                <div class="title">
                                    Release Date
                                </div>
                                <div class="description">
                                    {{ $movie_details['release_date'] }}
                                </div>
                            </div>
                        @endif
                        @if (isset($movie_details['description']))
                            <div class="flex  gap-8">
                                <div class="title">
                                    Synopsis
                                </div>
                                <div class="description">
                                    {{ $movie_details['description'] }} </div>
                            </div>
                        @endif
                        @if (isset($movie_details['casts']))
                            <div class="flex  gap-8">
                                <div class="title">
                                    Cast
                                </div>
                                <div class="flex flex-col items-center gap-5">
                                    @foreach ($movie_details['casts'] as $cast)
                                        <div class="flex flex-row gap-5 items-center min-w-[200px]">
                                            <div class="icon">
                                                <img src="{{ $cast['image'] }}" alt="" class="bg-gray-200">
                                            </div>

                                            <div class="font-bold text-[12px]">

                                                {{ $cast['name'] }}
                                            </div>
                                        </div>
                                    @endforeach



                                </div>
                            </div>
                        @endif
                        <div class="title ">
                            Wednesday January 8, 2025
                        </div>

                        <div class="title ">
                            Select another date
                        </div>
                        <div class="dates-list-cont" id="dates-list-cont">

                            <div class="date-item  active ">
                                <div class="day">08</div>
                                <div class="d-name">Wed</div>
                            </div>

                            <div class="date-item ">
                                <div class="day">09</div>
                                <div class="d-name">Thu</div>
                            </div>

                            <div class="date-item ">
                                <div class="day">10</div>
                                <div class="d-name">Fri</div>
                            </div>

                            <div class="date-item ">
                                <div class="day">11</div>
                                <div class="d-name">Sat</div>
                            </div>

                            <div class="date-item ">
                                <div class="day">12</div>
                                <div class="d-name">Sun</div>
                            </div>

                            <div class="date-item ">
                                <div class="day">13</div>
                                <div class="d-name">Mon</div>
                            </div>

                            <div class="date-item ">
                                <div class="day">14</div>
                                <div class="d-name">Tue</div>
                            </div>

                            <div class="date-item ">
                                <div class="day">15</div>
                                <div class="d-name">Wed</div>
                            </div>

                            <div class="date-item ">
                                <div class="day">16</div>
                                <div class="d-name">Thu</div>
                            </div>

                            <div class="date-item ">
                                <div class="day">17</div>
                                <div class="d-name">Fri</div>
                            </div>


                        </div>

                        <div id="available-times" class="available-times mt-05 mb-20">

                            <div class="theater-data-container">
                                <h2 class="theater-name">Cinema Alamirya Mall</h2>
                                <div class="zone">
                                    REG
                                </div>

                                <div class="timing-list">

                                    <div class="time-button">


                                        <div
                                            class="flex justify-center  bg-gray-100 gap-3 items-center rounded-full py-1 pl-1 pr-5">
                                            <div class="icon-seat flex justify-center bg-white items-center">
                                                <i class="fa-solid fa-loveseat"></i>
                                            </div>


                                            <span class="text-[10px] trancking-[1.9px] font-bold">3:45PM</span>
                                        </div>



                                    </div>

                                </div>

                            </div>



                            <a class="showhide-timings active primary-color">
                                <span class="icons">
                                    <i class="fa-solid fa-plus"></i>
                                </span> <span class="text-[14px] tracking-[1.9px]  uppercase font-bold pl-2">
                                    More theatres showtimes
                                </span>
                            </a>

                            <div class=" mt-5  w-full justify-between gap-4 flex flex-row">

                                <div class="quantity w-full">
                                    <button type="button" class="minus" onclick="">
                                        <i class="fas fa-minus"></i></button>
                                    <input type="text" step="1" readonly="" min="1" name="quantity"
                                        value="1" title="Qty" class="input-text qty text" size="4"
                                        pattern="" inputmode="">
                                    <button type="button" class="plus" onclick="">
                                        <i class="fas fa-plus"></i></button>

                                </div>
                                <div class="w-full">
                                    <button
                                        class="font-bold h-[50px] bg-primary-color text-white text-[12px] hover:bg-black tracking-[2.4px] text-center  rounded-full uppercase px-10 py-2">
                                        Sign In
                                    </button>
                                </div>
                            </div>
                            {{-- <div class="hidden-times" style="display: block;">


                                <div class="theater-data-cont">
                                    <h2 class="theater-name">Cinema Mansour Mall</h2>
                                    <div class="cinema-type">
                                        REG
                                    </div>




                                    <div class="timing-list">

                                        <label class="f-button2">
                                            <input type="radio" required="" onclick="appendTheater($(this),24)"
                                                data-theater-name="Theatre 2" data-theater-time="7:00 PM"
                                                name="movie_show_id" value="25617">
                                            <span class="data">
                                                <div class="icon">

                                                    <div class="set-size charts-container">

                                                        <div class="pie-wrapper progress-0 style-2">
                                                            <div class="label"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="20" height="20"
                                                                    viewBox="0 0 15.411 14.163">
                                                                    <g id="noun-seat-2029648" transform="translate(0)">
                                                                        <path id="Path_828" data-name="Path 828"
                                                                            d="M168.74,365.22h9.01v3.138h-9.01Z"
                                                                            transform="translate(-165.539 -354.196)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_829" data-name="Path 829"
                                                                            d="M142.935,0h8.13a1.346,1.346,0,0,1,1.24,1.44V4.8a1.8,1.8,0,0,0-.689,1.52V9.971h-9.232V6.321A1.8,1.8,0,0,0,141.7,4.8V1.44A1.346,1.346,0,0,1,142.935,0Z"
                                                                            transform="translate(-139.294)" fill="#a30101"
                                                                            fill-rule="evenodd"></path>
                                                                        <path id="Path_830" data-name="Path 830"
                                                                            d="M62.931,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,62.931,166.17Z"
                                                                            transform="translate(-60.53 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_831" data-name="Path 831"
                                                                            d="M541.77,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,541.77,166.17Z"
                                                                            transform="translate(-526.359 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div class="pie">
                                                                <div class="left-side half-circle"></div>
                                                                <div class="right-side half-circle"></div>
                                                            </div>
                                                            <div class="shadow"></div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="text">
                                                    7:00 PM
                                                </div>


                                            </span>
                                        </label>

                                        <label class="f-button2">
                                            <input type="radio" required="" onclick="appendTheater($(this),24)"
                                                data-theater-name="Theatre 2" data-theater-time="9:15 PM"
                                                name="movie_show_id" value="25618">
                                            <span class="data">
                                                <div class="icon">

                                                    <div class="set-size charts-container">

                                                        <div class="pie-wrapper progress-0 style-2">
                                                            <div class="label"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="20" height="20"
                                                                    viewBox="0 0 15.411 14.163">
                                                                    <g id="noun-seat-2029648" transform="translate(0)">
                                                                        <path id="Path_828" data-name="Path 828"
                                                                            d="M168.74,365.22h9.01v3.138h-9.01Z"
                                                                            transform="translate(-165.539 -354.196)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_829" data-name="Path 829"
                                                                            d="M142.935,0h8.13a1.346,1.346,0,0,1,1.24,1.44V4.8a1.8,1.8,0,0,0-.689,1.52V9.971h-9.232V6.321A1.8,1.8,0,0,0,141.7,4.8V1.44A1.346,1.346,0,0,1,142.935,0Z"
                                                                            transform="translate(-139.294)" fill="#a30101"
                                                                            fill-rule="evenodd"></path>
                                                                        <path id="Path_830" data-name="Path 830"
                                                                            d="M62.931,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,62.931,166.17Z"
                                                                            transform="translate(-60.53 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_831" data-name="Path 831"
                                                                            d="M541.77,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,541.77,166.17Z"
                                                                            transform="translate(-526.359 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div class="pie">
                                                                <div class="left-side half-circle"></div>
                                                                <div class="right-side half-circle"></div>
                                                            </div>
                                                            <div class="shadow"></div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="text">
                                                    9:15 PM
                                                </div>


                                            </span>
                                        </label>

                                    </div>

                                </div>










                                <div class="theater-data-cont">
                                    <h2 class="theater-name">Cinema Babylon Mall</h2>
                                    <div class="cinema-type">
                                        ATMOS
                                    </div>




                                    <div class="timing-list">

                                        <label class="f-button2">
                                            <input type="radio" required="" onclick="appendTheater($(this),34)"
                                                data-theater-name="Samaraa" data-theater-time="7:00 PM"
                                                name="movie_show_id" value="25657">
                                            <span class="data">
                                                <div class="icon">

                                                    <div class="set-size charts-container">

                                                        <div class="pie-wrapper progress-1 style-2">
                                                            <div class="label"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="20" height="20"
                                                                    viewBox="0 0 15.411 14.163">
                                                                    <g id="noun-seat-2029648" transform="translate(0)">
                                                                        <path id="Path_828" data-name="Path 828"
                                                                            d="M168.74,365.22h9.01v3.138h-9.01Z"
                                                                            transform="translate(-165.539 -354.196)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_829" data-name="Path 829"
                                                                            d="M142.935,0h8.13a1.346,1.346,0,0,1,1.24,1.44V4.8a1.8,1.8,0,0,0-.689,1.52V9.971h-9.232V6.321A1.8,1.8,0,0,0,141.7,4.8V1.44A1.346,1.346,0,0,1,142.935,0Z"
                                                                            transform="translate(-139.294)" fill="#a30101"
                                                                            fill-rule="evenodd"></path>
                                                                        <path id="Path_830" data-name="Path 830"
                                                                            d="M62.931,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,62.931,166.17Z"
                                                                            transform="translate(-60.53 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_831" data-name="Path 831"
                                                                            d="M541.77,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,541.77,166.17Z"
                                                                            transform="translate(-526.359 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div class="pie">
                                                                <div class="left-side half-circle"></div>
                                                                <div class="right-side half-circle"></div>
                                                            </div>
                                                            <div class="shadow"></div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="text">
                                                    7:00 PM
                                                </div>


                                            </span>
                                        </label>

                                    </div>

                                </div>










                                <div class="theater-data-cont">
                                    <h2 class="theater-name">Cinema Zayoona Mall</h2>
                                    <div class="cinema-type">
                                        REG
                                    </div>




                                    <div class="timing-list">

                                        <label class="f-button2">
                                            <input type="radio" required="" onclick="appendTheater($(this),19)"
                                                data-theater-name="Theatre 4" data-theater-time="7:00 PM"
                                                name="movie_show_id" value="25516">
                                            <span class="data">
                                                <div class="icon">

                                                    <div class="set-size charts-container">

                                                        <div class="pie-wrapper progress-4 style-2">
                                                            <div class="label"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="20" height="20"
                                                                    viewBox="0 0 15.411 14.163">
                                                                    <g id="noun-seat-2029648" transform="translate(0)">
                                                                        <path id="Path_828" data-name="Path 828"
                                                                            d="M168.74,365.22h9.01v3.138h-9.01Z"
                                                                            transform="translate(-165.539 -354.196)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_829" data-name="Path 829"
                                                                            d="M142.935,0h8.13a1.346,1.346,0,0,1,1.24,1.44V4.8a1.8,1.8,0,0,0-.689,1.52V9.971h-9.232V6.321A1.8,1.8,0,0,0,141.7,4.8V1.44A1.346,1.346,0,0,1,142.935,0Z"
                                                                            transform="translate(-139.294)" fill="#a30101"
                                                                            fill-rule="evenodd"></path>
                                                                        <path id="Path_830" data-name="Path 830"
                                                                            d="M62.931,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,62.931,166.17Z"
                                                                            transform="translate(-60.53 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_831" data-name="Path 831"
                                                                            d="M541.77,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,541.77,166.17Z"
                                                                            transform="translate(-526.359 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div class="pie">
                                                                <div class="left-side half-circle"></div>
                                                                <div class="right-side half-circle"></div>
                                                            </div>
                                                            <div class="shadow"></div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="text">
                                                    7:00 PM
                                                </div>


                                            </span>
                                        </label>

                                        <label class="f-button2">
                                            <input type="radio" required="" onclick="appendTheater($(this),18)"
                                                data-theater-name="Theatre 3" data-theater-time="9:00 PM"
                                                name="movie_show_id" value="25519">
                                            <span class="data">
                                                <div class="icon">

                                                    <div class="set-size charts-container">

                                                        <div class="pie-wrapper progress-0 style-2">
                                                            <div class="label"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="20" height="20"
                                                                    viewBox="0 0 15.411 14.163">
                                                                    <g id="noun-seat-2029648" transform="translate(0)">
                                                                        <path id="Path_828" data-name="Path 828"
                                                                            d="M168.74,365.22h9.01v3.138h-9.01Z"
                                                                            transform="translate(-165.539 -354.196)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_829" data-name="Path 829"
                                                                            d="M142.935,0h8.13a1.346,1.346,0,0,1,1.24,1.44V4.8a1.8,1.8,0,0,0-.689,1.52V9.971h-9.232V6.321A1.8,1.8,0,0,0,141.7,4.8V1.44A1.346,1.346,0,0,1,142.935,0Z"
                                                                            transform="translate(-139.294)" fill="#a30101"
                                                                            fill-rule="evenodd"></path>
                                                                        <path id="Path_830" data-name="Path 830"
                                                                            d="M62.931,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,62.931,166.17Z"
                                                                            transform="translate(-60.53 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_831" data-name="Path 831"
                                                                            d="M541.77,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,541.77,166.17Z"
                                                                            transform="translate(-526.359 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div class="pie">
                                                                <div class="left-side half-circle"></div>
                                                                <div class="right-side half-circle"></div>
                                                            </div>
                                                            <div class="shadow"></div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="text">
                                                    9:00 PM
                                                </div>


                                            </span>
                                        </label>

                                    </div>

                                </div>










                                <div class="theater-data-cont">
                                    <h2 class="theater-name">Cinema Baghdad Mall</h2>
                                    <div class="cinema-type">
                                        REG
                                    </div>




                                    <div class="timing-list">

                                        <label class="f-button2">
                                            <input type="radio" required="" onclick="appendTheater($(this),6)"
                                                data-theater-name="Theatre 6" data-theater-time="7:00 PM"
                                                name="movie_show_id" value="25529">
                                            <span class="data">
                                                <div class="icon">

                                                    <div class="set-size charts-container">

                                                        <div class="pie-wrapper progress-0 style-2">
                                                            <div class="label"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="20" height="20"
                                                                    viewBox="0 0 15.411 14.163">
                                                                    <g id="noun-seat-2029648" transform="translate(0)">
                                                                        <path id="Path_828" data-name="Path 828"
                                                                            d="M168.74,365.22h9.01v3.138h-9.01Z"
                                                                            transform="translate(-165.539 -354.196)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_829" data-name="Path 829"
                                                                            d="M142.935,0h8.13a1.346,1.346,0,0,1,1.24,1.44V4.8a1.8,1.8,0,0,0-.689,1.52V9.971h-9.232V6.321A1.8,1.8,0,0,0,141.7,4.8V1.44A1.346,1.346,0,0,1,142.935,0Z"
                                                                            transform="translate(-139.294)" fill="#a30101"
                                                                            fill-rule="evenodd"></path>
                                                                        <path id="Path_830" data-name="Path 830"
                                                                            d="M62.931,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,62.931,166.17Z"
                                                                            transform="translate(-60.53 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_831" data-name="Path 831"
                                                                            d="M541.77,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,541.77,166.17Z"
                                                                            transform="translate(-526.359 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div class="pie">
                                                                <div class="left-side half-circle"></div>
                                                                <div class="right-side half-circle"></div>
                                                            </div>
                                                            <div class="shadow"></div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="text">
                                                    7:00 PM
                                                </div>


                                            </span>
                                        </label>

                                        <label class="f-button2">
                                            <input type="radio" required="" onclick="appendTheater($(this),6)"
                                                data-theater-name="Theatre 6" data-theater-time="9:15 PM"
                                                name="movie_show_id" value="25530">
                                            <span class="data">
                                                <div class="icon">

                                                    <div class="set-size charts-container">

                                                        <div class="pie-wrapper progress-0 style-2">
                                                            <div class="label"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="20" height="20"
                                                                    viewBox="0 0 15.411 14.163">
                                                                    <g id="noun-seat-2029648" transform="translate(0)">
                                                                        <path id="Path_828" data-name="Path 828"
                                                                            d="M168.74,365.22h9.01v3.138h-9.01Z"
                                                                            transform="translate(-165.539 -354.196)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_829" data-name="Path 829"
                                                                            d="M142.935,0h8.13a1.346,1.346,0,0,1,1.24,1.44V4.8a1.8,1.8,0,0,0-.689,1.52V9.971h-9.232V6.321A1.8,1.8,0,0,0,141.7,4.8V1.44A1.346,1.346,0,0,1,142.935,0Z"
                                                                            transform="translate(-139.294)" fill="#a30101"
                                                                            fill-rule="evenodd"></path>
                                                                        <path id="Path_830" data-name="Path 830"
                                                                            d="M62.931,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,62.931,166.17Z"
                                                                            transform="translate(-60.53 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_831" data-name="Path 831"
                                                                            d="M541.77,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,541.77,166.17Z"
                                                                            transform="translate(-526.359 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div class="pie">
                                                                <div class="left-side half-circle"></div>
                                                                <div class="right-side half-circle"></div>
                                                            </div>
                                                            <div class="shadow"></div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="text">
                                                    9:15 PM
                                                </div>


                                            </span>
                                        </label>

                                    </div>

                                </div>










                                <div class="theater-data-cont">
                                    <h2 class="theater-name">Cinema DreamCity Mall</h2>
                                    <div class="cinema-type">
                                        REG
                                    </div>




                                    <div class="timing-list">

                                        <label class="f-button2">
                                            <input type="radio" required="" onclick="appendTheater($(this),57)"
                                                data-theater-name="Theatre 1" data-theater-time="7:00 PM"
                                                name="movie_show_id" value="25539">
                                            <span class="data">
                                                <div class="icon">

                                                    <div class="set-size charts-container">

                                                        <div class="pie-wrapper progress-0 style-2">
                                                            <div class="label"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="20" height="20"
                                                                    viewBox="0 0 15.411 14.163">
                                                                    <g id="noun-seat-2029648" transform="translate(0)">
                                                                        <path id="Path_828" data-name="Path 828"
                                                                            d="M168.74,365.22h9.01v3.138h-9.01Z"
                                                                            transform="translate(-165.539 -354.196)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_829" data-name="Path 829"
                                                                            d="M142.935,0h8.13a1.346,1.346,0,0,1,1.24,1.44V4.8a1.8,1.8,0,0,0-.689,1.52V9.971h-9.232V6.321A1.8,1.8,0,0,0,141.7,4.8V1.44A1.346,1.346,0,0,1,142.935,0Z"
                                                                            transform="translate(-139.294)" fill="#a30101"
                                                                            fill-rule="evenodd"></path>
                                                                        <path id="Path_830" data-name="Path 830"
                                                                            d="M62.931,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,62.931,166.17Z"
                                                                            transform="translate(-60.53 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_831" data-name="Path 831"
                                                                            d="M541.77,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,541.77,166.17Z"
                                                                            transform="translate(-526.359 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div class="pie">
                                                                <div class="left-side half-circle"></div>
                                                                <div class="right-side half-circle"></div>
                                                            </div>
                                                            <div class="shadow"></div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="text">
                                                    7:00 PM
                                                </div>


                                            </span>
                                        </label>

                                    </div>

                                </div>










                                <div class="theater-data-cont">
                                    <h2 class="theater-name">Cinema Cairo Mall</h2>
                                    <div class="cinema-type">
                                        REG
                                    </div>




                                    <div class="timing-list">

                                        <label class="f-button2">
                                            <input type="radio" required="" onclick="appendTheater($(this),42)"
                                                data-theater-name="Theatre 1" data-theater-time="9:00 PM"
                                                name="movie_show_id" value="25597">
                                            <span class="data">
                                                <div class="icon">

                                                    <div class="set-size charts-container">

                                                        <div class="pie-wrapper progress-0 style-2">
                                                            <div class="label"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="20" height="20"
                                                                    viewBox="0 0 15.411 14.163">
                                                                    <g id="noun-seat-2029648" transform="translate(0)">
                                                                        <path id="Path_828" data-name="Path 828"
                                                                            d="M168.74,365.22h9.01v3.138h-9.01Z"
                                                                            transform="translate(-165.539 -354.196)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_829" data-name="Path 829"
                                                                            d="M142.935,0h8.13a1.346,1.346,0,0,1,1.24,1.44V4.8a1.8,1.8,0,0,0-.689,1.52V9.971h-9.232V6.321A1.8,1.8,0,0,0,141.7,4.8V1.44A1.346,1.346,0,0,1,142.935,0Z"
                                                                            transform="translate(-139.294)" fill="#a30101"
                                                                            fill-rule="evenodd"></path>
                                                                        <path id="Path_830" data-name="Path 830"
                                                                            d="M62.931,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,62.931,166.17Z"
                                                                            transform="translate(-60.53 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                        <path id="Path_831" data-name="Path 831"
                                                                            d="M541.77,166.17v8.138h-2.4V166.17A1.2,1.2,0,0,1,541.77,166.17Z"
                                                                            transform="translate(-526.359 -160.144)"
                                                                            fill="#a30101" fill-rule="evenodd"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div class="pie">
                                                                <div class="left-side half-circle"></div>
                                                                <div class="right-side half-circle"></div>
                                                            </div>
                                                            <div class="shadow"></div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="text">
                                                    9:00 PM
                                                </div>


                                            </span>
                                        </label>

                                    </div>

                                </div>










                            </div> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
