@extends('website.layouts.main')

@section('content')
    <div class="account main-spacing main-container" x-init="window.GeneralFunctions.initPhone()">
        <div class="mt-10">
            @php
                $cinemaPrefix = request()->route('cinema_prefix');
                $langPrefix = request()->route('language_prefix');
            @endphp

            <div class="account-page">

                <div class="sm:col-span-4 col-span-12 left">
                    <livewire:website.profile-info :cinema-prefix="$cinemaPrefix" :lang-prefix="$langPrefix" />

                </div>


                <livewire:website.user.user-profile-update :cinema-prefix="$cinemaPrefix" :lang-prefix="$langPrefix" />


            </div>
        </div>
    @endsection
