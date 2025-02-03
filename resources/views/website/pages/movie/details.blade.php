@extends('website.layouts.main')

@section('content')
    {{-- @dd($movie_details); --}}
    <div class=" main-spacing movie-details-page">
        <div class="flex sm:flex-row flex-col  ">


            <div class="sm:w-[50%] w-full relative">
                <div class="asp asp-3-2">
                    <img src={{ $movie_details['cover_image'] }} alt="" class="bg-gray-200 ">
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
                {{-- <div class="{{ app()->getLocale() === 'ar' ? 'overlaying-rtl overlaying' : 'overlaying-ltr overlaying' }}"></div> --}}

                <div class="overlaying">

                </div>
              
            </div>

            <div
                class="   z-10 sm:w-[50%] w-full h-full  !mt-[5%] right sm:!pl-0 px-3 main-container flex sm:flex-row flex-col gap-[60px]">
                @if (isset($movie_details['main_image']))
                    <div class="card-cont ">

                        <div class="movie-card">
                            <div class="no-overflow">

                                <div class="asp asp-3-4 img-div">
                                    <img src="	{{ $movie_details['main_image'] }}" alt="" class="bg-gray-200">
                                </div>

                            </div>

                            <div class="card-bottom">
                                <div class="title">
                                    {{ $movie_details['name'] }}
                                </div>
                                <div class="flex flex-wrap gap-1">

                                    @foreach ($movie_details['genres'] as $genre)
                                        @if (isset($genre))
                                            <div class="border border-gray-300 px-3 py-1 text-[10px] rounded-full">
                                                {{ $genre['label'] }}
                                            </div>
                                        @endif
                                    @endforeach


                                </div>
                                <div>

                                    <div class="pt-1 opacity-65 font-normal text-[12px]">
                                        {{ $movie_details['duration'] }}
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                @endif

                <div class="details w-full">
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
                                        {{-- <i class="fa-regular fa-user primary-color"></i> --}}
                                        <i class="fa-regular fa-user"></i>
                                        {{-- <div class="icon">
                                            <img src="{{ $cast['image'] }}" alt="" class="bg-gray-200">
                                        </div> --}}

                                        <div class="font-bold text-[12px]">

                                            {{ $cast['name'] }}
                                        </div>
                                    </div>
                                @endforeach



                            </div>
                        </div>
                    @endif

                    <livewire:website.movie-show :slug="$slug" />
                </div>

            </div>




        </div>
    </div>
@endsection
