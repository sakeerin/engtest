<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include('../inc/user_info.php');

pre_page();
display_profile();

if (!$_GET['action']) {
    pre_test();
}
if ($_GET['action'] == "set_test") {
    set_test();
}
if ($_GET['action'] == "test") {
    est_test();
}
if ($_GET['action'] == "record") {
    est_record();
}
if ($_GET['action'] == "finish") {
    est_result();
}

display_footer();


function pre_page()
{
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>English Test Online :: ระบบทดสอบภาษาอังกฤษออนไลน์ </title>
    <link rel="shortcut icon" type="image/x-icon" href="http://localhost/engtest/images/image2/neweol-logo.ico">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/mainpage.css">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/tabbar.css">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/standardtest.css">

</head>

<body>
    <?php
}

function display_profile()
{
    include('../config/connection.php');

    $strSQL = "SELECT * FROM tb_x_member WHERE member_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_member = $result->num_rows;

    if ($is_member == 0) {
        header("Location:../inc/logout.php");
        exit;
    }
    $stmt->close();
    mysqli_close($conn);
    //---------------------------------------------------------------------------------------------------//

?>
    <div id='container'>
        <div id='header'>
            <!-- <img src='https://www.engtest.net/image2/mainpage/dbd-head.gif' width='927' height='148'
                style='margin:10px 0 0 16px; top:-10px;' /> -->
            <img src='http://localhost/engtest/images/image2/logo/logo-02.png' width='270' height='118'
                style='float:left;margin-left:20px; margin-top: 175px;' />
            <!---- info user ----->
            <div id='info_user'>
                <?php
    $data = new info();
    echo $data->loadinfo('test');
?>
                <div id='logoutPic'>
                    <a href='http://localhost/engtest/inc/logout.php'><img
                            src='http://localhost/engtest/images/image2/eol system/button/logout-06.png'
                            style='margin-top:10px; margin-left:20px;' /></a>
                </div>
            </div>
        </div>
        <!------- main content--------->
        <div id='content'>
            <div id='pic_border'>
                <img src='http://localhost/engtest/images/image2/eol system/head-box-02.png' width='1024' />
            </div>
            <div id='content-div'>
                <?php


}


