@extends('website.layouts.main')

@section('content')
    @if (isset($slider))
        <div>
            @include('website.components.main-slideshow')

        </div>
    @endif

 {{-- @dd($statistics); --}}
    @if (isset($statistics) && count($statistics) > 0)
  
        <div class="sm:mb-20 mb-10 mt-10">
            @include('website.components.separator-title', ['title' => __('messages.about_us')])


        </div>


        <div>

            @include('website.components.info-section')
        </div>
    @endif
    <div>





        {{-- @include('website.components.stacked-image-paragraph') --}}
    </div>
    @if (isset($branches))
        <div class="sm:mb-14 mb-10 mt-20">
            @include('website.components.separator-title', ['title' => __('messages.cinemas')])

        </div>
        <div class="grid sm:grid-cols-4 grid-cols-1 gap-10 main-container ">
            @foreach ($branches as $branch)
                @include('website.components.mini-card')
            @endforeach

        </div>
    @endif


    <div>
        @include('website.components.banner',['aspect'=>'asp-4-1'])
    </div>

    @if (isset($movies) && count($movies) > 0)
        <div class="sm:mb-14 mb-10 mt-20">
            @include('website.components.separator-title', ['title' => 'latest movies'])

        </div>
        <div class="main-container">
            <div class="sm:grid-cols-4 grid-cols-1 sm:gap-5 gap-2 grid">
                @foreach ($movies->take(4) as $movie)
                    @include('website.components.card', [
                        'movie' => $movie,
                        'cinemaPrefix' => $cinemaPrefix,
                        'languagePrefix' => $languagePrefix,
                    ])
                @endforeach
            </div>

            @if ($movies->count() > 4)
                <div class="pt-5 text-center mt-4 flex items-center justify-center">
                    <a href="{{ route('movie-listing', [
                        'cinema_prefix' => request()->route('cinema_prefix'),
                        'language_prefix' => request()->route('language_prefix'),
                    ]) }}"
                        class="font-bold bg-primary-color text-white text-[12px] hover:bg-black tracking-[2.4px] text-center rounded-full uppercase px-10 py-3">
                        View all
                    </a>
                </div>
            @endif
        </div>
    @endif
@endsection
