@extends('CMSView::layouts.main')

@section('content')

<div class="container-fixed">




    <livewire:components.table-grid :table="$table"  />

</div>

@endsection
