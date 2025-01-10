<nav class="main" x-data="{ scrolled: false, isHome: {{ Route::currentRouteName() === 'home' ? 'true' : 'false' }}, mobileMenuOpen: false }" 
    x-init="if (isHome) {
        window.addEventListener('scroll', () => { scrolled = window.scrollY > 0 });
    }"
    :class="{
        'scrolled': isHome && scrolled,
        'bg-white background-white text-black': !isHome,
        'text-white': isHome && !scrolled
    }">
    <div class="flex main-container justify-between items-center">
        <div class="flex items-center justify-between w-full">
            <div>
                <a href="/">
                    <img :src="!isHome ? '/images/iraqi-logo-white.png' : (scrolled ? '/images/iraqi-logo-white.png' : '/images/normal-logo.svg')"
                        alt="Logo" class="w-[100px] transition-all duration-300">
                </a>
            </div>
            <div class="flex md:hidden">
            
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white">
                    <i class="fa-solid fa-bars text-black"></i>
                </button>
            </div>
            <div class="hidden md:flex flex-row gap-5 items-center">
                <a href="/about-us" class="nav-text">About us</a>
                <a wire:navigate href="/movies/listing" class="nav-text">What's On</a>
                <a href="/branches/listing" class="nav-text">Cinemas</a>
                <a href="/contact-us" class="nav-text">Contact us</a>
                <div>
                    <a href="/register" class="bg-primary-color hover:bg-black inline-flex px-10 py-2 rounded-full gap-3 text-[10px] items-center tracking-[1.95px] font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17.324" height="17.324" viewBox="0 0 17.324 17.324">
                            <path id="Icon_awesome-user-alt" data-name="Icon awesome-user-alt"
                                d="M8.662,9.745A4.872,4.872,0,1,0,3.79,4.872,4.874,4.874,0,0,0,8.662,9.745Zm4.331,1.083H11.129a5.89,5.89,0,0,1-4.933,0H4.331A4.331,4.331,0,0,0,0,15.159V15.7a1.625,1.625,0,0,0,1.624,1.624H15.7A1.625,1.625,0,0,0,17.324,15.7v-.541A4.331,4.331,0,0,0,12.993,10.828Z" fill="#fff"></path>
                        </svg>
                        <span class="text-white uppercase">Sign in</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0" x-transition:enter-end="transform opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="transform opacity-100"
        x-transition:leave-end="transform opacity-0" class="md:hidden bg-black absolute top-full left-0 w-full p-5">
        <a href="/about-us" class="block text-white py-2">About us</a>
        <a wire:navigate href="/movies/listing" class="block text-white py-2">What's On</a>
        <a href="/branches/listing" class="block text-white py-2">Cinemas</a>
        <a href="/contact-us" class="block text-white py-2">Contact us</a>
        <div class="mt-4">
            <button class="bg-primary-color hover:bg-black inline-flex px-10 py-2 rounded-full gap-3 text-[10px] items-center tracking-[1.95px] font-bold w-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.324" height="17.324" viewBox="0 0 17.324 17.324">
                    <path id="Icon_awesome-user-alt" data-name="Icon awesome-user-alt"
                        d="M8.662,9.745A4.872,4.872,0,1,0,3.79,4.872,4.874,4.874,0,0,0,8.662,9.745Zm4.331,1.083H11.129a5.89,5.89,0,0,1-4.933,0H4.331A4.331,4.331,0,0,0,0,15.159V15.7a1.625,1.625,0,0,0,1.624,1.624H15.7A1.625,1.625,0,0,0,17.324,15.7v-.541A4.331,4.331,0,0,0,12.993,10.828Z" fill="#fff"></path>
                </svg>
                <span class="text-white uppercase">Sign in</span>
            </button>
        </div>
    </div>
</nav>
