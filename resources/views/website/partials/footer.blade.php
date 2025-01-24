@php
    $cinemaPrefix = request()->segment(1);

    $branch = App\Models\Branch::whereNull('deleted_at')->where('web_prefix', $cinemaPrefix)->first();
    if (!$branch) {
        abort(404, 'Branch not found');
    }

    $facebook = get_setting('facebook', app()->getLocale());
    $facebook_label = get_setting('facebook_label', app()->getLocale());
    $instagram = get_setting('instagram', app()->getLocale());
    $instagram_label = get_setting('instagram_label', app()->getLocale());

@endphp

<footer class="mt-10">
    <div class="grid sm:grid-cols-12 grid-cols-1 pb-20">
        <div class="sm:col-span-3 col-span-12">
            <div class="footer-title">
                {{ __('footer.get_in_touch') }}
            </div>
            <div class="flex flex-col gap-4">
                @if (isset($branch['email']))
                    <div class="inline-flex items-center gap-4">
                        <i class="fa-solid fa-envelope"></i>
                        <span> {{ $branch['email'] }}</span>
                    </div>
                @endif
                <div class="inline-flex items-center gap-4">
                    <i class="fa-solid fa-phone"></i>
                    <span> {{ $branch['number'] }}</span>
                </div>
                <div class="inline-flex items-center gap-4">
                    <i class="fa-solid fa-location-dot"></i>
                    <span> {{ $branch['address'] }}</span>
                </div>
            </div>
        </div>
        <div class="sm:col-span-3 col-span-12 sm:pt-0 pt-10">
            <div class="footer-title">
                {{ __('footer.useful_links') }}
            </div>
            <div class="flex flex-col gap-2">
                @if (!session('user'))
                  <span>
                    <a class="a-text"
                    href="{{ route('login-web', [
                        'cinema_prefix' => request()->route('cinema_prefix'),
                        'language_prefix' => request()->route('language_prefix'),
                    ]) }}">{{ __('footer.wallet_transactions') }}</a>
                  </span>
                @else
                   <span>
             
                        <a class="a-text"
                            href="{{ route('getWalletTransactions', [
                                'cinema_prefix' => request()->route('cinema_prefix'),
                                'language_prefix' => request()->route('language_prefix'),
                            ]) }}">{{ __('footer.wallet_transactions') }}</a>
             
                   </span>
                @endif

                @if (!session('user'))
                  <span>
                    <a class="a-text"
                    href="{{ route('login-web', [
                        'cinema_prefix' => request()->route('cinema_prefix'),
                        'language_prefix' => request()->route('language_prefix'),
                    ]) }}">{{ __('footer.recharge_wallet') }}</a>
                  </span>
                @else
                    <div>
                       <span>
                        <a class="a-text"
                        href="{{ route('getWalletTransactions', [
                            'cinema_prefix' => request()->route('cinema_prefix'),
                            'language_prefix' => request()->route('language_prefix'),
                        ]) }}">{{ __('footer.recharge_wallet') }}</a>
                       </span>
                    </div>
                @endif
                {{-- <div>
                    <a class="a-text" href="">{{ __('footer.recharge_wallet') }}</a>
                </div> --}}

                @if (!session('user'))
                  <span>
                    <a class="a-text"
                    href="{{ route('login-web', [
                        'cinema_prefix' => request()->route('cinema_prefix'),
                        'language_prefix' => request()->route('language_prefix'),
                    ]) }}">{{ __('footer.loyalty') }}</a>
                  </span>
                @else
                  
                     <span>
                        <a class="a-text"
                        href="{{ route('getLoyaltyCard', [
                            'cinema_prefix' => request()->route('cinema_prefix'),
                            'language_prefix' => request()->route('language_prefix'),
                        ]) }}">{{ __('footer.loyalty') }}</a>
                     </span>
                
                @endif
                {{-- <div>
                    <a class="a-text" href="">{{ __('footer.loyalty') }}</a>
                </div> --}}

                @if (!session('user'))
               <span>
                <a class="a-text"
                href="{{ route('login-web', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}">{{ __('footer.purchase_history') }}</a>
               </span>
                @else
                    
                       <span>
                        <a class="a-text"
                        href="{{ route('purchaseHistory', [
                            'cinema_prefix' => request()->route('cinema_prefix'),
                            'language_prefix' => request()->route('language_prefix'),
                        ]) }}">{{ __('footer.purchase_history') }}</a>
                       </span>
           
                @endif
                {{-- <div>
                    <a class="a-text" href="">{{ __('footer.purchase_history') }}</a>
                </div> --}}
            </div>
        </div>

        <div class="sm:col-span-2 col-span-12 sm:pt-0 pt-10">
            <div class="footer-title">
                {{ __('footer.social_media') }}
            </div>
            <div class="flex flex-col gap-5">

                @if ($facebook)
                    <div class="flex items-center gap-3">
                      <span>
                        <div class="gap-3 inline-flex">
                            <i class="fa-brands fa-facebook text-[17px] "></i>
                            <a href="{{ $facebook }}" target="_blank" class="a-text">
                                {{ $facebook_label ?? 'Facebook' }}
                            </a>
                        </div>
                     
                      </span>
                    </div>
                @endif

                @if ($instagram)
                    <div class="flex items-center gap-3">
                     <span>
                        <div class="gap-3 inline-flex">
                            <i class="fa-brands fa-instagram text-[17px] "></i>
                            <a href="{{ $instagram }}" target="_blank" class="a-text">
                                {{ $instagram_label ?? 'Instagram' }}
                            </a>
                        </div>
                     </span>
                      
                    </div>
                @endif



            </div>
        </div>

        <div class="col-span-4">
            <div class="footer-title">
                {{ __('footer.download_our_app') }}
            </div>
            <div class="flex flex-col gap-2">
                <div>
                    <span>{{ __('footer.app_description') }}</span>
                </div>
                <div class="flex gap-10">
                    <a href="https://play.google.com/store/apps/details?id=com.iraqicinema.booking"><img
                            src="/images/googleplay.svg" alt=""></a>
                    <a
                        href="https://apps.apple.com/us/app/iraqi-cinema-%D8%A7%D9%84%D8%B3%D9%8A%D9%86%D9%85%D8%A7-%D8%A7%D9%84%D8%B9%D8%B1%D8%A7%D9%82%D9%8A%D8%A9/id489958175"><img
                            src="/images/applestore.svg" alt=""></a>
                </div>
            </div>
        </div>
    </div>

    <div class="flex sm:flex-row flex-col justify-between w-full pb-10">
        <div  class="text-[#F5F5F5] opacity-40 text-[11px] font-medium">
            ©2022. All rights reserved. Copyrights Iraqi cinemas
        </div>
        <div  class="text-[#F5F5F5] opacity-40 text-[11px] font-medium">
            Web design & development by <a href="https://thewebaddicts.com" class="underline">the web addicts</a>
        </div>
    </div>
</footer>
