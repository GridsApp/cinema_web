@extends('CMSView::layouts.main')

@section('content')
    <div class="container-fixed">

        {{-- <a href="{{ route('branch-items', ['id' => $branch->id]) }}" class="flex gap-3">
            <div> <i class="fa-solid fa-arrow-left"></i> </div>
            <div> {{ $branch->label }} - Create Item </div>
        </a>
        <br> --}}

<div class="font-bold text-[18px] pb-6 "> 
    <h3> Box Office Report</h3>
</div>
        <livewire:entity-forms.box-office-report-form  />


        
    </div>
@endsection
