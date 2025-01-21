@php
    $cinemaPrefix = request()->segment(1);

    $branch = App\Models\Branch::whereNull('deleted_at')->where('web_prefix', $cinemaPrefix)->first();
    if (!$branch) {
        abort(404, 'Branch not found');
    }
@endphp

<footer class="mt-10">
    <div class="grid sm:grid-cols-12 grid-cols-1">
        <div class="sm:col-span-3 col-span-12">
            <div class="footer-title">
                {{ __('footer.get_in_touch') }}
            </div>
            <div class="flex flex-col gap-2">
                @if (isset($branch['email']))
                    <div>
                        <i class="fa-solid fa-envelope"></i>
                        <span>  {{ $branch['email'] }}</span>
                    </div>
                @endif
                <div>
                    <i class="fa-solid fa-phone"></i>
                    <span>  {{ $branch['number'] }}</span>
                </div>
                <div>
                    <i class="fa-solid fa-location-dot"></i>
                    <span> {{ $branch['address'] }}</span>
                </div>
            </div>
        </div>
        <div class="sm:col-span-2 col-span-12 sm:pt-0 pt-10">
            <div class="footer-title">
                {{ __('footer.useful_links') }}
            </div>
            <div class="flex flex-col gap-2">
                <div>
                    <a class="a-text" href="">{{ __('footer.wallet_transactions') }}</a>
                </div>
                <div>
                    <a class="a-text" href="">{{ __('footer.recharge_wallet') }}</a>
                </div>
                <div>
                    <a class="a-text" href="">{{ __('footer.loyalty') }}</a>
                </div>
                <div>
                    <a class="a-text" href="">{{ __('footer.purchase_history') }}</a>
                </div>
            </div>
        </div>

        <div class="sm:col-span-2 col-span-12 sm:pt-0 pt-10">
            <div class="footer-title">
                {{ __('footer.social_media') }}
            </div>
            <div class="flex flex-col gap-2">
                <div>
                    <a class="a-text" href="">{{ __('footer.wallet_transactions') }}</a>
                </div>
                <div>
                    <a class="a-text" href="">{{ __('footer.recharge_wallet') }}</a>
                </div>
                <div>
                    <a class="a-text" href="">{{ __('footer.loyalty') }}</a>
                </div>
                <div>
                    <a class="a-text" href="">{{ __('footer.purchase_history') }}</a>
                </div>
            </div>
        </div>

        <div class="col-span-5">
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
</footer>
