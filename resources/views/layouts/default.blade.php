<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? '' }} | Meet Doctor</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/frontsite/main.css') }}" />

    @stack('styles')
</head>

<body>
    @include('sweetalert::alert')

    <!-- Header -->
    @include('includes.frontsite.navbar')
    <!-- End Header -->

    @yield('content')

    <script defer src="https://unpkg.com/alpinejs@3.8.0/dist/cdn.min.js"></script>

    <script>
        function logout() {
            document.getElementById('logout-user-form').submit();
        }
    </script>

    @stack('scripts')
</body>

</html>