<!doctype html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAMP ADMIN</title>

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/game.css') }}">
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

        .game-box {
            width: 100%;
            text-align: left;

        }
    </style>
</head>

<body>
    <div class="game-box game-box-2" style="padding:10px;">
        <div class="bg-shadow">
            <div class="logo text-center">
                <img src="{{asset('/storage/settings/'.$setting->logo)}}" alt="logo--">
            </div>
            @include('message')
            <!--         START OF SITE SETTING -->
            <br>
            <a href="{{route('dashboard')}}" target="">Dashboard</a> &nbsp; &nbsp;
            <a href="{{route('show.otp')}}" target="">Add/View OTP</a> &nbsp; &nbsp;
            <a href="{{route('game.page1')}}" target="_blank">Play Test Game</a>
            <hr>
            <h3>サイト設定</h3>
            <form class="form-inline" action="{{ route('store.settings') }}" enctype="multipart/form-data"
                method="POST">
                @csrf
                <label for="app_name">アプリ名</label>
                <input type="text" id="app_name" placeholder="" name="app_name" value="{{ $setting->app_name }}">

                <label for="logo">ロゴ ( 画像リンクを挿入 )</label>
                <input type="file" id="logo" placeholder="" name="logo" value="{{ $setting->logo }}">

                <label for="background_image">背景画像 ( 画像リンクを挿入 )</label>
                <input type="file" id="background_image" placeholder="" name="background_image"
                    value="{{ $setting->background_image }}">

                <label for="game_img">ゲームイメージ ( 画像リンクを挿入 )</label>
                <input type="file" id="game_img" placeholder="" name="game_img" value="{{ $setting->game_img }}">
                <br>
                <!--         END OF SITE SETTING -->

                <!--         START OF PAGE 1 SETTING -->
                <h3>Page1設定</h3>
                <label for="email">題名</label>
                <input type="text" id="page1_body_title" placeholder="" name="page1_body_title"
                    value="{{ $setting->page1_body_title }}">
                <label for="pwd">ボタンテキスト</label>
                <input type="text" id="page1_button_title" placeholder="" name="page1_button_title"
                    value="{{ $setting->page1_button_title }}">
                <br>
                <!--         END OF SITE SETTING -->

                <!--         START OF PAGE 2 SETTING -->
                <h3>Page2 設定</h3>
                <label for="email">題名</label>
                <input type="text" id="page2_heading" placeholder="" name="page2_heading"
                    value="{{ $setting->page2_heading }}">
                <label for="pwd">2番目の見出し</label>
                <input type="text" id="page2_heading2" name="page2_heading2" value="{{ $setting->page2_heading2 }}">
                <label for="pwd">ゲーム開始テキスト</label>
                <input type="text" id="page2_game_start_text" name="page2_game_start_text"
                    value="{{ $setting->page2_game_start_text }}">
                <label for="pwd">ゲームスキップテキスト</label>
                <input type="text" id="page2_game_skip_text" name="page2_game_skip_text"
                    value="{{ $setting->page2_game_skip_text }}">
                <br>
                <!--         END OF PAGE 2 SETTING -->

                <!--         START OF PAGE 3 SETTING -->
                <h3>Page3設定</h3>
                <label for="email">題名</label>
                <input type="text" id="pg3_title" name="pg3_title" value="{{ $setting->pg3_title }}">
                <label for="pwd">注意テキスト</label>
                <input type="text" id="pg3_caution" name="pg3_caution" value="{{ $setting->pg3_caution }}">
                <br>
                <!--         END OF PAGE 2 SETTING -->

                <!--         START OF PAGE 4 SETTING -->
                <h3>Page4設定</h3>
                <label for="email">スコアテキスト</label>
                <input type="text" id="pg4_score_txt" name="pg4_score_txt" value="{{ $setting->pg4_score_txt }}">
                <br>
                <!--         END OF PAGE 4 SETTING -->

                <!--         START OF PAGE 5 SETTING -->
                <h3>Page5設定</h3>
                <label for="email">題名</label>
                <input type="text" id="pg5_title" name="pg5_title" value="{{ $setting->pg5_title }}">
                <label for="email">タイトル2</label>
                <input type="text" id="pg5_title2" name="pg5_title2" value="{{ $setting->pg5_title2 }}">
                <br>
                <!--         END OF PAGE 5 SETTING -->

                <!--         START OF Login Permission -->
                <h3>ログイン制限設定</h3>
                <label for="login_access">ユーザーログイン制限を設定しますか？</label>
                <select type="text" id="login_access" name="login_access">
                    <option selected disabled>一つ選択してください</option>
                    <option value="1" {{($setting->login_access)? 'selected' : ''}}>はい</option>
                    <option value="0" {{($setting->login_access)? '' : 'selected'}}>いいえ</option>
                </select>
                <br>
                <!--         END OF Login Permission -->
                {{-- <button type="submit" name="save">保存</button> --}}
            {{-- </form> --}}
            <!--         Save Settings End -->
            <hr>
            <h3>ポイント確率の管理</h3>

            {{-- <form class="form-inline" action="{{route('show.probability')}}" enctype="multipart/form-data" method="POST">
                @csrf --}}
                <table class="table table-sm ">
                    <thead>
                        <tr>
                            <th scope="col text-letf" wiidth="32%">ポイント</th>
                            <th scope="col"> <input type="text" id="point_1" name="point_1" value="{{ $setting->point_1 }}" required>
                            </th>
                            <th scope="col"> <input type="text" id="point_2" name="point_2" value="{{ $setting->point_2 }}" required>
                            </th>
                            <th scope="col"> <input type="text" id="point_3" name="point_3" value="{{ $setting->point_3 }}" required>
                            </th>
                            <th scope="col"> <input type="text" id="point_4" name="point_4" value="{{ $setting->point_4 }}" required>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">確率 (%)</th>
                            <td> <input type="text" id="probablity_1" name="probablity_1" value="{{ $setting->probablity_1 }}" required>
                            </td>
                            <td> <input type="text" id="probablity_2" name="probablity_2" value="{{ $setting->probablity_2 }}" required>
                            </td>
                            <td> <input type="text" id="probablity_3" name="probablity_3" value="{{ $setting->probablity_3 }}" required>
                            </td>
                            <td> <input type="text" id="probablity_4" name="probablity_4" value="{{ $setting->probablity_4 }}" required>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5"><button type="submit" name="save">保存</button></th>
                        </tr>
                    </tbody>
                </table>
            </form>
            <br>

            <!--         END OF PAGE 5 SETTING -->
        </div>
    </div>

    <script type="text/javascript"></script>
</body>

</html>
