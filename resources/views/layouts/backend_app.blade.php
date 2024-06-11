<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <meta name="csrf-token" content="{{ csrf_token() }}">
   
   <title>{{ config('app.name', 'Laravel') }}</title>

   @include("partial.head_link")
   @stack('css')

</head>

<body class="sb-nav-fixed">

    {{-- header --}}
    @include("partial.header")
    <div id="layoutSidenav">

        {{-- side bar --}}
        @include("partial.navigation")

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @yield('heading','Dashboard')
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                    @yield('backend_content','Backend Content')
                </div>
            </main>
            @include("partial.footer")
        </div>
    </div>

    
</body>
</html>

@stack('javascript')

