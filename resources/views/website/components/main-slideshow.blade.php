<div x-init="GeneralFunctions.slideshow()">
    <div class="f-carousel" id="slideshow">
        @foreach ($slider as $slide)
            @desktop
                <div class="f-carousel__slide asp asp-3-1">
                    <div>
                        <div>
                            <img src={{ get_image($slide['web_image']) }} alt="Slide 1" class="brightness-50 bg-gray-100">
                        </div>
                        <div class="main-container slide-box-container ">

                            <div class="slideshow-text-position  ">
                                <div class="position-align ">
                                    @if (isset($slide['label']))
                                        <div class="capitalize text-white font-bold text-[30px]">
                                            {{ $slide['label'] }}
                                        </div>
                                    @endif

                                    @if (isset($slide['text']))
                                        <div class="text-white font-semibold text-[12px] opacity-60">
                                            {{ $slide['text'] }}
                                        </div>
                                    @endif

                                    @if (isset($slide['cta_link']))
                                    <div class="w-full rtl:justify-end ltr:justify-start flex">

                                   
                                        <div class="w-fit max-w-[230px]">
                                            @include('website.components.link-button', [
                                                'link' => $slide['cta_link'],
                                                'text' => $slide['cta_label'],
                                            ])
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            @elsedesktop
                <div class="f-carousel__slide asp asp-9-16">
                    <div>
                        <div>
                            <img src={{ get_image($slide['web_image']) }} alt="Slide 1" class="brightness-50 bg-gray-200">
                        </div>
                        <div class=" slide-box-container">
                            <div class="slideshow-text-position ">
                                <div class="position-align main-container">
                                    @if (isset($slide['label']))
                                        <div class="capitalize text-white font-bold text-[30px]">
                                            {{ $slide['label'] }}
                                        </div>
                                    @endif

                                    @if (isset($slide['text']))
                                        <div class="text-white font-semibold text-[12px] opacity-60">
                                            {{ $slide['text'] }}
                                        </div>
                                    @endif

                                    @if (isset($slide['cta_link']))
                                    <div class="w-fit max-w-fit">
                                        @include('website.components.link-button', [
                                            'link' => $slide['cta_link'],
                                            'text' => $slide['cta_label'],
                                        ])
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @enddesktop
        @endforeach
        <div
            class="carousel__nav main-container absolute text-white sm:top-[75%] top-[80%] z-10 flex ltr:justify-end sm:rtl:justify-start rtl:justify-end w-full">
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
