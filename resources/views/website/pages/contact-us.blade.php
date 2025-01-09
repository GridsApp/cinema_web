@extends('website.layouts.main')

@section('content')
    <div class="main-container main-spacing  contact-us">

        <div class="mt-10 flex justify-center items-center">
            @include('website.components.title', ['title' => 'Contact Us'])
        </div>


        <div class="px-32">
            <div class="grid grid-cols-2 mt-10 gap-20">
                <div class="asp asp-2-1">
                    <img src="/images/about-banner.jpg" alt="" class="rounded-xl brightness-50 ">
                </div>

                <div class="mt-5">
                    <div class="uppercase text-[12px] tracking-[1.9px] font-bold">
                        Get in touch
                    </div>
                    <div class="border border-b opacity-50 mb-2 mt-2"></div>


                    <div>
                        <div class="min-w-[40px] max-w-[40px] inline-flex">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <span>+964 XXXXXXXXXX</span> <!-- Replace this with dynamic phone if available -->
                    </div>


                    @if ($facebook)
                        <div class="border border-b opacity-50 mb-2 mt-2"></div>
                        <div>
                            <div class="min-w-[40px] max-w-[40px] inline-flex">
                                <i class="fa-brands fa-facebook !text-[#4267B2]"></i>
                            </div>
                            <a href="{{ $facebook }}" target="_blank" class="hover:underline">
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
                            <a href="{{ $instagram }}" target="_blank" class="hover:underline">
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
                            <a href="https://wa.me/{{ $whatsapp }}" target="_blank" class="hover:underline">
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
                            <a href="{{ $x }}" target="_blank" class="hover:underline">
                                {{ $x_label ?? 'Twitter' }}
                            </a>
                        </div>
                    @endif

           
                    {{-- @if ($telegram)
                    <div class="border border-b opacity-50 mb-2 mt-2"></div>
                    <div>
                        <div class="min-w-[40px] max-w-[40px] inline-flex">
                            <i class="fa-brands fa-telegram !text-[#0088CC]"></i>
                        </div>
                        <a href="{{ $telegram }}" target="_blank" class="hover:underline">
                            Telegram
                        </a>
                    </div>
                    @endif --}}
                </div>

            </div>
        </div>


        <div class="grid grid-cols-3 gap-10 mt-20 mb-20">


            <div>
                <div class="uppercase text-[12px] tracking-[1.9px] font-bold">
                    Financial
                </div>
                <div class="border border-b opacity-50 mb-2 mt-2"></div>

                <div class="pt-3">
                    <div class="min-w-[40px] max-w-[40px] inline-flex">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <span>+964 XXXXXXXXXX</span>
                </div>

                <div class="pt-3">
                    <div class="min-w-[40px] max-w-[40px] inline-flex">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <span>financial@email.com</span>
                </div>

            </div>


            <div>
                <div class="uppercase text-[12px] tracking-[1.9px] font-bold">
                    Operational
                </div>
                <div class="border border-b opacity-50 mb-2 mt-2"></div>

                <div class="pt-3">
                    <div class="min-w-[40px] max-w-[40px] inline-flex">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <span>+964 XXXXXXXXXX</span>
                </div>

                <div class="pt-3">
                    <div class="min-w-[40px] max-w-[40px] inline-flex">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <span>operational@email.com</span>
                </div>

            </div>



            <div>
                <div class="uppercase text-[12px] tracking-[1.9px] font-bold">
                    Management
                </div>
                <div class="border border-b opacity-50 mb-2 mt-2"></div>

                <div class="pt-3">
                    <div class="min-w-[40px] max-w-[40px] inline-flex">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <span>+964 XXXXXXXXXX</span>
                </div>

                <div class="pt-3">
                    <div class="min-w-[40px] max-w-[40px] inline-flex">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <span>management@email.com</span>
                </div>

            </div>
        </div>
    </div>
@endsection
