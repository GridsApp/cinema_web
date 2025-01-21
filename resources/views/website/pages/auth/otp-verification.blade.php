@extends('website.layouts.main')

@section('content')
    <div class="main-container main-spacing">
        <div class="mt-10">
            <div class="flex justify-center w-full items-center">
                @include('website.components.title', ['title' => 'Verify OTP'])
            </div>
            <div class="w-full justify-center flex-col gap-6 flex items-center">
                <livewire:website.otp-verification-form  :cinema-prefix="$cinemaPrefix" :lang-prefix="$langPrefix" />
            </div>
        </div>
    </div>
@endsection
