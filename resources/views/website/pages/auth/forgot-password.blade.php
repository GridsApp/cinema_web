@extends('website.layouts.main')

@section('content')
    @php
        $cinemaPrefix = request()->route('cinema_prefix');
        $langPrefix = request()->route('language_prefix');
    @endphp
    <div class="login main-cointainer main-spacing " x-init="window.GeneralFunctions.initPhone()">


        <div class="mt-10">
            <div class="flex justify-center  w-full items-center">
                @include('website.components.title', ['title' => __('messages.forgot_password')])

            </div>
            <div class="w-full justify-center flex-col gap-6 flex items-center">

                <livewire:website.forgot-password-form :cinema-prefix="$cinemaPrefix" :lang-prefix="$langPrefix" />
              
            </div>
        </div>
    </div>
@endsection
