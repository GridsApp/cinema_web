<div>
    <div class="container-fixed  ">
        <form wire:submit="save">



            <div class="grid grid-cols-12 gap-4 ">


                <div class="col-span-12" wire:loading.class="twa-loading-panel">

                    <div class="twa-loading-panel-message loading-icon">
                        <i class="fa-regular fa-loader"></i>  Loading...
                    </div>

                @component('CMSView::components.panels.default', ['title' => 'Fetch Record'])
                        <div class="grid grid-cols-12 gap-5 " >
                            {!! field('movie_key', 'col-span-9') !!}

                            <div class="col-span-1">
                                <div style="min-height:27.5px"></div>
                                <button
                                    wire:loading.class="opacity-50"
                                    class="btn btn-primary" type="button" wire:click="handleFetch">
                                    Fetch
                                </button>
                            </div>
                            <div class="col-span-2">
                                <div style="min-height: 27.5px"></div>
                                <button class="btn btn-secondary"
                                        wire:loading.class="opacity-50"
                                        type="button" wire:click="generateKey">
                                    Generate
                                </button>

                            </div>

                        </div>
                    @endcomponent
                </div>
                <div class="col-span-6">
                    @component('CMSView::components.panels.default', ['title' => 'Movie Information'])
                        <div class="grid grid-cols-12 gap-5">
                            {!! field('name', 'col-span-6') !!}
                            {!! field('condensed_name', 'col-span-6') !!}
                            {!! field('description', 'col-span-12') !!}
                            {!! field('duration', 'col-span-12') !!}
                            {!! field('release_date', 'col-span-12') !!}
                        </div>
                    @endcomponent
                </div>
                <div class="col-span-6">
                    @component('CMSView::components.panels.default', ['title' => 'Detailed Information'])
                        <div class="grid grid-cols-12 gap-5">
                            {!! field('cast', 'col-span-12') !!}
                            {!! field('genre', 'col-span-12') !!}
                            {!! field('director', 'col-span-12') !!}
                            {!! field('age_rating', 'col-span-12') !!}
                            {!! field('language', 'col-span-12') !!}
                  
                        </div>
                    @endcomponent
                </div>
                <div class="col-span-12">
                    @component('CMSView::components.panels.default', ['title' => 'Movie Media'])
                        <div class="grid grid-cols-12 gap-5">
                            {!! field('main_image', 'col-span-12') !!}
                            {!! field('cover_image', 'col-span-12') !!}
                            {!! field('youtube_video', 'col-span-12') !!}
                        </div>
                    @endcomponent
                </div>
                <div class="col-span-12">
                    @component('CMSView::components.panels.default', ['title' => 'Ratings & Votes'])
                        <div class="grid grid-cols-12 gap-5">
                            {!! field('imdb_rating', 'col-span-6') !!}
                            {!! field('imdb_vote', 'col-span-6') !!}
                        </div>
                    @endcomponent
                </div>

                <div class="col-span-12 mb-4">
                    @component('CMSView::components.panels.default' , ['classes' => 'bg-[#fcfcfc] ring-1 ring-gray-300'])
                        <div class="flex justify-center gap-4">
                            {!! link_button("Cancel" , '#' , 'secondary') !!}
                            {!! button("'Submit'" ,'primary', '' ,'submit',  'text-[12px]') !!}
                        </div>

                    @endcomponent
                </div>
            </div>

        </form>
    </div>

</div>
