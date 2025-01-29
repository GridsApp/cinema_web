<div  x-data="{
    selectedDate: '{{ request()->get('date', now()->format('Y-m-d')) }}', 
    selectedTime: '{{ request()->get('time', '') }}', 
    showConfirmPopup: false 
}"
x-init="
 
    const urlParams = new URLSearchParams(window.location.search);
    selectedDate = urlParams.has('date') ? urlParams.get('date') : selectedDate;
    selectedTime = urlParams.has('time') ? urlParams.get('time') : selectedTime;
">

    <div class="title">
        {{ now()->format('l, F j, Y') }}
    </div>


    <div class="title pt-5">
        Select another date
    </div>


    <div class="dates-list-cont pt-3" id="dates-list-cont">
        @foreach ($dates as $date)
            <div class="date-item {{ $date['formatted'] === $selectedDate ? 'active' : '' }}"
                wire:click="selectDate('{{ $date['formatted'] }}')"
                @click="
                selectedDate = '{{ $date['formatted'] }}'; 
                window.history.pushState({}, '', '?date=' + selectedDate + '&time=' + selectedTime);
            ">

                <div class="d-name">{{ $date['d_name'] }}</div>
                <div class="day">{{ $date['day'] }}</div>
            </div>
        @endforeach
    </div>

    <div id="available-times" class="available-times mt-05 mb-5">
        @if (isset($movieShows['message']))

            <div
                class="bg-primary-color rounded-full text-white font-bold text-[12px] tracking-[1.9px] w-fit px-10 py-2">
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
                                    <div class="time-button"
                                        @click="
                                       selectedTime = '{{ $show['time'] }}'; 
                                       window.history.pushState({}, '', '?date=' + selectedDate + '&time=' + selectedTime);
                                   ">
                                        <div
                                            class="flex justify-center bg-gray-100 gap-3 items-center rounded-full pr-5">
                                            <div class="icon-seat border-2 flex justify-center bg-white items-center rounded-full relative"
                                                style="width: 40px; height: 40px; background: conic-gradient(#c51a24 {{ 100 - $percentage }}%, white {{ 100 - $percentage }}%);">
                                                <i class="fa-solid fa-loveseat z-10"></i>
                                                <div class="absolute bg-white rounded-full"
                                                    style="width: 30px; height: 30px;"></div>
                                            </div>
                                            <span class="text-[10px] tracking-[1.9px] font-bold">
                                                {{ $show['time'] }}
                                            </span>
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
                                    @php
                                        // dd($show['theater']);
                                        $nb_seats = $show['theater']->nb_seats;

                                        $reserved_seats = $nb_seats - $show['available_seats'];

                                        $percentage = ($show['available_seats'] / $nb_seats) * 100;

                                    @endphp
                                    <div class="time-button"
                                        @click="
                                        selectedTime = '{{ $show['time'] }}'; 
                                        window.history.pushState({}, '', '?date=' + selectedDate + '&time=' + selectedTime);
                                    ">
                                        <div
                                            class="flex justify-center bg-gray-100 gap-3 items-center rounded-full pr-5">
                                            <div class="icon-seat border-2 flex justify-center bg-white items-center rounded-full relative"
                                                style="width: 40px; height: 40px; background: conic-gradient(#c51a24 {{ 100 - $percentage }}%, white {{ 100 - $percentage }}%);">
                                                <i class="fa-solid fa-loveseat z-10"></i>
                                                <div class="absolute bg-white rounded-full"
                                                    style="width: 30px; height: 30px;"></div>
                                            </div>
                                            <span class="text-[10px] tracking-[1.9px] font-bold">
                                                {{ $show['time'] }}
                                            </span>
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

    <div class="mt-5">
        @if (!session('user'))
            <div class="w-fit">
                @include('website.components.link-button', [
                    'link' => route('login-web', [
                        'cinema_prefix' => request()->route('cinema_prefix'),
                        'language_prefix' => request()->route('language_prefix'),
                    ]),
                    'text' => __('messages.sign_in'),
                    'icon_visibitilty' => '!hidden',
                ])
            </div>
        @else
            <button type="button" @click="
            showConfirmPopup = true; " class="form-button">
                Choose Your Seats
            </button>
        @endif
    </div>

   
 
</div>
