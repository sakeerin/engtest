<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include('../inc/user_info.php');

//-----------------//

pre_page();
check_duel_login();
check_available_time();
main_page();
//-----------------//

function pre_page()
{
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>English Test Online :: ระบบทดสอบภาษาอังกฤษออนไลน์ </title>
    <link rel='shortcut icon' type='image/x-icon' href='http://localhost/engtest/images/image2/neweol-logo.ico'>
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/mainpage.css">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/systemtest.css">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/tabbar.css">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai&display=swap" rel="stylesheet">
    <style type='text/css'>
    .f-thai {
        font-family: 'IBM Plex Sans Thai' !important;
    }

    input[type="radio"] {
        font-size: 15px;
    }
    </style>

</head>

<body>
    <?php
}

function check_duel_login()
{
    include('../config/connection.php');
    $session_id = session_id();
    $strSQL = "SELECT * FROM tb_x_login WHERE member_id = ? && ssid = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $_SESSION['x_member_id'], $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_ok = $result->num_rows;
    if ($is_ok == 0) {
        unset($_SESSION['x_member_id']);
    }
    $stmt->close();

}

function check_available_time()
{
    include('../config/connection.php');
    $now = date("Y-m-d H:i:s");
    $strSQL = "SELECT * FROM tb_x_member_time WHERE member_id = ? && stop_date >= ? ORDER BY stop_date DESC limit 0,1";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $_SESSION['x_member_id'], $now);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_ok = $result->num_rows;
    if ($is_ok == 0) {
        echo "<script type=\"text/javascript\">
		            window.location=\"eoltest.php?section=business\";
	          </script>";
        exit();
    }
    $stmt->close();
}

function main_page()
{

    display_profile();
    if ($_GET['action'] == "set_test") {
        set_test();
    }
    if ($_GET['action'] == "test") {
        xtest();
    }
    if ($_GET['action'] == "record") {
        record_ans();
    }
    if ($_GET['action'] == "result") {
        display_result();
    }
    display_footer();
}

function display_profile()
{
    include('../config/connection.php');
    // global $data_profile;

    $strSQL = "SELECT * FROM tb_x_member WHERE member_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_member = $result->num_rows;

    /*------------  imageprofile-------------------*/
    if ($is_member == 1) {
        $data = $result->fetch_array();
        //----------------------------------------//
        $msg_image = "https://www.engtest.net/2010/member_images/" . $_SESSION['x_member_id'] . ".jpg";
        $data_image = @getimagesize($msg_image);
        if ($data_image[0] >= 1 && $data_image[0] - $data_image[0] == 0) {
            $image_name = $_SESSION['x_member_id'] . ".jpg";
            if ($data_image[1] >= 100) {
                $height = 100;
            }
            else {
                $height = $data_image[1];
            }
        }
        else {
            $msg_image = "https://www.engtest.net/2010/member_images/icon_user_0" . $data['gender'] . ".jpg";
            $height = 100;
        }
    }
    else {
        header("Location:../inc/logout.php");
        exit;
    }
    //---------------------------------------------------------------------------------------------------//
    $skill_ok = 0;
    $level_ok = 0;
    //---------------------------------------------------------------------------------------------------//
    if ($_SESSION['x_skill_id'] == 1) {
        $skill_ok = 1;
    }
    if ($_SESSION['x_skill_id'] == 2) {
        $skill_ok = 1;
    }
    if ($_SESSION['x_skill_id'] == 3) {
        $skill_ok = 1;
    }
    if ($_SESSION['x_skill_id'] == 4) {
        $skill_ok = 1;
    }
    if ($_SESSION['x_skill_id'] == 5) {
        $skill_ok = 1;
    }
    if ($_SESSION['x_skill_id'] == 7) {
        $skill_ok = 1;
    }
    if ($_SESSION['x_skill_id'] == 10) {
        $skill_ok = 1;
    }
    //---------------------------------------------------------------------------------------------------//
    if ($_SESSION['x_level_id'] == 1) {
        $level_ok = 1;
    }
    if ($_SESSION['x_level_id'] == 2) {
        $level_ok = 1;
    }
    if ($_SESSION['x_level_id'] == 3) {
        $level_ok = 1;
    }
    if ($_SESSION['x_level_id'] == 4) {
        $level_ok = 1;
    }
    if ($_SESSION['x_level_id'] == 5) {
        $level_ok = 1;
    }
    //---------------------------------------------------------------------------------------------------//
    if ($skill_ok == 1 && $level_ok == 1) {
?>
    <div id='container'>
        <div id='header'>
            <!-- <img src='https://www.engtest.net/image2/mainpage/dbd-head.gif' width='927' height='148'
                style='margin:10px 0 0 16px; top:-10px;' /> -->
            <img src='http://localhost/engtest/images/image2/logo/logo-02.png' width='270' height='118'
                style='float:left;margin-left:20px; margin-top: 175px;' />
            <!---- info user ----->
            <div id='info_user'>
                <?php $data = new info();
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
        <div id='content2'>
            <div id='pic_border'>
                <img src='http://localhost/engtest/images/image2/eol system/head-box-02.png' width='1024' />
            </div>
            <div id='content-div'>
                <?php
    }
    else {
        header("Location:../EOL/eoltest.php?section=business");
        exit;
    }

}

