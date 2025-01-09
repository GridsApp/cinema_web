
    {{-- @dd($branch); --}}
    <div class="mini-card">
        @if(isset($branch['image']))
        <div class="asp asp-2-1">

            <img src="{{ $branch['image'] }}" alt="">
        </div>
        @endif
        <div class="mini-card-bottom">
            @if(isset($branch['label']))
            <div class="title">
                {{ $branch['label'] }}
            </div>
            @endif
            <div class="location">

                <div class="flex flex-col gap-1">
                    @if(isset($branch['description']))
                    <div class="inline-flex items-center gap-2">
                        <div>
                            <i class="fa-solid fa-location-dot"> </i>
                        </div>
                        <div class="text-[12px]">
                            {{ $branch['description'] }}
                        </div>
                    </div>
                    @endif

                    @if(isset($branch['latitude']) && isset($branch['longitude']))
                    <a href="https://www.google.com/maps?q={{ $branch['latitude'] }},{{ $branch['longitude'] }}"
                       target="_blank" class="primary-color text-[12px] underline">
                       View Location
                    </a>
                    @endif
                </div>



            </div>
        </div>
    </div>

