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
                <h4 class="title">{{$setting->page1_body_title}}</h4>
                <div class="input-box">
                        <div class="input-field">
                            <input type="text" id="1" pattern="[0-9]*" inputtype="numeric" maxlength=1 required>
                            <input type="text" id="2" pattern="[0-9]*" inputtype="numeric" maxlength=1 required>
                            <input type="text" id="3" pattern="[0-9]*" inputtype="numeric" maxlength=1 required>
                            <input type="text" id="4" pattern="[0-9]*" inputtype="numeric" maxlength=1 required>
                        </div>

                        <div class="submit">
                            <button type="" onclick="matchCode()">{{$setting->page1_button_title}}</button>
                        </div>
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

        // input otp field 
        let in1 = document.getElementById('1'),
            ins = document.querySelectorAll('input[type="text"]');

        ins.forEach(function(input) {
            input.addEventListener('keyup', function(e){
                // Break if Shift, Tab, CMD, Option, Control.
                if (e.keyCode === 16 || e.keyCode == 9 || e.keyCode == 224 || e.keyCode == 18 || e.keyCode == 17) {
                    return;
                }
                
                // On Backspace or left arrow, go to the previous field.
                if ( (e.keyCode === 8 || e.keyCode === 37) && this.previousElementSibling && this.previousElementSibling.tagName === "INPUT" ) {
                    this.previousElementSibling.select();
                } else if (e.keyCode !== 8 && this.nextElementSibling) {
                    this.nextElementSibling.select();
                }
            });
            input.addEventListener('focus', function(e) {
                // If the focus element is the first one, do nothing
                if ( this === in1 ) return;
                
                // If value of input 1 is empty, focus it.
                if ( in1.value == '' ) {
                    in1.focus();
                }
                
                // If value of a previous input is empty, focus it.
                // To remove if you don't wanna force user respecting the fields order.
                if ( this.previousElementSibling.value == '' ) {
                    this.previousElementSibling.focus();
                }
            });
        });
        in1.addEventListener('input', function(e) {
            let data = e.data || this.value; // Chrome doesn't get the e.data, it's always empty, fallback to value then.
            if ( ! data ) return; // Shouldn't happen, just in case.
            if ( data.length === 1 ) return; // Here is a normal behavior, not a paste action.
            
            for (i = 0; i < data.length; i++ ) {
                ins[i].value = data[i];
            }
        });

        // end of input otp field
    </script>
</body>

</html>