function set_test()
{
    include('../config/connection.php');
    if (!isset($_SESSION['x_member_id'])) {
        header("Location:../inc/logout.php");
        exit;
    }

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
    unset($_SESSION['amount']);
    unset($_SESSION['quiz_id']);
    unset($_SESSION['ans']);
    unset($_SESSION['all_time']);
    unset($_SESSION['fn_time']);

    $test_id = 1;
    $active = 1;

    // ---------------------------- //
    echo "<a href='eoltest.php?section=business&&action=academic' style='float: right; margin-top: 10px; margin-right: 15px;' class='f-thai'>
                <font size=3 color=black><b> [ Back ]</b></font>
          </a>";
    // --------------------------- //
    $skill_name[1] = "Reading Comprehension";
    $skill_name[2] = "Listening Comprehension";
    $skill_name[3] = "Semi-Speaking";
    $skill_name[4] = "Semi-Writing";
    $skill_name[5] = "Grammar";
    $skill_name[6] = "Integrate Skill : Cloze Test";
    $skill_name[7] = "Vocabulary ";
    $skill_name[10] = "Multiple Skills";
    $level_name[1] = "Beginner";
    $level_name[2] = "Lower Intermediate";
    $level_name[3] = "Intermediate";
    $level_name[4] = "Upper Intermediate";
    $level_name[5] = "Advanced";
    //----------------------------------------//
    echo "<br><br><br><br>
          <div align=center style='margin-top:15px' class='f-thai'>
                <font size=4 color='#e29805'><b>" . $skill_name[$_SESSION['x_skill_id']] . "</font>&nbsp; &raquo; &nbsp;<font size=4 color='green'>" . $level_name[$_SESSION['x_level_id']] . "</b></font>
          </div>";
    //----------------------------------------//
    echo "<br>
          <div align=center style='font-size:15px;' class='table-form-create f-thai'>
			    <form action=?action=set_test method=post>
			    	<font size=3  ><b>ใส่จำนวนคำถามในชุดข้อสอบที่ท่านต้องการทดสอบ </b><br><br><b>
			    	จำนวนข้อสอบในแบบทดสอบ : </b></font><input type=number name='amount' size=5 value='$_POST[amount]' style='height:27px; width:40px;' required autofocus></font>&nbsp;&nbsp;
			    	<input type=submit value=' สร้างแบบทดสอบ ' class='create-test f-thai'><br><br>
			    	<font size=3 color='red'><b> *** จำนวนข้อสอบในชุดต้องมีอย่างน้อย 10 ข้อ และไม่เกิน 50 ข้อ *** </b></font>
		  </div>";

    if ($_POST['skill']) {
        for ($i = 1; $i <= 7; $i++) {
            if ($_POST['skill'][$i] == 1) {
                $checked[$i] = "checked";
            }
            else {
                $checked[$i] = "";
            }
        }
    }
    else {
        for ($i = 1; $i <= 7; $i++) {
            $checked[$i] = "checked";
        }
    }
    if ($_SESSION['x_skill_id'] == 10) // for multiple Skill
    {
        echo "
			<table id='multi_topic_a' align=center width=90% cellpadding=5 cellspacing=0 border=0  style=\"cursor:pointer;\" >
				<tr height=25>
					<td align=left 
						onclick=\"javascript:
									document.getElementById('multi_topic_a').style.display='none';
									document.getElementById('multi_topic_b').style.display='';
									document.getElementById('multi_skill_list').style.display='';
								\">
						<font size=2 face=tahoma color=black><b> &raquo; Advanced Setting </b></font>
					</td>
				</tr>
			</table>
			<table id='multi_topic_b' align=center width=90% cellpadding=5 cellspacing=0 border=0 style=\"cursor:pointer; display:none;\">
				<tr height=25>
					<td align=left 
						onclick=\"javascript:
									document.getElementById('multi_topic_a').style.display='';
									document.getElementById('multi_topic_b').style.display='none';
									document.getElementById('multi_skill_list').style.display='none';
								\">
						<font size=2 face=tahoma color=black><b> &laquo; Advanced Setting </b></font>
					</td>
				</tr>
			</table>
			<table id='multi_skill_list' align=center width=90% cellpadding=5 cellspacing=0 border=0 bgcolor='#f7f7f7' style='border-radius:10px; padding:10px 0;'>
				<tr height=25>
					<td width=1% rowspan=2>&nbsp;</td>
					<td width=35%>
						<input type='checkbox' name='skill[1]' value=1 $checked[1]>
						<font size=2 face=tahoma color=black>Reading Comprehension</font>
					</td>
					<td width=35%>
						<input type='checkbox' name='skill[3]' value=1 $checked[3]>
						<font size=2 face=tahoma color=black>Semi-Speaking</font>
					</td>
					<td width=30%>
						<input type='checkbox' name='skill[5]' value=1 $checked[5]>
						<font size=2 face=tahoma color=black>Grammartical Structure</font>
					</td>
				</tr>
				<tr height=25>
					<td >
						<input type='checkbox' name='skill[2]' value=1 $checked[2]>
						<font size=2 face=tahoma color=black>Listening Comprehension</font>
					</td>
					<td >
						<input type='checkbox' name='skill[4]' value=1 $checked[4]>
						<font size=2 face=tahoma color=black>Semi-Writing</font>
					</td>
					<td >
						<input type='checkbox' name='skill[7]' value=1 $checked[7]>
						<font size=2 face=tahoma color=black>Vocabulary </font>
					</td>
				</tr>
			</table>
			<br>";
    }
    echo "</form>";
    //------------------------------------------------------------------------------//
    if ($_POST['amount'] >= 10 && $_POST['amount'] <= 50 && $_POST['amount'] - $_POST['amount'] == 0) {
        //------------------------------ -------------------------------------------//
        //------------------------- Multiple Skill ---------------------------------//
        //------------------------------ -------------------------------------------//
        // $_SESSION['amount'] = 0;
        if ($_SESSION['x_skill_id'] == 10) {
            $last_num = 0;
            $current_num = 0;
            $skill = $_POST['skill'];
            //--------------------- Get data ----------------------------//
            $_SESSION['all_time'] = $_POST['amount'] * 60;
            $_SESSION['amount'] = $_POST['amount'] ?? '';
            //--------------------- Get data ----------------------------//
            for ($i = 1; $i <= 7; $i++) {
                if ($skill[$i] == 1) {

                    $sql = "SELECT QUESTIONS_ID FROM tb_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && IS_ACTIVE = ? ORDER BY QUESTIONS_ID ASC";
                    $query = $conn->prepare($sql);
                    $query->bind_param("iiii", $test_id, $i, $_SESSION['x_level_id'], $active);
                    $query->execute();
                    $result = $query->get_result();
                    $each_skill_num[$i] = $result->num_rows;
                }
            }
            $query->close();
            //-------------------------------------------------------------------//
            //-----------------     Set Each Skill Amount     -----------------//
            $used = 0;
            for ($i = 1; $i <= $_POST['amount']; $i++) {
                for ($k = 1; $k <= 7; $k++) {
                    if ($skill[$k] == 1) {
                        $skill_quiz_num[$k]++;
                        $used++;
                        if ($used == $_POST['amount']) {
                            $k = 8;
                            $i = $_POST['amount'] + 1;
                        }
                    }
                }
            }
            //-------------------------------------------------------------------//
            //-----------------     Get Data List    -----------------//
            $p = 1;
            for ($k = 1; $k <= 7; $k++) {
                if ($skill[$k] == 1) {
                    //-----------------     Get Ref Each Skill     -----------------//
                    for ($i = 1; $i <= $skill_quiz_num[$k]; $i++) {
                        $rand_quiz = rand(1, $each_skill_num[$k] - 1);
                        $quiz_num[$k][] = $rand_quiz;
                        $quiz_num[$k] = array_unique($quiz_num[$k]);
                        $count = count($quiz_num[$k]);
                        if ($count == $skill_quiz_num[$k]) {
                            $i = $skill_quiz_num[$k] + 2;
                        }
                        $i--;
                    }
                    sort($quiz_num[$k]);
                    //-----------------     Get Quiz ID From List Skill     -----------------//
                    for ($i = 1; $i <= $skill_quiz_num[$k]; $i++) {

                        $SQL = "SELECT QUESTIONS_ID FROM tb_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && IS_ACTIVE = ? ORDER BY QUESTIONS_ID ASC limit " . $quiz_num[$k][$i - 1] . ",1";
                        $sub_query = $conn->prepare($SQL);
                        $sub_query->bind_param("iiii", $test_id, $k, $_SESSION['x_level_id'], $active);
                        $sub_query->execute();
                        $result = $sub_query->get_result();
                        $is_have = $result->num_rows;
                        if ($is_have = 1) {
                            $data = $result->fetch_array();
                            $_SESSION['quiz_id'][$p] = $data['QUESTIONS_ID'];
                            $p++;
                        }
                    }
                    $sub_query->close();
                }
            }

        }
        //------------- ----------------- -----------------------------------------//
        //------------------------- Single Skill ----------------------------------//
        //------------- ----------------- -----------------------------------------//
        if ($_SESSION['x_skill_id'] != 10) // Single Skill
        {
            $msg = "SELECT QUESTIONS_ID FROM tb_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && IS_ACTIVE = ? ORDER BY QUESTIONS_ID ASC";
            $stmt = $conn->prepare($msg);
            $stmt->bind_param("iiii", $test_id, $_SESSION['x_skill_id'], $_SESSION['x_level_id'], $active);
            $stmt->execute();
            $result = $stmt->get_result();
            $num = $result->num_rows;
            if ($num >= 1) {

                //--------------------- Get data ----------------------------//
                $_SESSION['all_time'] = $_POST['amount'] * 60;
                $_SESSION['amount'] = $_POST['amount'] ?? '';
                //--------------------- Get data ----------------------------//
                for ($i = 1; $i <= 50; $i++) {
                    if ($_SESSION['x_member_id'] == 30112) {
                        $quiz_num[] = $i;
                        $i++;
                    }
                    else {
                        $quiz_num[] = rand(1, $num - 1);
                        $quiz_num = array_unique($quiz_num);
                    }
                    $count = count($quiz_num);
                    if ($count == $_POST['amount']) {
                        $i = 100;
                    }
                    $i--;
                }
                //--------------------- Order for Check ----------------------------//
                sort($quiz_num);

                for ($i = 0; $i < $_POST['amount']; $i++) {

                    $msgSQL = "SELECT QUESTIONS_ID FROM tb_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && IS_ACTIVE = ? ORDER BY QUESTIONS_ID ASC limit " . $quiz_num[$i] . ",1";
                    $sub_stmt = $conn->prepare($msgSQL);
                    $sub_stmt->bind_param("iiii", $test_id, $_SESSION['x_skill_id'], $_SESSION['x_level_id'], $active);
                    $sub_stmt->execute();
                    $result = $sub_stmt->get_result();
                    $is_have = $result->num_rows;
                    if ($is_have = 1) {
                        $data = $result->fetch_array();
                        $_SESSION['quiz_id'][$i + 1] = $data['QUESTIONS_ID'];
                    }

                }
                $sub_stmt->close();
            }
        }
        var_dump($_SESSION['quiz_id']);
        if (count($_SESSION['quiz_id']) == $_POST['amount']) {
            echo "
                <br><hr><br>
				<table align=center width=90% cellpadding=0 cellspacing=0 border=0 class='f-thai' style='font-size:14px;'>
                    <form action='?action=test' method=post>
                        <tr height=25><td><font size=5 color=blue><b>รายละเอียดของแบบทดสอบชุดนี้</b></font></td></tr>
                        <tr height=25><td><font size=4> - ข้อสอบประเภท 4 ตัวเลือก ให้เลือกเฉพาะข้อที่ถูกต้องที่สุดเท่านั้น </font></td></tr>
                        <tr height=25><td><font size=4> - จำนวนคำถามในแบบทดสอบชุดนี้ : " . count($_SESSION['quiz_id']) . " ข้อ </font></td></tr>
                        <tr height=25><td><font size=4> - ระยะเวลาในการทำแบบทดสอบชุดนี้ : " . count($_SESSION['quiz_id']) . " นาที  </font></td></tr>
                        <tr height=25><td><font size=4> - ข้อสอบแต่ละข้อมี : 1 คะแนน  </font></td></tr>
                        <tr height=25><td><font size=4> - กดที่ <font color=brown>\"Start\"</font> ทางด้านล่างเพื่อเริ่มทำแบบทดสอบ </font></td></tr>
                        <tr height=25><td><font size=4> - กดที่ <font color=green>\"Finish\"</font> เพื่อประเมินผลแบบทดสอบชุดนี้ </font></td></tr>
                        <tr height=50><td align=center><align=center><a href=''><input type=submit value=' Start ' class='create-test'></a></div></td></tr>
                    </form>
				</table>";
        }
    }
}

