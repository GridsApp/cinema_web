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
</div> --}}

<div class="paragraph mt-50 mb-50">


    <div class="left">



     



            <div class="image-tab opposite full">

                <img src="{{ get_image($cinema_founder['top_image']) }}" alt="">

            </div>
            <div class="image-tab no-border no-image">

                {{--                    <img src="/assets/home_image.jpg" alt=""> --}}

            </div>
            <div class="image-tab opposite">

                <img src="{{ get_image($cinema_founder['bottom_image']) }}" alt="">

            </div>



        </div>
        <div class="right">
            {!! $cinema_founder['content'] !!}

        </div>




    </div>
