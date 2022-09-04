@php
date_default_timezone_set('Asia/Dhaka');
$user_id = '';
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
        //echo $sql;
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
    function Redirect($url)
    {
        echo "<script>self.location='$url';</script>";
    }
    public function VD($data)
    {
        return htmlentities(strip_tags(trim(mysqli_real_escape_string($this->db, $data))));
    }
}
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
// RUN THE ABOVE QUERY

$num_of_rows = 0;
$table = "all_page_settings";
$result = $d->query("select * from $table  ORDER BY id DESC LIMIT 1");
$value = $result->fetch_assoc();
$num_of_rows = $result->num_rows;


$id = '';
$app_name = '';
$logo = "no-image.jpg";
$background_image = "no-image.jpg";
$game_img = "no-image.jpg";
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
    if ($logo == '') {
        $logo = "no-image.jpg";
    }
    if ($background_image == '') {
        $background_image = "no-image.jpg";
    }
    if ($game_img == '') {
        $game_img = "no-image.jpg";
    }
}
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@php echo $app_name @endphp</title>

    <link rel="stylesheet" href="style.css">
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
        <div class="game-box" style="	background: url( @php 
                                                            echo $background_image @endphp) no-repeat center / cover;
">
            <div class="bg-white">


                <div class="logo">
                    <img src=" @php '/' . $logo @endphp" alt="logo--">
                </div>
                @php
                $page = 1; // For active / show form -1
                /* ==================================================  Functionality for Page 2 /Step 2 ==================================*/
                // if ($user_id > 0) { // Checked Login or Not
                if (isset($_POST['check_otp']) && $_POST['step'] == 2) {
                    $user_id = $user_id;
                    $mainOTP = $_POST['otp_digit_1'] . $_POST['otp_digit_2'] . $_POST['otp_digit_3'] . $_POST['otp_digit_4'];
                    // SELECT * FROM otp WHERE otp_code = '8040' AND DAY <= '2022-08-05' AND STATUS = '1' AND date_valid_to >= '2022-08-05'; 
                    $sql3 = "SELECT * FROM otp WHERE otp_code = '" . $mainOTP . "' AND DAY <= '" . date("Y-m-d") . "' AND STATUS  ='1' AND date_valid_to >= '" . date("Y-m-d") . "'";
                    $result = $d->query($sql3);
                    // print_r($result); die();
                    if ($result->num_rows > 0) {
                        while ($value = $result->fetch_object()) {
                            if ($value->status == 0) {
                                echo " <br><span style='color:red;'>コードが無効です</span>"; //Invalid code
                            } elseif ($value->day >= date("Y-m-d") && $value->date_valid_to <= date("Y-m-d")) {
                                echo " <br><span style='color:red;'>この日付は現在対象外です</span>"; //This date is currently not covered
                            }

                            // To 


                        }
                        $page = 0;
                @endphp
                        <!--             Main Content Start Page 2  -->
                        <h3 class="title title-2">@php echo $page2_heading  @endphp</h3>
                        </h3>
                        <h4 class="title">
                            @php echo $page2_heading2 @endphp
                        </h4>
                        <form action="" method="POST">
                            <div class="cow submit btn">
                                <button type="submit" name="start_game"><img src=" @php echo get_site_url() . '/' . $game_img @endphp" alt=""></button>
                            </div>
                            <input type="hidden" name="step3" value="3">
                            <div class="submit btn margin">
                                <button type="submit" name="start_game"> @php echo $page2_game_start_text @endphp</button>
                            </div>
                        </form>
                        <!--             Main Content End  Page 2 -->
                @php
                    } else {
                        echo " <br><span style='color:red;'>コードが無効です。正しくお試しください</span>"; //Invalid code. try it right
                    }
                }
                //} else {
                // echo " <br><span style='color:red;'>最初にログインしてください</span>";
                // }
                /* ==================================================  Functionality for Page 2 /Step 2 ==================================*/

                @endphp
                @php
                /* ==================================================  Functionality for Page 2 /Step 2  ==================================*/
                   if (isset($_POST['start_game']) && $_POST['step3'] == 3) {
                    $user_id =  $_SESSION['userID'];
                    $date2 = date("Y-m-d H:m:s", strtotime('-24 hours'));
                    $sql = "SELECT * FROM game_info WHERE user_id = " . $user_id . " AND tracker = '1' AND start_time >= '" . $date2 . "'";
                    //  echo $sql ; 
                    //die();
                    $result = $d->query($sql);
                    if ($result->num_rows > 0) {
                        $img =  get_site_url() . '/' . $game_img;
                        echo " <br><span style='color:red;'> 過去24時間以内にプレイしたため、現在プレイできません。 後でお試しください。</span> </br><a href='#'><img src='$img' alt='cow'></a>";
                        echo '<form action="" method="POST">
                    <input type="hidden" name="step3" value="3">
                    <div class="submit btn margin">
                        <button type="submit" name="start_game">ゲーム開始</button>
                    </div>
                </form>
                <div class="btn">
                    <a href="">>>スキップ>> </a>
                </div>';
                    } else {
                        //  Redirect('page-3.php');
                        // echo "Ready to go page -3";
                @endphp
                        <!--             Main Content Start for page-3  -->
                        <div class="cow three-column">
                            <a href="#" class="randomButton"><img src="@php echo get_site_url() . '/' . $game_img @endphp" alt="@php echo $game_img @endphp"></a>
                            <a href="#" class="randomButton"><img src="  @php echo get_site_url() . '/' . $game_img @endphp" alt="@php echo $game_img @endphp"></a>
                            <a href="#" class="randomButton"><img src="  @php echo get_site_url() . '/' . $game_img @endphp" alt="@php echo $game_img @endphp"></a>
                            <a href="#" class="randomButton"><img src="  @php echo get_site_url() . '/' . $game_img @endphp" alt="@php echo $game_img @endphp"></a>
                            <a href="#" class="randomButton"><img src="  @php echo get_site_url() . '/' . $game_img @endphp" alt="@php echo $game_img @endphp"></a>
                            <a href="javascript::void(0)" class="randomButton"><img src="  @php echo get_site_url() . '/' . $game_img @endphp" alt="@php echo $game_img @endphp"></a>
                        </div>
                        <!-- <form action="" method="POST" id="myForm" style="">
                        <input type="hidden" name="step4" value="4">
                        <button type="submit" name="GoToStep4">ゲーム開始</button>
                    </form> -->
                        <h4 class="title">@php echo $pg3_title @endphp</h4>
                        <h4 class="title title-3">@php echo $pg3_caution @endphp</h4>

                        <!--           End of   Main Content  for page-3  -->
                @php
                    }
                    $page = '';
                }
                /* ================================================== END Functionality for Page 2 /Step 2  ==================================*/
                @endphp
                @php
                if (isset($_POST['step4']) && $_POST['step4'] == 4) {
                @endphp
                    <!--           End of   Main Content  for page-4  -->
                    <h3 class="title title-2">@php echo $pg4_score_txt @endphp</h3>
                    <div class="cow">
                        <a href="#" class="getPoint"><img src="@php echo get_site_url() . '/' . $game_img @endphp" alt="@php echo $game_img @endphp"></a>
                    </div>
                    <!--           End of   Main Content  for page-4  -->
                @php
                    $page = '';
                }
                @endphp
                @php
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
                if (isset($_POST['score']) && $_POST['score'] > 0) {
                    if (isset($_POST['score'])) {
                        $user_id = $user_id;
                        $score_points = $_POST['score'];
                        $tracker = 1;
                        $points = $_POST['score'];
                        if ($points == $point_1) {
                            $probablity = $probablity_1;
                        } elseif ($points == $point_2) {
                            $probablity = $probablity_2;
                        } elseif ($points == $point_3) {
                            $probablity = $probablity_3;
                        } elseif ($points == $point_4) {
                            $probablity = $probablity_4;
                        }

                        $data = array(
                            "user_id" => $user_id,
                            "score_points" => $score_points,
                            "tracker" => $tracker,
                            "probablity" => $probablity,
                        );
                        $result = $d->insert("game_info", $data);
                        if ($result) {
                            // echo " <br><span style='color:orange;'>Success </span>";
                        } else {
                            //echo " <br><span style='color:red;'>Failed </span>";
                        }
                    }
                @endphp
                    <div class="point-box">
                        <div class="point-circle">
                            <span class="point">@php echo  $_POST['score']; @endphp</span>
                            <span class="point-text">点</span>
                        </div>
                    </div>
                    <div class="btn btn-2">
                        <form action="" method="POST">
                            <input type="hidden" name="step5" value="5">
                            <input type="hidden" name="points" value="@php echo  $_POST['score']; @endphp">
                            <div class="submit btn margin">
                                <button type="submit" name="start_games">
                                    @php echo $pg5_title @endphp
                                    <br>
                                    @php echo $pg5_title2 @endphp</button>
                            </div>
                        </form>
                        <a href="#" class="">

                        </a>
                    </div>
                    <!--           End of   Main Content  for page-5  -->
                @php
                    $page = '';
                }
                @endphp
                @php
                if (isset($_POST['step5']) && $_POST['step5'] == 5) {
                @endphp

                    <div class="point-box">
                        <div class="point-circl">
                            <h3 class="title title-4">グーム参加ありがとうございます @php echo  wp_get_current_user()->user_nicename; @endphp 様 今回の獲得[:@php echo $_POST['points'] @endphp 」点を送ります </h3>
                        </div>
                    </div>

                @php
                    $page = '';
                }
                @endphp




                @php
                if ($page == 1) {
                @endphp
                    <!--             Main Content Start for page-1  -->
                    <h4 class="title">@php echo $page1_body_title; @endphp </h4>
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
                                <button type="submit" name="check_otp">@php echo $page1_button_title; @endphp </button>
                            </div>
                        </form>
                    </div>
                    <!--           End of   Main Content  for page-1  -->
                @php
                }
                @endphp
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
    $('.randomButton').click(function(event) {
  
            var login_access = "@php print $login_access; @endphp";
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
            @php
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
            @endphp
                    var form = $(document.createElement('form'));
                    $(form).attr("action", "");
                    $(form).attr("method", "POST");
                    var input = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", "score")
                        .val(@php echo $k; @endphp);
                    $(form).append($(input));
                    form.appendTo(document.body)
                    $(form).submit();
            @php
                }
            }
            @endphp
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

 

@php 
//     else {
//         @endphp
//             <div class="login-form">
//             	<img src="/wp-content/uploads/2022/08/logo.png" alt="logo"/>
                @php
//                     wp_login_form( array(
//                     'echo'            => true,
//                     'redirect'        => '/game',
//                     'remember'        => true,
//                     'value_remember'  => true,
//                     ));
                @endphp
//                 <p>アカウントを持っていませんか？ <a href="/register">ここに登録</a></p>
//             </div>
        @php
//     }
@endphp
<script>
    // var buttonGet = document.getElementById('wp-submit');
    // buttonGet.addEventListener('click', function(e){
    //     e.preventDefault();
    // });
</script>
</body>

</html>