function xtest()
{
    include('../config/connection.php');
    if (!isset($_SESSION['quiz_id'])) {
        header("Location:?action=set_test");
        exit;
    }
    set_time();
    if ($_GET['action'] == "test") {
?>

                <body onLoad='begintimer()'>
                    <script language='javascript'>
                    if (document.images) {
                        var parselimit = document.config.fn_time.value
                    }
                    </script>
                    <?php
        display_time_left();
    }

    // ------------------------------------------- //
    if ($_SESSION['amount'] && $_SESSION['quiz_id']) {
        if ($_GET['quiz_id'] <= 0) {
            header("Location:?action=test&&quiz_id=1");
            exit;
        }
        if ($_GET['quiz_id'] > $_SESSION['amount']) {
            header("Location:?action=test&&quiz_id=$_SESSION[amount]");
            exit;
        }
        //-------------------------------------------------------//
        if (!$_GET['quiz_id'] || $_GET['quiz_id'] == 0) {
            $num = 1;
        }
        else {
            $num = $_GET['quiz_id'];
        }
        $quiz_id = $_SESSION['quiz_id'][$num];
        //--------------------------------------------------------//
        $active = 1;
        $strSQL = "SELECT * FROM tb_questions WHERE QUESTIONS_ID = ? && IS_ACTIVE = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("si", $quiz_id, $active);
        $stmt->execute();
        $result = $stmt->get_result();
        $is_have = $result->num_rows;
        if ($is_have == 1) {
            $data = $result->fetch_array();
            $quiz_text = $data['QUESTIONS_TEXT'];
            $skill_id = $data['SKILL_ID'];
            $skill_name[1] = "Reading Comprehension";
            $skill_name[2] = "Listening Comprehension";
            $skill_name[3] = "Semi-Speaking";
            $skill_name[4] = "Semi-Writing";
            $skill_name[5] = "Grammar";
            $skill_name[6] = "Intergrated Skill : Cloze Test";
            $skill_name[7] = "Vocabulary ";
            echo "
				<br>
				<table align=center width=90% border=0 cellpadding=0 cellspacing=0>
					<tr height=30>
						<td width=90% colspan=2>
							<font size=3 face=tahoma color='gray'><b>Skill : " . $skill_name[$skill_id] . "</b></font><br><br>
							<font size=3 face=tahoma><b>No. $num  </b></font>
						</td>
						<td align=right width=10%>&nbsp;</td>
					</tr>";

            $SQL = "SELECT * FROM tb_questions_mapping WHERE QUESTIONS_ID = ?";
            $sub_stmt = $conn->prepare($SQL);
            $sub_stmt->bind_param("s", $quiz_id);
            $sub_stmt->execute();
            $result = $sub_stmt->get_result();
            $is_relate = $result->num_rows;
            if ($is_relate == 1) {
                $relate_data = $result->fetch_array();
                $relate_id = $relate_data['GQUESTION_ID'];
                $sql = "SELECT * FROM tb_questions_relate WHERE GQUESTION_ID = ?";
                $query = $conn->prepare($sql);
                $query->bind_param("s", $relate_id);
                $query->execute();
                $result = $query->get_result();
                $relate_data = $result->fetch_array();
                $relate_type = $relate_data['GQUESTION_TYPE_ID'];
                $relate_text = $relate_data['GQUESTION_TEXT'];
                if ($relate_type == 1) {
                    $msg_relate = $relate_text;
                }
                if ($relate_type == 3) {
                    if (is_mobile()) {
                        $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $relate_text);
                        $relate_text = str_replace(".flv", ".mp3", $relate_text);
                        $msg_relate = "	<div align=center>
										    <br>
											<audio controls='controls' height='50px' width='100px' autoplay='autoplay'>
                                                    <source src=\"https://www.engtest.net/files/sound/$relate_text\" type='audio/mpeg'>
                                            </audio>
											<br>
										</div> ";
                    }
                    else {
                        $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $relate_text);
                        $relate_text = str_replace(".flv", ".mp3", $relate_text);

                        $msg_relate = '<audio id="audio" autoplay="autoplay" controls="controls" > 
                                            <source src="https://www.engtest.net/files/sound/' . $relate_text . '">  
                                       </audio>';
                    }
                }
                if ($relate_type == 2) {
                    $msg_relate = str_replace("/home/engtest/domains/engtest.net/public_html/", "", "../" . $relate_text);
                    $msg_relate = "<div align=center><img src='$msg_relate' border=0 width=300></div>";
                }
                $query->close();
                echo "
					<tr height=10><td colspan=3></td></tr>
					<tr>
						<td width=100% colspan=3 ><font size=3 face=verdana> $msg_relate </font></td>
					</tr>
					<tr height=10><td colspan=3></td></tr>";
            }
            $sub_stmt->close();

            echo "	
				<tr height=10><td width=100% colspan=3></td></tr>
				<tr height=25>
					<td width=100% colspan=3><font size=3 face=verdana><b>$quiz_text</b></font></td>
				</tr>
			    <form name='quiz_form' method='post' action='?action=record&&quiz_id=$num' name='quiz'>	
				    <tr height=25>
					    <td  colspan=3 align=left>";

            $SQL = "SELECT * FROM tb_answers WHERE QUESTIONS_ID = ? ORDER BY ANSWERS_ID";
            $sub_query = $conn->prepare($SQL);
            $sub_query->bind_param("s", $_SESSION['quiz_id'][$num]);
            $sub_query->execute();
            $result = $sub_query->get_result();
            $ans_num = $result->num_rows;
            if ($ans_num >= 1) {
                $ans_msg = "";
                for ($i = 1; $i <= $ans_num; $i++) {
                    $ans_data = $result->fetch_array();
                    $ans_id = $ans_data['ANSWERS_ID'];
                    $ans_detail = $ans_data['ANSWERS_TEXT'];
                    if ($ans_id == $_SESSION['ans'][$num]) {
                        $checked = "checked";
                    }
                    else {
                        $checked = "";
                    }
                    $ans_msg = $ans_msg . "<input type=radio value='" . $ans_id . "' name='choose' $checked> &nbsp; <font face=Verdana size=3>" . $ans_detail . "</font><br>";
                }
            }
            $sub_query->close();

            echo "$ans_msg";
            //-----------------------------------------------------//
            $back = $num - 1;
            $next = $num + 1;
            if ($num <= "1") {
                $back = $_SESSION['amount'];
            }
            if ($num >= $_SESSION['amount']) {
                $next = 1;
            }

            echo "
					</td>
				</tr>
				<tr height=50>
					<td width=100% colspan=3>
						<input type=hidden name='time_left'>
						<input type='submit' value=' Record your answer ' class='record_answer'>
					</td>
				</tr>
				<tr height=30>
					<td width=100% colspan=3 align=center style='background-color: #fdb83d; border-radius: 4px;'>
					    <font size=2 face=tahoma color=black><b>Question Number</b></font>
					</td>
				</tr>
				<tr height=10 ><td width=100% colspan=3 align=center></td></tr>
			    </form>
				<tr>
					<form name='num_form' method=post>
					<td colspan=3 align=center><input type=hidden name='time_left'>";

            for ($i = 1; $i <= $_SESSION['amount']; $i++) {
                $pre = "";
                $post = "";
                if (trim($_SESSION['ans'][$i])) {
                    $class = "bt_green";
                    $title = " Answered ";
                }
                else {
                    $class = "bt_red";
                    $title = " Unanswer ";
                }
                if ($i < 10) {
                    $pre = "&nbsp;&nbsp;";
                    $post = "&nbsp;&nbsp;";
                }
                if ($i >= 10 && $i < 100) {
                    $pre = "&nbsp;";
                    $post = "&nbsp;";
                }
                echo "&nbsp;<input type='button' class='$class' value='$pre$i$post' title='$title' style=\"cursor:pointer; border-radius:2px; margin-bottom:3px;\";
                        onclick=\"javascript:window.document.num_form.action='?action=test&&quiz_id=$i';document.num_form.submit();\">";
                if ($i % 20 == "0") {
                    echo "<br>";
                }
            }

            echo "
                        </td>
                    </form>
                </tr>
                <tr height=50>
                    <form name='back_form' method=post action=?action=test&&quiz_id=" . $back . ">
                        <input type=hidden name='time_left'>
                        <td width=10% align=left><input type=image src='http://localhost/engtest/images/image2/test/back.png' style=\"cursor:pointer; border-radius:5px;\"></td>
                    </form>
                    <td width=80% align=center>
                        <font size=2 face=tahoma color=red>Red : Unanswer</font>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <font size=2 face=tahoma color=green>Green : Answered</font>
                    </td>
                    <form name='next_form' method=post action=?action=test&&quiz_id=" . $next . ">
                        <input type=hidden name='time_left'>
                        <td width=10% align=right><input type=image  src='http://localhost/engtest/images/image2/test/next.png' style=\"cursor:pointer; border-radius:5px;\"></td>
                    </form>
                </tr>
                <tr height=10 ><td width=100% colspan=3 align=center></td></tr>
                <tr height=1 bgcolor='#aaaaaa'><td width=100% colspan=3 align=center></td></tr>
                <tr height=10 ><td width=100% colspan=3 align=center></td></tr>
                <tr height=50 >
                <form name='fin_form' method=post action='?action=result'>
                    <td width=100% colspan=3 align=center>
                        <input type=image  src='http://localhost/engtest/images/image2/test/finish.png' style=\"cursor:pointer\"  >
                    </td>
                </form>
            </tr>
        </table>";
        }
        $stmt->close();
    }

}

