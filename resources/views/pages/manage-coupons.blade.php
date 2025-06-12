@extends('CMSView::layouts.main')

@section('content')

<style>
    .twa-table tbody tr td:last-child{
        position: unset !important;
    }
    .twa-table thead th:last-child{
        position: unset !important;
    }
</style>
<div class="container-fixed">
  
    <livewire:components.manage-coupons />
</div>

@endsection
