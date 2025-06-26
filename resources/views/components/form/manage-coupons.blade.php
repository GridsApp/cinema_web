<div>

    <div class="manage-wallet flex flex-col gap-5">


        @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'Manage Coupons'])
            <form wire:key="{{ uniqid() }}" method="POST" wire:submit.prevent="searchByCouponCode">
                @csrf

                <div class="mb-5">

            
                    {!! field('coupon_code') !!}
                </div>

                <div class="flex gap-4 items-center justify-start">
                    <button type="submit" class="btn btn-primary"> Search </button>

                    <button type="button" class="btn btn-secondary" wire:click="handleClear"> Clear</button>

                </div>

            </form>
        @endcomponent



        @if ($this->form['coupon_code'])

            @component('CMSView::components.panels.default', ['classes' => 'manage-wallet-panel overflow-auto !p-0', 'title' => 'Coupon Details'])
                <table class="twa-table table-auto">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Label</th>
                            <th>Code</th>
                            <th>Used At</th>
                            <th>Expires At</th>
                            <th>Order ID</th>
                            <th>Order Reference</th>
                            <th>User Id</th>
                            <th>User Name</th>
                            <th>POS User ID</th>
                            <th>POS User Name</th>
                            <th>Branch</th>
                            <th>Theater</th>
                            <th>Movie</th>
                            <th>Show Time</th>
                         
                         
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id ?? '-' }}</td>
                                <td>{{ $transaction->label ?? '-' }}</td>
                                <td>{{ $transaction->code ?? '-' }}</td>
                                <td>{{ $transaction->used_at ? \Carbon\Carbon::parse($transaction->used_at)->format('Y-m-d H:i:s') : 'Not Used' }}</td>
                                <td>{{ $transaction->expires_at ? \Carbon\Carbon::parse($transaction->expires_at)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                <td>{{ $transaction->order_id ?? '-' }}</td>
                                <td>{{ $transaction->order_reference ?? '-' }}</td>
                              
                                <td>{{ $transaction->user_id ?? '-' }}</td>
                                <td>{{ $transaction->user_name ?? '-' }}</td>
                                <td>{{ $transaction->pos_user_id ?? '-' }}</td>
                                <td>{{ $transaction->pos_user_name ?? '-' }}</td>
                                <td>{{ $transaction->branch_name ?? '-' }}</td>
                                <td>{{ $transaction->theater ?? '-' }}</td>
                                <td>{{ $transaction->movie_name ?? '-' }}</td>
                                <td>{{ $transaction->show_time ?? '-' }}</td>
                            
                             
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="text-center">No coupon found with this code</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endcomponent
        @endif


    </div>

</div>
