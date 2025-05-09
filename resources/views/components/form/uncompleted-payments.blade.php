<div>
 

    @component('CMSView::components.panels.default', ['classes' => 'manage-wallet-panel', 'title' => 'Uncompleted Payments' 
            
        
    ])
        <table class="twa-table table-auto">
            <thead>
                <tr>
                    <th> Card Number </th>
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
                        <td> {{ $row->amount }} </td>
                        <td> {{ $row->payment_reference }} </td>
                        <td> {{ $row->message }} </td>
                        <td> <button class="btn btn-primary" wire:click="treatPayment('{{$row->id}}')"> Treat</button> </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5"> No Data </td>

                    </tr>
                @endforelse
               
            </tbody>
        </table>
    @endcomponent

    

</div>
