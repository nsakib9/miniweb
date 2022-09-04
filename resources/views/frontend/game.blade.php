<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$app_name</title>

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/game.css') }}">
    <style>
	#wpadminbar,
	#masthead,
    #site-header,
    #site-footer {
        display: none;
    }
    
    .login-form {
        position: absolute;
        width: 400px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 40px;
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .login-form img {
        max-width: 150px;
        display: flex;
        margin: 0 auto;
        margin-bottom: 20px;
    }
    #loginform label {
        display: block;
    }
    #loginform input[type="text"],
    #loginform input[type="password"] {
        width: 100%;
        background: white;
        border: none;
    }
    #loginform input[type="submit"] {
        background: #FFA92A;
        border: 1px solid #FFA92A;
        color: #fff;
        padding: 14px 22px;
        cursor: pointer;
        border-radius: 0;
    }
</style>
</head>

<body>

    <div class="smartphone">
        <div class="game-box" style="	background: url($background_image) no-repeat center / cover;
">
            <div class="bg-white">


                <div class="logo">
                    <img src="$logo" alt="logo--">
                </div>
                        <!--             Main Content Start Page 2  -->
                        <h3 class="title title-2">$page2_heading</h3>
                        </h3>
                        <h4 class="title">
                        </h4>
                        <form action="" method="POST">
                            <div class="cow submit btn">
                                <button type="submit" name="start_game"><img src="' . $game_img" alt=""></button>
                            </div>
                            <input type="hidden" name="step3" value="3">
                            <div class="submit btn margin">
                                <button type="submit" name="start_game"></button>
                            </div>
                        </form>
                        <!--             Main Content End  Page 2 -->

