@php
        //  session_start();
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
        }
        // function Redirect($url)
        // {
        //     echo "<script>self.location='$url';</script>";
        // }
        $d = new Database();
        // Create Table Automatically (game_info)
        $sql_to_create_table = "CREATE TABLE IF NOT EXISTS game_info (
    `id` int(11) NOT NULL AUTO_INCREMENT ,
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

        @endphp

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
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
            </style>
        </head>

        <body>

            <div class="game-box game-box-2">
                <div class="bg-shadow">
                    <div class="logo text-center">
                        <img src="$logo" alt="">
                    </div>
                    </br>
                    <a href="/game-content" target="">Setting</a> &nbsp; &nbsp;
                    <a href="/game" target="_blank">Play Game</a>

                    <h3 class="title title-2 text-center">管理パネル</h3>
                    <div class="point-box">
                        @php
                        $d = new Database();

                        if (isset($_POST['addOTP'])) {
                            if ($_POST['date'] >= date("Y-m-d") && $_POST['date_valid_to'] >= date("Y-m-d")) {
                                $status = 1;
                            } else {
                                $status = 0;
                            }

                            $data = array(
                                "day" => $_POST['date'],
                                "date_valid_to" =>  $_POST['date_valid_to'],
                                "otp_code" =>  $_POST['otp'],
                                "status" => $status,
                            );
                            // $d->query("insert into otp set day='2022-08-03', date_valid_to='2022-08-05', otp_code='803220', status='1'");

                            $result = $d->insert("otp", $data);

                            if ($result) {
                                echo " <br><span style='text-align: center; color:orange; display: block;'>正常に追加されました</span>";
                            } else {
                                echo " <br><span style='text-align: center; color:red; display: block;'>追加に失敗しました</span>";
                            }
                        }
                        if (isset($_GET['id'])) {
                            $d->delete("otp", $_GET['id']);
                        }
                        @endphp
                        @if (isset($_GET['ids'])) 
                        @php
                            $ids = $_GET['ids'];
                            /* --For-Receiving--Value--In--Input--Field-- */
                            if (isset($_GET['ids'])) {
                                $table = "otp";
                                $where = array(
                                    "id" => $_GET['ids']
                                );
                                $data = $d->view($table, "", $where);
                                $value = $data->fetch_object();
                            }

                            if (isset($_POST['updateOTP'])) {
                                if ($_POST['date'] >= date("Y-m-d") && $_POST['date_valid_to'] >= date("Y-m-d")) {
                                    $status = 1;
                                } else {
                                    $status = 0;
                                }

                                $data = array(
                                    "day" => $_POST['date'],
                                    "date_valid_to" => $_POST['date_valid_to'],
                                    "otp_code" => $_POST['otp'],
                                    "status" => $status,
                                );
                                if ($d->update("otp", $data, array("id" => $_GET['ids']))) {
                                    global $wp;
                                    // $url = home_url(add_query_arg(array(), $wp->request));
                                    // echo "<script>self.location='$url';</script>";
                                }
                            }
                            @endphp
                            <div class="otp-box">
                                <form action="" method="POST">
                                    <label for="fname">有効日を選択</label><br>
                                    <input type="date" id="date" name="date" value="@php echo $value->day; @endphp"><br>
                                    <label for="fname">有効期限 </label><br>
                                    <input type="date" id="date" name="date_valid_to" value="@php echo $value->date_valid_to; @endphp" require><br>
                                    <label for="lname">タイプOTPコード：</label><br>
                                    <input type="text" id="otp" name="otp" value="@php echo $value->otp_code; @endphp">
                                    <label for="cars">選択する：</label> <br>
                                    <input type="submit" value="アップデート" name="updateOTP">
                                </form>
                            </div>
                         @else 
                            <div class="otp-box">
                                <form action="" method="POST">
                                    <label for="fname">有効日を選択:</label><br>
                                    <input type="date" id="date" name="date" require><br>
                                    <label for="fname">有効期限 </label><br>
                                    <input type="date" id="date" name="date_valid_to" require><br>
                                    <label for="lname">タイプOTPコード：</label><br>
                                    <button type="button" onClick="AutoGenerateOTP()">OTPの自動生成</button><input type="text" id="otp" name="otp" readonly>
                                    <input type="submit" value="送信" name="addOTP">
                                    <button type="button" onClick="Refresh()">ページの更新</button>
                                </form>
                            </div>
                        @endif

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
                        @php
                        $perpage = 4; // Define the number of Per Page 
                        if (isset($_GET["page"])) {
                            $page = intval($_GET["page"]); // To get integer value
                        } else {
                            $page = 1;
                        }
                        $calc = $perpage * $page; // 5*2= 10
                        $start = $calc - $perpage; // 10-5=5
                        $result = $d->query("select * from otp Limit $start, $perpage");
                        print_r($result);
                        die();
                        $rows = $result->num_rows; // To get number of Rows = 2
                        if ($rows) {
                            $i = 0;
                            while ($value = $result->fetch_object()) { // To get the value 
                        @endphp
                                <tr>
                                    <td>@php echo $value->day; @endphp</td>
                                    <td>@php echo $value->date_valid_to; @endphp</td>
                                    <td>@php echo $value->otp_code; @endphp</td>
                                    <td>

                                        @php if ($value->status == 1) {
                                            echo 'Active';
                                        } else {
                                            echo 'Deactive';
                                        }; @endphp

                                    </td>
                                    <td>@php echo $value->created_at; @endphp</td>
                                    <td>
                                        <a href="?ids=@php echo $value->id; @endphp">Edit</a>
                                    </td>
                                    <td>
                                        <a href="?id=@php echo $value->id; @endphp">Delete</a>
                                    </td>
                                </tr>
                        @php
                            }
                        }
                        @endphp
                    </table>
                    @php

                    if (isset($page)) {
                        $sql = "select Count(*) As Total from otp";
                        $result = $d->query($sql);
                        $rows = $result->num_rows;
                        if ($rows) {
                            $rs =  $result->fetch_assoc();
                            $total = $rs["Total"]; // 10
                        }
                        $totalPages = ceil($total / $perpage); // 2
                        echo "<br>";
                        if ($page <= 1) {
                            echo "<span id='page_links' style='font-weight: bold;'>Prev</span>";
                        } else {
                            $j = $page - 1;
                            echo "<span><a id='page_a_link' href='?page=$j'>< Prev</a></span>";
                        }

                        for ($i = 1; $i <= $totalPages; $i++) {
                            if ($i <> $page) {
                                echo "<span><a id='page_a_link' href='page=$i'>$i</a></span>";
                            } else {
                                echo "<span id='page_links' style='font-weight: bold;'>$i</span>";
                            }
                        }
                        if ($page == $totalPages) {
                            echo "<span id='page_links' style='font-weight: bold;'>Next ></span>";
                        } else {
                            $j = $page + 1;
                            echo "<span><a id='page_a_link' href='?page=$j'>Next</a></span>";
                        }
                    }

                    @endphp

                    <script type="text/javascript">
                        /*    window.location.hash = "error";
            // Again because Google Chrome doesn't insert
            // the first hash into the history
            window.location.hash = "error-to-back";
            window.onhashchange = function() {
                window.location.hash = "error"; */
                    </script>
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