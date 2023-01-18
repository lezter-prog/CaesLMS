<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Assesment</title>

    <style>
        body {
          margin: 0;
          font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
          font-size: 16px;
          line-height: 1.5;
        }
  
        main {
          max-width: 600px;
          margin: 0 auto;
          padding: 0 16px;
          box-sizing: border-box;
          position: relative;
        }
        
        h1 {
          display: inline-block;
        }
        .pointer {cursor: pointer;}
      </style>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <script src="{{ URL::asset('js/jquery.min.js'); }}"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- <link href="{{ URL::asset('css/app.css'); }} " rel="stylesheet"> --}}
    <link href="{{ URL::asset('js/DataTables/datatables.min.css'); }} " rel="stylesheet">
    <link href="{{ URL::asset('js/DataTables/datatables.select.min.css'); }} " rel="stylesheet">
    <link href="{{ URL::asset('js/select2-4.0.13/dist/css/select2.min.css'); }} " rel="stylesheet">
    <link href="{{ URL::asset('js/select2/select2-bootstrap-5-theme.min.css'); }} " rel="stylesheet">
    <link href="{{ URL::asset('js/icheck-1.0.3/skins/all.css'); }} " rel="stylesheet">

    @yield('style')


</head>
<body>
    <div id="app">
        <main class ="main-content mt-10" style="margin-top: 10px;margin-bottom: 10px;background: white;box-shadow: 2px 3px 18px rgb(167, 160, 160);padding: 50px;">
            
            @yield('content')
        </main>
    </div>
    
    <script src="{{ URL::asset('js/DataTables/datatables.min.js'); }}"></script>
    <script src="{{ URL::asset('js/icheck-1.0.3/icheck.min.js'); }}"></script>
    <script src="{{ URL::asset('js/DataTables/datatables.select.min.js'); }}"></script>
    <script src="{{ URL::asset('js/select2-4.0.13/dist/js/select2.min.js'); }}"></script>
    <script src="{{ URL::asset('js/particles.js'); }}"></script>
    
    @yield('script')
    <script>

        particlesJS.load('particle-js', '/json/particles-config.json', function() {
            console.log('callback - particles.js config loaded');
        });
    </script>
</body>
</html>
