@extends('CMSView::layouts.main')

@section('content')
    <div class="container-fixed">
        <div class="font-bold text-[18px] pb-6 "> 
            <h3> Distributor Shares Report</h3>
        </div>

        <livewire:entity-forms.distributor-shares-report-form />
    </div>
@endsection
