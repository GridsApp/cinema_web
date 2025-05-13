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
        'title' => 'Payments',
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


            </tbody>
        </table>
    @endcomponent

            @endif

    </div>

</div>
