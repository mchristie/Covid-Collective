<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Covid Collective</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">

    <link href="{{mix('css/app.css')}}" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container-fluid bg-light">

        <div class="container">
            <div class="row pt-3">
                <div class="col-sm">
                    <h1>🌈 &nbsp; Covid Collective</h1>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    @include('menu')
                </div>
            </div>
        </div>

    </div>

    <div class="container-fluid py-5 bg-white">
        <div class="container">
            
            @yield('content')

        </div>
    </div>

    <div class="container-fluid p-3 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <p class="text-muted text-small text-small">
                        Covid Collective is voluntary organisation and it would be most uncool to sue us.<br>
                        Our content is accurate only to the best of our effort and is provided in good faith.
                    </p>
                </div>
                <div class="col-sm-5">
                    <p class="text-right text-muted text-small">
                    
                        <a href="{{ route('home') }}" class="text-reset">
                            Home
                        </a>
                        &nbsp; | &nbsp;
                        <a href="{{ route('groups') }}" class="text-reset">
                            Groups
                        </a>
                        &nbsp; | &nbsp;
                        <a href="{{ route('resources') }}" class="text-reset">
                            Resources
                        </a>
                        &nbsp; | &nbsp;
                        <a href="{{ route('volunteer') }}" class="text-reset">
                            Volunteer
                        </a>
                        &nbsp; | &nbsp;
                        <a href="{{ route('help') }}" class="text-reset">
                            Help
                        </a>
                        
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://kit.fontawesome.com/9856bcf32a.js" crossorigin="anonymous"></script>
        
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-2556711-33"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-2556711-33');
    </script>

</body>
</html>
