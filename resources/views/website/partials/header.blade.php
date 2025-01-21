<nav class="main" x-data="{ scrolled: false, isHome: {{ Route::currentRouteName() === 'home' ? 'true' : 'false' }}, mobileMenuOpen: false }" x-init="if (isHome) {
    window.addEventListener('scroll', () => { scrolled = window.scrollY > 0 });
}" :class="{
    'scrolled': isHome && scrolled,
    'bg-white background-white text-black': !isHome,
    'text-white': isHome && !scrolled
}">
    <div class="flex main-container h-full justify-between items-center">
        <div class="flex items-center justify-between w-full">
            <div class="flex flex-1 justify-between gap-10 items-center">
                <div>
                    <a
                        href="{{ route('home', [
                            'cinema_prefix' => request()->route('cinema_prefix'),
                            'language_prefix' => request()->route('language_prefix'),
                        ]) }}">
                        <img :src="!isHome ? '/images/iraqi-logo-white.png' : (scrolled ? '/images/iraqi-logo-white.png' : '/images/normal-logo.svg')"
                            alt="Logo" class="w-[100px] transition-all duration-300">
                    </a>
                </div>
                <div class="w-full">
                    <select class="custom-select !w-[10%] !border-transparent font-bold" id="lang" x-data
                        x-init="$el.value = '{{ app()->getLocale() }}'"
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
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white">
                    <i class="fa-solid fa-bars text-black"></i>
                </button>
            </div>
            <div class="hidden md:flex flex-row gap-5 items-center">
                <a href="{{ route('about', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}" class="nav-text">{{ __('messages.about_us') }}</a>

                <a href="{{ route('movie-listing', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}" class="nav-text">{{ __('messages.whats_on') }}</a>

                <a href="{{ route('listing', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}" class="nav-text">{{ __('messages.cinemas') }}</a>

                <a href="{{ route('contact', [
                    'cinema_prefix' => request()->route('cinema_prefix'),
                    'language_prefix' => request()->route('language_prefix'),
                ]) }}" class="nav-text">{{ __('messages.contact_us') }}</a>
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

    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0" x-transition:enter-end="transform opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="transform opacity-100"
        x-transition:leave-end="transform opacity-0" class="md:hidden bg-black absolute top-full left-0 w-full p-5">
        <a href="/about-us" class="block text-white py-2">{{ __('messages.about_us') }}</a>
        <a wire:navigate href="/movies/listing" class="block text-white py-2">{{ __('messages.whats_on') }}</a>
        <a href="/branches/listing" class="block text-white py-2">{{ __('messages.cinemas') }}</a>
        <a href="/contact-us" class="block text-white py-2">{{ __('messages.contact_us') }}</a>
        <div class="mt-4">
            <button
                class="bg-primary-color hover:bg-black inline-flex px-10 py-2 rounded-full gap-3 text-[10px] items-center tracking-[1.95px] font-bold w-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.324" height="17.324" viewBox="0 0 17.324 17.324">
                    <path id="Icon_awesome-user-alt" data-name="Icon awesome-user-alt"
                        d="M8.662,9.745A4.872,4.872,0,1,0,3.79,4.872,4.874,4.874,0,0,0,8.662,9.745Zm4.331,1.083H11.129a5.89,5.89,0,0,1-4.933,0H4.331A4.331,4.331,0,0,0,0,15.159V15.7a1.625,1.625,0,0,0,1.624,1.624H15.7A1.625,1.625,0,0,0,17.324,15.7v-.541A4.331,4.331,0,0,0,12.993,10.828Z"
                        fill="#fff"></path>
                </svg>
                <span class="text-white uppercase">{{ __('messages.sign_in') }}</span>
            </button>
        </div>
    </div>
</nav>
