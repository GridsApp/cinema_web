@extends('website.layouts.main')

@section('content')
    <div class="account main-spacing main-container" x-init="window.GeneralFunctions.initPhone()">
        <div class="mt-10">
            {{-- @php
                $cinemaPrefix = request()->route('cinema_prefix');
                $langPrefix = request()->route('language_prefix');
            @endphp --}}

            <div class="account-page">

                <div class="col-span-4 left">
                    <livewire:website.profile-info :cinema-prefix="$cinemaPrefix" :lang-prefix="$languagePrefix" />

                </div>


                <div class="col-span-8 ">

                    <div class="flex flex-col gap-7">
                        <div>
                            @include('website.components.title', ['title' => __('tables.recharge_wallet')])

                        </div>

                        <div>
                            <button type="submit" class="form-button">{{ __('tables.recharge_wallet') }}</button>
                        </div>

                    </div>
                    <div class="pb-4 pt-16">
                        @include('website.components.title', ['title' => __('tables.transaction_history')])
                    </div>
                    {{-- @dd($transactions); --}}
                    @if (empty($transactions))
                        <p class="empty-text">
                            {{ __('tables.no_transaction') }}</p>
                    @else
                        <div>
                            <table class="custom-table equal">
                                <thead>
                                    <tr>
                                        <th>{{ __('tables.date') }}</th>
                                        <th>{{ __('tables.amount') }}</th>
                                        <th>{{ __('tables.type') }}</th>
                                        <th>{{ __('tables.description') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if (isset($transactions))
                                        @foreach ($transactions as $transaction)
                                            {{-- @dd($transaction); --}}
                                            <tr>
                                                <td>{{ $transaction['date'] }}</td>
                                                <td>
                                                    {{ $transaction['amount'] }}
                                                </td>
                                                <td>
                                                    {{ $transaction['type'] }}
                                                </td>
                                                <td>
                                                    {{ $transaction['description'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
