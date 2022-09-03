 @php
    $user_id = $_SESSION["userID"] = 1;
    class Database
    {
        protected $db;
        public $ERROR;
        public $Id;
        function __construct()
        {
            $SERVER_NAME    = "localhost";
                $USER_NAME      = "root"; //vieknhno_wp826
                $PASSWORD       = "";     //opD64@S@I8
                $DB_NAME        = "miniweb"; //vieknhno_wp826
            $this->db = new mysqli($SERVER_NAME, $USER_NAME, $PASSWORD, $DB_NAME);
        }
        public function VD($data)
        {
            return htmlentities(strip_tags(trim(mysqli_real_escape_string($this->db, $data))));
        }
        public function insert($table, $arr)
        {
            $sql = "";
            foreach ($arr as $key => $value) {
                if ($sql != "") {
                    $sql .= ", ";
                }
                $sql .= "{$key}='{$value}'";
            }

            $sql = "insert into {$table} set " . $sql;
            //echo $sql;
            if ($this->db->query($sql)) {
                $this->Id = $this->db->insert_id;
                return TRUE;
            } else {
                $this->ERROR = $this->db->error;
                return FALSE;
            }
        }
        public function query($sql)
        {
            $this->db->query($sql);
            // echo $sql;
            return $this->db->query($sql);
        }
        public function delete($table, $id)
        {
            $sql = "delete from $table where id=$id";
            $this->db->query($sql);
            return $this->db->affected_rows;
        }
        public function update($table, $arr, $where)
        {
            $sql = "";
            foreach ($arr as $key => $value) {
                if ($sql != "") {
                    $sql .= ", ";
                }
                $sql .= "{$key}='{$value}'";
            }

            $sql = "update {$table} set " . $sql;

            $temp = "";
            if ($where) {
                foreach ($where as $key => $value) {
                    if ($temp != "") {
                        $temp .= " and ";
                    }
                    $temp .= "{$key}='{$value}'";
                }
                $sql .= " where $temp";
            }

            // echo $sql;
            return $this->db->query($sql);
        }
        public function view($table, $order = NULL, $where = NULL, $select = NULL, $rel = NULL)
        {
            $select = ($select == NULL) ? "*" : $select;
            $sql = "SELECT $select FROM $table";

            $temp1 = "";
            if ($rel) {
                foreach ($rel as $key => $value) {
                    if ($temp1 != "") {
                        $temp1 .= " and ";
                    }
                    $temp1 .= "{$key}={$value}";
                }
            }
            $temp2 = "";
            if ($where) {
                foreach ($where as $key => $value) {
                    if ($temp2 != "") {
                        $temp2 .= " and ";
                    }
                    $temp2 .= "{$key}='{$value}'";
                }
            }
            if ($temp1 != "" || $temp2 != "") {
                if ($temp1 != "" && $temp2 != "") {
                    $sql .= " where $temp1 and $temp2";
                } else if ($temp1 != "") {
                    $sql .= " where $temp1";
                } else if ($temp2 != "") {
                    $sql .= " where $temp2";
                }
            }
            if ($order) {
                $sql .= " order by {$order[0]} {$order[1]}";
            }
            //echo $sql;
            return $this->db->query($sql);
        }
        // function Redirect($url)
        // {
        //     echo "<script>self.location='$url';</script>";
        // }
    }
    function extension($data)
    {
        if ($data) {
            $ext = pathinfo($data);
            $ext = stripslashes(strtolower($ext['extension']));
            if ($ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "gif") {
                return "";
            } else {
                return $ext;
            }
        } else {
            return "";
        }
    }
    $d = new Database();

    // Create Table Automatically (game_info)
    $sql_to_create_table = "CREATE TABLE IF NOT EXISTS game_info (
    `id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL ,
`score_points` int(11) DEFAULT NULL,
`tracker` int(1) NOT NULL DEFAULT 0 COMMENT '0 = False(Not Played), 1= True(Played)\r\n',
`probablity` int(11) DEFAULT NULL,
`start_time` datetime DEFAULT current_timestamp(),
PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $creare_table = $d->query($sql_to_create_table);
    // Create Table Automatically (otp)

    $sql_to_create_table2 = "CREATE TABLE  IF NOT EXISTS `otp` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `day` date DEFAULT current_timestamp(),
        `date_valid_to` date DEFAULT current_timestamp(),
        `otp_code` int(4) DEFAULT NULL,
        `status` int(11) DEFAULT 1 COMMENT '1 = active, 0 = deactive',
        `user_id` int(11) DEFAULT NULL,
        `created_at` datetime DEFAULT current_timestamp(),
        `update_at` datetime DEFAULT current_timestamp(),
        PRIMARY KEY (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $creare_table = $d->query($sql_to_create_table2);


    // To Create All PAGE SETTING TABLE
    $sql_create_table_allPageSetting = "CREATE TABLE  IF NOT EXISTS `all_page_settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `app_name` varchar(255) DEFAULT NULL,
        `logo` varchar(255) DEFAULT NULL,
        `background_image` varchar(255) DEFAULT NULL,
        `game_img` varchar(255) DEFAULT NULL,
        `page1_body_title` varchar(255) DEFAULT NULL,
        `page1_button_title` varchar(255) DEFAULT NULL,
        `page2_heading` varchar(255) DEFAULT NULL,
        `page2_heading2` varchar(255) DEFAULT NULL,
        `page2_game_start_text` varchar(255) DEFAULT NULL,
        `page2_game_skip_text` varchar(255) DEFAULT NULL,
        `pg3_title` varchar(255) DEFAULT NULL,
        `pg3_caution` varchar(255) DEFAULT NULL,
        `pg4_score_txt` varchar(255) DEFAULT NULL,
        `pg5_title` varchar(255) DEFAULT NULL,
        `pg5_title2` varchar(255) DEFAULT NULL,
        `login_access` int(1) NOT NULL DEFAULT 1,
        PRIMARY KEY(id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$d->query($sql_create_table_allPageSetting);
    // FOR MAKING AN AUTO EVENT 
    $sql_event = "CREATE EVENT IF NOT EXISTS RESET_GAME_INFO ON SCHEDULE EVERY 1 HOUR DO UPDATE game_info SET tracker = 0 WHERE start_time >= DATE_SUB(NOW(), INTERVAL 24 HOUR) AND tracker = 1; ";
    $creare_table = $d->query($sql_event);
    $sql_to_create_pointOFProbabality = "CREATE TABLE  IF NOT EXISTS `point_and_probablity` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `point_1` varchar(22) DEFAULT NULL,
        `probablity_1` varchar(22) DEFAULT NULL,
        `point_2` varchar(22) DEFAULT NULL,
        `probablity_2` varchar(22) DEFAULT NULL,
        `point_3` varchar(22) DEFAULT NULL,
        `probablity_3` varchar(22) DEFAULT NULL,
        `point_4` varchar(22) DEFAULT NULL,
        `probablity_4` varchar(22) DEFAULT NULL,
          PRIMARY KEY(id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $creare_table = $d->query($sql_to_create_pointOFProbabality);
    // RUN THE ABOVE QUERY



    @endphp
    <!doctype html>
    <html lang="en-US">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="https://gmpg.org/xfn/11">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LAMP ADMIN</title>

        <link rel="stylesheet" href="style.css">
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




    @php
    if (isset($_POST['save'])) {
        $ext1 = extension($_FILES['logo']['name']);
        $ext2 = extension($_FILES['background_image']['name']);
       $ext3 = extension($_FILES['game_img']['name']);

        $data = array(
            "app_name" => $d->VD($_POST['app_name']),
            "logo" => "logo." . $ext1,
            "background_image" => "main-bg." . $ext2,
            "game_img" => "game_img." . $ext3,
            "page1_body_title" => $d->VD($_POST['page1_body_title']),
            "page1_button_title" => $d->VD($_POST['page1_button_title']),
            "page2_heading" => $d->VD($_POST['page2_heading']),
            "page2_heading2" => $d->VD($_POST['page2_heading2']),
            "page2_game_start_text" => $d->VD($_POST['page2_game_start_text']),
            "page2_game_skip_text" => $d->VD($_POST['page2_game_skip_text']),
            "pg3_title" => $d->VD($_POST['pg3_title']),
            "pg3_caution" => $d->VD($_POST['pg3_caution']),
            "pg4_score_txt" => $d->VD($_POST['pg4_score_txt']),
            "pg5_title" => $d->VD($_POST['pg5_title']),
            "pg5_title2" => $d->VD($_POST['pg5_title2']),
            "login_access" => $d->VD($_POST['login_access'])
        );
        if ($d->insert("all_page_settings", $data)) {
            global $wp;
            $url = home_url(add_query_arg(array(), $wp->request));
            echo "<script>self.location='$url';</script>";

            move_uploaded_file($_FILES['logo']['tmp_name'], "$path/logo." . $ext1);
            move_uploaded_file($_FILES['background_image']['tmp_name'], "$path/main-bg." . $ext2);
            move_uploaded_file($_FILES['game_img']['tmp_name'], "$path/game_img." . $ext3);
        } else {
            echo "failed";
        }
    }


    $num_of_rows = 0;
    $table = "all_page_settings";
    $result = $d->query("select * from $table  ORDER BY id DESC LIMIT 1");
    $value = $result->fetch_assoc();
    $num_of_rows = $result->num_rows;


    $id = '';
    $app_name = '';
    $logo = '';
    $background_image = '';
    $game_img = '';
    $page1_body_title = '';
    $page1_button_title = '';
    $page2_heading = '';
    $page2_heading2 = '';
    $page2_game_start_text = '';
    $page2_game_skip_text = '';
    $pg3_title = '';
    $pg3_caution = '';
    $pg4_score_txt = '';
    $pg5_title = '';
    $pg5_title2 = '';
    $login_access = '';
    //while ($value = $result->fetch_assoc()) {
    if ($num_of_rows > 0) {
        $id = $value['id'];
        $app_name = $value['app_name'];
        $logo = $value['logo'];
        $background_image = $value['background_image'];
        $game_img = $value['game_img'];
        $page1_body_title = $value['page1_body_title'];
        $page1_button_title = $value['page1_button_title'];
        $page2_heading = $value['page2_heading'];
        $page2_heading2 = $value['page2_heading2'];
        $page2_game_start_text = $value['page2_game_start_text'];
        $page2_game_skip_text = $value['page2_game_skip_text'];
        $pg3_title = $value['pg3_title'];
        $pg3_caution = $value['pg3_caution'];
        $pg4_score_txt = $value['pg4_score_txt'];
        $pg5_title = $value['pg5_title'];
        $pg5_title2 = $value['pg5_title2'];
        $login_access = $value['login_access'];
    }

    //}


    if (isset($_POST['update'])) {

        /* --if---picture--selected-- */
        // if ($_FILES['logo']['name'] != "") {

        //     if (file_exists("$path/$logo")) {
        //         unlink("$path/$logo");
        //     }
        //     $ext1 = extension($_FILES['logo']['name']);
        //     $logo = "logo." . $ext1;
        // }
        // if ($_FILES['background_image']['name'] != "") {
        //     if (file_exists("$path/$background_image")) {
        //         unlink("$path/$background_image");
        //     }
        //     $ext2 = extension($_FILES['background_image']['name']);
        //     $background_image = "main-bg." . $ext2;
        // }
        // if ($_FILES['game_img']['name'] != "") {
        //     if (file_exists("$path/$game_img")) {
        //         unlink("$path/$game_img");
        //     }
        //     $ext3 = extension($_FILES['game_img']['name']);
        //     $game_img = "game_img." . $ext3;
        // }

        $data = array(
            "app_name" => $d->VD($_POST['app_name']),
            "logo" => $d->VD($_POST['logo']),
            "background_image" => $d->VD($_POST['background_image']),
            "game_img" => $d->VD($_POST['game_img']),
            "page1_body_title" => $d->VD($_POST['page1_body_title']),
            "page1_button_title" => $d->VD($_POST['page1_button_title']),
            "page2_heading" => $d->VD($_POST['page2_heading']),
            "page2_heading2" => $d->VD($_POST['page2_heading2']),
            "page2_game_start_text" => $d->VD($_POST['page2_game_start_text']),
            "page2_game_skip_text" => $d->VD($_POST['page2_game_skip_text']),
            "pg3_title" => $d->VD($_POST['pg3_title']),
            "pg3_caution" => $d->VD($_POST['pg3_caution']),
            "pg4_score_txt" => $d->VD($_POST['pg4_score_txt']),
            "pg5_title" => $d->VD($_POST['pg5_title']),
            "pg5_title2" => $d->VD($_POST['pg5_title2']),
            "login_access" => $d->VD($_POST['login_access'])
        );

        if ($d->update($table, $data, array("id" => $id))) {
            // if ($_FILES['logo']['name'] != "") {
            //     $ext1 = extension($_FILES['logo']['name']);
            //     $logoNamewithExt = "logo." . $ext1;
            //     $des = $path . $logoNamewithExt;
            //     $upload_file =  move_uploaded_file($_FILES['logo']['tmp_name'], $des);
            //     if ($upload_file) {
            //         echo "20";
            //     }else{
            //         echo $path . $logoNamewithExt;
            //         echo "<br>";
            //     }

            //     die();
            // }
            // if ($_FILES['background_image']['name'] != "") {
            //     $ext2 = extension($_FILES['background_image']['name']);
            //     move_uploaded_file($_FILES['background_image']['tmp_name'], "$path/main-bg." . $ext2);
            // }
            // if ($_FILES['game_img']['name'] != "") {
            //     $ext3 = extension($_FILES['game_img']['name']);
            //     move_uploaded_file($_FILES['game_img']['tmp_name'], "$path/game_img." . $ext3);
            // }
          //  header("Location: ");
          global $wp;
          $url = home_url(add_query_arg(array(), $wp->request));
          echo "<script>self.location='$url';</script>";
        } else {
            echo "Not Updated";
        }
    }

    @endphp

    <body>
        <div class="game-box game-box-2" style="padding:10px;">
            <div class="bg-shadow">
                <div class="logo text-center">
                    <img src="@php echo '/' . $logo @endphp" alt="logo--">
                </div>

                <!--         START OF SITE SETTING -->
                </br>
                <a href="@php  @endphp/game-admin" target="">Add/View OTP</a> &nbsp; &nbsp;
                <a href="@php  @endphp/game" target="_blank">Play Test Game</a>
                <hr>
                <h3>サイト設定</h3>
                <form class="form-inline" action="" enctype="multipart/form-data" method="POST">
                    <label for="app_name">アプリ名</label>
                    <input type="text" id="app_name" placeholder="" name="app_name" value="@php echo $app_name @endphp">

                    <label for="logo">ロゴ ( 画像リンクを挿入 )</label>
                    <input type="text" id="logo" placeholder="" name="logo" value="@php echo $logo @endphp">

                    <label for="background_image">背景画像 ( 画像リンクを挿入 )</label>
                    <input type="text" id="background_image" placeholder="" name="background_image" value="@php echo $background_image @endphp">

                    <label for="game_img">ゲームイメージ ( 画像リンクを挿入 )</label>
                    <input type="text" id="game_img" placeholder="" name="game_img" value="@php echo $game_img @endphp">

                    <!--<label for="pwd">ロゴ</label>-->
                    <!--<input type="file" id="logo" placeholder="" name="logo">-->
                    <!--<label for="pwd">背景画像</label>-->
                    <!--<input type="file" id="background_image" placeholder="" name="background_image">-->
                    <!--<label for="pwd">ゲームアイコン/画像</label>-->
                    <!--<input type="file" id="game_img" placeholder="" name="game_img">-->
                    </br>
                    <!--         END OF SITE SETTING -->

                    <!--         START OF PAGE 1 SETTING -->

                    <h3>Page1設定</h3>
                    <label for="email">題名</label>
                    <input type="text" id="page1_body_title" placeholder="" name="page1_body_title" value="@php echo $page1_body_title @endphp">
                    <label for="pwd">ボタンテキスト</label>
                    <input type="text" id="page1_button_title" placeholder="" name="page1_button_title" value="@php echo $page1_button_title @endphp">
                    </br>
                    <!--         END OF SITE SETTING -->



                    <!--         START OF PAGE 2 SETTING -->
                    <h3>Page2 設定</h3>
                    <label for="email">題名</label>
                    <input type="text" id="page2_heading" placeholder="" name="page2_heading" value="@php echo $page2_heading @endphp">
                    <label for="pwd">2番目の見出し</label>
                    <input type="text" id="page2_heading2" name="page2_heading2" value="@php echo $page2_heading2 @endphp">
                    <label for="pwd">ゲーム開始テキスト</label>
                    <input type="text" id="page2_game_start_text" name="page2_game_start_text" value="@php echo $page2_game_start_text @endphp">
                    <label for="pwd">ゲームスキップテキスト</label>
                    <input type="text" id="page2_game_skip_text" name="page2_game_skip_text" value="@php echo $page2_game_skip_text @endphp">
                    </br>
                    <!--         END OF PAGE 2 SETTING -->


                    <!--         START OF PAGE 3 SETTING -->
                    <h3>Page3設定</h3>
                    <label for="email">題名</label>
                    <input type="text" id="pg3_title" name="pg3_title" value="@php echo $pg3_title; @endphp">
                    <label for="pwd">注意テキスト</label>
                    <input type="text" id="pg3_caution" name="pg3_caution" value="@php echo $pg3_caution; @endphp">
                    </br>
                    <!--         END OF PAGE 2 SETTING -->



                    <!--         START OF PAGE 4 SETTING -->
                    <h3>Page4設定</h3>
                    <label for="email">スコアテキスト</label>
                    <input type="text" id="pg4_score_txt" name="pg4_score_txt" value="@php echo $pg4_score_txt @endphp">
                    </br>
                    <!--         END OF PAGE 4 SETTING -->




                    <!--         START OF PAGE 5 SETTING -->
                    <h3>Page5設定</h3>
                    <label for="email">題名</label>
                    <input type="text" id="pg5_title" name="pg5_title" value="@php echo $pg5_title @endphp">
                    <label for="email">タイトル2</label>
                    <input type="text" id="pg5_title2" name="pg5_title2" value="@php echo $pg5_title2 @endphp">
                    </br>


                    <!--         END OF PAGE 5 SETTING -->

                    <!--         START OF PAGE 5 SETTING -->
                    <h3>ログイン制限設定</h3>
                    <label for="email">ユーザーログイン制限を設定しますか？</label>
                    <select type="text" id="login_access" name="login_access">
                        <option value="0">一つ選択してください</option>
                        <option value="1" @php if($login_access == '1'){ echo 'selected'; }@endphp>はい</option>
                        <option value="0" @php if($login_access == '0'){ echo 'selected'; }@endphp>いいえ</option>
                    </select>
                    </br>
                    <!--         END OF PAGE 5 SETTING -->
                    @php
                    if ($num_of_rows == 0) { @endphp
                        <button type="submit" value="" name="save">保存</button>
                    @php } else { @endphp
                        <button type="submit" value="" name="update"> アップデート</button>

                    @php    }
                    @endphp
                </form>
                <!--         START OF PAGE 5 SETTING -->
                <hr>
                <h3>ポイント確率の管理</h3>
                @php
                if (isset($_POST['savePoints'])) {
                    $data1 = array(
                        "point_1" => $d->VD($_POST['point_1']),
                        "point_2" => $d->VD($_POST['point_2']),
                        "point_3" => $d->VD($_POST['point_3']),
                        "point_4" => $d->VD($_POST['point_4']),

                        "probablity_1" => $d->VD($_POST['probablity_1']),
                        "probablity_2" => $d->VD($_POST['probablity_2']),
                        "probablity_3" => $d->VD($_POST['probablity_3']),
                        "probablity_4" => $d->VD($_POST['probablity_4']),
                    );
                    if ($d->insert("point_and_probablity", $data1)) {
                        global $wp;
                        $url = home_url(add_query_arg(array(), $wp->request));
                        echo "<script>self.location='$url';</script>";
                    } else {
                        echo "failed";
                    }
                }
                $num_of_rows_pro = 0;
                $table_point_and_probablity = "point_and_probablity";
                $result = $d->query("select * from $table_point_and_probablity  ORDER BY id DESC LIMIT 1");
                $value = $result->fetch_assoc();
                $num_of_rows_pro = $result->num_rows;


                $idd = '';
                $point_1 = '';
                $probablity_1 = '';
                $point_2 = '';
                $probablity_2 = '';
                $point_3 = '';
                $probablity_3 = '';
                $point_4 = '';
                $probablity_4 = '';

                //while ($value = $result->fetch_assoc()) {
                if ($num_of_rows_pro > 0) {
                    $idd = $value['id'];
                    $point_1 = $value['point_1'];
                    $probablity_1 = $value['probablity_1'];
                    $point_2 = $value['point_2'];
                    $probablity_2 = $value['probablity_2'];
                    $point_3 = $value['point_3'];
                    $probablity_3 = $value['probablity_3'];
                    $point_4 = $value['point_4'];
                    $probablity_4 = $value['probablity_4'];
                }

                if (isset($_POST['updatePoints'])) {

                    $data_u = array(
                        "point_1" => $d->VD($_POST['point_1']),
                        "point_2" => $d->VD($_POST['point_2']),
                        "point_3" => $d->VD($_POST['point_3']),
                        "point_4" => $d->VD($_POST['point_4']),

                        "probablity_1" => $d->VD($_POST['probablity_1']),
                        "probablity_2" => $d->VD($_POST['probablity_2']),
                        "probablity_3" => $d->VD($_POST['probablity_3']),
                        "probablity_4" => $d->VD($_POST['probablity_4']),
                    );
                    if ($d->update($table_point_and_probablity, $data_u, array("id" => $idd))) {
                        global $wp;
                        $url = home_url(add_query_arg(array(), $wp->request));
                        echo "<script>self.location='$url';</script>";
                    }
                }

                @endphp

                <form class="form-inline" action="" enctype="multipart/form-data" method="POST">

                    <table class="table table-sm ">
                        <thead>
                            <tr>
                                <th scope="col text-letf" wiidth="32%">ポイント</th>
                                <th scope="col">
                                    <input type="text" id="point_1" name="point_1" value="@php echo $point_1 @endphp">
                                </th>
                                <th scope="col"> <input type="text" id="point_2" name="point_2" value="@php echo $point_2 @endphp">
                                </th>
                                <th scope="col"> <input type="text" id="point_3" name="point_3" value="@php echo $point_3 @endphp">
                                </th>
                                <th scope="col"> <input type="text" id="point_4" name="point_4" value="@php echo $point_4 @endphp">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">確率 (%)</th>
                                <td> <input type="text" id="probablity_1" name="probablity_1" value="@php echo $probablity_1 @endphp">
                                </td>
                                <td> <input type="text" id="probablity_2" name="probablity_2" value="@php echo $probablity_2 @endphp">
                                </td>
                                <td> <input type="text" id="probablity_3" name="probablity_3" value="@php echo $probablity_3 @endphp">
                                </td>
                                <td> <input type="text" id="probablity_4" name="probablity_4" value="@php echo $probablity_4 @endphp">
                                </td>

                            </tr>
                            <tr>
                                <th colspan="5">
                                    @php
                                    if ($num_of_rows_pro == 0) { @endphp
                                        <button type="submit" value="" name="savePoints">保存</button>
                                    @php } else { @endphp
                                        <button type="submit" value="" name="updatePoints"> アップデート</button>

                                    @php    }
                                    @endphp
                                </th>
                            </tr>

                        </tbody>
                    </table>
                </form>

                </br>

                <!--         END OF PAGE 5 SETTING -->


            </div>
        </div>

        <script type="text/javascript">
            
        </script>
    </body>

    </html>