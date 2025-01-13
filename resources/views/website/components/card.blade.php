{{-- @dump($cinemaPrefix); --}}
<a
    href="{{ route('details', [
        'cinema_prefix' => $cinemaPrefix,
        'language_prefix' => $languagePrefix,
        'slug' => $movie['slug'],
    ]) }}">
    <div class="movie-card">
        <div class="movie-card">
            <div class="no-overflow">
                <div class="asp asp-2-3 img-div">
                    <img src="{{ $movie['main_image'] }}" alt="">
                </div>
            </div>
            <div class="card-bottom">
            <div class="flex flex-wrap gap-3">
                    @foreach ($movie['genres'] as $genre)
                        @if (isset($genre))
                            <div class="border border-gray-300 px-3 py-1 text-[12px] rounded-full">
                                {{ $genre['label'] }}
                            </div>
                        @endif
                    @endforeach
                </div>
                <div>
                    <div class="title">
                        {{ $movie['name'] }}
                    </div>
                    <div class="italic text-[12px]">
                        {{ $movie['duration'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
