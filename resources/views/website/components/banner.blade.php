<div class="banner">
    @desktop
        <div class="asp asp-3-1 ">
            <img src={{ get_image($banner->image) }} alt="">
        </div>
    @elsedesktop
        <div class="asp asp-16-9 ">
            <img src={{ get_image($banner->image) }} alt="">
        </div>
    @enddesktop

    <div class="box-position main-container">

        <div class="banner-title">
            Discover the history of iraqi cinemas
        </div>

        <div class="banner-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
            dolore.
        </div>

        <div>
            @include('website.components.button', ['title' => 'Learn more'])
        </div>
    </div>
</div>
