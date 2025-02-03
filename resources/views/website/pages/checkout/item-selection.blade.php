@extends('website.layouts.main')

@section('content')
    <div class="main-container main-spacing ">
        <div class="grid grid-cols-12 sm:gap-7 gap-4  mt-9">
            <div class="sm:col-span-8 col-span-12">
                <div class="pb-5">
                    @include('website.components.title', ['title' => 'Choose your extras'])
                </div>
                <div class="grid sm:grid-cols-4 grid-cols-2 sm:gap-10 gap-5">


                    @foreach ($items as $item)
                        <div class="w-fit flex flex-col gap-3">

                            <div class="bg-[#F0F0F0]  relative rounded-xl sm:w-[170px] sm:h-[170px] w-[140px] h-[140px]">
                                <div class="absolute top-0 left-0 right-0 bottom-0  z-10 asp asp-1-1 ">

                                    <img src="{{ $item['image'] }}" alt="" class="p-[50px]  !object-contain">

                                </div>

                            </div>


                            <div class="flex justify-center items-center flex-col gap-2">
                                <div class="font-bold capitalize text-[12px] ">
                                    {{ $item['label'] }}

                                    {{-- Popcorn medium --}}
                                </div>
                                <div class="primary-color font-bold text-[12px]">
                                    {{ $item['price']['display'] }}
                                </div>
                            </div>

                            <livewire:website.item-selector :item="$item" />


                        </div>
                    @endforeach
                </div>
            </div>

            <div class="sm:col-span-4 col-span-12">


                <livewire:website.cart-details  />

                {{-- <div class=" border flex flex-col p-6 rounded-xl  border-[#E5E5E5] ">

                    <div class="primary-color font-bold uppercase tracking-[1.5px] text-[12px]">
                        Order Summary
                    </div>
                    <div class="cart-info">
                        <div class="w-[150px]">

                            <div class="asp asp-3-4">
                                <img src="/images/cart-image.jpg" alt="">
                            </div>
                        </div>


                        <div>
                            <div class="name">
                                morbius
                            </div>

                            <div class="details-container">
                                <div>
                                    <i class="fa-regular fa-calendar !font-normal"></i>
                                </div>
                                <div class="flex flex-col">
                                    <div class="title">
                                        date:
                                    </div>
                                    <div class="subtitle">April 20, 2022</div>
                                </div>
                            </div>


                            <div class="details-container">
                                <div>
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div class="flex flex-col">
                                    <div class="title">
                                        time:
                                    </div>
                                    <div class="subtitle">8:00 pm</div>
                                </div>
                            </div>




                            <div class="details-container">
                                <div>
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div class="flex flex-col">
                                    <div class="title">
                                        Theatre:
                                    </div>
                                    <div class="subtitle">
                                        Theatre Number 4
                                    </div>
                                </div>
                            </div>


                            <div class="details-container">
                                <div>
                                    <i class="fa-solid fa-couch"></i>
                                </div>
                                <div class="flex flex-col">
                                    <div class="title">
                                        seats
                                    </div>
                                    <div class="subtitle">F07 — F08 — F09 — F10</div>
                                </div>
                            </div>



                        </div>
                    </div>


                    <div class="separator-line">

                    </div>
                    <div class="flex justify-between w-full pt-5">

                        <div class="font-bold text-[16px] capitalize ">
                            Total
                        </div>


                        <div class="primary-color font-bold uppercase  text-[12px]">
                            30,000 iqd
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
