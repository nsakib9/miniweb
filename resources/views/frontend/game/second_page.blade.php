<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$setting->app_name}}</title>

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
</head>
<body>
    
    <div class="smartphone">
        <div class="game-box">
            <div class="bg-white">
                <div class="logo">
                    <img src="{{ asset('/storage/settings/' . $setting->logo) }}" alt="logo">
                </div>
                <h3 class="title title-2">{{$setting->page2_heading}}</h3>
                <h4 class="title">
                    {{$setting->page2_heading2}}
                </h4>
                <div class="cow">
                    <a href="{{route('game.page3')}}"><img src="{{ asset('/storage/settings/' . $setting->game_img) }}" alt="cow"></a>
                </div>

                <div class="btn margin">
                    <a href="{{route('game.page3')}}">{{$setting->page2_game_start_text}}</a>
                </div>
                <div class="btn">
                    <a href="{{url('/')}}">>>{{$setting->page2_game_skip_text}}>></a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>