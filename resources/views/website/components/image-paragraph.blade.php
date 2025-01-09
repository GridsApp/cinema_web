@foreach ($cinema_growth_plans as $cinema_growth_plan)
    <div class="grid sm:grid-cols-2 grid-cols-1  images-bordered">
        @if (isset($cinema_growth_plan['content']))
            <div>

                {!! $cinema_growth_plan['content'] !!}
            </div>
        @endif
        @if (isset($cinema_growth_plan['image']))
            <div class="border-image-wrapper flex justify-end w-full">
                <div class="relative ">

                    <div class="border-image-top-right"> </div>
                    <div class="border-image-bottom-left"> </div>

                    <div class="sm:w-[500px] w-[250px]">
                        <div class="asp asp-4-3">
                            <img src={{ get_image($cinema_growth_plan['image']) }} alt="Godfather Image"
                                class="image-bordered ">

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endforeach
