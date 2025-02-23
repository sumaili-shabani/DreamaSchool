@if(isset(auth()->user()->email))
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{csrf_token() }} ">
        <script>window.Laravel={ csrfToken:'{{csrf_token() }}'} </script>


        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">


        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Dashboard | Pharma-Dream</title>

       <!--  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">


        <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet"> -->

        <!-- <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet"> -->

        <!-- mes scripts -->
        <link rel="stylesheet" type="text/css" href="assets/css/font-awesome/css/font-awesome.min.css">

        <!-- <link rel="stylesheet" type="text/css" href="assets/css/font-awesome/css/materialdesignicons.min.css"> -->
        <!-- Fonts -->
        <link rel="shortcut icon" href="./images/vue.png">
        <!-- fin mes scripts -->

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"> -->

    </head>
    <body  >

    <div id="app">
          <!-- <dashboard />  -->

          <app-init></app-init>

    </div>


    <script type="text/javascript">
        window.emerfine = {!! json_encode([
            'baseURL' => url('/'),
            'apiBaseURL' => url('/api'),
            'user' => auth()->user()
        ]) !!}
    </script>



    <script src="{{mix('/js/app.js')}}"></script>
    </body>
</html>

@else
<script type="text/javascript">
   window.location="{{url('/login')}}";
</script>
@endif



