<div>


    <style>
        .twa-table tbody tr td:first-child {
            background-color: transparent !important;

        }

        .twa-table tbody tr td:last-child {
            position: unset !important;
        }
    </style>

    <div class="flex flex-col gap-5">



    @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'Payment Lookup'])
        <form wire:key="{{ uniqid() }}" method="POST" wire:submit.prevent="searchPaymentReference">
            @csrf

            <div class="mb-5">

                {!! field('payment_ref') !!}
            </div>

            <div class="flex gap-4 items-center justify-start">
                <button type="submit" class="btn btn-primary"> Search </button>

                <button type="button" class="btn btn-secondary" wire:click="handleClear">  Clear</button>

            </div>

        </form>

    @endcomponent


        @if($payment)
            @component('CMSView::components.panels.default', [
                'classes' => 'manage-wallet-panel',
                'title' => 'Conversion',
            ])
                <table class="twa-table table-auto">

                    <tbody>


                    <tr>
                        <td> Payment Reference </td>
                        <td> {{ $form["payment_ref"] }} </td>
                    </tr>

                    <tr>
                        <td> Description </td>
                        <td> {{ $payment->topup_desc }} </td>
                    </tr>

                    <tr>
                        <td> Amount </td>
                        <td> {{ $payment->price }} </td>
                    </tr>

                    <tr>
                        <td> Payment Method </td>
                        <td> {{ $payment->payment_method }} </td>
                    </tr>

                    <tr>
                        <td> Customer </td>
                        <td> {{ $payment->user }} </td>
                    </tr>

                    <tr>
                        <td> Customer ID </td>
                        <td> {{ $payment->user_id }} </td>
                    </tr>


                    <tr>
                        <td> Created at </td>
                        <td> {{ now()->parse($payment->created_at)->format('d-m-Y h:i')}} </td>
                    </tr>



                    </tbody>
                </table>
            @endcomponent

        @endif

        @if($transaction)

            @component('CMSView::components.panels.default', [
      'classes' => 'manage-wallet-panel',
      'title' => 'Transaction'
  ])
                <table class="twa-table table-auto">

                    <tbody>


                    <tr>
                        <td> Amount </td>
                        <td> {{ $transaction->amount }} </td>
                    </tr>

                    <tr>
                        <td> Payment Method </td>
                        <td> {{ $transaction->payment_method }} </td>
                    </tr>

                    <tr>
                        <td> Customer </td>
                        <td> {{ $transaction->user }} </td>
                    </tr>

                    <tr>
                        <td> Customer ID </td>
                        <td> {{ $transaction->user_id }} </td>
                    </tr>

                    <tr>
                        <td> Created at </td>
                        <td> {{ now()->parse($transaction->created_at)->format('d-m-Y h:i')}} </td>
                    </tr>


                    </tbody>
                </table>
            @endcomponent



        @endif




        @if(count($transaction_logs) > 0)

        @component('CMSView::components.panels.default', [
   'classes' => 'manage-wallet-panel',
   'title' => 'Transaction Logs',
])
            <table class="twa-table table-auto">

                <thead>
                <tr>
                    <th> ID </th>
                    <th> Type </th>
                    <th> Message </th>
                    <th> Payload </th>
                    <th> Created at </th>


                </tr>

                </thead>
                <tbody>

                @foreach($transaction_logs as $log)

                <tr>

                    <td> {{$log->id}} </td>
                    <td> {{$log->type}} </td>
                    <td> {{$log->message}} </td>
                    <td >
                        <div
                            style="position: relative ;max-width: 300px ; overflow: hidden ; cursor: pointer" @click="navigator.clipboard.writeText('{{$log->payload}}')">
                            {!!  nl2br($log->payload) !!}
                        </div>
                    </td>
                    <td> {{ now()->parse($log->created_at)->format('d-m-Y h:i')}} </td>

                </tr>

                    @endforeach

                    @if($log->message == '' && !$payment)

                        <tr>
                            <td colspan="5" >


                                <div x-data="{
                                showModal: false,
                                handleOpen() { this.showModal = true },
                                handleClose() { this.showModal = false }
                            }" x-on:payment-treated.window="handleClose()"><button type="button"
                                                                                   class="btn btn-primary" @click="handleOpen"> Treat</button>

                                    @component('UIKitView::components.modal', [
                                        'title' => 'Treat',
                                        'variable' => 'showModal',
                                        'action' => [
                                            'label' => '"Treat"',
                                            'type' => 'primary',
                                            'handler' => '$wire.treatPayment(' . $transaction->id . ')',
                                        ],
                                    ])
                                        <div class="text-[13px] font-medium text-left text-gray-800 p-5">
                                            Are you sure you want to treat this payment?
                                        </div>
                                    @endcomponent



                                </div>

                            </td>
                        </tr>

                    @endif

                </tbody>
            </table>
        @endcomponent


            @endif


    </div>

</div>
