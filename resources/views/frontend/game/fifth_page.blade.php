<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->app_name }}</title>

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
</head>

<body>

    <div class="smartphone">
        <div class="game-box">
            <div class="bg-white">
                <div class="logo">
                    <img src="{{ asset('/storage/settings/' . $setting->logo) }}" alt="logo">
                </div>
                <h3 class="title title-2">{{ $setting->pg5_title }}</h3>
                <div class="point-box">
                     @if (!empty($message))
                        <div class="title"><span style="color:red;"> {{$message}} </span></div>
                        <img src="{{ asset('/storage/settings/' . $setting->game_img) }}" alt="cow"> 
                @else
                    <div class="point-circle">
                        <span class="point">{{ $score }}</span>
                        <span class="point-text">点</span>
                    </div>
                    @endif
                </div>

                <div class="btn btn-2">
                    <a href="{{route('game.page6')}}" class="">
                        {!! $setting->pg5_title2 !!}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onbeforeunload = function() {
            window.setTimeout(function() {
                    window.location = '{{route("game.page1")}}';
                
            }, 10000);
            window.onbeforeunload = null; // necessary to prevent infinite loop, that kills browser 
        }
    </script>
</body>

</html>
