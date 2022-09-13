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
                <h3 class="title title-2">{{$setting->pg4_score_txt}}</h3>
                <div class="cow">
                    @auth
                        <a href="{{route('game.page5')}}"><img src="{{ asset('/storage/settings/' . $setting->game_img) }}" alt="cow"></a>
                    @endauth
                    @guest
                        <a onclick="alert('Please log in to view score')"><img src="{{ asset('/storage/settings/' . $setting->game_img) }}" alt="cow"></a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</body>
</html>
