@extends('website.layouts.main')

@section('content')
    <div class="account main-spacing main-container" x-init="window.GeneralFunctions.initPhone()">
        <div class="mt-10">
            <div class="account-page">

                <div class="col-span-4 left">
                    <livewire:website.profile-info :cinema-prefix="$cinemaPrefix" :lang-prefix="$languagePrefix" />
                </div>

                <div class="col-span-8 favorites">
                    <div class="pb-5">
            @include('website.components.title', ['title' => __('messages.my_favorites')])

                       
                    </div>
                    @if ($movies->isEmpty())
                        <p class="empty-text">  {{ __('messages.no_movies') }}</p>
                    @else
                        <div class="grid sm:grid-cols-4 grid-cols-2 gap-7">
                            @foreach ($movies as $movie)
                                @include('website.components.card', [
                                    'movie' => $movie,
                                    'cinemaPrefix' => $cinemaPrefix,
                                    'languagePrefix' => $languagePrefix,
                                ])
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
