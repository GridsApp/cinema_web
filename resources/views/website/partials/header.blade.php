
<nav class="main nav-bar" x-data="{ scrolled: false, isHome: {{ Route::currentRouteName() === 'home' ? 'true' : 'false' }}, menu_mobile: false }" 
    x-init="if (isHome) { window.addEventListener('scroll', () => { scrolled = window.scrollY > 0; }); }" 
    :class="{
        'scrolled': isHome && scrolled,
        'bg-white text-black': !isHome,
        'text-white': isHome && !scrolled
    }">
    <div class="flex main-container h-full justify-between items-center">
        <div class="flex items-center justify-between w-full">
            <div class="flex flex-1 justify-between sm:gap-10 gap-5 items-center">
                <div>
                    <a wire:navigate
                        href="{{ route('home', [
                            'cinema_prefix' => request()->route('cinema_prefix'),
                            'language_prefix' => request()->route('language_prefix'),
                        ]) }}">
                        <img :src="!isHome ? '/images/iraqi-logo-white.png' : (scrolled ? '/images/iraqi-logo-white.png' :
                            '/images/normal-logo.svg')"
                            alt="Logo" class="w-[100px] transition-all duration-300">
                    </a>
                </div>
                <div class="w-full">
                    <select class="custom-select sm:!w-[10%] !w-[30%] !border-transparent font-bold" id="lang"
                        x-data x-init="$el.value = '{{ app()->getLocale() }}'"
                        @change="
                        const selectedLang = $event.target.value; 
                        const currentUrl = new URL(window.location.href); 
                        const pathSegments = currentUrl.pathname.split('/'); 
                        if (['en', 'ar'].includes(pathSegments[2])) { 
                            pathSegments[2] = selectedLang;
                        }
                        currentUrl.pathname = pathSegments.join('/');
                        window.location.href = currentUrl.toString(); 
                    ">
                        <option value="en">EN</option>
                        <option value="ar">AR</option>
                    </select>
                </div>
            </div>
            <div class="flex md:hidden">
                <button @click="menu_mobile = true"
                    :class="{
                        'text-black': !isHome || scrolled,
                        'text-white': isHome && !scrolled
                    }">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <div class="hidden md:flex flex-row gap-5 items-center">
                <a href="{{ route('about', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}"
                :class="{
                    'text-black': scrolled || !isHome,
                    'text-white': !scrolled && isHome
                }"
                class="nav-text">{{ __('messages.about_us') }}</a>
            
                <a href="{{ route('movie-listing', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}"
                    class="nav-text">{{ __('messages.whats_on') }}</a>

                <a href="{{ route('listing', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}"
                    class="nav-text">{{ __('messages.cinemas') }}</a>

                <a href="{{ route('contact', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}"
                    class="nav-text">{{ __('messages.contact_us') }}</a>
                @if (!session('user'))
                    <div>
                        <a href="{{ route('login-web', [
                            'cinema_prefix' => request()->route('cinema_prefix'),
                            'language_prefix' => request()->route('language_prefix'),
                        ]) }}"
                            class="bg-primary-color hover:bg-black inline-flex px-10 py-2 rounded-full gap-3 text-[10px] items-center tracking-[1.95px] font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17.324" height="17.324"
                                viewBox="0 0 17.324 17.324">
                                <path id="Icon_awesome-user-alt" data-name="Icon awesome-user-alt"
                                    d="M8.662,9.745A4.872,4.872,0,1,0,3.79,4.872,4.874,4.874,0,0,0,8.662,9.745Zm4.331,1.083H11.129a5.89,5.89,0,0,1-4.933,0H4.331A4.331,4.331,0,0,0,0,15.159V15.7a1.625,1.625,0,0,0,1.624,1.624H15.7A1.625,1.625,0,0,0,17.324,15.7v-.541A4.331,4.331,0,0,0,12.993,10.828Z"
                                    fill="#fff"></path>
                            </svg>
                            <span class="text-white uppercase">{{ __('messages.sign_in') }}</span>
                        </a>
                    </div>
                @else
                    <div>
                        <a href="{{ route('update', [
                            'cinema_prefix' => request()->route('cinema_prefix'),
                            'language_prefix' => request()->route('language_prefix'),
                        ]) }}"
                            class="bg-primary-color hover:bg-black inline-flex px-10 py-2 rounded-full gap-3 text-[10px] items-center tracking-[1.95px] font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17.324" height="17.324"
                                viewBox="0 0 17.324 17.324">
                                <path id="Icon_awesome-user-alt" data-name="Icon awesome-user-alt"
                                    d="M8.662,9.745A4.872,4.872,0,1,0,3.79,4.872,4.874,4.874,0,0,0,8.662,9.745Zm4.331,1.083H11.129a5.89,5.89,0,0,1-4.933,0H4.331A4.331,4.331,0,0,0,0,15.159V15.7a1.625,1.625,0,0,0,1.624,1.624H15.7A1.625,1.625,0,0,0,17.324,15.7v-.541A4.331,4.331,0,0,0,12.993,10.828Z"
                                    fill="#fff"></path>
                            </svg>
                            <span class="text-white uppercase">{{ __('messages.account') }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="mobile-menu-dimmer transition-all" x-show="menu_mobile" @click="menu_mobile = false"
        x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0 transform"
        x-transition:enter-end="opacity-100 transform" x-transition:leave="transition duration-300"
        x-transition:leave-start="opacity-100 transform" x-transition:leave-end="opacity-0 transform"></div>
    <div class="mobile-menu" x-show="menu_mobile" x-init="function() { document.querySelector('.mobile-menu a.has-children').setAttribute('href', '#'); }"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full transform"
        x-transition:enter-end="-translate-x-0 transform" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0 transform" x-transition:leave-end="-translate-x-full transform" x-cloak>
        <a href="javascript:;" @click="menu_mobile = false" class="close"><i
                class="fa-thin fa-x text-white text-[15px]"></i></a>
     <div class="p-4">
        <a wire:navigate
        href="{{ route('about', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"
        class="block text-white text-[12px] py-2">{{ __('messages.about_us') }}</a>
    <a wire:navigate
        href="{{ route('movie-listing', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"
        class="block text-white text-[12px] py-2">{{ __('messages.whats_on') }}</a>
    <a wire:navigate
        href="{{ route('listing', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"
        class="block text-white text-[12px] py-2">{{ __('messages.cinemas') }}</a>
    <a wire:navigate
        href="{{ route('contact', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"
        class="block text-white text-[12px] py-2">{{ __('messages.contact_us') }}</a>
    <div class="mt-4 max-w-fit">
        <button
            class="bg-primary-color hover:bg-black inline-flex px-10 py-2 rounded-full gap-3 text-[10px] items-center tracking-[1.95px] font-bold w-full">
            <svg xmlns="http://www.w3.org/2000/svg" width="17.324" height="17.324" viewBox="0 0 17.324 17.324">
                <path id="Icon_awesome-user-alt" data-name="Icon awesome-user-alt"
                    d="M8.662,9.745A4.872,4.872,0,1,0,3.79,4.872,4.874,4.874,0,0,0,8.662,9.745Zm4.331,1.083H11.129a5.89,5.89,0,0,1-4.933,0H4.331A4.331,4.331,0,0,0,0,15.159V15.7a1.625,1.625,0,0,0,1.624,1.624H15.7A1.625,1.625,0,0,0,17.324,15.7v-.541A4.331,4.331,0,0,0,12.993,10.828Z"
                    fill="#fff"></path>
            </svg>
            <span class="text-white text-[12px] uppercase">{{ __('messages.sign_in') }}</span>
        </button>
    </div>
     </div>
    </div>
    {{-- <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0" x-transition:enter-end="transform opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="transform opacity-100"
        x-transition:leave-end="transform opacity-0" class="md:hidden bg-black absolute top-full left-0 w-full p-5">
        <a wire:navigate href="{{ route('about', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}" class="block text-white text-[12px] py-2">{{ __('messages.about_us') }}</a>
        <a  wire:navigate href="{{ route('movie-listing', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"  class="block text-white text-[12px] py-2">{{ __('messages.whats_on') }}</a>
        <a wire:navigate href="{{ route('listing', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}"  class="block text-white text-[12px] py-2">{{ __('messages.cinemas') }}</a>
        <a  wire:navigate href="{{ route('contact', [
            'cinema_prefix' => request()->route('cinema_prefix'),
            'language_prefix' => request()->route('language_prefix'),
        ]) }}" class="block text-white text-[12px] py-2">{{ __('messages.contact_us') }}</a>
        <div class="mt-4 max-w-fit">
            <button
                class="bg-primary-color hover:bg-black inline-flex px-10 py-2 rounded-full gap-3 text-[10px] items-center tracking-[1.95px] font-bold w-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.324" height="17.324" viewBox="0 0 17.324 17.324">
                    <path id="Icon_awesome-user-alt" data-name="Icon awesome-user-alt"
                        d="M8.662,9.745A4.872,4.872,0,1,0,3.79,4.872,4.874,4.874,0,0,0,8.662,9.745Zm4.331,1.083H11.129a5.89,5.89,0,0,1-4.933,0H4.331A4.331,4.331,0,0,0,0,15.159V15.7a1.625,1.625,0,0,0,1.624,1.624H15.7A1.625,1.625,0,0,0,17.324,15.7v-.541A4.331,4.331,0,0,0,12.993,10.828Z"
                        fill="#fff"></path>
                </svg>
                <span class="text-white text-[12px] uppercase">{{ __('messages.sign_in') }}</span>
            </button>
        </div>
    </div> --}}
</nav>
