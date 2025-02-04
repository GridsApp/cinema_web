<div class="border flex flex-col p-6 rounded-xl border-[#E5E5E5] ">

    @php
        $seats = collect($cart_details['lines'])->where('type', 'Seat');
        $items = collect($cart_details['lines'])->where('type', 'Item');
        // Group the seats by movie_show_id
        $groupedSeats = $seats->groupBy('movie_show_id');
        $groupedItems = $items->groupBy('label');
        $total = 0;
    @endphp

    {{-- @dd($seats); --}}

    <div class="primary-color font-bold uppercase tracking-[1.5px] text-[12px]">
        Order Summary
    </div>

    @foreach ($groupedSeats as $movieShowId => $seatsGroup)
        @php

            $movieShow = \App\Models\MovieShow::find($movieShowId);

            $subtotal = $seatsGroup->sum(function ($seat) {
                return $seat['quantity'] * $seat['price']['value'];
            });
            $total += $subtotal;
        @endphp

        <div class="cart-info">
            <div class="w-[150px]">
                <div class="asp asp-3-4">
                    <img src="/images/cart-image.jpg" alt="">
                </div>
            </div>

            <div>
                <div class="name">
                    {{ $movieShow->movie['name'] }}
                </div>

                <div class="details-container">
                    <div>
                        <i class="fa-regular fa-calendar !font-normal"></i>
                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="title">
                            Date:
                        </div>
                        <div class="subtitle">
                            {{ $movieShow['date'] }}
                        </div>
                    </div>
                </div>

                <div class="details-container">
                    <div>
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="title">
                            Time:
                        </div>
                        <div class="subtitle">
                            {{ $movieShow->time['label'] }}
                        </div>
                    </div>
                </div>

                <div class="details-container">
                    <div>
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="title">
                            Theatre:
                        </div>
                        <div class="subtitle">
                            {{ $movieShow->theater['label'] }}
                        </div>
                    </div>
                </div>

                <div class="details-container">
                    <div>
                        <i class="fa-solid fa-couch"></i>
                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="title">
                            Seats:
                        </div>
                        <div class="subtitle">
                            @foreach ($seatsGroup as $seat)
                                {{ $seat['seat'] }}@if (!$loop->last)
                                    -
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="separator-line"></div>
        <div class="flex justify-between w-full pt-3 pb-3">
            <div class="font-bold text-[13px] capitalize">
                Subtotal Total
            </div>
            <div class=" font-bold uppercase text-[12px]">
                {{ number_format($subtotal, 0) }} IQD
            </div>
        </div>
    @endforeach

    <div class="separator-line"></div>

    @foreach ($groupedItems as $label => $itemsGroup)
        @php

            $totalQuantity = $itemsGroup->sum('quantity');

            $subtotal = $itemsGroup->sum(function ($item) {
                return $item['quantity'] * $item['price']['value'];
            });
            $total += $subtotal;
        @endphp

        <div class="cart-info !justify-between">
            <div class="flex flex-row justify-between">
                <div class="title pr-1">Items:</div>
                <div class="subtitle">{{ $label }}</div>
                <div class="subtitle">({{ $totalQuantity }}x)</div>
            </div>
            <div class="flex flex-row justify-between">
                {{-- <div class="title">Price:</div> --}}
                <div class="subtitle">
                    {{ number_format($subtotal, 0) }} IQD
                </div>
            </div>
        </div>


        <div class="flex justify-between w-full pt-5 pb-3">
            <div class="font-bold text-[13px] capitalize">Subtotal Total</div>
            <div class=" font-bold uppercase text-[12px]">
                {{ number_format($subtotal, 0) }} IQD
            </div>
        </div>
    @endforeach

    <div class="separator-line"></div>
    <div class="flex justify-between w-full pt-5">
        <div class="font-bold text-[13px] capitalize">Total</div>
        <div class="primary-color font-bold uppercase text-[12px]">
            {{ number_format($total, 0) }} IQD
        </div>
    </div>

</div>
