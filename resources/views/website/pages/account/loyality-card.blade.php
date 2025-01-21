@extends('website.layouts.main')

@section('content')
    @php
        $cinemaPrefix = request()->route('cinema_prefix');
        $langPrefix = request()->route('language_prefix');
    @endphp
    <div class="account main-spacing main-container" x-data="{ activeTab: 'loyalty' }" x-init="window.GeneralFunctions.initPhone()">
        <div class="mt-10">
            <div class="account-page">

                <div class="col-span-4 left">
                    <livewire:website.profile-info :cinema-prefix="$cinemaPrefix" :lang-prefix="$languagePrefix" />
                </div>
                <div class="col-span-8 ">
                    <livewire:website.user.loyalty-rewards-component :cinema-prefix="$cinemaPrefix" :lang-prefix="$langPrefix" />
                </div>

            </div>
        </div>
    @endsection
