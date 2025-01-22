

<a
    @if(!empty($movie['slug']))
        href="{{ route('details', [
            'cinema_prefix' => $cinemaPrefix,
            'language_prefix' => $languagePrefix,
            'slug' => $movie['slug'],
        ]) }}"
    @else
        href="#"
    @endif>
    <div class="movie-card">
        <div class="movie-card">
            <div class="no-overflow">
                <div class="asp asp-3-4 img-div">
                    <img src="{{ $movie['main_image'] }}" alt="">
                </div>
            </div>
            <div class="card-bottom">
            <div class="genres ">
                    @foreach ($movie['genres'] as $genre)
                        @if (isset($genre))
                            <div class="genres-text">
                                {{ $genre['label'] }}
                            </div>
                        @endif
                    @endforeach
                </div>
                <div>
                    <div class="title">
                        {{ $movie['name'] }}
                    </div>
                    <div class="opacity-65 font-normal text-[12px]">
                        {{ $movie['duration'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
