<div>
    <div class="title">
        {{ now()->format('l, F j, Y') }}
    </div>

    <div class="title pt-5">
        Select another date
    </div>

    <div class="dates-list-cont" id="dates-list-cont">
        @foreach ($dates as $date)
            <div class="date-item {{ $date['formatted'] === $selectedDate ? 'active' : '' }}"
                wire:click="selectDate('{{ $date['formatted'] }}')">
                <div class="day">{{ $date['day'] }}</div>
                <div class="d-name">{{ $date['d_name'] }}</div>
            </div>
        @endforeach
    </div>

    <div id="available-times" class="available-times mt-05 mb-20">
        @if ($movieShows)
            <div class="theater-data-container">
                <h2 class="theater-name">{{ $firstBranch }}</h2>
    
                @foreach ($movieShows as $priceGroup => $shows)
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
        @else
            <div class="no-available-times">
                <p>No Available Times</p>
            </div>
        @endif
    
        @if ($otherBranches)
            <button @click="expanded = !expanded" class="primary-color text-[12px] uppercase underline font-bold px-4 py-2 rounded-full mt-4 transition">
                <i class="fa-solid fa-plus"></i>
                <span x-show="!expanded">More theatres showtimes</span>
                <span x-show="expanded">Show less</span>
            </button>
    
            <div x-show="expanded" x-collapse>
                @foreach ($otherBranches as $branchLabel => $branchShows)
                @dd($branchShows)
                    <div class="theater-data-container mt-6">
                        <h2 class="theater-name">{{ $branchLabel }}</h2>
                        @foreach ($branchShows as $priceGroup => $shows)
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
    </div>
    
</div>
