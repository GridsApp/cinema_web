<div class="banner">
    @if (!empty($banner))

        @desktop
            <div class="asp  {{ $aspect }} ">
                <img src={{ get_image($banner->image) }} alt="" class="bg-gray-100">
            </div>
        @elsedesktop
            <div class="asp asp-16-9 ">
                <img src={{ get_image($banner->image) }} alt="" class="bg-gray-100">
            </div>
        @enddesktop
{{-- @dd($banner); --}}
        <div class="box-position main-container">
            @if (isset($banner->title))
                <div class="banner-title">
                    {{ $banner->title }}
                </div>
            @endif
            @if (isset($banner->description))
                <div class="banner-description">
                    {{ $banner->description }}
                </div>
            @endif
            @if (isset($banner->cta_link))
                <div>
                    @include('website.components.link-button', [
                        'text' => $banner->cta_label,
                        'link' => $banner->cta_link,
                    ])
                </div>
            @endif
        </div>
    @endif
</div>
