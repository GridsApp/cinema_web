<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Iraqi Cinema</title>

  <div>
    @include('website.partials.header',["compact"=>true])
  </div>
    @livewireStyles
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>


    @yield('content')



    @yield('scripts')
    
    
    @livewireScripts
    @include('website.partials.footer')
   
</body>

</html>
