<div x-data="{ expanded: false }">
    <div class="title">
        {{ now()->format('l, F j, Y') }}
    </div>

    <div class="title">
        Select another date
    </div>

    <div class="dates-list-cont" id="dates-list-cont">
        <!-- Date list items -->
        @foreach ($dates as $date)
            <div class="date-item {{ $date['formatted'] === $selectedDate ? 'active' : '' }}"
                wire:click="selectDate('{{ $date['formatted'] }}')">
                <div class="day">{{ $date['day'] }}</div>
                <div class="d-name">{{ $date['d_name'] }}</div>
            </div>
        @endforeach
    </div>

    <div id="available-times" class="available-times mt-05 mb-20">
        @php
            $branches = array_keys($movieShows);
            $firstBranch = $branches[0];
            $otherBranches = array_slice($branches, 1);
        @endphp

        <!-- Show the first branch -->
        <div class="theater-data-container">
            <h2 class="theater-name">{{ $firstBranch }}</h2>
            @foreach ($movieShows[$firstBranch] as $priceGroup => $shows)
            {{-- @dd($shows); --}}
                <div class="zone">{{ $priceGroup }}</div>
                <div class="timing-list">
                    @foreach ($shows as $show)
                        <div class="time-button">
                            <div
                                class="flex justify-center bg-gray-100 gap-3 items-center rounded-full py-1 pl-1 pr-5">
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

        <!-- Button to expand other branches -->
        <button
            @click="expanded = !expanded"
            class="primary-color underline uppercase  px-4 py-2 rounded-full mt-4 transition text-[12px] font-bold tracking-[1.9px]">
            <i class="fa-solid fa-plus"></i>
               <span x-show="!expanded">More theatres showtimes</span>
          
            <span x-show="expanded">Show less</span>
        </button>

        <!-- Show other branches with transition -->
        <div x-show="expanded" x-collapse>
            @foreach ($otherBranches as $branch)
            @dd($branch);
                <div class="theater-data-container mt-6">
                    <h2 class="theater-name">{{ $branch }}</h2>
                    @foreach ($movieShows[$branch] as $priceGroup => $shows)
                        <div class="zone">{{ $priceGroup }}</div>
                        <div class="timing-list">
                            @foreach ($shows as $show)
                                <div class="time-button">
                                    <div
                                        class="flex justify-center bg-gray-100 gap-3 items-center rounded-full py-1 pl-1 pr-5">
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
    </div>
</div>
