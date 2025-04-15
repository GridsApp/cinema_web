<div>
    <form wire:submit.prevent="save">
        <div class="container-content-height-2">
            <div class="grid grid-cols-12 gap-5">


                {!! field('label' , 'col-span-7') !!}
                {!! field('condensed_label', 'col-span-7') !!}
                {!! field('iso', 'col-span-7') !!}
                {!! field('color', 'col-span-7') !!}
                {!! field('price_settings', 'col-span-7') !!}
      
               
            </div>
        </div>
        <div class="my-4">
            @component('CMSView::components.panels.default', ['classes' => 'bg-[#fcfcfc] ring-1 ring-gray-300'])
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
