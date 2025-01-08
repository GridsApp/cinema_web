{{-- <div class="grid grid-cols-2 gap-10 images-bordered">
 
    <div class="flex flex-col ">
        @if (isset($cinema_founder['top_image']))
            <div class="border-image">


                

                <div class="asp asp-2-1">
                    <img src={{ get_image($cinema_founder['top_image']) }} alt="Godfather Image" class="image-bordered">
                </div>
            </div>
        @endif
        @if (isset($cinema_founder['top_image']))
            <div class="w-full flex justify-end ">
                <div class="border-image2">
                    <div class="asp asp-2-1">
                        <img src={{ get_image($cinema_founder['bottom_image']) }} alt="Godfather Image"
                            class="image-bordered">
                    </div>
                </div>
            </div>
        @endif


    </div>

    @if (isset($cinema_founder['content']))
        <div>
            {!! $cinema_founder['content'] !!}
        </div>
    @endif
</div>

 --}}


<div class="grid grid-cols-2  images-bordered">

    <div class="flex flex-col">
        @if (isset($cinema_founder['top_image']))
            <div class="border-image-wrapper flex  w-full">
                <div class="relative ">

                    <div class="border-image-top-right"> </div>
                    <div class="border-image-bottom-left"> </div>

                    <div class="w-[600px]">
                        <div class="asp asp-2-1">
                            <img src={{ get_image($cinema_founder['top_image']) }} alt="Godfather Image"
                                class="image-bordered ">

                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($cinema_founder['top_image']))
            <div class="border-image-wrapper justify-end flex  w-[90%]">
                <div class="relative ">

                    <div class="border-image-top-right"> </div>
                    <div class="border-image-bottom-left"> </div>

                    <div class="w-[400px]">
                        <div class="asp asp-2-1">
                            <img src={{ get_image($cinema_founder['bottom_image']) }} alt="Godfather Image"
                                class="image-bordered ">

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if (isset($cinema_founder['content']))
        <div>
            {!! $cinema_founder['content'] !!}
        </div>
    @endif
</div>
