@if (isset(auth()->user()->email))
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        {{-- debit --}}
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }} ">
        <meta name="csrf-token" value="{{ csrf_token() }}" />
        <script>
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            }
        </script>

        <meta name="viewport"
            content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">


        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Vue Banckend Application" />
        <meta name="keywords" content="School Project, Backend Project, VueProject" />
        <meta name="author" content="Dream of drc" />
        <meta name="robots" content="noindex, nofollow" />
        <title>Dashboard | Ecole</title>

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('vuetheme/assets/img/favicon.jpg') }}" />

        <link rel="stylesheet" href="{{ asset('vuetheme/assets/css/bootstrap.min.css') }}" />

        <link rel="stylesheet" href="{{ asset('vuetheme/assets/plugins/fontawesome/css/fontawesome.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('vuetheme/assets/plugins/fontawesome/css/all.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('vuetheme/assets/css/dataTables.bootstrap4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('vuetheme/assets/css/animate.css') }}" />

        <link rel="stylesheet" href="{{ asset('vuetheme/assets/css/dataTables.bootstrap4.min.css') }}" />

        <link rel="stylesheet" href="{{ asset('vuetheme/assets/css/style.css') }}" />
        {{-- fin --}}

        {{-- scanner qrcode --}}
        {{-- <script src="https://unpkg.com/html5-qrcode"></script> --}}




    </head>

    <body>

        {{-- <div id="global-loader">
            <div class="whirly-loader"></div>
        </div> --}}

        <div id="app" data-app>

            <dashboard />

        </div>


        <script type="text/javascript">
            window.emerfine = {!! json_encode([
                'baseURL' => url('/'),
                'apiBaseURL' => url('/api'),
                'user' => auth()->user(),
            ]) !!}
        </script>



        <script src="{{ asset('vuetheme/assets/js/jquery-3.6.0.min.js') }}"></script>

        <script src="{{ asset('vuetheme/assets/js/feather.min.js') }}"></script>
        <script src="{{ asset('vuetheme/assets/js/jquery.slimscroll.min.js') }}"></script>

        <script src="{{ asset('vuetheme/assets/js/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('vuetheme/assets/js/script.js') }}"></script>


        <script type="text/javascript">
            window.emerfine = {!! json_encode([
                'baseURL' => url('/'),
                'apiBaseURL' => url('/api'),
                'user' => auth()->user(),
            ]) !!}
        </script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>

    </html>
@else
    <script type="text/javascript">
        window.location = "{{ url('/login') }}";
    </script>
@endif
