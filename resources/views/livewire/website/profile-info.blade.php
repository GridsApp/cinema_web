<div class="flex flex-col gap-10">
    <div class="flex sm:flex-row flex-col gap-10">
        <div class="w-[100px]">
            {{-- @dd($user); --}}
            <div class="flex justify-center items-center w-full flex-col">
                <div class="asp asp-2-2">
                    <img src="{{ $user->profile_picture ? get_image($user->profile_picture) : '/images/profile.png' }}" alt="Profile Image" class="rounded-full w-full h-full object-cover">

                </div>
                <div class="pt-3">
                    <a class="tracking-[1.9px] uppercase underline font-bold primary-color text-center text-[10px]"
                        href="#">
                        {{ __('messages.add_image') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="profile-details">
            <div>
                <p class="font-bold capitalize text-[14px] pb-2">{{ $user->name }}</p>
                <p class="normal-text">{{ $user->email }}</p>
            </div>
            <div>
                <p class="bold-text pt-3">{{ __('messages.points_balance') }}:</p>
                <p class="normal-text">{{ $loyaltyBalance }} {{ __('messages.points') }}</p>
            </div>

            <div>
                <p class="bold-text pt-3">{{ __('messages.wallet_balance') }}:</p>
                <p class="normal-text">{{ $walletBalance['display'] }}</p>
            </div>

        </div>
    </div>

    <div x-data="{
                    activeLink: localStorage.getItem('activeLink') || '',
                    setActive(link) {
                        this.activeLink = link;
                        localStorage.setItem('activeLink', link);
                    }
                }" class="account-menu">
        <a href="{{ route('update', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"
            class="account-menu-text" :class="{ active: activeLink === 'personal_information' }"
            x-on:click="setActive('personal_information')">
            <div>
                <div>{{ __('messages.personal_information') }}</div>
            </div>
            <div>
                <i class="fa-solid arrow {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
            </div>
        </a>

        <a href="{{ route('favorites', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"
            class="account-menu-text" :class="{ active: activeLink === 'my_favorites' }"
            x-on:click="setActive('my_favorites')">
            <div>
                <div>{{ __('messages.my_favorites') }}</div>
            </div>
            <div>
                <i class="fa-solid arrow {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
            </div>
        </a>

        <a href="{{ route('getWalletTransactions', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"
            class="account-menu-text" :class="{ active: activeLink === 'wallet_transactions' }"
            x-on:click="setActive('wallet_transactions')">
            <div>
                <div>{{ __('messages.wallet_transactions') }}</div>
            </div>
            <div>
                <i class="fa-solid arrow {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
            </div>
        </a>

        <a href="{{ route('getLoyaltyCard', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"
            class="account-menu-text" :class="{ active: activeLink === 'loyalty' }" x-on:click="setActive('loyalty')">
            <div>
                <div>{{ __('messages.loyalty') }}</div>
            </div>
            <div>
                <i class="fa-solid arrow {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
            </div>
        </a>

        <a href="{{ route('purchaseHistory', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"
            class="account-menu-text" :class="{ active: activeLink === 'purchase_history' }"
            x-on:click="setActive('purchase_history')">
            <div>
                <div>{{ __('messages.purchase_history') }}</div>
            </div>
            <div>
                <i class="fa-solid arrow {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
            </div>
        </a>

        <div class="pt-7">
            <a class="account-menu-text !uppercase !border-b-transparent"
                href="{{ route('logout-web', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}">
                <div>
                    <i class="fa-solid  fa-left-from-bracket ltr:pr-3 rtl:pl-3"></i>
                    {{ __('messages.logout') }}
                </div>
            </a>
        </div>
    </div>

</div>
