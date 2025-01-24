<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Iraqi Cinema</title>


    @livewireStyles
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div>
        @include('website.partials.header', ['compact' => true])
    </div>
    @php

        $is_home = request()->route()->getName() == 'home';

    @endphp

    <main class="@if (!$is_home) height-spacing @endif">
        @yield('content')


    </main>
    @yield('scripts')

    @include('CMSView::components.toast')
    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('initPhoneNumber', function() {
                var timeout = false;
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    window.GeneralFunctions.initPhone();
                }, 200);

            });
            Livewire.on('changeUrl', (event) => {
                console.log(event);

                const webPrefix = event[0].webPrefix;
                const currentUrl = window.location.href;

                const url = new URL(currentUrl);
                const pathnameSegments = url.pathname.split('/');

                if (webPrefix && pathnameSegments.length > 1) {
                    pathnameSegments[1] = webPrefix;

                    url.pathname = pathnameSegments.join('/');

                    window.history.pushState({
                        path: url.pathname
                    }, '', url.pathname);


                }
            });


        });
    </script>
    @include('website.partials.footer')

</body>

</html>
