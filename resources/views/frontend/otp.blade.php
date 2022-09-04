<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAMP ADMIN</title>

    <link rel="stylesheet" href="{{asset('assets/frontend/css/game.css')}}">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        #page_links {
            font-size: 12px;
            margin: 3px;
            text-decoration: none;
            border: 1px #FFA92A solid;
            padding: 8px 20px;
        }

        #page_a_link {
            font-size: 12px;
            border: 1px #FFA92A solid;
            color: #FFA92A;
            padding: 8px 20px;
            margin: 3px;
            text-decoration: none;
        }

        #site-header,
        #site-footer {
            display: none;
        }
    </style>
</head>

<body>
    <div class="game-box game-box-2">
        <div class="bg-shadow">
            <div class="logo text-center">
                <img src="$logo" alt="">
            </div>
            <br>
            <a href="{{route('show.settings')}}" target="">Settings</a> &nbsp; &nbsp;
            <a href="" target="_blank">Play Game</a>

            <h3 class="title title-2 text-center">管理パネル</h3>
            <div class="point-box">

                {{-- <div class="otp-box">
                                <form action="" method="POST">
                                    <label for="fname">有効日を選択</label><br>
                                    <input type="date" id="date" name="date" value=""><br>
                                    <label for="fname">有効期限 </label><br>
                                    <input type="date" id="date" name="date_valid_to" value="" require><br>
                                    <label for="lname">タイプOTPコード：</label><br>
                                    <input type="text" id="otp" name="otp" value="">
                                    <label for="cars">選択する：</label> <br>
                                    <input type="submit" value="アップデート" name="updateOTP">
                                </form>
                            </div> --}}
                <div class="otp-box">
                    <form action="{{route('store.otp')}}" method="POST">
                        @csrf
                        <label for="date">有効日を選択:</label><br>
                        <input type="date" id="date" name="date" require><br>
                        <label for="fname">有効期限 </label><br>
                        <input type="date" id="date" name="date_valid_to" require><br>
                        <label for="lname">タイプOTPコード：</label><br>
                        <button type="button" onClick="AutoGenerateOTP()">OTPの自動生成</button><input type="text"
                            id="otp" name="otp" readonly>
                        <input type="submit" value="送信" name="addOTP">
                        <button type="button" onClick="Refresh()">ページの更新</button>
                    </form>
                </div>

            </div>
            <h2>ワンタイムパスワードテーブル</h2>

            <table>
                <tr>
                    <th>有効な日</th>
                    <th>有効期限</th>
                    <th>OTPコード </th>
                    <th>状態</th>
                    <th>で作成</th>
                    <th>編集</th>
                    <th>消去</th>

                </tr>
                @foreach ($otps as $otp)
                   <tr>
                        <td>{{$otp->date}}</td>
                        <td>{{$otp->date_valid_to}}</td>
                        <td>{{$otp->otp}}</td>
                        <td>{{($otp->status)? 'Active' : 'Deactive'}}</td>
                        <td>{{$otp->created_at}}</td>
                        <td>
                            <a href="">Edit</a>
                        </td>
                        <td>
                            <a href="">Delete</a>
                        </td>
                    </tr> 
                @endforeach
                
            </table>
        </div>
    </div>
    <script>
        function Refresh() {
            window.parent.location = window.parent.location.href;
        }

        function AutoGenerateOTP() {
            var val = Math.floor(1000 + Math.random() * 9000);
            document.getElementById("otp").value = val;
        }
    </script>
</body>
</html>
