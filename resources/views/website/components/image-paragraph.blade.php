@foreach ($cinema_growth_plans as $cinema_growth_plan)
    <div class="grid grid-cols-2  images-bordered">
        @if (isset($cinema_growth_plan['content']))
            <div>

                {!! $cinema_growth_plan['content'] !!}
            </div>
        @endif
        @if (isset($cinema_growth_plan['image']))
            <div class="flex justify-end w-full">
                <div class="border-image2">
                    <div class="w-[500px]">
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
