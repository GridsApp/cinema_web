@extends('website.layouts.main')

@section('content')
    @if (isset($slider))
        <div>
            @include('website.components.main-slideshow')

        </div>
    @endif
    <div class="mb-20">
        @include('website.components.separator-title', ['title' => 'About Us'])

    </div>

    </div>
    <div>
        @include('website.components.info-section')

    </div>
    @if (isset($branches))
        <div class="mb-20 mt-20">
            @include('website.components.separator-title', ['title' => 'cinemas'])

        </div>
        <div class="grid grid-cols-4 gap-10 main-container ">
            @foreach ($branches as $branch)
                @include('website.components.mini-card')
            @endforeach

        </div>
    @endif
    @if (isset($movies))
        <div class="mb-20 mt-20">
            @include('website.components.separator-title', ['title' => 'latest movies'])

        </div>
        <div class=" main-container">
            <div class="sm:grid-cols-4 grid-cols-2 sm:gap-5  gap-2 grid">
            @foreach ($movies as $movie)
                @include('website.components.card')
            @endforeach
            </div>
        </div>
    @endif
@endsection
