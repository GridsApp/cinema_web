<div>



    <div class=" grid grid-cols-12 pt-8 gap-3">

        @foreach ($grouped_movies as $group => $grouped_movies_list)
            <div class="col-span-6">
                @component('CMSView::components.panels.default', ['title' => $group])
                    <div class="">

                        @foreach ($grouped_movies_list as $movie)
                            <div class="bg-gray-50 p-3 my-3 rounded-md text-[12px] flex flex-row">
                            <div class="flex-1">
                                {{ $movie["movie"] }} : {{ $movie["id"] }}
                            </div>

                            <div>
                                <i class="fa-solid fa-trash cursor-pointer text-red-500"
                                   wire:click="deleteMovie({{ $movie['id'] }})"
                                   title="Delete"
                                ></i>
                            </div>
                            </div>

                           
                        @endforeach
         
                    </div>
                @endcomponent
            </div>
        @endforeach

    </div>
</div>
