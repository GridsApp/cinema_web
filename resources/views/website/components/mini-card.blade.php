@foreach ($branches as $branch)
    {{-- @dd($branch); --}}
    <div class="mini-card">
        <div class="asp asp-2-1">
            <img src="{{ $branch['image'] }}" alt="">
        </div>
        <div class="mini-card-bottom">
            <div class="title">
                {{ $branch['label'] }}
            </div>
            <div class="location">

                <div class="flex flex-col gap-1">
                    <div class="inline-flex items-center gap-2">
                        <div>
                            <i class="fa-solid fa-location-dot"> </i>
                        </div>
                        <div class="text-[12px]">
                            {{ $branch['description'] }}
                        </div>
                    </div>

                    <a href="https://www.google.com/maps?q={{ $branch['latitude'] }},{{ $branch['longitude'] }}"
                        target="_blank" class="primary-color text-[12px] underline">
                        View Location
                    </a>
                </div>



            </div>
        </div>
    </div>
@endforeach
