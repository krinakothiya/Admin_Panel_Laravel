<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    @include("frontend.partial.head_link")
    @stack('css')

    

</head>

<body>
    {{-- header --}}
    @include("frontend.partial.header")

    {{-- side bar --}}
    @include("frontend.partial.navigation")

    {{-- content --}}
    @yield('frontend_content','frontend Content')

    {{-- footer --}}
    @include("frontend.partial.footer")


</body>
</html>

@stack('javascript')