function pre_test()
{
    include('../config/connection.php');
    include('../config/format_time.php');
?>
                <div class="tabbed" style="border-bottom: 4px solid #f7941d !important;">
                    <ul>
                        <a href="http://localhost/engtest/EOL/eoltest.php?section=bussiness&&status=edit_profile">
                            <li class="" id="tab_profile">Profile</li>
                        </a>
                        <a href="http://localhost/engtest/EOL/eoltest.php?section=business&&status=refill">
                            <li class="" id="tab_refill">Refill</li>
                        </a>
                        <?php if ($_SESSION['coporate'] == 1) { ?>
                        <a href="http://localhost/engtest/corporate/ecop.php">
                            <li class="" id="tab_corporate">Multi - Learning</li>
                        </a>
                        <?php
    }?>
                        <a href="http://localhost/engtest/EOL/eoltest.php?section=business">
                            <li class="active" id="tab_eolsystem">SYSTEM Page</li>
                        </a>
                    </ul>
                </div>
                <?php
    echo " <table width=90% align=center cellpadding=0 cellspacing=0 border=0 >		
                <img src='http://localhost/engtest/images/image2/eol system/Standard Test/bg-standard-test.png' width='99.7%' />
                    <tr>
                        <td colspan=2 >";
    $skill_name = array("", "Reading Comprehension", "Listening Comprehension", "Semi-Speaking", "Semi-Writing", "Grammar", "", "Vocabulary Items");
    $level_name = array("", "Beginner", "Lower Intermediate", "Intermediate");

    echo "	<table align=center width=100% cellpadding=0 cellspacing=1 border=0>
				<tr height=50>
					<td align=center width=34% bgcolor='#c0c0c0' style='border-top-left-radius: 5px;'>
						<font size=2 face=tahoma ><b>Single Skill</font>
					</td>
					<td align=center width=22% bgcolor='#d0d0d0'>
						<font size=2 face=tahoma ><b>$level_name[1]</b></font>
					</td>
					<td align=center width=22% bgcolor='#d0d0d0'>
						<font size=2 face=tahoma ><b>$level_name[2]</b></font>
					</td>
					<td align=center width=22% bgcolor='#d0d0d0' style='border-top-right-radius: 5px;'>
						<font size=2 face=tahoma ><b>$level_name[3]</b></font>
					</td>
				</tr>
				<tr height=25>
					<td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma ><b>$skill_name[1]</b></font></td>
					<td align=center colspan=3 rowspan=6>";

    for ($skill_id = 1; $skill_id <= 7; $skill_id++) {
        if ($skill_id == 6) {
            $skill_id = $skill_id + 1;
        }
        for ($level_id = 1; $level_id <= 3; $level_id++) {

            $percent = 50;
            $strSQL = "SELECT result_id FROM tb_w_result WHERE member_id = ? && skill_id = ? && level_id = ? && percent >= ? order by percent DESC limit 0,1";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("sssi", $_SESSION['x_member_id'], $skill_id, $level_id, $percent);
            $stmt->execute();
            $result = $stmt->get_result();
            $is_pass = $result->num_rows;

            if ($is_pass == 1) {
                $pass[$skill_id][$level_id] = "<img width=25 src=http://localhost/engtest/2010/temp_images/icon_correct.jpg border=0>";
                $count = $count + 1;
            }
            if ($is_pass == 0) {
                $pass[$skill_id][$level_id] = "<img width=25 src=http://localhost/engtest/2010/temp_images/icon_incorrect.jpg border=0>";
            }
            $stmt->close();
        }
    }

    echo "<table align=center width=100% cellpadding=0 cellspacing=2 border=0 style='background: #eaeaea;'>";
    for ($skill_id = 1; $skill_id <= 7; $skill_id++) {
        echo "<tr height=25>";
        if ($skill_id == 6) {
            $skill_id = $skill_id + 1;
        }
        for ($level_id = 1; $level_id <= 3; $level_id++) {
            echo "<td align=center bgcolor='#f9f9f9'>" . $pass[$skill_id][$level_id] . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    //-----------------------------------------------------------------//

    $is_est = 1;
    $sql = "SELECT ETEST_ID FROM tb_etest WHERE IS_EST = ? ORDER BY ETEST_ID";
    $query = $conn->prepare($sql);
    $query->bind_param("i", $is_est);
    $query->execute();
    $result = $query->get_result();
    $num = $result->num_rows;

    if ($num >= 1) {
        for ($i = 1; $i <= $num; $i++) {
            $data = $result->fetch_array();
            $etest_id = $data['ETEST_ID'];
            if ($i != $num) {
                $event = $event . " ETEST_ID='$etest_id' || ";
            }
            else {
                $event = $event . " ETEST_ID='$etest_id' ";
            }
        }
    }
    $query->close();
    if ($event) {
        $event = "( $event )";
        $date_event = date("Y-m-d H:i:s", time() - (60 * 60 * 24 * 30));
        $now = date("Y-m-d H:i:s", time());

        // ควรจะแยกตารางเก็บผลการทดสอบจาก tb_w_result ไปยัง tb_w_result_est
        $msg_last = "";
        $strSQL = "SELECT result_id,create_date FROM tb_w_result_est WHERE $event && member_id = ? && create_date >= ? ORDER BY create_date DESC limit 0,1";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ss", $_SESSION['x_member_id'], $date_event);
        $stmt->execute();
        $result = $stmt->get_result();
        $is_have = $result->num_rows;

        if ($is_have == 1) {
            $data = $result->fetch_array();
            $last_test = $data['create_date'];
            //---------------------------------------------------------------------//
            $arr = explode(" ", $last_test);
            $date_a = $arr[0];
            $now_date = explode(" ", $now);
            $date_b = $now_date[0];
            $diff = date_dif($date_a, $date_b);
            $wait = 30 - $diff;
            //---------------------------------------------------------------------//
            $msg_last = get_thai_day($arr[0]) . " " . get_thai_month($arr[0]) . " " . get_thai_year($arr[0]);
            $msg_last = "<font color=red>" . $msg_last . " [ กรุณารออีก $wait วัน เพื่อใช้งานใหม่อีกครั้ง ] </font>";
        }
        $stmt->close();

        if ($is_have == 0) {

            $sql = "SELECT result_id,create_date FROM tb_w_result_est WHERE $event && member_id = ? ORDER BY create_date DESC limit 0,1 ";
            $query = $conn->prepare($sql);
            $query->bind_param("s", $_SESSION['x_member_id']);
            $query->execute();
            $result = $query->get_result();
            $is_ok = $result->num_rows;

            if ($is_ok == 1) {
                $data = $result->fetch_array();
                $last_test = $data['create_date'];
                $arr = explode(" ", $last_test);
                $date_a = $arr[0];
                $msg_last = get_thai_day($arr[0]) . " " . get_thai_month($arr[0]) . " " . get_thai_year($arr[0]);
                $msg_last = "<font color=green>" . $msg_last . " [ สามารถใช้งานได้ทันที หากเงื่อนไขด้านบนครบถ้วน ] </font>";
            }
            if ($is_ok == 0) {
                $msg_last = "<font color=green><b> ไม่พบข้อมูลการใช้งาน EST [ สามารถใช้งานได้ทันที หากเงื่อนไขด้านบนครบถ้วน ] </b></font>";
            }
            $event_wait = 1;
            $query->close();
        }

        if ($count == 18 && $event_wait == 1) {
            $event_pass = 1;
            $pass_msg = "";
        }
        else if ($_SESSION['x_member_id'] == 30112 || $_SESSION['x_member_id'] == 41294 || $_SESSION['x_member_id'] == 37013 || $_SESSION['x_member_id'] == 52026 || $_SESSION['x_member_id'] == 52027 || $_SESSION['x_member_id'] == 52028 || $_SESSION['x_member_id'] == 52029 || $_SESSION['x_member_id'] == 52030 || $_SESSION['x_member_id'] == 52031 || $_SESSION['x_member_id'] == 52032 || $_SESSION['x_member_id'] == 52033 || $_SESSION['x_member_id'] == 52034 || $_SESSION['x_member_id'] == 52035 || $_SESSION['x_member_id'] == 52036 || $_SESSION['x_member_id'] == 52037 || $_SESSION['x_member_id'] == 52055 || $_SESSION['x_member_id'] == 52056 || $_SESSION['x_member_id'] == 52057 || $_SESSION['x_member_id'] == 52058 || $_SESSION['x_member_id'] == 52061 || $_SESSION['x_member_id'] == 52062 || $_SESSION['x_member_id'] == 52063 || $_SESSION['x_member_id'] == 52064 || $_SESSION['x_member_id'] == 104913) {
            $event_pass = 1;
            $pass_msg = " ";
        }
        else {
            $event_pass = 0;
            $pass_msg = " disabled='true' ";
        }
    }
    mysqli_close($conn);
    //-----------------------------------------------------------------//
    echo "
                        </td>
                    </tr>
                    <tr height=25>
                        <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma ><b>$skill_name[2]</b></font></td>
                    </tr>
                    <tr height=25>
                        <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma ><b>$skill_name[3]</b></font></td>
                    </tr>
                    <tr height=25>
                        <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma ><b>$skill_name[4]</b></font></td>
                    </tr>
                    <tr height=25>
                        <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma ><b>$skill_name[5]</b></font></td>
                    </tr>
                    <tr height=25>
                        <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma ><b>$skill_name[7]</b></font></td>
                    </tr>
                    <tr height=50>
                        <td align=center bgcolor='#e0e0e0' style='border-bottom-left-radius: 5px;'><font size=2 face=tahoma ><b>ทดสอบ EST ครั้งล่าสุดเมื่อ</b></font></td>
                        <td align=center colspan=3 bgcolor='#ffffff' style='border-bottom-right-radius: 5px;'><font size=2 face=tahoma > $msg_last </font></td>
                    </tr>
                    <tr height=100>
                    <form method='post' action='?action=set_test'>
                        <td align=center colspan=4>
                            <input type=hidden name='event_pass' value='$event_pass'>
                            <input class='want-test' type=submit value=' I want to use EOL Standard Test ( EST ) . ' $pass_msg >
                        </td>
                    </form>
                    </tr>
                </table>
			</td>
		</tr>
	</table>";
}

function set_test()
{
    include('../config/connection.php');

    unset($_SESSION['etest']);
    unset($_SESSION['amount']);
    unset($_SESSION['quiz_id']);
    unset($_SESSION['all_page']);
    unset($_SESSION['all_time']);
    unset($_SESSION['ans']);
    unset($_SESSION['sound']);

    if ($_POST['event_pass'] == 1) {
        $_SESSION['tester'] = $_SESSION['x_member_id'];

?>
                <div class="tabbed" style="border-bottom: 4px solid #f7941d !important;">
                    <ul>
                        <a href="http://localhost/engtest/EOL/eoltest.php?section=bussiness&&status=edit_profile">
                            <li class="" id="tab_profile">Profile</li>
                        </a>
                        <a href="http://localhost/engtest/EOL/eoltest.php?section=business&&status=refill">
                            <li class="" id="tab_refill">Refill</li>
                        </a>
                        <?php if ($_SESSION['coporate'] == 1) { ?>
                        <a href="http://localhost/engtest/corporate/ecop.php">
                            <li class="" id="tab_corporate">Multi - Learning</li>
                        </a>
                        <?php
        }?>
                        <a href="http://localhost/engtest/EOL/eoltest.php?section=business">
                            <li class="active" id="tab_eolsystem">SYSTEM Page</li>
                        </a>
                    </ul>
                </div>
                <?php
        echo "		
            <table width=90% align=center cellpadding=0 cellspacing=0 border=0 >
                <tr>
                    <td>
                        <img src='http://localhost/engtest/images/image2/eol system/Standard Test/bg-standard-2.png' width='99.7%'/>	
                    </td>
                </tr>
                <tr height=100>
                    <td align=center>
                        <input class='start-test' type=button value='Start EOL Standard Test' onclick=\"javascript:window.location='?action=test'\">
                    </td>
                </tr>
            </table>";

        $count = 0;
        $page_num = 1;
        $is_est = 1;
        $strSQL = "SELECT ETEST_ID FROM tb_etest WHERE IS_EST = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("i", $is_est);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
        if ($num >= 1) {
            $rand = rand(1, $num) - 1;
        }
        $stmt->close();
        echo "<br>" . $rand;
        $SQL = "SELECT ETEST_ID,ETEST_TIME FROM tb_etest WHERE IS_EST = ?  limit $rand,1";
        $query = $conn->prepare($SQL);
        $query->bind_param("i", $is_est);
        $query->execute();
        $result = $query->get_result();
        $is_have = $result->num_rows;
        if ($is_have == 1) {
            $data = $result->fetch_array();
            $etest_id = $data['ETEST_ID'];
            $_SESSION['etest'] = $etest_id;
            $_SESSION['all_time'] = $data['ETEST_TIME'] * 60;
            echo "<br>" . $data['ETEST_ID'];
            echo "<br>" . $data['ETEST_TIME'];
        }
        $query->close();
        //----------------------------------------------------------------------//
        for ($k = 1; $k <= 4; $k++) {
            if ($k == 1) {
                $skill_id = 2;
            }
            if ($k == 2) {
                $skill_id = 1;
            }
            if ($k == 3) {
                $skill_id = 5;
            }
            if ($k == 4) {
                $skill_id = 4;
            }

            $strSQL = "SELECT tb_etest_mapping.QUESTIONS_ID,tb_questions.SKILL_ID,tb_questions_mapping.GQUESTION_ID FROM tb_etest_mapping, tb_questions, tb_questions_mapping WHERE
            tb_etest_mapping.ETEST_ID = ? && tb_etest_mapping.QUESTIONS_ID = tb_questions.QUESTIONS_ID && tb_etest_mapping.QUESTIONS_ID = tb_questions_mapping.QUESTIONS_ID && tb_questions.SKILL_ID = ?
            order by tb_questions_mapping.GQUESTION_ID ASC,tb_questions.QUESTIONS_ID ASC";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ss", $etest_id, $skill_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $num = $result->num_rows;

            echo "<br>num: $num <br><br>";

            $event = "";
            for ($i = 1; $i <= $num; $i++) {
                $count = $count + 1;
                $data = $result->fetch_array();
                $quiz['id'][$count] = $data['QUESTIONS_ID'];
                $quiz['skill_id'][$count] = $data['SKILL_ID'];
                $quiz['relate_id'][$count] = $data['GQUESTION_ID'];
                if ($i != $num) {
                    $event = $event . " tb_etest_mapping.QUESTIONS_ID != '$data[QUESTIONS_ID]' && ";
                }
                else {
                    $event = $event . " tb_etest_mapping.QUESTIONS_ID != '$data[QUESTIONS_ID]' ";
                }
                if ($count - $page[$page_num - 1] >= 4 || $count == 1 || $quiz['skill_id'][$count - 1] != $quiz['skill_id'][$count]) { // 1 Relate per Quiz / First Page / Change Skill
                    if ($quiz['relate_id'][$count] != $quiz['relate_id'][$count - 1]) {
                        echo "<br>before plus page num : $page_num <br><br>";
                        echo "<br>before plus count : $count <br><br>";
                        echo "<br>before plus page : " . print_r($page) . "<br><br>";
                        $page[$page_num] = $count;
                        $page_num = $page_num + 1;
                    }
                }
                echo "<br>page : $page_num <br><br>";
            }
            $stmt->close();
            if ($event) {
                $event = " && ( " . $event . " ) ";
            }
            echo " <br><br> query string : $event <br><br>";
            $SQL = "SELECT tb_etest_mapping.QUESTIONS_ID, tb_questions.SKILL_ID FROM tb_etest_mapping,tb_questions WHERE
							tb_etest_mapping.ETEST_ID = ? && tb_etest_mapping.QUESTIONS_ID = tb_questions.QUESTIONS_ID && tb_questions.SKILL_ID = ?  $event
							order by tb_questions.QUESTIONS_ID ASC";
            $query = $conn->prepare($SQL);
            $query->bind_param("ss", $etest_id, $skill_id);
            $query->execute();
            $result = $query->get_result();
            $num = $result->num_rows;

            echo " <br><br> count : $count <br><br>";
            echo " <br><br> loop 2 num : $num <br><br>";
            for ($i = 1; $i <= $num; $i++) {
                $count = $count + 1;
                $data = $result->fetch_array();
                $quiz['id'][$count] = $data['QUESTIONS_ID'];
                $quiz['skill_id'][$count] = $data['SKILL_ID'];
                $quiz['relate_id'][$count] = "none";
                if ($quiz['relate_id'][$count] != $quiz['relate_id'][$count - 1]) {
                    $page[$page_num] = $count;
                    $page_num = $page_num + 1;
                }
                if (($page[$page_num - 1] + 5) <= $count) {
                    $page[$page_num] = $count;
                    $page_num = $page_num + 1;
                }
            }
            $query->close();
        }
        mysqli_close($conn);
        //---------------------------------------//
        $_SESSION['amount'] = $count;
        $_SESSION['quiz'] = $quiz;
        $_SESSION['all_page'] = $page;

        var_dump($quiz['id']);
        echo "<br><br>";
        var_dump($quiz['relate_id']);
        echo "<br><br>";
        var_dump($page);
        echo "<br><br>";

    }
    else {
        echo "<script>window.location='?'</script>";
        exit;
    }

}

function est_test()
{
    include('../config/connection.php');
    if ($_SESSION['amount'] == 0 || $_SESSION['x_member_id'] != $_SESSION['tester']) {
        echo "<script>window.location='?action=set_test'</script>";
        exit;
    }
    else {
        set_time();
        if ($_GET['action'] == "test") {
?>

                <body onLoad='begintimer()'>
                    <script language='javascript'>
                    if (document.images) {
                        var parselimit = document.config.fn_time.value
                    }

                    function hide(id, id2, end) {
                        document.getElementById(id).style.display = 'none';
                        document.getElementById(id2).style.display = 'none';
                        document.getElementById(end).style.display = '';
                        document.getElementById(end).innerHTML = 'Completed';
                    }

                    function end_play(id, end) {
                        document.getElementById(id).style.display = 'none';
                        document.getElementById(end).style.display = '';
                        document.getElementById(end).innerHTML =
                            "<span style='color: red;'>คุณได้ฟังเสียงนี้ไปแล้ว &#x2713;</span>";
                    }
                    </script>
                    <?php

            echo "<center><img src='https://www.engtest.net/image2/eol system/Standard Test/EST_head_test.png' width=80%></center>";
            display_time_left();
        }
        if ($_SESSION['all_page']) {
            $count = count($_SESSION['all_page']);
        }
        if ($_GET['page'] - $_GET['page'] == 0 && $_GET['page'] >= 1) {
            $page = $_GET['page'];
        }
        if ($page >= $count) {
            $page = $count;
        }
        if (!$page) {
            $page = 1;
        }

        //------------------------------------------------------------------//
        echo "<form name='quiz_form' id='quiz_form' method='post'><input type=hidden name='time_left' >";
        $start = $_SESSION['all_page'][$page];
        $stop = $_SESSION['all_page'][$page + 1] - 1;
        if ($stop <= 0) {
            $stop = $_SESSION['amount'];
        }
        echo "Start : $start | Stop : $stop <br>";
        if ($start >= 1 && $stop >= 1 && $start <= $stop) {
            for ($i = $start; $i <= $stop; $i++) {
                $relate_text = "";
                if ($_SESSION['quiz']['relate_id'][$i] != $_SESSION['quiz']['relate_id'][$i - 1] && $_SESSION['quiz']['relate_id'][$i] != "none") {

                    $strSQL = "SELECT GQUESTION_TYPE_ID,GQUESTION_TEXT FROM tb_questions_relate WHERE GQUESTION_ID = ?";
                    $stmt = $conn->prepare($strSQL);
                    $stmt->bind_param("s", $_SESSION['quiz']['relate_id'][$i]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $is_have = $result->num_rows;
                    if ($is_have == 1) {
                        $data = $result->fetch_array();
                        $relate_type = $data['GQUESTION_TYPE_ID'];
                        $relate_text = $data['GQUESTION_TEXT'];
                        $bg_color = "bgcolor='#fff'";
                        if ($relate_type == 3) {
                            if (is_mobile()) {
                                if ($_SESSION['sound'][$i] != 1) {
                                    $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $relate_text);
                                    $relate_text = str_replace(".flv", ".mp3", $relate_text);
                                    $relate_text = "<div align=center>
                                                    <br>
                                                        <audio id='play_mobile_" . $i . "' controls='controls' height='50px' width='100px' onended=\"end_play('play_mobile_" . $i . "','finish_" . $i . "')\" onplaying=\" document.getElementById('played_" . $i . "').value='1';\">
                                                            <source src=\"https://www.engtest.net/files/sound/$relate_text\" type='audio/mpeg'>
                                                        </audio>
                                                        <div id='finish_" . $i . "' align=center style='display:none'></div>
                                                    <br>&nbsp;
                                                    </div>
                                                    <input type=hidden id='played_" . $i . "' name='played_" . $i . "' size=10>";
                                }
                                else {
                                    $relate_text = "<div align=center><font size=2 face=tahoma color=red><b>คุณได้ฟังเสียงนี้ไปแล้ว</b></font></div>";
                                }
                            }
                            else {
                                if ($_SESSION['sound'][$i] != 1) {
                                    // $width = 300;
                                    // $height = 60;
                                    $folder = "sound";
                                    $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $relate_text);
                                    $relate_text = str_replace(".flv", ".mp3", $relate_text);

                                    $relate_text = "
                                    <div id='box_" . $i . "' align=center  style='cursor:pointer'
                                        onclick=\"
                                                    if(confirm('สามารถฟังเสียงนี้ได้เพียงครั้งเดียว ต้องการฟังเดี๋ยวนี้หรือไม่'))
                                                    {	
                                                        document.getElementById('box_" . $i . "').style.display='none';	
                                                        document.getElementById('sound_" . $i . "').style.display='';
                                                        document.getElementById('played_" . $i . "').value='1';
                                                    }
                                                \">
                                        <font size=2 face=tahoma color=blue><b>กดที่นี่เพื่อฟังเสียง สามารถฟังได้เพียงครั้งเดียวเท่านั้น</b></font>
                                    </div>
                                    <div id='sound_" . $i . "' align=center style=\"display:none\">
                                    <audio id='player_" . $i . "' preload='auto' onended=\"hide('btnp_" . $i . "','btnp2_" . $i . "','finish_" . $i . "')\">
                                    <source src=\"https://www.engtest.net/files/$folder/$relate_text\">
                                    </audio>
                                    <div id='btnp_" . $i . "' class='yui3-button' onclick=\"document.getElementById('player_" . $i . "').play();\">Play &#9658; </div>
                                    <div id='btnp2_" . $i . "' class='yui3-button' onclick=\"document.getElementById('player_" . $i . "').pause();\">Pause &#10073;&#10073;</div>
                                    <div id='finish_" . $i . "' class='yui3-button' style='display:none'></div>
                                    </div>
                                    <input type=hidden id='played_" . $i . "' name='played_" . $i . "' size=10>";
                                }
                                else {
                                    $relate_text = "<div align=center><font size=2 face=tahoma color=red><b>คุณได้ฟังเสียงนี้ไปแล้ว</b></font></div>";
                                }
                            }
                            $bg_color = "";
                        }
                        if ($relate_type == 2) {
                            $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/", "", "../" . $relate_text);
                            $relate_text = "<div align=center><img src='$msg_relate' border=0 width=300></div>";
                        }
                        echo "<br>
							  <table align=center width=90% cellpadding=5 cellspacing=0 border=0 $bg_color style='border-radius:5px'>
									<tr height=25>
										<td><font size=2 face=verdana>$relate_text</font></td>
									</tr>
							  </table>";
                    }
                    $stmt->close();
                }

                $SQL = "SELECT QUESTIONS_TEXT FROM tb_questions WHERE QUESTIONS_ID = ?";
                $query = $conn->prepare($SQL);
                $query->bind_param("s", $_SESSION['quiz']['id'][$i]);
                $query->execute();
                $result = $query->get_result();
                $is_have = $result->num_rows;
                if ($is_have == 1) {
                    $data = $result->fetch_array();
                    $quiz_text = $data['QUESTIONS_TEXT'];
                    echo "
						<br>
						<table align=center width=90% cellpadding=5 cellspacing=0 border=0 >
							<tr height=25 valign=top>
								<td align=center width=5% rowspan=2 ><font size=2 face=verdana >$i.</font></td>
								<td align=left width=95%><font size=2 face=verdana > $quiz_text </font></td>
							</tr>
							<tr height=25>
								<td>
							";

                    $tb_ans = "SELECT ANSWERS_ID,ANSWERS_TEXT FROM tb_answers WHERE QUESTIONS_ID = ? ORDER BY ANSWERS_ID ASC";
                    $sub_stmt = $conn->prepare($tb_ans);
                    $sub_stmt->bind_param("s", $_SESSION['quiz']['id'][$i]);
                    $sub_stmt->execute();
                    $result = $sub_stmt->get_result();
                    $ans_num = $result->num_rows;
                    if ($ans_num >= 1) {
                        echo "<table align=left cellpadding=0 cellspacing=0 border=0>";
                        for ($k = 1; $k <= $ans_num; $k++) {
                            $check[$k] = 0;
                            $data = $result->fetch_array();
                            $ans_id = $data['ANSWERS_ID'];
                            $ans_text = $data['ANSWERS_TEXT'];
                            //----------------------------------------------------------------------------//
                            if ($k == 1) {
                                $check_event = "document.getElementById('ans_" . $i . "_2').checked=''
																		document.getElementById('ans_" . $i . "_3').checked=''
																		document.getElementById('ans_" . $i . "_4').checked=''";
                                $click_event = "
																		if( document.getElementById('ans_" . $i . "_1').checked=='')
																		{	document.getElementById('ans_" . $i . "_1').checked='checked'	}
																		else
																		{	document.getElementById('ans_" . $i . "_1').checked=''	}" . $check_event;
                            }
                            if ($k == 2) {
                                $check_event = "document.getElementById('ans_" . $i . "_1').checked=''
																		document.getElementById('ans_" . $i . "_3').checked=''
																		document.getElementById('ans_" . $i . "_4').checked=''";
                                $click_event = "
																		if( document.getElementById('ans_" . $i . "_2').checked=='')
																		{	document.getElementById('ans_" . $i . "_2').checked='checked'	}
																		else
																		{	document.getElementById('ans_" . $i . "_2').checked=''	}" . $check_event;
                            }
                            if ($k == 3) {
                                $check_event = "document.getElementById('ans_" . $i . "_1').checked=''
																		document.getElementById('ans_" . $i . "_2').checked=''
																		document.getElementById('ans_" . $i . "_4').checked=''";
                                $click_event = "
																		if( document.getElementById('ans_" . $i . "_3').checked=='')
																		{	document.getElementById('ans_" . $i . "_3').checked='checked'	}
																		else
																		{	document.getElementById('ans_" . $i . "_3').checked=''	}" . $check_event;
                            }
                            if ($k == 4) {
                                $check_event = "document.getElementById('ans_" . $i . "_1').checked=''
																		document.getElementById('ans_" . $i . "_2').checked=''
																		document.getElementById('ans_" . $i . "_3').checked=''";
                                $click_event = "
																		if( document.getElementById('ans_" . $i . "_4').checked=='')
																		{	document.getElementById('ans_" . $i . "_4').checked='checked'	}
																		else
																		{	document.getElementById('ans_" . $i . "_4').checked=''	}" . $check_event;
                            }
                            if ($_SESSION['ans'][$i][$k] >= 1) {
                                $check[$k] = "checked";
                            }
                            else {
                                $check[$i] = "";
                            }
                            //----------------------------------------------------------------------------//
                            echo "
														<tr height=25 valign=top>
															<td align=left ><input name='ans_" . $i . "_" . $k . "' id='ans_" . $i . "_" . $k . "' type=checkbox  
																onclick=\"$check_event\" value='$ans_id' $check[$k]>&nbsp;</td>
															<td align=left onclick=\"$click_event\"><font size=2 face=verdana>$ans_text</font></td>
														</tr>
														";
                        }
                        echo "</table>";
                    }
                    $sub_stmt->close();
                    echo "
										</td>
									</tr>
								</table>
							";
                }
                $query->close();
            }
        }


        if ($count >= 1) {
            if ($page + 1 > $count) {
                $next = 1;
            }
            else {
                $next = $page + 1;
            }
            if ($page - 1 <= 0) {
                $back = $count;
            }
            else {
                $back = $page - 1;
            }
            echo "
						<br>
						<table align=center width=90% cellpadding=5 cellspacing=0 border=0 style='background-color:#fff; border-radius: 6px;'>
							<tr height=25 valign=top>
								<td align=left width=15%>
									<img src='https://www.engtest.net/image2/eol system/Standard Test/back.png' border=0 style='cursor:pointer; height:43px;'
										onclick=\"javascript:	document.getElementById('quiz_form').action='?action=record&&page=$page&&next=$back';
																document.getElementById('quiz_form').submit();
												\"
									>
								</td>
								<td align=right width=11%><font size=2 face=verdana>Page&nbsp;:&nbsp;</font></td>
								<td align=left width=59%><font size=2 face=verdana>
							
					";
            for ($i = 1; $i <= $count; $i++) {
                if ($i <= 9) {
                    $num = "[0" . $i . "]";
                }
                if ($i >= 10 && $i <= 99) {
                    $num = "[" . $i . "]";
                }
                if ($page == $i) {
                    $color = "red";
                }
                else {
                    $color = "blue";
                }
                echo "&nbsp;<a onclick=\"javascript:document.getElementById('quiz_form').action='?action=record&&page=$page&&next=$i';
														document.getElementById('quiz_form').submit();
											\" style='cursor:pointer'
								><font color='$color'>$num</font></a>&nbsp;";
                if ($i % 10 == 0) {
                    echo "<br>";
                }
            }
            echo "
								</font></td>
								<td align=right width=15%>
									<img src='https://www.engtest.net/image2/eol system/Standard Test/next.png' border=0 style='cursor:pointer; height:43px;'
										onclick=\"javascript:	document.getElementById('quiz_form').action='?action=record&&page=$page&&next=$next';
																document.getElementById('quiz_form').submit();
												\"
									>
								</td>
							</tr>
						</table>
					";
        }
        echo "
				<table align=center width=90% cellpadding=0 cellspacing=0 border=0>
					<tr height=20><td></td></tr>
					<tr height=8 ><td style='background-color:#777777; border-radius: 4px;'></td></tr>
					<tr height=75><td align=center>
						<img  src='https://www.engtest.net/image2/eol system/Standard Test/finish-standard-test.png' style='cursor:pointer'  width='160' height='50'
											onclick=\"javascript:	if(confirm('Do you want to finish this EOL Standard Test ? '))
													{
														document.getElementById('quiz_form').action='?action=record&&page=$page&&next=$next&&finish=finish';
														document.getElementById('quiz_form').submit();
													}
									\"
						>
					</td></tr>
				</table>
				</form>";
    }
    mysqli_close($conn);
}

function est_record()
{
    set_time();
    //-------------------------------------------------------------------//
    $next = $_GET['next'];
    $page = $_GET['page'];
    if ($_SESSION['all_page'][$page] - $_SESSION['all_page'][$page] == 0 && $_SESSION['all_page'][$page] >= 1) {
        $start = $_SESSION['all_page'][$page];
        $stop = $_SESSION['all_page'][$page + 1] - 1;
        if ($stop <= 0) {
            $stop = $_SESSION['amount'];
        }
        if ($start >= 1 && $stop >= 1 && $start <= $stop) {
            for ($i = $start; $i <= $stop; $i++) {
                for ($k = 1; $k <= 4; $k++) {
                    $ans_name = "ans_" . $i . "_" . $k;
                    if ($_POST[$ans_name] >= 1) {
                        $_SESSION['ans'][$i][$k] = $_POST[$ans_name];
                    }
                    else {
                        $_SESSION['ans'][$i][$k] = 0;
                    }
                }
            }
        }
        for ($i = $start; $i <= $stop; $i++) {
            $sound_play = "played_" . $i;
            if ($_POST[$sound_play] == 1) {
                $_SESSION['sound'][$i] = "1";
            }
        }
    }
    if ($_GET['finish'] == "finish") {
        $msg_link = "<script>window.location='?action=finish'</script>";
    }
    else {
        $msg_link = "<script>document.getElementById('back_form').submit()</script>";
    }
    echo "
			<form id='back_form' method=post action='?action=test&&page=$next'>
				<input type=hidden name='time_left' value='" . trim($_POST['time_left']) . "'>
			</form>
			$msg_link";
}

function set_time()
{
    if ($_SESSION['all_time'] && $_SESSION['all_time'] - $_SESSION['all_time'] == 0) {
        $_SESSION['fn_time'] = $_SESSION['all_time'];
        unset($_SESSION['all_time']);
    }
    if ($_SESSION['fn_time'] && $_POST['time_left']) {
        $_SESSION['fn_time'] = $_POST['time_left'];
    }

    echo "
		<form name=config>
			<input type=hidden  value='$_SESSION[fn_time]' name='fn_time'  readonly>
			<input type=hidden  name='time_min'  readonly>
			<input type=hidden  name='time_sec'  readonly>
		</form>";
}
function display_time_left()
{
    echo "	<br>
			<table align=center width=250 cellpadding=0 cellspacing=0 border=0>
				<tr height=30>
                    <td style='background-color:#eeeeee; border-radius: 6px;'>
						<div id='dplay' align=center></div>
				    </td>
                </tr>
			</table>";
}

function est_result()
{
    include('../config/connection.php');
    //-------------------------------------------------------------------//
    echo "
			<table align=center border=0>
				<tr height=200>
					<td align=center><font size=2 face=tahoma color=blue><b>- ระบบกำลังวิเคราะห์ผลโปรดรอซักครู่ ( Now Loading... ) -</b></font></td>
				</tr>
			</table>
			";
    if ($_SESSION['amount'] >= 1 && $_SESSION['etest'] >= 1) {

        $strSQL = "SELECT * FROM tb_w_result_est ORDER BY result_id DESC limit 0,1";
        $stmt = $conn->prepare($strSQL);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
        if ($num == 1) {
            $data = $result->fetch_array();
            $last_id = $data['result_id'] + 1;
        }
        else {
            $last_id = 1;
        }
        //----------------------------------------------//
        $sum = 0;
        for ($i = 1; $i <= $_SESSION['amount']; $i++) {
            $ans_id = 0;
            for ($k = 1; $k <= 4; $k++) {
                if ($_SESSION['ans'][$i][$k] - $_SESSION['ans'][$i][$k] == 0 && $_SESSION['ans'][$i][$k] >= 1) {
                    $ans_id = $_SESSION['ans'][$i][$k];
                    $ans_correct = 1;
                    $SQL = "SELECT * FROM tb_answers WHERE QUESTIONS_ID = ? && ANSWERS_CORRECT = ? && ANSWERS_ID = ?";
                    $query = $conn->prepare($SQL);
                    $query->bind_param("sis", $_SESSION['quiz']['id'][$i], $ans_correct, $ans_id);
                    $query->execute();
                    $result = $query->get_result();
                    $correct = $result->num_rows;

                    if ($correct == 1) {
                        $sum = $sum + 1;
                    }
                    else {
                        $sum = $sum - 0.25;
                    }
                }
            }

            $msg = "INSERT INTO tb_w_result_est_detail (result_id, quiz_id, ans_id) VALUES (?,?,?)";
            $sub_stmt = $conn->prepare($msg);
            $sub_stmt->bind_param("sss", $last_id, $_SESSION['quiz']['id'][$i], $ans_id);
            $sub_stmt->execute();
            $sub_stmt->close();
        }
        $now = date("Y-m-d H:i:s");

        $sql = "INSERT INTO tb_w_result_est (result_id, member_id, etest_id, percent, create_date) VALUES(?,?,?,?,?)";
        $sub_query = $conn->prepare($sql);
        $sub_query->bind_param("sssds", $last_id, $_SESSION['x_member_id'], $_SESSION['etest'], $sum, $now);
        $sub_query->execute();
        $sub_query->close();
    }
    mysqli_close($conn);

    echo "<script>window.location='eoltest.php?section=business&&action=report&&report_section=standard&&result_id=$last_id'</script>";
    exit;
}



function display_footer()
{
?>


            </div>
        </div>
        <!-----------end main cotent------------>
    </div>
    <!------------------- footer -------------->
    <script src='http://localhost/engtest/bootstrap/js/jquery.min.js'></script>
    <script language="javascript">
    function begintimer() {
        if (!document.images)
            return
        if (parselimit == 1)
            window.location = '?action=record&&page=$page&&next=$next&&finish=finish';
        // alert('หมดเวลาสำหรับการทำข้อสอบ');
        // เหตุการณ์ที่ต้องการให้เกิดขึ้น
        // window.location='page.php'; ถ้าต้องการให้กระโดดไปยัง Page อื่น
        // fin_form.submit();
        else {
            parselimit -= 1
            curmin = Math.floor(parselimit / 60)
            cursec = parselimit % 60
            if (curmin != 0) {
                curtime = "<b><font face=tahoma size=2>เวลาที่เหลือ : <font color=red> " + curmin +
                    " </font>นาที กับ <font color=red> " + cursec + " </font>วินาที </font></b>"
                document.config.time_min.value = curmin
                document.config.time_sec.value = cursec
                document.quiz_form.time_left.value = parselimit
                // document.next_form.time_left.value = parselimit
                // document.back_form.time_left.value = parselimit
                // document.num_form.time_left.value = parselimit
            } else {
                curtime = "<b><font face=tahoma size=2>เวลาที่เหลือ <font color=red>" + cursec +
                    " </font>วินาที </font></b>"
                document.config.time_min.value = curmin
                document.config.time_sec.value = cursec
                document.quiz_form.time_left.value = parselimit
                // document.next_form.time_left.value = parselimit
                // document.back_form.time_left.value = parselimit
                // document.num_form.time_left.value = parselimit
            }
            document.getElementById('dplay').innerHTML = curtime;
            setTimeout("begintimer()", 1000)
        }
    }
    $(function() {
        $(window).bind("beforeunload", function(event) {
            var msg = "ยืนยันต้องการปิดหน้านี้ ?";
            $(window).bind("unload", function(event) {
                event.stopImmediatePropagation();
                $.ajax({
                    type: "POST",
                    url: "../inc/updatetimeout.php",
                    data: '',
                    success: function(response) {
                        if (response == 'OK') {
                            alert(msg);
                        }
                    },
                    async: false
                });
            });
            return;
        });
        $("a").click(function() {
            $(window).unbind("beforeunload");
        });
    });
    </script>
    <div>
        <center style="margin-bottom:10px; margin-top:-3px;"><b>Copyright © 2022 By English Online Co.,Ltd. All rights
                reserved.</b>
        </center>
    </div>
</body>

</html>

<?php
}
function is_mobile()
{

    // Get the user agent

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Create an array of known mobile user agents
    // This list is from the 21 October 2010 WURFL File.
    // Most mobile devices send a pretty standard string that can be covered by
    // one of these. I believe I have found all the agents (as of the date above)
    // that do not and have included them below. If you use this function, you
    // should periodically check your list against the WURFL file, available at:
    // https://wurfl.sourceforge.net/


    $mobile_agents = array(

        "240x320",
        "acer",
        "acoon",
        "acs-",
        "abacho",
        "ahong",
        "airness",
        "alcatel",
        "allview",
        "amoi",
        "amazon",
        "android",
        "anywhereyougo.com",
        "applewebkit/525",
        "applewebkit/532",
        "archos",
        "asus",
        "audio",
        "au-mic",
        "avantogo",
        "becker",
        "benq",
        "bilbo",
        "bird",
        "blackberry",
        "blazer",
        "bleu",
        "cdm-",
        "compal",
        "coolpad",
        "danger",
        "dbtel",
        "dopod",
        "elaine",
        "eric",
        "etouch",
        "fly ",
        "fly_",
        "fly-",
        "go.web",
        "goodaccess",
        "google",
        "gradiente",
        "grundig",
        "haier",
        "hedy",
        "hitachi",
        "hp",
        "htc",
        "honor",
        "huawei",
        "hutchison",
        "inno",
        "infinix",
        "ipad",
        "ipaq",
        "ipod",
        "iphone",
        "itel",
        "jbrowser",
        "kddi",
        "kgt",
        "kwc",
        "leeco",
        "lenovo",
        "lg ",
        "lg2",
        "lg3",
        "lg4",
        "lg5",
        "lg7",
        "lg8",
        "lg9",
        "lg-",
        "lge-",
        "lge9",
        "longcos",
        "maemo",
        "mercator",
        "meridian",
        "micromax",
        "midp",
        "mini",
        "mitsu",
        "meizu",
        "mmm",
        "mmp",
        "mobi",
        "mot-",
        "moto",
        "motorola",
        "nec-",
        "netfront",
        "newgen",
        "nexian",
        "nf-browser",
        "nintendo",
        "nitro",
        "nokia",
        "nook",
        "novarra",
        "nvidia",
        "obigo",
        "oppo",
        "oneplus",
        "orange",
        "palm",
        "panasonic",
        "pantech",
        "philips",
        "plum",
        "phone",
        "pg-",
        "playstation",
        "poco",
        "pocket",
        "pt-",
        "qc-",
        "qtek",
        "rover",
        "redmi",
        "realme",
        "sagem",
        "sama",
        "samu",
        "sanyo",
        "samsung",
        "sch-",
        "scooter",
        "sec-",
        "sendo",
        "sgh-",
        "sharp",
        "siemens",
        "sie-",
        "softbank",
        "sony",
        "spice",
        "sprint",
        "spv",
        "symbian",
        "tablet",
        "talkabout",
        "tcl-",
        "teleca",
        "telit",
        "tecno",
        "tianyu",
        "tim-",
        "toshiba",
        "tsm",
        "up.browser",
        "utec",
        "utstar",
        "verykool",
        "virgin",
        "vivo",
        "vk-",
        "voda",
        "voxtel",
        "vx",
        "wap",
        "wellco",
        "wig browser",
        "wii",
        "wiko",
        "windows ce",
        "wireless",
        "xolo",
        "xda",
        "xde",
        "xiaomi",
        "yezz",
        "yu",
        "zte"
    );

    // Pre-set $is_mobile to false.

    $is_mobile = false;

    // Cycle through the list in $mobile_agents to see if any of them
    // appear in $user_agent.

    foreach ($mobile_agents as $device) {

        // Check each element in $mobile_agents to see if it appears in
        // $user_agent. If it does, set $is_mobile to true.

        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            // break out of the foreach, we don't need to test
            // any more once we get a true value.
            break;
        }
    }

    return $is_mobile;
}
?>