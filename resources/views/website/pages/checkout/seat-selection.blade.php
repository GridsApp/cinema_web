@extends('website.layouts.main')

@section('content')
    <div class="main-container main-spacing">
        <div class="flex justify-center w-full pt-7">
            @include('website.components.title', ['title' => 'Max 1 Seat Map'])
        </div>
        <div>Cart Expiration Timer:</div>
        <div id="timer" class="font-thin text-[20px]" style="font-family:'Noto Kufi Arabic';">
            @php
                // Get the expiration time from the cart
                $expirationTime = \Carbon\Carbon::parse($result['cart']->expires_at);
                $expirationTimestamp = $expirationTime->timestamp; // Get timestamp for the expiration time
            @endphp

            <!-- Display the remaining time (initially passed from PHP) -->
            <span
                id="remaining-time">{{ \Carbon\Carbon::now()->diffForHumans($expirationTime, ['parts' => 3, 'join' => ', ']) }}</span>
        </div>
        <div class="w-full flex justify-center theater-info mt-7 ">
            <div class="flex flex-row max-w-[70%] gap-20 border p-3 justify-between">

                <div class="title">
                    Movie: <span class="subtitle">
                        {{ $result['movie_show']->movie['name'] }}
                    </span>
                </div>

                <div class="title">
                    Theatre: <span class="subtitle"> {{ $result['movie_show']->theater['label'] }}</span>
                </div>

                <div class="title">
                    Time:<span class="subtitle"> {{ $result['movie_show']->time['label'] }}</span>
                </div>

                <div class="title">
                    date:<span class="subtitle">{{ $result['movie_show']->date }}</span>
                </div>
            </div>
        </div>


        <livewire:website.seat-selector :movie_show_id="$result['movie_show']->id" :theater_id="$result['movie_show']->theater_id" />



        <div class="w-full justify-center mt-7 flex">



            <div class="font-thin  text-[20px]" style="font-family:'Noto Kufi Arabic';">
                الشاشة هنا
            </div>
            <div class="relative  w-full max-w-[55%] ">
                <div
                    class="absolute right-0 bottom-0 w-0 h-0 border-l-[50px] border-l-transparent border-t-[32px] border-t-white">
                </div>
                <div
                    class="absolute left-0 bottom-0 w-0 h-0 border-r-[50px] border-r-transparent border-t-[32px] border-t-white">
                </div>
                <div class="flex justify-center tracking-[1.2px]  bg-black text-white uppercase text-[10px] p-1">
                    screen
                </div>
            </div>


            <div class="font-thin  text-[20px]" style="font-family:'Noto Kufi Arabic';">
                الشاشة هنا
            </div>
        </div>

        <div class="flex justify-center w-full pt-6">


            <div class="  max-w-[50%] flex justify-between w-full ">

                <div class="flex flex-row items-center gap-2">
                    <div>
                        @include('website.components.includes.seat')

                    </div>

                    <div>
                        <div class="capitalize font-bold text-[12px]">
                            available seats
                        </div>
                        <div style="font-family:'Noto Kufi Arabic';" class="text-[12px]">
                            مقاعد متاحة
                        </div>
                    </div>
                </div>

                <div class="flex flex-row items-center gap-2">
                    <div>
                        @include('website.components.includes.seat', ['color' => '#012DA3'])

                    </div>

                    <div>
                        <div class="capitalize font-bold text-[12px]">
                            Selected seats
                        </div>
                        <div style="font-family:'Noto Kufi Arabic';" class="text-[12px]">
                            مقاعد مختارة
                        </div>
                    </div>
                </div>


                <div class="flex flex-row items-center gap-2">
                    <div class="relative">
                        <div>
                            @include('website.components.includes.seat', ['color' => '#C51A24','reserved'=>true])
                        </div>
                        <span
                            class="absolute top-[-2px] left-0 w-full h-full flex items-center justify-center text-sm text-[#C51A24]">
                            X
                        </span>
                    </div>

                    <div>
                        <div class="capitalize font-bold text-[12px]">
                            Selected seats
                        </div>
                        <div style="font-family:'Noto Kufi Arabic';" class="text-[12px]">
                            مقاعد مختارة
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="flex w-full justify-center pt-5">

            @include('website.components.link-button', [
                'link' => route('getItems', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]),
                'text' => 'Proceed',
                'icon_visibitilty' => 'hidden',
                'class' => 'capitalize',
            ])

            {{-- <a href="{{ route('getItems', ['cinema_prefix' => request()->route('cinema_prefix'), 'language_prefix' => request()->route('language_prefix')]) }}">
                Proceed
            </a>  --}}
            {{-- <button class="fom-buttom">Proceed</button> --}}
        </div>

    </div>
@endsection
