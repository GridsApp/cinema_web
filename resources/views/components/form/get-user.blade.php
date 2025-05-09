<div>
    @if (cms_check_permission('view-transactions'))
        <div class="manage-wallet flex flex-col gap-5">


            @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'Manage Users'])
                <form wire:key="{{ uniqid() }}" method="POST" wire:submit.prevent="searchByCard">
                    @csrf

                    <div class="mb-5">

                        {{-- <input type="text" wire:model="form.card_number">
                @error('form.card_number') {{$message}} @enderror --}}

                      
                            <div> {!! field('phone_email_card_number') !!}</div>
                           
              
                    </div>

                    <button type="submit" class="btn btn-primary"> Search </button>
                </form>
            @endcomponent



            @if($user)


            @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'User Info'])
                <table class="twa-table table-auto">
                    <tbody>
                        <tr>
                            <td> <strong> Name </strong> </td>
                            <td>{{ $user->name ?? "-"}}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>{{ $user->email ?? "-"}}</td>
                        </tr>

                        <tr>
                            <td><strong>Login Metdod</strong></td>
                            <td>{{ $user->login_providder ?? "Basic Registration" }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone</strong></td>
                            <td>{{ $user->phone ?? "-" }}</td>
                        </tr>

                        <tr>
                            <td><strong>Gender</strong></td>
                            <td>{{ $user->gender  ?? "-"}}</td>
                        </tr>
                        <tr>
                            <td><strong>Date of Birth </strong> </td>
                            <td>{{ $user->dob ?? "-"}}</td>
                        </tr>

                        <tr>
                            <td><strong>Date of Marriage </strong></td>
                            <td>{{ $user->dom  ?? "-"}}</td>
                        </tr>
                       
                    </tbody>
                </table>
            @endcomponent


            @component('CMSView::components.panels.default', ['classes' => 'manage-wallet-panel', 'title' => 'Wallet Transactions' ,
            
            
            'actions' => $this->barcode ? '<div> <a target="_blank" href="'.route('manage-wallets' , ['form[card_number]' => $this->barcode ]).'" class="btn btn-primary"> Top-up</a> </div>' : ''

            ])
                <table class="twa-table table-auto">
                    <thead>
                        <tr>
                            <th> ID </th>
                            <th> Type </th>
                            <th> Date </th>
                            <th> Description </th>

                            <th> Created By </th>
                            <th> System </th>
                            <th> Amount </th>
                            <th> Balance </th>

                        </tr>

                    </thead>
                    <tbody>

                        @forelse($transactions as $transaction)
                            <tr>
                                <td> #{{ $transaction['id'] }} </td>
                                <td> {{ $transaction['type'] == 'in' ? 'Topup' : 'Deduct' }} </td>
                                <td> {{ $transaction['date'] }} </td>
                                <td> {{ $transaction['description'] }} </td>

                                <td> {{ $transaction['created_by'] }} </td>
                                <td> {{ $transaction['system'] }} </td>


                                <td>{{ currency_format($transaction['amount'])['display'] }} </td>
                                <td>{{ currency_format($transaction['balance'])['display'] }} </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8"> No Transactions </td>

                            </tr>
                        @endforelse
                        <tr>
                            <th colspan="7"
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

   


            @component('CMSView::components.panels.default', ['classes' => 'manage-wallet-panel', 'title' => 'Loyalty Transactions'])
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

                        @forelse($loyaltyTransactions as $transaction)
                            {{-- @dd($transaction); --}}


                            <tr>
                                <td> #{{ $transaction['id'] }} </td>
                                <td> {{ $transaction['type'] == 'in' ? 'Topup' : 'Deduct' }} </td>
                                <td> {{ $transaction['date'] }} </td>
                                <td> {{ $transaction['description'] }} </td>

                                {{-- <td> {{ $transaction['created_by'] }} </td> --}}
                                {{-- <td> {{ $transaction['system'] }} </td> --}}


                                <td>{{ $transaction['amount'] }} </td>
                                <td>{{ $transaction['balance'] }} </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8"> No Transactions </td>

                            </tr>
                        @endforelse
                        <tr>
                            <th colspan="5"
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




        </div>
    @endif
</div>
