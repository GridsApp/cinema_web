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

                <div class="d-name">{{ $date['d_name'] }}</div>
                <div class="day">{{ $date['day'] }}</div>
            </div>
        @endforeach
    </div>


    <div id="available-times" class="available-times mt-05 mb-5">
        @if (isset($movieShows['message']))

            <div class="alert alert-warning">
                {{ $movieShows['message'] }}
            </div>
        @else
            {{-- @dump(!empty($movieShows[$firstBranch])); --}}
            @if (!empty($movieShows[$firstBranch]))
                <div class="theater-data-container">
                    <h2 class="theater-name">{{ $firstBranch }}</h2>


                    @if (isset($movieShows[$firstBranch]) && count($movieShows[$firstBranch]) > 0)
                        @foreach ($movieShows[$firstBranch] as $priceGroup => $shows)
                            <div class="zone">{{ $priceGroup }}</div>
                            <div class="timing-list">
                              

                                @foreach ($shows as $show)
                                {{-- @dd($shows); --}}
                                    @php
                                    // dd($show['theater']);
                                        $nb_seats = $show['theater']->nb_seats;

                                        // dd($show['theater'] );
                                        $reserved_seats = $nb_seats - $show['available_seats'];
                                       
                                        $percentage = ($show['available_seats'] / $nb_seats) * 100;

                                        // dd($percentage);
                                    @endphp
                                    <div class="time-button">
                                        <div
                                            class="flex justify-center bg-gray-100 gap-3 items-center rounded-full py-1 pl-1 pr-5">
                                            <div class="icon-seat border-2 border-red-600 flex justify-center bg-white items-center">
                                                <i class="fa-solid fa-loveseat"></i>
                                            </div>
                                            {{-- @dd($show); --}}
                                            <span
                                                class="text-[10px] tracking-[1.9px] font-bold">{{ $show['time'] }}</span>
                                                {{-- <p>Available seats percentage for the show: {{ number_format($percentage, 2) }}%</p> --}}
                                             

                                            <div>
                                                {{-- {{ $show['available_seats'] / $show['theater']->nb_seats * 360 }} --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                    @endif
                </div>
            @else
                {{-- @dump($firstBranch); --}}
                <div class="theater-data-container">
                    <div class="theater-name">{{ $firstBranch }}</div>
                    <p
                        class="bg-primary-color rounded-full text-white font-bold text-[12px] tracking-[1.9px] w-fit px-10 py-2">
                        No show times available !!</p>
                </div>
            @endif
        @endif
    </div>

    @if (!empty($otherBranches))
        <div x-data="{ showMore: false }">
            <button @click="showMore = !showMore"
                class="mt-3 underline primary-color uppercase tracking-[1.9px] text-[12px] font-bold">
                <!-- Toggle icon between + and - -->
                <i class="fa-solid" :class="showMore ? 'fa-minus' : 'fa-plus'"></i>
                More theatres showtimes
            </button>
            <div x-show="showMore">
                @foreach ($otherBranches as $branchName => $priceGroups)
                    <div class="theater-data-container">
                        <h2 class="theater-name">{{ $branchName }}</h2>
                        @foreach ($priceGroups as $priceGroup => $shows)
                            <div class="zone">{{ $priceGroup }}</div>
                            <div class="timing-list">
                                @foreach ($shows as $show)
                                    {{-- @php
                                        $theater = $show-?;
                                        dd($theater);
                                        $nb_seats = $show->theater->nb_seats;
                                    @endphp --}}
                                    <div class="time-button">
                                        <div
                                            class="flex justify-center bg-gray-100 gap-3 items-center rounded-full py-1 pl-1 pr-5">
                                            <div class="icon-seat flex justify-center bg-white items-center">
                                                <i class="fa-solid fa-loveseat"></i>
                                            </div>
                                            <span
                                                class="text-[10px] tracking-[1.9px] font-bold">{{ $show['time'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

    @endif
</div>
