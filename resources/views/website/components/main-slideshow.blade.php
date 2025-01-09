<div x-init="GeneralFunctions.slideshow()">
    <div class="f-carousel" id="slideshow">
        @foreach ($slider as $slide)
            @desktop
                <div class="f-carousel__slide asp asp-3-1">
                    <div>
                        <div>
                            <img src={{ get_image($slide['image']) }} alt="Slide 1" class="brightness-50 ">
                        </div>
                        <div class="main-container">
                            <div class="absolute top-[80%] z-10 text-white font-bold text-[30px] capitalize" style="">
                                {{ $slide['label_en'] }}
                            </div>
                        </div>
                    </div>

                </div>
            @elsedesktop
                <div class="f-carousel__slide asp asp-9-16">
                    <div>
                        <div>
                            <img src={{ get_image($slide['image']) }} alt="Slide 1" class="brightness-50 ">
                        </div>
                        <div class="main-container">
                            <div class="absolute top-[80%] z-10 text-white font-bold text-[30px] capitalize" style="">
                                {{ $slide['label_en'] }}
                            </div>
                        </div>
                    </div>

                </div>
            @enddesktop
        @endforeach
        <div class="carousel__nav main-container absolute text-white top-[80%] z-10 flex justify-end w-full">
            <button tabindex="0" title="Previous slide" class="f-button is-prev" data-carousel-prev="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1">
                    <path d="M15 3l-9 9 9 9"></path>
                </svg></button>
            <button tabindex="0" title="Next slide" class="f-button is-next" data-carousel-next="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1">
                    <path d="M9 3l9 9-9 9"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
