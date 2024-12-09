<div

{{--    x-data="Functions.MovieShowForm()"--}}

{{--     @theaterchangedvalue.window="handleValueChanged"--}}
{{--     @theaterselectedvalue.window="handleValueSelected"--}}

{{--     @datesrangevalue.window="handleDateRange"--}}

>
    <form wire:submit.prevent="save">
        <div class="container-content-height-2">

            <div class="grid grid-cols-12 gap-5">
                {!! field('movie' , 'col-span-12' , null , false , false) !!}
                {!! field('date_from', 'col-span-12') !!}
                {!! field('date_to', 'col-span-12') !!}
                {!! field('time', 'col-span-12' , null , false , false) !!}
                {!! field('screen_type', 'col-span-12' , null , false , false) !!}
                {!! field('system', 'col-span-12') !!}     
                {!! field('movie_show_color', 'col-span-12') !!}
            </div>
        </div>
        <div class="my-4">
            @component('components.panels.default', ['classes' => 'bg-[#fcfcfc] ring-1 ring-gray-300'])
                <div class="flex justify-center gap-4">
                    @if (!$uniqeid)
                        {!! link_button('Cancel', '#', 'secondary') !!}
                    @endif
                    {!! button("'Submit'", 'primary', '', 'submit', 'text-[12px]') !!}
                </div>
            @endcomponent
        </div>
    </form>
</div>
