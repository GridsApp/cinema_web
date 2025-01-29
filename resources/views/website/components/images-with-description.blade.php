<div class="flex sm:gap-20 gap-5 sm:flex-row flex-col !mt-20  main-container images-bordered-four">


    <div class="sm:h-[400px] h-full w-[50%[ images-bordered-four gap-x-4 gap-y-7 grid sm:grid-cols-2 grid-cols-1">

        @if (isset($paragraph_banner['first_image']))
            <div class="border-image-wrapper flex  w-full">
                <div class="relative ">

                    <div class="border-image-top-left"> </div>
                    <div class="border-image-bottom-right"> </div>

                    <div class="sm:w-[250px] w-[250px]">
                        <div class="asp asp-4-3">

                            <img src={{ get_image($paragraph_banner['first_image']) }} alt="Godfather Image"
                                class="image-bordered1 bg-gray-100 ">

                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($paragraph_banner['second_image']))
            <div class="border-image-wrapper flex  w-full">
                <div class="relative ">

                    <div class="border-image-top-right"> </div>
                    <div class="border-image-bottom-left"> </div>

                    <div class="sm:w-[250px] w-[250px]">
                        <div class="asp asp-4-3">

                            <img src={{ get_image($paragraph_banner['second_image']) }} alt="Godfather Image"
                                class="image-bordered2 bg-gray-100">

                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($paragraph_banner['third_image']))
            <div class="border-image-wrapper flex  w-full">
                <div class="relative ">

                    <div class="border-image-top-right"> </div>
                    <div class="border-image-bottom-left"> </div>

                    <div class="sm:w-[250px] w-[250px]">
                        <div class="asp asp-4-3">

                            <img src={{ get_image($paragraph_banner['third_image']) }} alt="Godfather Image"
                                class="image-bordered2 bg-gray-100">

                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($paragraph_banner['fourth_image']))
            <div class="border-image-wrapper flex  w-full">
                <div class="relative ">

                    <div class="border-image-top-left"> </div>
                    <div class="border-image-bottom-right"> </div>

                    <div class="sm:w-[250px] w-[250px]">
                        <div class="asp asp-4-3">

                            <img src={{ get_image($paragraph_banner['fourth_image']) }} alt="Godfather Image"
                                class="image-bordered1 bg-gray-100">

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="sm:w-[50%] w-full">
        @if (isset($paragraph_banner['content']))
            <div>

                {!! $paragraph_banner['content'] !!}
            </div>
        @endif
    </div>




</div>
