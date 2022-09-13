<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
    </style>
</head>

<body>
    <div class="game-box game-box-2" id="wpScore">
        <div class="bg-shadow">
            <div class="logo text-center">
                <img src="" alt="logo--">
            </div>
            <br>
            <a href="{{ route('dashboard') }}" target="">Dashboard</a> &nbsp; &nbsp;
            <a href="{{ route('show.settings') }}" target="">Settings</a> &nbsp; &nbsp;
            <a href="{{ route('game.page1') }}" target="_blank">Play Game</a>

            <h3 class="title title-2 text-center">管理パネル</h3>
            <div class="point-box">

                <h2>ワンタイムパスワードテーブル</h2>

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>メールアドレス</th>
                            <th>獲得ポイント</th>
                            <th>日時</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(score, index) in scores" :key="score.id">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ score . user . name }}</td>
                            <td>@{{ score . score }}</td>
                            <td>@{{ score . created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        let app = new Vue({
            el: '#wpScore',
            data: {
                scores: []
            },
            methods: {
                getScore() {
                    let ref = this;
                    let url = '/api/score';
                    axios.get(url).then(function(response) {
                        let data = response.data;
                        ref.scores = data.score;
                        console.log(ref.scores);
                    });
                }
            },
            created() {
                this.getScore();
            }
        });
    </script>
</body>

</html>
