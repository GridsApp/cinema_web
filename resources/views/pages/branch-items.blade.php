@extends('CMSView::layouts.main')

@section('content')

<div class="container-fixed">



    <a href="{{route('entity' , ['slug' => 'branches'])}}" class="flex gap-3">
        <div>  <i class="fa-solid fa-arrow-left"></i> </div>
        <div> {{$branch->label}} </div>
    </a>
    <br>

    <livewire:components.table-grid :table="$table"  />

</div>

@endsection