function record_ans()
{
    set_time();
    // clear Old Answer
    isset($_SESSION['ans'][$_GET['quiz_id']]) ? NULL : NULL;
    //---------------------------------------------------------//
    if ($_GET['quiz_id']) {
        $_SESSION['ans'][$_GET['quiz_id']] = $_POST['choose'];
    }
    if ($_GET['quiz_id'] >= "1") {
        $quiz_id = $_GET['quiz_id'] + 1;
    }
    if ($_GET['quiz_id'] == $_SESSION['amount']) {
        $quiz_id = 1;
    }

    echo "<script type=\"text/javascript\">
			    window.location=\"?action=test&&quiz_id=$quiz_id\";
		  </script>";
    exit();
}

function display_time_left()
{
    echo "<br>
		  <table align=center width=250 cellpadding=0 cellspacing=0 border=0>
				<tr height=30><td bgcolor=eeeeee style='border-radius:5px;'>
					<div id='dplay' align=center></div>
				</td></tr>
		  </table>";
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

function display_result()
{

    include('../config/connection.php');
    if ($_SESSION['quiz_id']) {
        $num = count($_SESSION['quiz_id']);
    }
    if ($num >= 1) {
        if ($_SESSION['quiz_id']) {
            $count = count($_SESSION['quiz_id']);
            if ($count >= 1) {
                $sum = 0;
                for ($i = 1; $i <= $count; $i++) {

                    $ans_id = ($_SESSION['ans'][$i] + 0);
                    $is_correct = 1;
                    $strSQL = "SELECT * FROM tb_answers WHERE QUESTIONS_ID = ? && ANSWERS_CORRECT = ? && ANSWERS_ID = ?";
                    $stmt = $conn->prepare($strSQL);
                    $stmt->bind_param("sis", $_SESSION['quiz_id'][$i], $is_correct, $ans_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $correct = $result->num_rows;
                    if ($correct == 1) {
                        $sum = $sum + 1;
                    }
                    $stmt->close();
                }
                if ($sum >= 1) {
                    $percent = number_format((($sum / $count) * 100), 2);
                }
                else {
                    $percent = 0.00;
                }
            }
        }
        //------------------------------------------------------------------//
        // last reult id
        $sql = "SELECT * FROM tb_w_result ORDER BY result_id DESC limit 0,1";
        $sub_stmt = $conn->prepare($sql);
        $sub_stmt->execute();
        $result = $sub_stmt->get_result();
        $is_have = $result->num_rows;
        if ($is_have == 1) {
            $data = $result->fetch_array();
            $last_id = $data['result_id'] + 1;
        }
        else {
            $last_id = 1;
        }
        $sub_stmt->close();
        //-------------------------------------------------------------------//
        $now = date("Y-m-d H:i:s");
        $etest_id = 0;
        $SQL = "INSERT INTO tb_w_result (result_id, member_id, skill_id, level_id, etest_id ,percent, create_date) VALUES (?,?,?,?,?,?,?)";
        $query = $conn->prepare($SQL);
        $query->bind_param("ssssiis", $last_id, $_SESSION['x_member_id'], $_SESSION['x_skill_id'], $_SESSION['x_level_id'], $etest_id, $percent, $now);
        $query->execute();
        $query->close();
        //------------------------------------------------------------------//
        if ($_SESSION['quiz_id']) {

            $count = count($_SESSION['quiz_id']);
            if ($count >= 1) {
                for ($i = 1; $i <= $count; $i++) {

                    $ans_id = ($_SESSION['ans'][$i] + 0);
                    $str = "INSERT INTO tb_w_result_detail (result_id, quiz_id, ans_id) VALUES (?,?,?)";
                    $sub_query = $conn->prepare($str);
                    $sub_query->bind_param("sss", $last_id, $_SESSION['quiz_id'][$i], $ans_id);
                    $sub_query->execute();
                    $sub_query->close();
                }
            }
        }
    }

    // unset($_SESSION['amount']);
    // unset($_SESSION['quiz_id']);
    // unset($_SESSION['ans']);
    // unset($_SESSION['all_time']);
    // unset($_SESSION['fn_time']);
    mysqli_close($conn);

    echo "<script type=\"text/javascript\">
                window.location=\"eoltest.php?section=business&&action=report&&report_section=academic&&result_id=$last_id\";
          </script>";
    exit();

}

function display_footer()
{
?>


            </div>
        </div>
        <!-----------end main cotent------------>
    </div>
    <!------------------- footer -------------->
    <script language="javascript">
    function begintimer() {
        if (!document.images)
            return
        if (parselimit == 1)
            // alert('หมดเวลาสำหรับการทำข้อสอบ');
            // เหตุการณ์ที่ต้องการให้เกิดขึ้น
            // window.location='page.php'; ถ้าต้องการให้กระโดดไปยัง Page อื่น
            fin_form.submit();
        else {
            parselimit -= 1
            curmin = Math.floor(parselimit / 60)
            cursec = parselimit % 60
            if (curmin != 0) {
                curtime = "<font face=tahoma size=2>เวลาที่เหลือ : <font color=red> " + curmin +
                    " </font>นาที กับ <font color=red> " + cursec + " </font>วินาที </font>"
                document.config.time_min.value = curmin
                document.config.time_sec.value = cursec
                document.quiz_form.time_left.value = parselimit
                document.next_form.time_left.value = parselimit
                document.back_form.time_left.value = parselimit
                document.num_form.time_left.value = parselimit
            } else if (cursec == 0) {
                alert('หมดเวลาแล้วจ้า');
            } else {
                curtime = "<font face=tahoma size=2>เวลาที่เหลือ <font color=red>" + cursec +
                    " </font>วินาที </font>"
                document.config.time_min.value = curmin
                document.config.time_sec.value = cursec
                document.quiz_form.time_left.value = parselimit
                document.next_form.time_left.value = parselimit
                document.back_form.time_left.value = parselimit
                document.num_form.time_left.value = parselimit
            }
            document.getElementById('dplay').innerHTML = curtime;
            setTimeout("begintimer()", 1000)
        }
    }
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