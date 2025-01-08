<div class="mt-10">
    <div class="flex sm:flex-row flex-col sm:gap-10 gap-5 filteration">
        <div class="w-full flex flex-row gap-6" class="filteration-select">
            <div>
                <select wire:model="selectedBranch"
                    class="custom-select lg:w-[400px] md:w-[400px] sm:w-full font-bold uppercase">
                    <option value="" selected>— Select Branch —</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="button" wire:click="filterMovies"
                    class="bg-primary-color text-[14px] rounded-full uppercase px-10 py-2 text-white font-bold tracking-[1.95px] hover:bg-black">
                    Go
                </button>
            </div>
        </div>

        <div class="w-full search-form-input">
            <input type="text" wire:model="searchTerm" name="term" placeholder="SEARCH FOR A MOVIE">
            <button type="submit" wire:click="filterMovies">
                <svg xmlns="http://www.w3.org/2000/svg" width="22.02" height="22.02" viewBox="0 0 22.02 22.02">
                    <g id="Icon_feather-search" data-name="Icon feather-search" transform="translate(1.5 1.5)">
                        <path id="Path_845" data-name="Path 845"
                            d="M20.855,12.677A8.177,8.177,0,1,1,12.677,4.5a8.177,8.177,0,0,1,8.177,8.177Z"
                            transform="translate(-4.5 -4.5)" fill="none" stroke="#c51a24" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="3"></path>
                        <path id="Path_846" data-name="Path 846" d="M29.421,29.421l-4.446-4.446"
                            transform="translate(-11.022 -11.022)" fill="none" stroke="#c51a24"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
                    </g>
                </svg>
            </button>
        </div>
    </div>

    <div class="mt-10">

        @if (is_null($selectedBranch) && empty($searchTerm))
            <div class="text-left w-full text-gray-500 text-[16px] font-light mt-4">
                Please choose a branch to filter the movies.
            </div>
        @elseif (collect($movies)->isEmpty())
            <div class="text-left w-full text-gray-500 text-[16px] font-light mt-4">
                No results found for the selected filters.
            </div>
        @else
            <div class="grid grid-cols-4 gap-10">
                @foreach ($movies as $movie)
                    @include('website.components.card', ['movie' => $movie])
                @endforeach
            </div>
        @endif
    </div>
</div>
