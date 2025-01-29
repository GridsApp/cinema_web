<div x-data="{
    selectedDate: '{{ $selectedDate }}',
    selectedTime: '',
    movieShowId: '',
    selectedShowId: '',
    showConfirmPopup: false
}">
    <!-- Display Current Date -->
    <div class="title">
        {{ now()->format('l, F j, Y') }}
    </div>

    <!-- Select another date -->
    <div class="title pt-5">
        Select another date
    </div>

    <!-- Dates List -->
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

    <!-- Available Show Times -->
    <div id="available-times" class="available-times mt-05 mb-5">
        @if (isset($movieShows['message']))
            <div
                class="bg-primary-color rounded-full text-white font-bold text-[12px] tracking-[1.9px] w-fit px-10 py-2">
                {{ $movieShows['message'] }}
            </div>
        @else
            @if (!empty($movieShows[$firstBranch]))
                <div class="theater-data-container">
                    <h2 class="theater-name">{{ $firstBranch }}</h2>

                    @foreach ($movieShows[$firstBranch] as $priceGroup => $shows)
                        <div class="zone">{{ $priceGroup }}</div>
                        <div class="timing-list">
                            @foreach ($shows as $show)
                                {{-- @dump($show); --}}
                                @php
                                    $nb_seats = $show['theater']->nb_seats;
                                    $reserved_seats = $nb_seats - $show['available_seats'];
                                    $percentage = ($show['available_seats'] / $nb_seats) * 100;
                                @endphp
                                <div class="time-button"
                                    @click="
                                   selectedTime = '{{ $show['time'] }}'; 
                                   selectedShowId = '{{ $show['id'] }}'; 
                                   window.history.pushState({}, '', '?date=' + selectedDate + '&time=' + selectedTime);
                               ">
                                    <div class="flex justify-center bg-gray-100 gap-3 items-center rounded-full pr-5">
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
            @else
                <div class="theater-data-container">
                    <div class="theater-name">{{ $firstBranch }}</div>
                    <p
                        class="bg-primary-color rounded-full text-white font-bold text-[12px] tracking-[1.9px] w-fit px-10 py-2">
                        No show times available !!
                    </p>
                </div>
            @endif
        @endif
    </div>

    <!-- Other Branches -->
    @if (!empty($otherBranches))
        <div x-data="{ showMore: false }">
            <button @click="showMore = !showMore"
                class="mt-3 underline primary-color uppercase tracking-[1.9px] text-[12px] font-bold">
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
                                    {{-- @dump($show); --}}
                                    @php
                                        $nb_seats = $show['theater']->nb_seats;
                                        $reserved_seats = $nb_seats - $show['available_seats'];
                                        $percentage = ($show['available_seats'] / $nb_seats) * 100;
                                    @endphp
                                    <div class="time-button"
                                        @click="
                                      selectedTime = '{{ $show['time'] }}'; 
                                      selectedShowId = '{{ $show['id'] }}'; 
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

    <!-- Choose Your Seats Button -->
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
            <button type="button" @click="showConfirmPopup = true" class="form-button">
                Choose Your Seats
            </button>
        @endif
    </div>

    <!-- Confirmation Popup -->
    {{-- <div x-show="showConfirmPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-5 rounded-lg shadow-lg text-center w-[400px]">
            <h2 class="text-lg font-bold">Are you sure?</h2>
            <p class="mt-2">
                Are you sure you want to book your ticket for <span class="font-bold" x-text="selectedTime"></span> on
                <span class="font-bold" x-text="selectedDate"></span>?
            </p>
            <div class="mt-5 flex justify-center gap-3">
                <button type="button"
                    @click="
            selectedShowId = selectedShow.id;
            showConfirmPopup = true;
        "
                    class="form-button">
                    Choose Your Seats
                </button>

                <div x-show="showConfirmPopup"
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white p-5 rounded-lg shadow-lg text-center w-[400px]">
                        <h2 class="text-lg font-bold">Are you sure?</h2>
                        <p class="mt-2">
                            Are you sure you want to book your ticket for <span class="font-bold"
                             ></span> at
                         
                            <span class="font-bold" x-text="selectedDate + ' at ' + selectedTime"></span>?
                        </p>

                        <div class="mt-5 flex justify-center gap-3">
                            <button type="button"
                                @click="
                                selectedShowId = selectedShow.id;
                    showConfirmPopup = true;
                ">
                                Choose Your Seats
                            </button>

                            <div x-show="showConfirmPopup"
                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                <div class="bg-white p-5 rounded-lg shadow-lg text-center w-[400px]">
                                    <h2 class="text-lg font-bold">Are you sure?</h2>
                                    <p class="mt-2">
                                        Booking for <span class="font-bold" }></span> at
                                       <span class="font-bold" x-text="selectedDate + ' at ' + selectedTime"></span>?
                                    </p>

                                    <div class="mt-5 flex justify-center gap-3">
                                        <button @click="showConfirmPopup = false"
                                            class="bg-gray-300 px-4 py-2 rounded">Go Back</button>

                                        <form method="POST"
                                            :action="`/{{ request()->route('cinema_prefix') }}/{{ request()->route('language_prefix') }}/checkout/seat/selection`">
                                            @csrf
                                            <input type="hidden" name="movieshow_id" :value="selectedShowId">
                                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Yes,
                                                Proceed</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}

    <!-- Confirmation Popup -->
    <div x-show="showConfirmPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-5 rounded-lg shadow-lg text-center w-[400px]">
            <h2 class="text-lg font-bold">Are you sure?</h2>
            <p class="mt-2">
                Booking for <span class="font-bold">{{ $movieTitle ?? 'this movie' }}</span> at
                <span class="font-bold" x-text="selectedDate + ' at ' + selectedTime"></span>?
            </p>

            <div class="mt-5 flex flex-col justify-center gap-3">

                <form method="POST"
                    :action="`/{{ request()->route('cinema_prefix') }}/{{ request()->route('language_prefix') }}/checkout/seat/selection`">
                    
                    @csrf
                    <input type="hidden" name="movie_show_id" :value="selectedShowId">

                    <button type="submit" class="form-button">Yes, proceed</button>
                </form>

                <button @click="showConfirmPopup = false" class="underline px-4 py-2 primary-color text-[12px] font-bold uppercase tracking-[1.2px]">Go Back</button>

            </div>
        </div>
    </div>


</div>
