<div>

    <form wire:submit="save">

        <div class="container-fixed" x-data="{disabled : true}"
        
        
        @submitenabled.window="disabled = false"
        @submitdisabled.window="disabled = true"

        {{-- @toggle-disabled.window="disabled = $event.detail.disabled" {{ '@' . $info['listen']['change'] }}.window="handleValueChanged"
        {{ '@' . $info['listen']['init'] }}.window="handleValueSelected" --}}
        

        
        
        >
            <div class="container-content-height">


                @component('CMSView::components.panels.default', ['main_class' => 'mb-5'])
                    <div class="grid grid-cols-12 gap-4 ">
                        {!! field('hall_number', 'col-span-12', null) !!}

                        {!! field('branch', 'col-span-6') !!}

                        {!! field('price_groups', 'col-span-6') !!}


                    </div>
                @endcomponent


                @component('CMSView::components.panels.default', ['main_class' => 'mb-5'])
                    <div class="grid grid-cols-12 gap-4 ">

                        {!! field('theater_map_json', 'col-span-12') !!}

                    </div>
                @endcomponent
            </div>

            @component('CMSView::components.panels.default', ['classes' => 'bg-[#fcfcfc] ring-1 ring-gray-300'])
                <div class="flex justify-center gap-4">
                    {!! link_button('Cancel', '#', 'secondary') !!}
                    {{-- {!! button("'Submit'", 'primary', '', 'submit', 'text-[12px]') !!} --}}
                    <button type="submit" class="btn btn-primary text-[12px]" :disabled="disabled">
                        Submit
                    </button>
                </div>
            @endcomponent

        </div>

    </form>
</div>
