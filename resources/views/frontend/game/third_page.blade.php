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
                
                <div class="cow three-column">
                    <a href="{{route('game.page4')}}"><img src="{{ asset('/storage/settings/' . $setting->game_img) }}" alt="cow"></a>
                    <a href="{{route('game.page4')}}"><img src="{{ asset('/storage/settings/' . $setting->game_img) }}" alt="cow"></a>
                    <a href="{{route('game.page4')}}"><img src="{{ asset('/storage/settings/' . $setting->game_img) }}" alt="cow"></a>
                    <a href="{{route('game.page4')}}"><img src="{{ asset('/storage/settings/' . $setting->game_img) }}" alt="cow"></a>
                    <a href="{{route('game.page4')}}"><img src="{{ asset('/storage/settings/' . $setting->game_img) }}" alt="cow"></a>
                    <a href="{{route('game.page4')}}"><img src="{{ asset('/storage/settings/' . $setting->game_img) }}" alt="cow"></a>
                </div>

                <h4 class="title">{!! $setting->pg3_title !!}</h4>
                <h4 class="title title-3">{{$setting->pg3_caution}}</h4>

            </div>
        </div>
    </div>

</body>
</html>