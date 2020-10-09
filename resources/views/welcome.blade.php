<?php
$siteinfo = DB::table('site_infos')->whereIn('user_id', [1,2])->first();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $siteinfo->title }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
                background-color: #465a5a;
                padding: 15px;
                opacity: 0.8;
                color: #fffcfc;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            #main-body{
                background-image: url('img/celular.jpg');
            }
            .links{                
                visibility: visible;
            }
            .links a{
                color: #fff;
                transition: 800ms;
                overflow: visible;
            }
            .links a:hover{
                color: rgb(136, 219, 252);
                font-weight: 800;
            }
            .blue{
                color:#1d1dff;
                text-shadow: 1px 1px 3px rgb(255 255 255);
            }
        </style>
    </head>
    <body>
        <div id="main-body" class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-mdtop">
                    <b>Welcome to <span class="blue">{{ $siteinfo->title }}</span></b>
                </div>

                <div class="links">
                   <h1> If you new here and don't have any account then join hurry up with a lot of community people. <a href="{{ route('register') }}">Register</a> first. Otherwise <a href="{{ route('login') }}">Login</a></h1>
                </div>
            </div>
        </div>
    </body>
</html>
