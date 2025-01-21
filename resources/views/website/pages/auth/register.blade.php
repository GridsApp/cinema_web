@extends('website.layouts.main')

@section('content')
    <div class="register main-spacing main-container" x-init="window.GeneralFunctions.initPhone()">
        <div class="mt-10">
            <div class="flex justify-center w-full items-center">
                @include('website.components.title', ['title' => 'Register'])
            </div>

            @php
                $cinemaPrefix = request()->route('cinema_prefix');
                $langPrefix = request()->route('language_prefix');
            @endphp

            <div class="w-full justify-center flex-col gap-10 flex items-center">
                <livewire:website.register-form :cinema-prefix="$cinemaPrefix" :lang-prefix="$langPrefix" />
                <p class="link-button">
                    {{ __('messages.already_have_account') }}
                    <span>
                        <a class="primary-color underline"
                            href="{{ route('login-web', [
                                'cinema_prefix' => request()->route('cinema_prefix'),
                                'language_prefix' => request()->route('language_prefix'),
                            ]) }}">
                            {{ __('messages.sign_in') }}
                        </a>
                    </span>
                </p>
                
            </div>
        </div>
    </div>
@endsection
