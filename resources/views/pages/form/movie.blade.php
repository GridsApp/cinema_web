@extends('layouts.main')

@section('content')
<livewire:entity-forms.movie-form :slug="$slug" :id="$id" />
@endsection
