@extends('website.layouts.main')

@section('content')
   <div class="main-container main-spacing">

   <div class="flex justify-center w-full mt-10">
    @include('website.components.title',['title'=>'Cinemas'])
   </div>
    <div class="grid sm:grid-cols-4 grid-cols-1 gap-5 mt-10">
        @foreach ($branches as $branch)
        @include('website.components.mini-card')
        @endforeach
    </div>
   </div>
@endsection
