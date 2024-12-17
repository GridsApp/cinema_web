<div @selectedshows.window="$wire.handleIdChange(event.detail.selected)">
    <form wire:submit="save">
        <div class="container-content-height-2">

            <div class="grid grid-cols-12 gap-5">

                @if($this->type == "single")
                {!! field('date', 'col-span-12') !!}
                @endif

                @if($this->type == "single")
                    {!! field('time', 'col-span-12') !!}
                @else
                    {!! field('time', 'col-span-10') !!}
                    {!! field('apply_time', 'col-span-2 toggle-custom') !!}
                @endif

                @if($this->type == "single")
                    {!! field('screen_type', 'col-span-12') !!}
                @else
                    {!! field('screen_type', 'col-span-10') !!}
                    {!! field('apply_screen_type', 'col-span-2 toggle-custom') !!}
                @endif


                @if($this->type == "single")
                {!! field('system', 'col-span-12') !!}
                @else
                {!! field('system', 'col-span-10') !!}
                {!! field('apply_system', 'col-span-2 toggle-custom') !!}
                @endif


                @if($this->type == "single")
                    {!! field('color', 'col-span-12') !!}
                @else
                    {!! field('color', 'col-span-10') !!}
                    {!! field('apply_color', 'col-span-2 toggle-custom') !!}
                @endif



            </div>

        </div>
        <div class="my-4">
            @component('CMSView::components.panels.default', ['classes' => 'bg-[#fcfcfc] ring-1 ring-gray-300'])
                <div class="flex justify-center gap-4">
                    {{-- @if (!$uniqeid)    {!! link_button('Cancel', '#', 'secondary') !!} @endif --}}
                    {!! button("'Submit'", 'primary', '', 'submit', 'text-[12px]') !!}
                </div>
            @endcomponent
        </div>
    </form>
</div>
