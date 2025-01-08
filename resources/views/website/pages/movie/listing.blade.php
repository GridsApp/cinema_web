@extends('website.layouts.main')

@section('content')

<div class=" main-container main-spacing">

    <div class="flex justify-center items-center pt-6">
        @include('website.components.title',['title'=>'WHAT’S ON'])
    </div>
 <div>
    <livewire:website.movie-listing />
 </div>
</div>
@endsection