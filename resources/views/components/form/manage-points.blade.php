<div>
    @if (cms_check_permission('view-transactions'))
        <div class="manage-wallet flex flex-col gap-5">


            @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'Manage Loyalty Points'])
                <form wire:key="{{ uniqid() }}" method="POST" wire:submit.prevent="searchByCard">
                    @csrf

                    <div class="mb-5">

                        {{-- <input type="text" wire:model="form.card_number">
                @error('form.card_number') {{$message}} @enderror --}}

                        {!! field('card_number') !!}
                    </div>

                    <div class="flex gap-4 items-center justify-start">
                        <button type="submit" class="btn btn-primary"> Search </button>

                        <button type="button" class="btn btn-secondary" wire:click="handleClear">  Clear</button>
    
                    </div>
                  
                </form>

            @endcomponent



            @if ($this->form['card_number'])

                @component('CMSView::components.panels.default', ['classes' => 'manage-wallet-panel', 'title' => 'Transactions'])
                    <table class="twa-table table-auto">
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Type </th>
                                <th> Date </th>
                                <th> Description </th>

                               
                         
                                <th> Amount </th>
                                <th> Balance </th>

                            </tr>

                        </thead>
                        <tbody>

                            @forelse($transactions as $transaction)
                                {{-- @dd($transaction); --}}
                                <tr>
                                    <td> #{{ $transaction['id'] }} </td>
                                    <td> {{ $transaction['type'] == 'in' ? 'Topup' : 'Deduct' }} </td>
                                    <td> {{ $transaction['date'] }} </td>
                                    <td> {{ $transaction['description'] }} </td>

                                  
                                 

                                    {{-- <td> {{  }}</td> --}}

                                    {{-- <td> App </td>
                        <td> </td> --}}
                                    <td>{{ currency_format($transaction['amount'])['display'] }} </td>
                                    <td>{{ currency_format($transaction['balance'])['display'] }} </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6"> No Transactions </td>

                                </tr>
                            @endforelse
                            <tr>
                                <th colspan="6"
                                    class="py-[10px] text-center text-[14px] font-bold bg-gray-50 text-[#78829d] ">
                                    BALANCE
                                </th>
                                <th class="py-[10px] text-center text-[14px] font-bold bg-gray-50 text-[#78829d]">
                                    {{ currency_format($balance)['display'] }}
                                </th>
                            </tr>
                        </tbody>
                    </table>
                @endcomponent
            @endif

            @if ($form['card_number'])
                @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'Topup/Deduct'])
                    <form wire:key="{{ uniqid() }}" method="POST" wire:submit.prevent="submitForm">
                        @csrf

                        <div class="mb-5 grid grid-cols-12 gap-4">
                            {!! field('transaction_type') !!}
                            {!! field('amount') !!}
                            {!! field('description') !!}
                        </div>

                        <button class="btn btn-primary"> Submit </button>
                    </form>
                @endcomponent
            @endif

        </div>
    @endif
</div>
