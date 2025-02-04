<div x-data="{ cartSeats: [] }">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-center mt-5">
        <div class="grid gap-2 p-4"
            style="display: grid; grid-template-columns: minmax(30px, 1fr) repeat({{ count($result['columns']) }}, minmax(30px, 1fr));">


            @foreach ($result['rows'] as $row)
                <div class="flex items-center justify-center text-center text-[12px] font-bold primary-color">
                    {{ $row }}
                </div>
                @foreach ($result['columns'] as $column)
                    @php
                        $seatCode = $row . $column;
                        $seat = $result['map'][$seatCode] ?? null;
                    @endphp

                    @if ($column === '')
                        <div class="w-7 h-7"></div>
                    @elseif($seat)
                        {{-- @dump($seat); --}}
                        {{-- @dump($seat['selected']); --}}
                        <div class="relative">
                            <button wire:click="addSeatToCart('{{ $seat['code'] }}')" class="seat-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30.369" height="20.585"
                                    viewBox="0 0 34.369 31.585">
                                    <g id="noun-seat-2029648" transform="translate(0)">
                                        <path id="Path_828" data-name="Path 828" d="M168.74,365.22h20.094v7H168.74Z"
                                            transform="translate(-161.602 -340.634)"
                                            fill="{{ $seat['selected'] ? '#012DA3' : ($seat['reserved'] ? '#C51A24' : $seat['color']) }}"
                                            fill-rule="evenodd" />
                                        <path id="Path_829" data-name="Path 829"
                                            d="M144.461,0h18.131a3,3,0,0,1,2.766,3.212v7.495a4.025,4.025,0,0,0-1.537,3.391v8.138H143.232V14.1a4.024,4.024,0,0,0-1.537-3.391V3.212A3,3,0,0,1,144.461,0Z"
                                            transform="translate(-136.341)"
                                            fill="{{ $seat['selected'] ? '#012DA3' : ($seat['reserved'] ? 'rgba(197, 26, 36, 0.1)' : $seat['color']) }}"
                                            fill-rule="evenodd" />
                                        <path id="Path_830" data-name="Path 830"
                                            d="M65.884,167.578v18.148H60.53V167.578C60.53,164.175,65.884,164.175,65.884,167.578Z"
                                            transform="translate(-60.53 -154.14)"
                                            fill="{{ $seat['selected'] ? '#012DA3' : ($seat['reserved'] ? '#C51A24' : $seat['color']) }}"
                                            fill-rule="evenodd" />
                                        <path id="Path_831" data-name="Path 831"
                                            d="M544.723,167.578v18.148H539.37V167.578C539.37,164.175,544.723,164.175,544.723,167.578Z"
                                            transform="translate(-510.354 -154.14)"
                                            fill="{{ $seat['selected'] ? '#012DA3' : ($seat['reserved'] ? '#C51A24' : $seat['color']) }}"
                                            fill-rule="evenodd" />
                                    </g>
                                </svg>

                            </button>


                            {{-- @dump($seat['reserved']) --}}
                            {{-- If seat is reserved, overlay a red "X" --}}
                            @if ($seat['reserved'])
                                <span
                                    class="absolute top-[-6px] left-0 w-full h-full flex items-center justify-center text-sm text-[#C51A24]">
                                    X
                                </span>
                            @endif

                            <span class="absolute text-[10px] font-light"
                                style="top: -13px; left: 50%; transform: translateX(-50%);">{{ $seat['code'] }}</span>
                        </div>
                    @else
                        <div class="w-7 h-7 bg-gray-300"></div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>






</div>
