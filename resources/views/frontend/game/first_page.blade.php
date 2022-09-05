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

    <div class="game-box">
        <div class="bg-white">
            <div class="logo">
                <img src="{{ asset('/storage/settings/' . $setting->logo) }}" alt="logo">
            </div>
            <h4 class="title">{{$setting->page1_body_title}}</h4>
            <div class="input-box">
                    <div class="input-field">
                        <input type="text" id="1">
                        <input type="text" id="2">
                        <input type="text" id="3">
                        <input type="text" id="4">
                    </div>

                    <div class="submit">
                        <button type="" onclick="matchCode()">{{$setting->page1_button_title}}</button>
                    </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/backend/plugins/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript">
        function matchCode() {
            var n1 = $('#1');
            var n2 = $('#2');
            var n3 = $('#3');
            var n4 = $('#4');
            var code = n1.val() + n2.val() + n3.val() + n4.val();

            let otp = '{{ $otp }}';
            if(code == otp){
                window.location.href =" {{ route('game.page2')}} ";
            }
            else{
                alert('Wrong Input! Code did not match');
            }
        };
    </script>
</body>

</html>
