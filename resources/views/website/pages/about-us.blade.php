@extends('website.layouts.main')

@section('content')
    <div class="main-container main-spacing  ">
        <div class="flex justify-center mt-10">
            @include('website.components.title', ['title' => 'About us'])
        </div>

    </div>

    <div class="mt-5">
        @include('website.components.banner')
    </div>

    <div class=" main-container">
        <div class="  flex justify-center w-full">
            <div class="max-w-[900px] mt-10 ">
                <div>
                    @include('website.components.paragraph')
                </div>

            </div>

        </div>
        <div class="mt-20">
            @include('website.components.stacked-image-paragraph')
        </div>
        <div class="mt-20">
            @include('website.components.image-paragraph')
        </div>

    </div>
    @if (isset($board_members))
        <div class="mt-20">
            @include('website.components.separator-title', ['title' => 'Board members'])
        </div>

        <div class="grid pt-10 gap-7 sm:grid-cols-4 grid-cols-1 main-container ">
            @include('website.components.members-card')
        </div>
    @endif
@endsection
