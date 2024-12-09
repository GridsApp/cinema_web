<div>

    <form wire:submit="save">
        <div class="container-fixed  ">

            <div class="container-content-height">


                @component('components.panels.default', ['main_class' => 'mb-5'])

                <div class="grid grid-cols-12 gap-4 ">
                    {!! field('hall_number', 'col-span-12' , null) !!}

                    {!! field('branch', 'col-span-6') !!}

                    {!! field('price_groups', 'col-span-6') !!}


                </div>

                @endcomponent


                @component('components.panels.default', ['main_class' => 'mb-5'])

                <div class="grid grid-cols-12 gap-4 ">

                {!! field('theater_map_json', 'col-span-12') !!}

                </div>
                @endcomponent
            </div>

            @component('components.panels.default', ['classes' => 'bg-[#fcfcfc] ring-1 ring-gray-300'])
                <div class="flex justify-center gap-4">
                    {!! link_button('Cancel', '#', 'secondary') !!}
                    {!! button("'Submit'", 'primary', '', 'submit', 'text-[12px]') !!}
                </div>
            @endcomponent

        </div>

    </form>
</div>
