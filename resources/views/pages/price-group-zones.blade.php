@extends('CMSView::layouts.main')

@section('content')

<div class="container-fixed">



    <a href="{{route('entity' , ['slug' => 'price-groups'])}}" class="flex gap-3">
        <div>  <i class="fa-solid fa-arrow-left"></i> </div>
        <div> {{$price_group->label}} </div>
    </a>
    <br>

    <livewire:components.table-grid :table="$table"  />

</div>

@endsection
