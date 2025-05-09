<div>
 

    @component('CMSView::components.panels.default', ['classes' => 'manage-wallet-panel', 'title' => 'Uncompleted Payments' 
            
        
    ])
        <table class="twa-table table-auto">
            <thead>
                <tr>
                    <th> Card Number </th>
                    <th> User Id </th>
                    <th> Amount </th>
                    <th> Payment Reference </th>
                    <th> Message </th>

                    <th> Action </th>
                   
                </tr>

            </thead>
            <tbody>

                @forelse($rows as $row)
                    <tr>
                        <td> {{ $row->barcode }} </td>
                        <td> {{ $row->user_id }} </td>
                        <td> {{ $row->amount }} </td>
                        <td> {{ $row->payment_reference }} </td>
                        <td> {{ $row->message }} </td>
                        <td> 
                            <div x-data="{ showModal: false, handleOpen() { this.showModal = true } }">
                            <button type="button" class="btn btn-primary" @click="handleOpen" > Treat</button>
                        
                            @component('UIKitView::components.modal', [
                                'title' => 'Treat',
                                'variable' => 'showModal',
                                'action' => [
                                    'label' => "'Treat'",
                                    'type' => 'success',
                                    'handler' => "treatPayment('".$row->id."')",
                                ],
                            ])
                                <div class="text-[13px] font-medium text-left text-gray-800 p-5">
                                    Are you sure you want to treat this payment?
                                </div>
                            @endcomponent
                            </div>

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6"> No Data </td>

                    </tr>
                @endforelse
               
            </tbody>
        </table>
    @endcomponent

    

</div>
