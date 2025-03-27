<div>
    <form wire:submit.prevent="save">
        <div class="container-content-height-2">
            <div class="grid grid-cols-12 gap-5">


                {!! field('family_group_id', 'col-span-7') !!}

                {!! field('image', 'col-span-7') !!}
                {!! field('label', 'col-span-7') !!}

                {!! field('screen_type_condition', 'col-span-7') !!}
                {!! field('item_branch', 'col-span-7') !!}



                <div class="col-span-7 flex flex-col gap-4">



                    @foreach ($branch_prices as $index => $branch_price)
                        <div class="w-full flex gap-5">
                            @php
                                $field = config('fields.item_price');
                                $field['id'] = uniqid();
                                $field['label'] = '';
                                $field['livewire']['wire:model'] = 'branch_prices.' . $index . '.price';
                                $field['container'] = 'flex-1';
                                $field['prefix'] = 'IQD';

                                // unset($field['container']);

                            @endphp



                            <div class="w-[100px] flex items-center">
                                <div class="twa-form-label ">
                                    {{ $branch_price['label'] }}
                                </div>

                            </div>


                            {!! field($field) !!}

                        </div>
                    @endforeach


                </div>

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
