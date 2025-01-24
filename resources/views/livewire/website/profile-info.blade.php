<div class="flex flex-col gap-10">
    <div class="flex sm:flex-row flex-col gap-10">
        <div class="w-[100px]">

            <div class="flex justify-center items-center w-full flex-col">


                <iframe
                    src="{{ route('render', [
                        'cinema_prefix' => request()->route('cinema_prefix'),
                        'language_prefix' => request()->route('language_prefix'),
                    ]) }}"
                    frameborder="0"></iframe>
                {{-- <div class="asp asp-2-2"> --}}
                    {{-- <img src="{{ $user->profile_picture ? get_image($user->profile_picture) : '/images/profile.png' }}"
                        alt="Profile Image" class="rounded-full w-full h-full object-cover"> --}}
                {{-- </div> --}}
                {{-- <div class="asp asp-2-2">
                    <img src="{{ $user->profile_picture ? get_image($user->profile_picture) : '/images/profile.png' }}"
                        alt="Profile Image" class="rounded-full w-full h-full object-cover">

                </div>
                <div class="pt-3">
                    <a class="tracking-[1.9px] uppercase underline font-bold primary-color text-center text-[10px]"
                        href="#">
                        {{ __('messages.add_image') }}
                    </a>
                </div> --}}

                {{-- <form id="profile-image-form" enctype="multipart/form-data" method="POST" action="{{ route('addImage', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}">
                    @csrf  
                    <input type="file" name="profile_picture" id="profile_picture" required>
                    <button type="submit">Upload Image</button>
                </form> --}}

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

    <div class="account-menu">
        <a wire:nagivate
            href="{{ route('update', [
                'cinema_prefix' => request()->route('cinema_prefix'),
                'language_prefix' => request()->route('language_prefix'),
            ]) }}"
            class="account-menu-text {{ Route::currentRouteName() === 'update' ? 'active' : '' }}">
            <div>
                <div>{{ __('messages.personal_information') }}</div>
            </div>
            <div>
                @if (Route::currentRouteName() === 'update')
                    <i
                        class="fa-solid arrow {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                @endif
            </div>
        </a>

        <a wire:nagivate
            href="{{ route('favorites', [
                'cinema_prefix' => request()->route('cinema_prefix'),
                'language_prefix' => request()->route('language_prefix'),
            ]) }}"
            class="account-menu-text {{ Route::currentRouteName() === 'favorites' ? 'active' : '' }}">
            <div>
                <div>{{ __('messages.my_favorites') }}</div>
            </div>
            <div>
                @if (Route::currentRouteName() === 'favorites')
                    <i
                        class="fa-solid arrow {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                @endif
            </div>
        </a>

        <a wire:nagivate
            href="{{ route('getWalletTransactions', [
                'cinema_prefix' => request()->route('cinema_prefix'),
                'language_prefix' => request()->route('language_prefix'),
            ]) }}"
            class="account-menu-text {{ Route::currentRouteName() === 'getWalletTransactions' ? 'active' : '' }}">
            <div>
                <div>{{ __('messages.wallet_transactions') }}</div>
            </div>
            <div>
                @if (Route::currentRouteName() === 'getWalletTransactions')
                    <i
                        class="fa-solid arrow {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                @endif
            </div>
        </a>

        <a wire:nagivate
            href="{{ route('getLoyaltyCard', [
                'cinema_prefix' => request()->route('cinema_prefix'),
                'language_prefix' => request()->route('language_prefix'),
            ]) }}"
            class="account-menu-text {{ Route::currentRouteName() === 'getLoyaltyCard' ? 'active' : '' }}">
            <div>
                <div>{{ __('messages.loyalty') }}</div>
            </div>
            <div>
                @if (Route::currentRouteName() === 'getLoyaltyCard')
                    <i
                        class="fa-solid arrow {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                @endif
            </div>
        </a>

        <a wire:nagivate
            href="{{ route('purchaseHistory', [
                'cinema_prefix' => request()->route('cinema_prefix'),
                'language_prefix' => request()->route('language_prefix'),
            ]) }}"
            class="account-menu-text {{ Route::currentRouteName() === 'purchaseHistory' ? 'active' : '' }}">
            <div>
                <div>{{ __('messages.purchase_history') }}</div>
            </div>
            <div>
                @if (Route::currentRouteName() === 'purchaseHistory')
                    <i
                        class="fa-solid arrow {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                @endif
            </div>
        </a>

        <a wire:nagivate
        href="{{ route('renderDelete', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"
        class="account-menu-text {{ Route::currentRouteName() === 'purchaseHistory' ? 'active' : '' }}">
        <div>
            <div>{{ __('messages.delete_account') }}</div>
        </div>
        <div>
            @if (Route::currentRouteName() === 'renderDelete')
                <i
                    class="fa-solid arrow {{ app()->getLocale() === 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
            @endif
        </div>
    </a>

        <div class="pt-7">
            <a class="account-menu-text  !uppercase !border-b-transparent"
                href="{{ route('logout-web', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}">
                <div>
                    <i class="fa-solid primary-color fa-left-from-bracket ltr:pr-3 rtl:pl-3"></i>
                    {{ __('messages.logout') }}
                </div>
            </a>
        </div>
    </div>



</div>
