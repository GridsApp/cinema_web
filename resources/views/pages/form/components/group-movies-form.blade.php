<div>
    <form wire:submit.prevent="add">
        @component('CMSView::components.panels.default', ['title' => 'Group Movies'])
            <div class="grid grid-cols-12 gap-5 ">
                {!! field('movies', 'col-span-5') !!}
                {!! field('group_id', 'col-span-5') !!}
                <div class="col-span-2 items-center">
                    <div style="min-height:27.5px"></div>
                    <button class="btn btn-primary w-full" type="submit">
                        Add
                    </button>
                </div>
            </div>
        @endcomponent
    </form>
</div>
