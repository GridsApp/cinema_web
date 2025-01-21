@extends('website.layouts.main')

@section('content')
    {{-- @dd($allOrders); --}}
    <div class="account main-spacing main-container" x-init="window.GeneralFunctions.initPhone()">
        <div class="mt-10">


            <div class="account-page">

                <div class="col-span-4 left">
                    <livewire:website.profile-info :cinema-prefix="$cinemaPrefix" :lang-prefix="$languagePrefix" />

                </div>

              
                    <div class="col-span-8 history">
                        <div>
                            @include('website.components.title', [
                                'title' => __('tables.purchase_history'),
                            ])
                        </div>

                        @if (empty($allOrders))
                        <p class="empty-text">{{ __('tables.no_orders_found') }}</p>
                    @else

                        <div class="request-quotations" x-data="{ activeItem: null }">
                            <div class="table-head">
                                <div class="head-item">{{ __('tables.order_number') }}</div>
                                <div class="head-item">{{ __('tables.date') }}</div>
                                <div class="head-item">{{ __('tables.price') }}</div>
                            </div>
                            <div class="table-body">
                                @foreach ($allOrders as $order)
                                    <div class="item"
                                        @click="activeItem === {{ $loop->index }} ? activeItem = null : activeItem = {{ $loop->index }}"
                                        :class="{ 'active': activeItem === {{ $loop->index }} }">
                                        <div class="item-head">
                                            <div class="info-title">#{{ $order['order_id'] }}</div>
                                            <div class="info-title">
                                                {{ \Carbon\Carbon::parse($order['date'])->format('m/d/Y') }}</div>
                                            <div class="info-title">{{ $order['total']['display'] ?? '-' }}</div>
                                            <div class="icon-container">
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>
                                        </div>

                                        <div class="item-body">
                                            <div class="list-details">
                                                @foreach ($order['lines'] as $line)
                                                    @if ($line['type'] === 'Seat')
                                                        <div class="name">{{ $line['movie_name'] }}</div>
                                                        <div class="grid grid-cols-2">
                                                            <div class="listing-items">
                                                                <div>
                                                                    <div class="title">Order number</div>
                                                                    <div class="subtitle">#{{ $order['order_id'] }}</div>
                                                                </div>
                                                                <div>
                                                                    <div class="title">Theatre</div>
                                                                    <div class="subtitle">{{ $line['theater'] }}</div>
                                                                </div>
                                                                <div>
                                                                    <div class="title">Date</div>
                                                                    <div class="subtitle">
                                                                        {{ \Carbon\Carbon::parse($line['date'])->format('m/d/Y') }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="listing-items">
                                                                <div>
                                                                    <div class="title">Payment</div>
                                                                    <div class="subtitle">{{ $order['payment_method'] }}
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="title">Seats</div>
                                                                    {{-- @dd($line['seats']); --}}
                                                                    {{-- $order_seat->seats --}}
                                                                    <div class="subtitle">{{ $line['seats'] ?? [] }}</div>
                                                                </div>
                                                                <div>
                                                                    <div class="title">Time</div>
                                                                    <div class="subtitle">
                                                                        {{ \Carbon\Carbon::parse($line['date'])->format('h:i a') }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>

                                            <div class="order-summary">
                                                <div class="body-title">{{ __('tables.order_summary') }}</div>

                                                <div class="grid grid-cols-12">
                                                    <div class="col-span-4">
                                                        <div class="body-item head">{{ __('tables.product') }}</div>
                                                        @foreach ($order['lines'] as $line)
                                                            @if ($line['type'] === 'Seat' || $line['type'] === 'Item')
                                                                <div class="body-item body">{{ $line['label'] }}</div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="col-span-4">
                                                        <div class="body-item head">{{ __('tables.quantity') }}</div>

                                                        @foreach ($order['lines'] as $line)
                                                            @if ($line['type'] === 'Seat' || $line['type'] === 'Item')
                                                                <div class="body-item body">{{ $line['quantity'] }}</div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="col-span-4">
                                                        <div class="body-item head">{{ __('tables.price') }}</div>
                                                        @foreach ($order['lines'] as $line)
                                                            @if ($line['type'] === 'Seat' || $line['type'] === 'Item')
                                                                <div class="body-item body">{{ $line['price']['display'] }}
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
           
            </div>
        </div>
    @endsection
