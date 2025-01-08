{{-- <div x-data="{ showAll: false }"> --}}


    {{-- @foreach ($movies as $index => $movie) --}}
    {{-- @dd($movie) --}}
    <div class="movie-card">
        <div {{-- x-show="showAll || {{ $index }} < 4" --}} class="movie-card">
            <div class="no-overflow">

                <div class="asp asp-2-3 img-div">
                    <img src="{{ $movie['main_image'] }}" alt="">
                </div>

            </div>

            <div class="card-bottom">
                <div class="flex flex-wrap gap-3">

                    {{-- @foreach ($movie['genres'] as $genre)
                       
                        @if (isset($genre))
                            <div class="border border-gray-300 px-3 py-1 text-[12px] rounded-full">
                                {{ $genre['label'] }}
                            </div>
                        @endif
                    @endforeach --}}



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
    {{-- @endforeach --}}

{{-- @if (count($movies) > 4)
        <div class="text-center mt-4 flex items-center justify-center">
            <button @click="showAll = true" x-show="!showAll" class="font-bold bg-primary-color text-white text-[12px] hover:bg-black tracking-[2.4px] text-center  rounded-full uppercase px-10 py-2">
                View all
            </button>
        </div>
    @endif --}}
{{-- </div> --}}
