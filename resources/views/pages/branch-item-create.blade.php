@extends('CMSView::layouts.main')

@section('content')

<div class="container-fixed">



    <a href="{{route('branch-items' , ['id' => $branch->id])}}" class="flex gap-3">
        <div>  <i class="fa-solid fa-arrow-left"></i> </div>
        <div> {{$branch->label}} - Create Item </div>
    </a>
    <br>


    <livewire:entity-forms.branch-item-form :branch_id="$branch->id"  />


    {{-- <livewire:components.table-grid :table="$table"  /> --}}

</div>

@endsection