<form action="" method="POST">
                    <input type="hidden" name="step3" value="3">
                    <div class="submit btn margin">
                        <button type="submit" name="start_game">ゲーム開始</button>
                    </div>
                </form>
                <div class="btn">
                    <a href="">>>スキップ>> </a>
                </div>
                        <!--             Main Content Start for page-3  -->
                        <div class="cow three-column">
                            <a href="#" class="randomButton"><img src=" $game_img" alt="$game_img"></a>
                            <a href="#" class="randomButton"><img src=" $game_img" alt="$game_img"></a>
                            <a href="#" class="randomButton"><img src=" $game_img" alt="$game_img"></a>
                            <a href="#" class="randomButton"><img src=" $game_img" alt="$game_img"></a>
                            <a href="#" class="randomButton"><img src="$game_img" alt="$game_img"></a>
                            <a href="javascript::void(0)" class="randomButton"><img src="$game_img" alt="$game_img"></a>
                        </div>
                        <!-- <form action="" method="POST" id="myForm" style="">
                        <input type="hidden" name="step4" value="4">
                        <button type="submit" name="GoToStep4">ゲーム開始</button>
                    </form> -->
                        <h4 class="title"></h4>
                        <h4 class="title title-3"></h4>

                        <!--           End of   Main Content  for page-3  -->
                /* ================================================== END Functionality for Page 2 /Step 2  ==================================*/
                    <!--           End of   Main Content  for page-4  -->
                    <h3 class="title title-2"></h3>
                    <div class="cow">
                        <a href="#" class="getPoint"><img src="$game_img" alt=""></a>
                    </div>
                    <!--           End of   Main Content  for page-4  -->

                    <div class="point-box">
                        <div class="point-circle">
                            <span class="point"></span>
                            <span class="point-text">点</span>
                        </div>
                    </div>
                    <div class="btn btn-2">
                        <form action="" method="POST">
                            <input type="hidden" name="step5" value="5">
                            <input type="hidden" name="points" value="">
                            <div class="submit btn margin">
                                <button type="submit" name="start_games">
                                    
                                    <br>
                                    </button>
                            </div>
                        </form>
                        <a href="#" class="">

                        </a>
                    </div>
                    <!--           End of   Main Content  for page-5  -->
                    <div class="point-box">
                        <div class="point-circl">
                            <h3 class="title title-4">グーム参加ありがとうございます  様 今回の獲得[: 」点を送ります </h3>
                        </div>
                    </div>
                    <!--             Main Content Start for page-1  -->
                    <h4 class="title"></h4>
                    <div class="input-box">
                        <form action="" name="one-time-code" method="POST">
                            <div class="input-field">
                                <input type="hidden" name="step" value="2">
                                <input type="text" name="otp_digit_1" pattern="[0-9]*" inputtype="numeric" id="otc-1" maxlength=1 required>
                                <input type="text" name="otp_digit_2" pattern="[0-9]*" inputtype="numeric" id="otc-2" maxlength=1 required>
                                <input type="text" name="otp_digit_3" pattern="[0-9]*" inputtype="numeric" id="otc-3" maxlength=1 required>
                                <input type="text" name="otp_digit_4" pattern="[0-9]*" inputtype="numeric" id="otc-4" maxlength=1 required>
                            </div>
                            <div class="submit">
                                <button type="submit" name="check_otp"></button>
                            </div>
                        </form>
                    </div>
                    <!--           End of   Main Content  for page-1  -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
    $('.randomButton').click(function(event) {
  
            var login_access = "$login_access;";
            event.preventDefault();
            if (login_access == '1') {
                var form = $(document.createElement('form'));
                $(form).attr("action", "");
                $(form).attr("method", "POST");
                var input = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "step4")
                    .val("4");
                $(form).append($(input));
                form.appendTo(document.body)
                $(form).submit();
            } else {
                alert("最初にログインしてください");
            }


        });
    $('.getPoint').click(function(event) {
            event.preventDefault();
            $Sec_Max = $probablity_1 + $probablity_2;
            $Third_Max = $probablity_1 + $probablity_2 + $probablity_3;
            $last_Max = $probablity_1 + $probablity_2 + $probablity_3 + $probablity_4;
            $arr = array(
                $point_1    =>  array('min' =>  0, 'max' =>  $probablity_1),
                $point_2  =>  array('min' => $probablity_1 + 1, 'max' =>  $Sec_Max),
                $point_3    =>  array('min' =>  $Sec_Max + 1, 'max' => $Third_Max),
                $point_4  =>  array('min' => $Third_Max + 1, 'max' => $last_Max),
            );
            $rnd = rand(1, 100);
            foreach ($arr as $k => $v) {
                if ($rnd > $v['min'] && $rnd <= $v['max']) {
                    echo $k, "\n";

                    var form = $(document.createElement('form'));
                    $(form).attr("action", "");
                    $(form).attr("method", "POST");
                    var input = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", "score")
                        .val($k;);
                    $(form).append($(input));
                    form.appendTo(document.body)
                    $(form).submit();
                }
        });
    
    
        // input otp field 
        let in1 = document.getElementById('otc-1'),
            ins = document.querySelectorAll('input[type="text"]');

        ins.forEach(function(input) {
            /**
             * Control on keyup to catch what the user intent to do.
             * I could have check for numeric key only here, but I didn't.
             */
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
            
            /**
             * Better control on Focus
             * - don't allow focus on other field if the first one is empty
             * - don't allow focus on field if the previous one if empty (debatable)
             * - get the focus on the first empty field
             */
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

        /**
         * Handle copy/paste of a big number.
         * It catches the value pasted on the first field and spread it into the inputs.
         */
        in1.addEventListener('input', function(e) {
            let data = e.data || this.value; // Chrome doesn't get the e.data, it's always empty, fallback to value then.
            if ( ! data ) return; // Shouldn't happen, just in case.
            if ( data.length === 1 ) return; // Here is a normal behavior, not a paste action.
            
            for (i = 0; i < data.length; i++ ) {
                ins[i].value = data[i];
            }
        });

        // end of input otp field
  
        
        /*   window.location.hash = "error";
          // Again because Google Chrome doesn't insert
          // the first hash into the history
          window.location.hash = "error-to-back";
          window.onhashchange = function() {
              window.location.hash = "error";
          } */
    </script>
    
    <script>
        let digitValidate = function(ele) {
            ele.value = ele.value.replace(/[^0-9]/g, '');
        }

        let tabChange = function(val) {
            let ele = document.querySelectorAll('.next-step');
            if (ele[val - 1].value != '') {
                ele[val].focus()
            } else if (ele[val - 1].value == '') {
                ele[val - 2].focus()
            }
        }
    </script>
<script>
    // var buttonGet = document.getElementById('wp-submit');
    // buttonGet.addEventListener('click', function(e){
    //     e.preventDefault();
    // });
</script>
</body>

</html>