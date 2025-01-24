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
                                                {{ \Carbon\Carbon::parse($order['date'])->format('F d, Y') }}</div>
                                            <div class="info-title">{{ $order['total']['display'] ?? '-' }}</div>
                                            <div class="icon-container">
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>
                                        </div>
                                        <div class="item-body">
                                            <div class="list-details">

                                                @if ($order['lines']->where('type', 'Seat')->isNotEmpty())
                                                    <div class="list-section">
                                                        <div class="section-title">Seats</div>
                                                        @foreach ($order['lines']->where('type', 'Seat') as $line)
                                                            <div class="grid grid-cols-2">
                                                                <div class="listing-items">
                                                                    <div>
                                                                        <div class="title">Movie</div>
                                                                        <div class="subtitle">{{ $line['movie_name'] }}
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="title">Theater</div>
                                                                        <div class="subtitle">{{ $line['theater'] }}</div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="title">Date</div>
                                                                        <div class="subtitle">
                                                                            {{ \Carbon\Carbon::parse($line['date'])->format('F d, Y') }}
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="title">Time</div>
                                                                        <div class="subtitle">
                                                                            {{ \Carbon\Carbon::parse($line['date'])->format('h:i a') }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="listing-items">
                                                                    <div>
                                                                        <div class="title">Seats</div>
                                                                        <div class="subtitle">{{ $line['seats'] }}</div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="title">Price</div>
                                                                        <div class="subtitle">
                                                                            {{ $line['price']['display'] }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif


                                                @if ($order['lines']->where('type', 'Item')->isNotEmpty())
                                                    <div class="list-section">
                                                        <div class="section-title">Items</div>
                                                        @foreach ($order['lines']->where('type', 'Item') as $line)
                                                            <div class="grid grid-cols-2">
                                                                <div class="listing-items">
                                                                    <div>
                                                                        <div class="title">Item</div>
                                                                        <div class="subtitle">{{ $line['label'] }}</div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="title">Quantity</div>
                                                                        <div class="subtitle">{{ $line['quantity'] }}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="listing-items">
                                                                    <div>
                                                                        <div class="title">Price</div>
                                                                        <div class="subtitle">
                                                                            {{ $line['price']['display'] }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if ($order['lines']->where('type', 'Topup')->isNotEmpty())
                                                    <div class="list-section">
                                                        <div class="section-title">TopUps</div>
                                                        @foreach ($order['lines']->where('type', 'Topup') as $line)
                                                            <div class="grid grid-cols-2 ">
                                                                <div class="listing-items">
                                                                    <div>
                                                                        <div class="title">Topup</div>
                                                                        <div class="subtitle">{{ $line['label'] }}</div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="title">Quantity</div>
                                                                        <div class="subtitle">{{ $line['quantity'] }}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="listing-items">
                                                                    <div>
                                                                        <div class="title">Price</div>
                                                                        <div class="subtitle">
                                                                            {{ $line['price']['display'] }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="order-summary">
                                                <div class="body-title">{{ __('tables.order_summary') }}</div>
                                                <div class="grid grid-cols-12">
                                                    <div class="col-span-4">
                                                        <div class="body-item head">{{ __('tables.product') }}</div>
                                                        @foreach ($order['lines'] as $line)
                                                            <div class="body-item body">{{ $line['label'] }}</div>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-span-4">
                                                        <div class="body-item head">{{ __('tables.quantity') }}</div>
                                                        @foreach ($order['lines'] as $line)
                                                            <div class="body-item body">{{ $line['quantity'] }}</div>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-span-4">
                                                        <div class="body-item head">{{ __('tables.price') }}</div>
                                                        @foreach ($order['lines'] as $line)
                                                            <div class="body-item body">{{ $line['price']['display'] }}
                                                            </div>
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
