@extends('website.layouts.main')

@section('content')
    @php
        $cinemaPrefix = request()->route('cinema_prefix');
        $langPrefix = request()->route('language_prefix');
    @endphp
    <div class="login main-cointainer main-spacing " x-init="window.GeneralFunctions.initPhone()">


        <div class="mt-10">
            <div class="flex justify-center  w-full items-center">
                @include('website.components.title', ['title' => 'sign in'])
            </div>
            <div class="w-full justify-center flex-col gap-6 flex items-center">

                <livewire:website.sign-in-form :cinema-prefix="$cinemaPrefix" :lang-prefix="$langPrefix" />
                <p class="link-button">
                    {{ __('messages.dont_have_account') }} 
                    <span>
                        <a class="primary-color underline"
                            href="{{ route('register-web', [
                                'cinema_prefix' => request()->route('cinema_prefix'),
                                'language_prefix' => request()->route('language_prefix'),
                            ]) }} ">
                            {{ __('messages.register') }}
                        </a>
                    </span>
                </p>
                
            </div>
        </div>
    </div>
@endsection
