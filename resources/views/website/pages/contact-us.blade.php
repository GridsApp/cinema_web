@extends('website.layouts.main')

@section('content')
    <div class="main-container main-spacing  contact-us">

        <div class="mt-10 flex justify-center items-center">
            @include('website.components.title', ['title' => __('messages.contact_us')])

        </div>


        <div class="sm:px-32 px-0">
            <div class="grid sm:grid-cols-2 grid-cols-1 mt-10 sm:gap-20 gap-10">
                <div class="asp asp-2-1">
                    <img src="/images/about-banner.jpg" alt="" class="rounded-xl brightness-50 ">
                </div>

                <div class="mt-5">
                    <div class="uppercase text-[12px] tracking-[1.9px] font-bold">
                        {{ __('footer.get_in_touch') }}
                    </div>
                    <div class="border border-b opacity-50 mb-2 mt-2"></div>


                    <div>
                        <div class="min-w-[40px] max-w-[40px] inline-flex">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <span>+964 XXXXXXXXXX</span> 
                    </div>


                    @if ($facebook)
                        <div class="border border-b opacity-50 mb-2 mt-2"></div>
                        <div>
                            <div class="min-w-[40px] max-w-[40px] inline-flex">
                                <i class="fa-brands fa-facebook !text-[#4267B2]"></i>
                            </div>
                            <a href="{{ $facebook }}" target="_blank" class="hover:underline text-[12px]">
                                {{ $facebook_label ?? 'Facebook' }}
                            </a>
                        </div>
                    @endif


                    @if ($instagram)
                        <div class="border border-b opacity-50 mb-2 mt-2"></div>
                        <div>
                            <div class="min-w-[40px] max-w-[40px] inline-flex">
                                <i class="fa-brands fa-instagram !text-black"></i>
                            </div>
                            <a href="{{ $instagram }}" target="_blank" class="hover:underline text-[12px]">
                                {{ $instagram_label ?? 'Instagram' }}
                            </a>
                        </div>
                    @endif


                    @if ($whatsapp)
                        <div class="border border-b opacity-50 mb-2 mt-2"></div>
                        <div>
                            <div class="min-w-[40px] max-w-[40px] inline-flex">
                                <i class="fa-brands fa-whatsapp !text-[#25D366]"></i>
                            </div>
                            <a href="https://wa.me/{{ $whatsapp }}" target="_blank" class="hover:underline text-[12px]">
                                {{ $whatsapp_label ?? 'WhatsApp' }}
                            </a>
                        </div>
                    @endif


                    @if ($x)
                        <div class="border border-b opacity-50 mb-2 mt-2"></div>
                        <div>
                            <div class="min-w-[40px] max-w-[40px] inline-flex">
                                <i class="fa-brands fa-x-twitter !text-[#1DA1F2]"></i>
                            </div>
                            <a href="{{ $x }}" target="_blank" class="hover:underline text-[12px]">
                                {{ $x_label ?? 'Twitter' }}
                            </a>
                        </div>
                    @endif


                
                </div>

            </div>
        </div>


        <div class="grid sm:grid-cols-3 grid-cols-1 gap-10 mt-20 mb-20">

            @if ($financial_phone || $financial_email)
                <div>
                    <div class="uppercase text-[12px] tracking-[1.9px] font-bold">
                        {{ __('messages.financial') }}
                    </div>
                    <div class="border border-b opacity-50 mb-2 mt-2"></div>
                    @if ($financial_phone)
                    <div class="pt-3">
                        <div class="min-w-[40px] max-w-[40px] inline-flex">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <span>{{ $financial_phone }}</span>
                    </div>
                    @endif
                    @if ($financial_email)
                    <div class="pt-3">
                        <div class="min-w-[40px] max-w-[40px] inline-flex">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <span>{{ $financial_email }}</span>
                    </div>
                    @endif

                </div>
            @endif
            @if ($operator_phone || $operator_email)
                <div>
                    <div class="uppercase text-[12px] tracking-[1.9px] font-bold">
                        {{ __('messages.operational') }}
                    </div>
                    <div class="border border-b opacity-50 mb-2 mt-2"></div>
                    @if ($operator_phone)
                        <div class="pt-3">
                            <div class="min-w-[40px] max-w-[40px] inline-flex">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <span>{{ $operator_phone }}</span>
                        </div>
                    @endif
                    @if ($operator_email)
                        <div class="pt-3">
                            <div class="min-w-[40px] max-w-[40px] inline-flex">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <span>{{ $operator_email }}</span>
                        </div>
                    @endif
                </div>
            @endif

            @if ($management_phone || $management_email)
                <div>
                    <div class="uppercase text-[12px] tracking-[1.9px] font-bold">
                        {{ __('messages.management') }}
                    </div>
                    <div class="border border-b opacity-50 mb-2 mt-2"></div>
                    @if ($management_phone)
                        <div class="pt-3">
                            <div class="min-w-[40px] max-w-[40px] inline-flex">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <span>{{ $management_phone }}</span>
                        </div>
                    @endif
                    @if ($management_email)
                        <div class="pt-3">
                            <div class="min-w-[40px] max-w-[40px] inline-flex">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <span>{{ $management_email }}</span>
                        </div>
                    @endif

                </div>
            @endif
        </div>
    </div>
@endsection
