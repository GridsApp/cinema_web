

<div class="grid sm:grid-cols-2 grid-cols-1 images-bordered">

    <div class="flex flex-col">
        @if (isset($cinema_founder['top_image']))
            <div class="border-image-wrapper flex  w-full">
                <div class="relative ">

                    <div class="border-image-top-right"> </div>
                    <div class="border-image-bottom-left"> </div>

                    <div class="sm:w-[600px] w-[260px]">
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

                    <div class="sm:w-[350px] w-[160px]">
                        <div class="asp asp-4-3">
                            <img src={{ get_image($cinema_founder['bottom_image']) }} alt="Godfather Image"
                                class="image-bordered ">

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if (isset($cinema_founder['content']))
        <div class="sm:pt-0 pt-10">
            {!! $cinema_founder['content'] !!}
        </div>
    @endif
</div>
