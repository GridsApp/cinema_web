@extends('CMSView::layouts.main')

@section('content')
    <div class="container-fixed">

  
        <div class="font-bold text-[18px] pb-6 "> 
            <h3> Box Office Summary Report</h3>
        </div>
        <livewire:entity-forms.box-office-report-summary-form  />


        
    </div>
@endsection
