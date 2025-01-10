<div x-data="{ expanded: false }">
    <div class="title">
        {{ now()->format('l, F j, Y') }}
    </div>

    <div class="title">
        Select another date
    </div>

    <div class="dates-list-cont" id="dates-list-cont">
        @foreach ($dates as $date)
            <div class="date-item {{ $date['formatted'] === $selectedDate ? 'active' : '' }}"
                wire:click="selectDate('{{ $date['formatted'] }}', '{{ $currentMovieSlug }}')">
                <div class="day">{{ $date['day'] }}</div>
                <div class="d-name">{{ $date['d_name'] }}</div>
            </div>
        @endforeach
    </div>

    <div id="available-times" class="available-times mt-05 mb-20">
        @php
            // Get the first branch and the other branches
            $firstBranch = array_key_first($movieShows);
            $otherBranches = array_slice(array_keys($movieShows), 1);
        @endphp

        @if (!empty($movieShows))
            <div class="theater-data-container">
                <!-- First Branch -->
                @if ($firstBranch)
                    <h2 class="theater-name">{{ $firstBranch }}</h2>
                    @foreach ($movieShows[$firstBranch] as $priceGroup => $shows)
                        <div class="zone">{{ $priceGroup }}</div>
                        <div class="timing-list">
                            @foreach ($shows as $show)
                                <div class="time-button">
                                    <div class="flex justify-center bg-gray-100 gap-3 items-center rounded-full py-1 pl-1 pr-5">
                                        <div class="icon-seat flex justify-center bg-white items-center">
                                            <i class="fa-solid fa-loveseat"></i>
                                        </div>
                                        <span class="text-[10px] tracking-[1.9px] font-bold">{{ $show['time'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Other Branches -->
            @if ($otherBranches)
                <button @click="expanded = !expanded"
                    class="primary-color underline uppercase px-4 py-2 rounded-full mt-4 transition text-[12px] font-bold tracking-[1.9px]">
                    <i class="fa-solid fa-plus"></i>
                    <span x-show="!expanded">More theatres showtimes</span>
                    <span x-show="expanded">Show less</span>
                </button>

                <div x-show="expanded" x-collapse>
                    @foreach ($otherBranches as $branch)
                        <div class="theater-data-container mt-6">
                            <h2 class="theater-name">{{ $branch }}</h2>
                            @foreach ($movieShows[$branch] as $priceGroup => $shows)
                                <div class="zone">{{ $priceGroup }}</div>
                                <div class="timing-list">
                                    @foreach ($shows as $show)
                                        <div class="time-button">
                                            <div class="flex justify-center bg-gray-100 gap-3 items-center rounded-full py-1 pl-1 pr-5">
                                                <div class="icon-seat flex justify-center bg-white items-center">
                                                    <i class="fa-solid fa-loveseat"></i>
                                                </div>
                                                <span class="text-[10px] tracking-[1.9px] font-bold">{{ $show['time'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <div class="no-shows">
                <p class="text-gray-500">No shows available for the selected date in any branch.</p>
            </div>
        @endif
    </div>
</div>
