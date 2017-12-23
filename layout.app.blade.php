<html>
  <head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
  </head>
  <body>
    @if(Session::has('success'))
      <div class="alert alert-success" role=alert>
        {{ Session::get('success') }}
      </div>

    @endif
   @yield('header')
    <div class="container">
      @yield('content')
    </div>
      <script  src="{{ asset('js/app.js') }}"></script>
      <script  src="{{ asset('js/toastr.min.js') }}"></script>
      <script>
        @if(Session::has('success'))
        // Display a success toast, with a title
          toastr.success("{{ Session::get('success')}}", "task completed");
        @endif
        @if ($errors->any())
         @foreach ($errors->all() as $error)
         // Display an error toast, with a title
          toastr.error(' {{ $error }}', 'Error!')

         @endforeach
        @endif
      </script>

  </body>
</html>
