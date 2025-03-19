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

    <div class="flex" style="display: flex; align-items: center; justify-content: center; height:100vh">
        <div>
            <h3> Your app requires an update </h3>
            <h3> التطبيق يتطلب التحديث </h3>
        </div>
    </div>

    @livewireScripts


</body>

</html>
