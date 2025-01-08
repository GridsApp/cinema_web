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
        @include('website.components.mini-card')

    </div>
    @endif
    @if (isset($movies))
        <div class="mb-20 mt-20">
            @include('website.components.separator-title', ['title' => 'latest movies'])

        </div>
        {{-- <div class=" main-container">
    @include('website.components.card')

</div> --}}
    @endif
@endsection
