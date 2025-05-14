@extends('CMSView::layouts.main')

@section('content')
    <div class="container-fixed">
<div class="manage-wallet flex flex-col gap-5">


    @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'Cashier: '.$pos_user->name])
        <form target="_blank"  method="GET" >

            
            <div class="mb-5">

                <div>
                    <label class="twa-form-label">
                        Date
                    </label>
                    <div class="twa-form-input-container">
                        <div class="twa-form-input-ring">
                            <input name="date" type="date" value="{{request()->input('date')}}" class="twa-form-input date">
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex gap-4 items-center justify-start">
                <button type="submit"  class="btn btn-primary"> Search </button>

            </div>

        </form>

@endcomponent
</div>

@endsection
