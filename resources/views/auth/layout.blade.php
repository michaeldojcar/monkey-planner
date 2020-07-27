<!doctype html>
<html lang="cs">
<head>
    <meta charset="utf-8">

    {{-- CSRF Token --}}
    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="">
    <meta name="author"
          content="">
    <link rel="icon"
          type="image/png"
          sizes="16x16"
          href="{{asset('favicon-16x16.png')}}">

    <title>
        @yield('title')
    </title>

    {{-- Fonts --}}
    <link rel="dns-prefetch"
          href="https://fonts.gstatic.com">

    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
          crossorigin="anonymous">

    <link href="{{ asset('css/ui_fullscreen.css') }}"
          rel="stylesheet">

    {{-- Javascript --}}
    <script src="{{ asset('js/app.js') }}"
            defer></script>

    <style>
        body {
            margin-top: 0;

            height: 100vh;
        }
    </style>

    @stack('css')
</head>

<body>

{{-- Content after panel top --}}
<div class="container-fluid">
    @yield('content')
</div>

{{-- Feather icons --}}
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>

<script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>


{{--    <script src="https://www.vantajs.com/dist/three.r95.min.js"></script>--}}
<script src="{{asset('js/libs/vanta.js')}}"></script>

<script>
  /*  VANTA.NET({
        el: "body",
        mouseControls: true,
        touchControls: true,
        minHeight: 200.00,
        minWidth: 200.00,
        scale: 1.00,
        scaleMobile: 1.00,
        color: 0xcfcece,
        backgroundColor: 0xfbf8ff,
        points: 17.00
    })*/
</script>

@stack('scripts')
</body>
</html>
