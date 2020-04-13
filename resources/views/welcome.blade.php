<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
       <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-6 mt-2 text-center">
                    <img src="{{ asset('images/what-is-crowds.png') }}" class="img-fluid" alt="what is crowds?">
                </div>
            </div>


            <div class="row justify-content-center">
                <div class="col-md-6">
                   <p class="lead">
                       Crowds is an app that allows neighbors of the same barangay to perform services like buying goods, getting transportation, getting haircut, and many others. It's free to use, and you only pay for the services rendered by your neighbor (it can also be for free if your neighbor simply wants to help).
                   </p>
                   <a href="/get-started" class="btn btn-block btn-primary">Get Started</a>
                </div>
            </div>

        </div>
    </body>
</html>
