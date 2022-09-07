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
                <div class="point-box">
                    <div class="point-circl">
                        <h3 class="title title-4">グーム参加ありがとうございます game-admin 様 今回の獲得[:3 」点を送ります </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
