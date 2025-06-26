@extends('CMSView::layouts.main')

@section('content')


<div class="container-fixed">
  
    <livewire:components.edit-manage-coupons :id="$id"/>
</div>

@endsection
