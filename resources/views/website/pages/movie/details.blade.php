@extends('website.layouts.main')

@section('content')
    {{-- @dd($movie_details); --}}
    <div class=" main-spacing movie-details-page"  >
        <div class="grid sm:grid-cols-12 grid-cols-1  ">
            <div class="col-span-6 relative">
                {{-- @if (isset($movie_details['cover_image'])) --}}
                <div class="relative">
                    <div class="asp asp-3-2">
                        <img src={{ $movie_details['cover_image'] }} alt="" class="bg-gray-200 ">
                    </div>
                    <div class="overlaying"></div>
                    <div class="main-container absolute bottom-10 z-20"
                        onclick="GeneralFunctions.openYoutube('{{ $movie_details['youtube_video'] }}')">
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
                <div class="h-full  !mt-[5%] right sm:!pl-0 px-3 main-container flex sm:flex-row flex-col gap-4">
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
                        {{-- <div class="title">
                            {{ now()->format('l, F j, Y') }}
                        </div>


                        <div class="title ">
                            Select another date
                        </div>
                        <div class="dates-list-cont" id="dates-list-cont">
                            <!-- Date list items -->
                            <template x-for="date in dates" :key="date">
                                <div :class="{ 'date-item': true, 'active': date === selectedDate }"
                                    @click="selectDate(date)">
                                    <div class="day" x-text="date.day"></div>
                                    <div class="d-name" x-text="date.d_name"></div>
                                </div>
                            </template>
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

                        </div> --}}

                        <livewire:website.movie-show :slug="$slug" />
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
