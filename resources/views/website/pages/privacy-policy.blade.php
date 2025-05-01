@extends('website.layouts.main')

@section('content')
    <div class="main-container main-spacing  contact-us">

        <div class="mt-10 flex justify-center items-center">
            @include('website.components.title', ['title' => $page->label ])

        </div>


        <div>

            {!! $page->content !!}

        </div>


      
    </div>
@endsection
