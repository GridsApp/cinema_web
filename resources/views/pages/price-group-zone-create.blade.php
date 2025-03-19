@extends('CMSView::layouts.main')

@section('content')

<div class="container-fixed">



    <a href="{{route('price-group-zones' , ['id' => $price_group->id])}}" class="flex gap-3">
        <div>  <i class="fa-solid fa-arrow-left"></i> </div>
        <div> {{$price_group->label}} - Create Zone </div>
    </a>
    <br>


    <livewire:entity-forms.price-group-zone-form :price_group_id="$price_group->id" :zone_id="$zone_id" />


    {{-- <livewire:components.table-grid :table="$table"  /> --}}

</div>

@endsection
