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
    <link href="https://fonts.googleapis.com/css?family=Nunito"
          rel="stylesheet"
          type="text/css">

    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
          crossorigin="anonymous">

    <link href="{{ asset('css/app.css') }}"
          rel="stylesheet">


    @stack('css')
</head>

<body>

@component('layouts.navbar_top')
    @yield('navbar_top')
@endcomponent

{{-- Content after panel top --}}
<div class="container-fluid">
    <div class="row">
        @component('layouts.sidebar')
            @yield('sidebar')
        @endcomponent

        <main role="main"
              id="app"
              class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            @yield('content')
        </main>
    </div>
</div>

{{-- Monkey planner JS --}}
<script src="{{ asset('js/app.js') }}"></script>

{{-- Feather icons --}}
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>

<script>
    feather.replace()
</script>


@stack('scripts')
</body>
</html>
