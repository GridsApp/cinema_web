@extends('CMSView::layouts.main')

@section('content')
    <div class="container-fixed">

        <livewire:entity-forms.item-form :family_group_id="$family_group_id" />

    </div>
@endsection
