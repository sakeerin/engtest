<?php
ob_start();
session_start();

pre_page();
display_profile();

if (!$_GET['action']) {
    pre_test();
}
if ($_GET['action'] == "set-test") {
    set_test();
}
if ($_GET['action'] == "test") {
    main_test();
}
if ($_GET['action'] == "finish") {
    finish();
}
if ($_GET['action'] == "result") {
    if ($_GET['result_id']) {
        report($_GET['result_id']);
    }
}

display_footer();

function pre_page()
{
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>General English Proficiency Online Test :: ระบบทดสอบภาษาอังกฤษออนไลน์ </title>
    <link rel='shortcut icon' type='image/x-icon' href='http://localhost/engtest/images/image2/neweol-logo.ico'>
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/page-gepot.css">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/button-gepot.css">
    <style type="text/css">
    #submit {
        color: #00000020;
        font-size: 18px;
        font-weight: bold;
        width: 115px;
        height: 50px;
        letter-spacing: 1.8px;
        border-style: outset;
        border: 2px solid black;
        border-radius: 15px;
        /* -moz-border-radius: 15px; */
        -webkit-border-radius: 15px;
        margin-top: 35px;
        margin-bottom: 35px;
        padding: 0;
        /* background: #D6DAD9 no-repeat; */
        background: url(https://www.engtest.net/image2/test/finish.png) no-repeat;
        background-size: cover;
        background-position: center;
        box-shadow: -3px 3px orange, -2px 2px orange, -1px 1px orange;
        -webkit-box-shadow: -3px 3px orange, -2px 2px orange, -1px 1px orange;
        /* -moz-box-shadow: -3px 3px orange, -2px 2px orange, -1px 1px orange; */
    }

    #tbl_time_left {
        position: sticky;
        top: 10px;
    }

    input[type="checkbox"] {
        font-size: 16px;
    }

    body {
        margin-left: 0px;
        margin-top: -15px;
    }
    </style>
</head>

<body>
    <?php

}

function display_profile()
{
    include('../config/connection.php');
    $y_member_id = $_COOKIE["y_member_id"] ?? $_SESSION["y_member_id"];

    $strSQL = "SELECT * FROM tb_x_member_general WHERE member_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $y_member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_member = $result->num_rows;
    if ($is_member == 1) {
        $datatop = $result->fetch_array();
        $gender = $datatop['gender'];
        if ($gender == 0) {
            $gender = 1;
        }
        $msg_image = "http://localhost/engtest/2010/member_images/icon_user_0" . $gender . ".jpg";
    }
    else {
        echo "<script type=\"text/javascript\">
    	            window.location=\"http://localhost/engtest/index.php\";
    	      </script>";
        exit();
    }
    $stmt->close();
    mysqli_close($conn);
    // --------------------------- //
    echo "<div id='container'>
            <div id='header'>
                <!---- info user ----->
                <div id='info_user'>   
                    <div id='pic_profile'>
                        <img src='" . $msg_image . "' height='100'  width='100'/>
                    </div>
                    <div id='user_text'>
	                    <p style='margin-top:75px; font-weight:bold;'>$datatop[fname] &nbsp;&nbsp;$datatop[lname]</p>
                    </div>   
                    <div id='logoutPic'>
				        <a href='http://localhost/engtest/inc/logout.php'>
                            <img src='http://localhost/engtest/images/image2/eol system/button/logout-06.webp' style='margin-top:52px;' />
                        </a>
                    </div>
                </div>
            </div>
            <!------- main content--------->
            <div id='content'>
                <div id='pic_border'>
                    <img src='http://localhost/engtest/images/image2/eol system/head-box-02.png' width='1024' />
                </div>
                <div id='content-div'>";

}

function pre_test()
{
    include('../config/connection.php');
    include('../config/format_time.php');
    date_default_timezone_set('Asia/Bangkok');
    $_SESSION["event_start"] = TRUE;
    $_SESSION["event_pass"] = TRUE;
    // -------------------------- //    
    $is_est = 2;
    $strSQL = "SELECT ETEST_ID FROM tb_etest WHERE IS_EST = ? ORDER BY ETEST_ID";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $is_est);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have == 1) {
        $data_etest = $result->fetch_array();
        $etest_id = $data_etest['ETEST_ID'];
        $_SESSION['etest'] = $etest_id;
        setcookie("etest", $etest_id, time() + 9000, "/");
    }
    $stmt->close();

    $y_member_id = $_COOKIE["y_member_id"] ?? $_SESSION["y_member_id"];
    $y_etest_id = $_COOKIE["etest"] ?? $_SESSION["etest"];

    $SQL = "SELECT result_id,create_date FROM tb_w_result_gepot WHERE member_id = ? && etest_id = ?  ORDER BY create_date DESC limit 0,1";
    $query = $conn->prepare($SQL);
    $query->bind_param("ss", $y_member_id, $y_etest_id);
    $query->execute();
    $data_result = $query->get_result();
    $is_have = $data_result->num_rows;
    if ($is_have == 1) {
        $data = $data_result->fetch_array();
        $last_test = $data['create_date'];
        echo "is have <br>";

        $arr = explode(" ", $last_test);

        $msg_last = get_thai_day($arr[0]) . " " . get_thai_month($arr[0]) . " " . get_thai_year($arr[0]);
        $msg_last = "<font color=white>" . $msg_last . "</font>";
        $result_id = $data[0];
        $pass_msg = 0;
    }
    else {
        $msg_last = "<font color=green> ไม่พบข้อมูลการใช้งาน GEPOT ครั้งล่าสุด </font>";
        $pass_msg = "";
    }
    $query->close();
    echo "
		<table width=90% align=center cellpadding=0 cellspacing=0 border=0 >		
            <tr>
                <td align=center>
                    <img src='http://localhost/engtest/images/image2/gepot/pre-test-page.png' width='90%' style='margin-top:25px; border-radius:10px;'/>	
                </td>
            </tr>
            <tr>
                <td colspan=2 >";

    echo "<br><table align=center width=60% cellpadding=0 cellspacing=1 border=0>";
    // -------------------------------------- //
    if ($pass_msg == "" or $_SESSION['y_member_id'] == 6) {
        echo "
			    <tr height=30 border=1 style='background:#C1CDC1; border-radius:5px;'>
			  	    <td align=center  width='40%'>
                        <font size=2 face=tahoma border=1>
                            <b>ทดสอบ GEPOT ครั้งล่าสุดเมื่อ</b>
                        </font>
                    </td>
			  	    <td align=center colspan=3 >
                        <font size=2 face=tahoma border=1> $msg_last </font>
                    </td>
			    </tr>
			    <tr height=100 >		
				    <form method='post' action='?action=set-test'>
					    <td align=center colspan=4>		
                            <input type=checkbox id=notice onclick=\"javascript:
                                var notice_chk = document.getElementById('notice').checked;
                                if (notice_chk == false){
                                    document.getElementById('btnpretest').disabled = true;
                                }else{
                                    document.getElementById('btnpretest').disabled = false;
                                }
                                \"><font color=red  size=2>ข้าพเจ้ายอมรับเงื่อนไขในการใช้ระบบ (I accept the terms of use)</br></br></font>";
        // -------------------------- //

        $msg = "SELECT * FROM tb_x_general_time ORDER BY time DESC limit 0,1";
        $stmt_time = $conn->prepare($msg);
        $stmt_time->execute();
        $result = $stmt_time->get_result();
        $data = $result->fetch_array();

        if ($_SESSION['y_member_id'] == 6) {
            echo "
                <input type=hidden name='event_pass' value='1'>
                <input id='btnpretest' type='submit' class='yui3-button' value=' I want to use this test [GEPOT].' disabled>";
        }
        else if (date("Y-m-d") <= $data[1] || date("Y-m-d") >= $data[2]) {
            echo "  <input id='btnnotime' type='submit' class='yui3-button' value=' Currently Unavailable ' disabled>";

        }
        else {
            echo "  <input type=hidden name='event_pass' value='1'>
                <input id='btnpretest' type='submit' class='yui3-button' value=' I want to use this test [GEPOT].' disabled>";
        }
        echo "</td>
            </form>
        </tr>";
        $stmt_time->close();
    }
    else {
        echo "
            <tr height=30>
                <td align=center bgcolor='#FF6A6A' width='40%'><font size=2 face=tahoma ><b>ทดสอบ GEPOT ครั้งล่าสุดเมื่อ</b></font></td>
                <td align=center colspan=3 bgcolor='#FF6A6A'><font size=2 face=tahoma > $msg_last </font></td>
            </tr>
            <tr height=100 >
                <td align=center colspan=4>
                    <input type=button class='yui3-button' value=' Click to show report.' onclick=\"window.location.href='?action=result&&result_id=$result_id'\">
                </td>
            </tr>";
    }
    echo "     </table>
            </td>
        </tr>
    </table>";
    mysqli_close($conn);

}

function set_test()
{
    if ($_POST['event_pass'] == 1 && $_SESSION['event_pass'] == TRUE) {
        echo "	
            <center>
				<table width=90% align=center cellpadding=0 cellspacing=0 border=0 >
					<tr>
						<td align=center>
							<img src='http://localhost/engtest/images/image2/gepot/set-test-page.png' width='90%' style='margin-top:25px; border-radius:10px;'/>	
						</td>
					</tr>
				</table>
                <table>
                    <tr height=70>
                        <form method='post' action='?action=test'>
                            <td align=center>
                                <input type=hidden name='event_start' value='1'>
                                <input align=center id=event_start type='submit' class='yui3-button' value=' Start GEPOT Test'>
                            </td>
                        </form>
                    </tr>
                </table>
            </center>";
    }
    else {
        echo "<script>window.location='?'</script>";
        exit();
    }
}

function main_test()
{
    if ($_POST['event_start'] == 1 && $_SESSION['event_start'] == TRUE) {
        if ($_SESSION['event_pass'] == TRUE) {
            $_SESSION['event_pass'] = FALSE;
        }

        $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost/engtest/EOL/api_gepot.php",
            // CURLOPT_URL => "https://www.engtest.net/EOL/test_gepot_api.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => $ua,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        )
        );
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
        $num = count($data['question']);

        set_time();
        if ($_GET['action'] == "test") {
            echo "<img src='http://localhost/engtest/images/image2/gepot/GEPOT-3.webp' width=99.8% style='margin-left:2px;border-radius:10px;'>";
?>

    <body onLoad='begintimer()' oncontextmenu='return false;' onkeydown='return false;' onmousedown='return false;'>
        <script language='javascript'>
        if (document.images) {
            var parselimit = document.config.fn_time.value
        }
        </script>
        <?php
            display_time_left();

        }
        echo "<form name='quiz_form' id='quiz_form' method=post action='?action=finish'><input type=hidden name='time_left' >";
        for ($i = 0; $i < $num; $i++) {
            $relate_text = $data['relate_text'][$i];
            $bg_color = "bgcolor='#F7E8E8'";
            if ($data['relate_type'][$i] == 3) {
                if ($relate_text) {
                    if ($_COOKIE['sound_' . $i] == '') {
                        if (is_mobile()) {
                            $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $relate_text);
                            $relate_text = str_replace(".flv", ".mp3", $relate_text);
                            $relate_text = "<div align=center>
                                        <br>
                                        <audio id='play_mobile_" . $i . "' controls='controls' height='50px' width='100px' onended=\"end_play('play_mobile_" . $i . "','finish_" . $i . "'," . $i . ")\" preload='none'>
                                            <source src=\"https://www.engtest.net/files/sound/$relate_text\" type='audio/mpeg'>
                                        </audio>
                                        <div id='finish_" . $i . "' align=center style='display:none'></div>
                                                    <br>&nbsp;
                                    </div>";
                        }
                        else {

                            $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $data['relate_text'][$i]);
                            $relate_text = str_replace(".flv", ".mp3", $relate_text);
                            $relate_text = "
                                    <div id='box_" . $i . "' align=center  style='cursor:pointer'
                                            onclick=\"
                                                if(confirm('สามารถฟังเสียงนี้ได้เพียงครั้งเดียว ต้องการฟังเดี๋ยวนี้หรือไม่')){	
                                                    document.getElementById('box_" . $i . "').style.display='none';	
                                                    document.getElementById('sound_" . $i . "').style.display='';
                                                    document.getElementById('played_" . $i . "').value='1';
                                                }\">
                                                <font size=2 face=tahoma color=blue><b>กดที่นี่เพื่อฟังเสียง สามารถฟังได้เพียงครั้งเดียวเท่านั้น</b></font>
                                    </div>
                                    <div id='sound_" . $i . "' align=center style=\"display:none\">
                                        <audio id='player_" . $i . "' preload='none' onended=\"hide('btnp_" . $i . "','btnp2_" . $i . "','finish_" . $i . "'," . $i . ")\">
                                            <source src=\"https://www.engtest.net/files/sound/$relate_text\">
                                            </audio>
                                        <div id='btnp_" . $i . "' class='yui3-button' onclick=\"document.getElementById('player_" . $i . "').play();\">Play &#9658; </div>
                                        <div id='btnp2_" . $i . "' class='yui3-button' onclick=\"document.getElementById('player_" . $i . "').pause();\">Pause &#10073;&#10073;</div>
                                        <div id='finish_" . $i . "' align=center style='display:none'></div>
                                    </div>
                                    <input type=hidden id='played_" . $i . "' name='played_" . $i . "' size=10>";
                        }
                    }
                    else {
                        $relate_text = "<div align=center><font size=2 face=tahoma color=red><b>คุณได้ฟังเสียงนี้ไปแล้ว</b></font></div>";
                    }
                    if ($i == 0) {
                        echo "<br>
                            <table align=center width=90% cellpadding=5 cellspacing=0 border=0>
                                <tr height=25>
                                    <td><font size=3 face=verdana><b> Part 1 : Listening Skill</b></font></td>
                                </tr>
                            </table>";
                    }

                    echo "<br>
                        <table align=center width=90% cellpadding=5 cellspacing=0 border=0>
                            <tr height=25>
                                <td><font size=2 face=verdana>
                                    <b> Directions:  Listen to the passage and answer Questions below </b>
                                </font></td>
                            </tr>
                        </table>";
                    echo "<br>
                        <table align=center width=90% cellpadding=5 cellspacing=0 border=0>
                            <tr height=25>
                                <td><font size=2 face=verdana>$relate_text</font></td>
                            </tr>
                        </table>";
                }
            }
            // if ($data['relate_type'][$i] == 2) {
            //     $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/", "", "../" . $relate_text);
            //     $relate_text = "<div align=center><img src='$msg_relate' border=0 width=300></div>";
            //     echo "<br>
            //                 <table align=center width=90% cellpadding=5 cellspacing=0 border=0>
            //                     <tr height=25>
            //                         <td><font size=2 face=verdana>$relate_text</font></td>
            //                     </tr>
            //                 </table>";
            // }

            if ($data['relate_type'][$i] == 1) {
                if ($i == 30) {
                    echo "<br>
                        <table align=center width=90% cellpadding=5 cellspacing=0 border=0>
                            <tr height=25>
                                <td><font size=3 face=verdana><b> Part 2 : Reading Skill </b></font></td>
                            </tr>
                        </table>";
                }
                if ($relate_text) {
                    echo "<br>
                        <table align=center width=90% cellpadding=5 cellspacing=0 border=0 $bg_color style='border-radius:5px'>
                            <tr height=25>
                                <td><font size=3 face=verdana>$relate_text</font></td>
                            </tr>
                        </table>";
                }
            }
            if ($i == 70) {
                echo "<br>
                    <table align=center width=90% cellpadding=5 cellspacing=0 border=0>
                        <tr height=25>
                            <td><font size=3 face=verdana><b> Part 3 : Grammar Skill</b></font></td>
                        </tr>
                    </table>";
            }

            $z = $i + 1;
            echo "<br>
                <table id=element-to-hide align=center width=90% cellpadding=5 cellspacing=0 border=0 >
                    <tr height=25 valign=top>
                        <td align=center width=5% rowspan=2 style='padding: 17px;'><font size=3 face=verdana >$z.</font></td>
                            <td align=left width=95%><font size=3 face=verdana >" . $data['question'][$i] . "</font>
                        </td>
                    </tr>
                    <tr height=25>
                        <td>";

            $x = 1;
            echo "<table align=left cellpadding=0 cellspacing=0 border=0>";
            for ($j = 0; $j < 4; $j++) {
                $ans_id = $data['answer_correct'][$i][$j];
                $answer_id = base64_encode($ans_id);
                if ($j == 0) {
                    $check_event = "document.getElementById('ans_" . $i . "_2').checked=''
                                            document.getElementById('ans_" . $i . "_3').checked=''
                                            document.getElementById('ans_" . $i . "_4').checked=''";
                // $click_event = "
                //                             if( document.getElementById('ans_" . $i . "_1').checked=='')
                //                             {	document.getElementById('ans_" . $i . "_1').checked='checked'	}
                //                             else
                //                             {	document.getElementById('ans_" . $i . "_1').checked=''	}" . $check_event;

                }
                if ($j == 1) {
                    $check_event = "document.getElementById('ans_" . $i . "_1').checked=''
                                            document.getElementById('ans_" . $i . "_3').checked=''
                                            document.getElementById('ans_" . $i . "_4').checked=''";
                // $click_event = "
                //                             if( document.getElementById('ans_" . $i . "_2').checked=='')
                //                             {	document.getElementById('ans_" . $i . "_2').checked='checked'	}
                //                             else
                //                             {	document.getElementById('ans_" . $i . "_2').checked=''	}" . $check_event;

                }
                if ($j == 2) {
                    $check_event = "document.getElementById('ans_" . $i . "_1').checked=''
                                            document.getElementById('ans_" . $i . "_2').checked=''
                                            document.getElementById('ans_" . $i . "_4').checked=''";
                // $click_event = "
                //                             if( document.getElementById('ans_" . $i . "_3').checked=='')
                //                             {	document.getElementById('ans_" . $i . "_3').checked='checked'	}
                //                             else
                //                             {	document.getElementById('ans_" . $i . "_3').checked=''	}" . $check_event;

                }
                if ($j == 3) {
                    $check_event = "document.getElementById('ans_" . $i . "_1').checked=''
                                            document.getElementById('ans_" . $i . "_2').checked=''
                                            document.getElementById('ans_" . $i . "_3').checked=''";
                // $click_event = "
                //                             if( document.getElementById('ans_" . $i . "_4').checked=='')
                //                             {	document.getElementById('ans_" . $i . "_4').checked='checked'	}
                //                             else
                //                             {	document.getElementById('ans_" . $i . "_4').checked=''	}" . $check_event;

                }

                echo "<tr height=25 valign=top>
                        <td align=left ><font size=3 face=verdana ><input name='ans_" . $i . "_" . $x . "' id='ans_" . $i . "_" . $x . "' type=checkbox  
                                        onclick=\"$check_event\" value='$answer_id' onchange=\"checkfield('" . $i . "','ans_" . $i . "_" . $x . "')\" ></font>&nbsp;&nbsp;</td>
                        <td align=left valign=top><font size=3 face=verdana >" . strip_tags($data['answer_text'][$i][$j]) . "</font</td>
                 </tr>";
                $x = $x + 1;
            }
            echo "</table>
                        </td>
                    </tr>
                </table>";
        }

        echo "<br><br><hr><br>";
        echo "<center><img  src='http://localhost/engtest/images/image2/gepot/finish1.png' width='170' height='45' style='cursor:pointer' onclick=\"javascript: if(confirm('Do you want to finished this test ? '))
        {
            document.getElementById('quiz_form').action='?action=finish';
            document.getElementById('quiz_form').submit();
        }
    \"></center><br></form>";
    }
    else {
        echo "<script>window.location='?'</script>";
    }
}

function finish()
{
    include('../config/connection.php');
    date_default_timezone_set('Asia/Bangkok');

    echo "
		<table align=center border=0>
			<tr height=200>
				<td align=center><font size=2 face=tahoma color=blue><b>- ระบบกำลังวิเคราะห์ผลโปรดรอซักครู่ ( Now Loading... ) -</b></font></td>
			</tr>
		</table>
		";

    if ($_SESSION['event_start'] == TRUE) {
        $_SESSION['event_start'] = FALSE;
    }
    $strSQL = "SELECT * FROM tb_w_result_gepot order by result_id DESC limit 0,1";
    $stmt_etest = $conn->prepare($strSQL);
    $stmt_etest->execute();
    $result = $stmt_etest->get_result();
    $num = $result->num_rows;
    if ($num == 1) {
        $data = $result->fetch_array();
        $last_id = $data['result_id'] + 1;
    }
    else {
        $last_id = 1;
    }
    $sum = 0;
    $unans = 0;
    $wrong = 0;
    $correct = 0;
    $correct_grammar = 0;
    $wrong_grammar = 0;
    $correct_listening = 0;
    $wrong_listening = 0;
    $correct_reading = 0;
    $wrong_reading = 0;
    if ($_GET['action'] == "finish") {
        for ($i = 0; $i < 100; $i++) {
            $do_wrong = "0";
            // $do_unans = "0";
            for ($j = 1; $j < 5; $j++) {
                if (base64_decode($_POST['ans_' . $i . '_' . $j]) == "1") {
                    $sum = $sum + 1;
                    $correct = $correct + 1;
                    if ($i < 30) {
                        $correct_listening = $correct_listening + 1;
                    }
                    if ($i >= 30 && $i < 70) {
                        $correct_reading = $correct_reading + 1;
                    }
                    if ($i >= 70) {
                        $correct_grammar = $correct_grammar + 1;
                    }

                }
                elseif (base64_decode($_POST['ans_' . $i . '_' . $j]) == "0") {
                    if ($do_wrong == "0") {
                        $sum = $sum - 0.25;
                        $wrong = $wrong + 1;
                        $do_wrong = "1";
                        if ($i < 30) {
                            $wrong_listening = $wrong_listening + 1;
                        }
                        if ($i >= 30 && $i < 70) {
                            $wrong_reading = $wrong_reading + 1;
                        }
                        if ($i >= 70) {
                            $wrong_grammar = $wrong_grammar + 1;
                        }
                    }
                }
            }
        }
        //-----------------------------------------------------//
        $y_member_id = $_COOKIE["y_member_id"] ?? $_SESSION["y_member_id"];
        $y_etest_id = $_COOKIE["etest"] ?? $_SESSION["etest"];
        $now = date("Y-m-d H:i:s");

        $SQL = "INSERT INTO tb_w_result_gepot (result_id, member_id, etest_id, percent, correct, wrong, correct_listening, wrong_listening, correct_reading, wrong_reading, correct_grammar, wrong_grammar, create_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $conn->prepare($SQL);
        $query->bind_param("ssssdssssssss", $last_id, $y_member_id, $y_etest_id, $sum, $correct, $wrong, $correct_listening, $wrong_listening, $correct_reading, $wrong_reading, $correct_grammar, $wrong_grammar, $now);
        $query->execute();
        $query->close();

        echo "<script>window.location='general_eng.php?action=result&&result_id=$last_id'</script>";
        exit();
    }
    mysqli_close($conn);
}
function report($id)
{
    include('../config/connection.php');
    include('../config/format_time.php');

    $focus_member_id = $_COOKIE["y_member_id"] ?? $_SESSION["y_member_id"];

    $strSQL = "SELECT * FROM tb_w_result_gepot WHERE member_id = ? && result_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $focus_member_id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    if ($num == 1) {
        echo "is have";
        $data = $result->fetch_array();
        $percent = $data['percent'];
        $correct = $data['correct'];
        $wrong = $data['wrong'];
        $correct_listening = $data['correct_listening'];
        $wrong_listening = $data['wrong_listening'];
        $correct_reading = $data['correct_reading'];
        $wrong_reading = $data['wrong_reading'];
        $correct_grammar = $data['correct_grammar'];
        $wrong_grammar = $data['wrong_grammar'];
        $create_date = $data['create_date'];
        // ----------------------------------- //
        $arr_date_time = explode(" ", $create_date);
        $msg_date = get_thai_day($arr_date_time[0]) . " &nbsp; " . get_thai_month($arr_date_time[0]) . " &nbsp; " . get_thai_year($arr_date_time[0]) . " &nbsp; 
                         &nbsp; เวลา " . $arr_date_time[1] . " น. ";
        // ----------------------------------- //
        $SQL = "SELECT * FROM tb_x_member_general WHERE member_id = ?";
        $query = $conn->prepare($SQL);
        $query->bind_param("s", $focus_member_id);
        $query->execute();
        $result = $query->get_result();
        $result_data = $result->fetch_array();
        $fname = $result_data['fname'];
        $lname = $result_data['lname'];
        $query->close();
    }
    $stmt->close();
    mysqli_close($conn);
    $unans = (100 - ($correct + $wrong));
    $unans_lestening = (30 - ($correct_listening + $wrong_listening));
    $unans_reading = (40 - ($correct_reading + $wrong_reading));
    $unans_grammar = (30 - ($correct_grammar + $wrong_grammar));

    echo "
			<table align=center width=90% cellpadding=5 cellspacing=0 border=0 bgcolor='#f7f7f7'>
				<tr height=25>
				<center><img src='https://www.engtest.net/image2/gepot/GEPOT-4.webp' style='width:90%; margin-top:20px;border-radius:10px;'></img><br><br></center>
					<td width=20% align=right><font size=2 face=tahoma color=black><b>ผู้ทำแบบทดสอบ &nbsp; : &nbsp; </b></font></td>
					<td width=70% align=left colspan=3><font size=2 face=tahoma color=black><b>&nbsp; $fname &nbsp; &nbsp; $lname </b></font></td>
				</tr>
				<tr  height=25>
					<td align=right><font size=2 face=tahoma color=black><b>วันที่ทำการทดสอบ &nbsp; : &nbsp; </b></font></td>
					<td align=left ><font size=2 face=tahoma color=black><b>&nbsp; $msg_date </b></font></td>
				</tr>
				<tr  height=25>
					<td align=right><font size=2 face=tahoma color=black><b>
						ประเภทการทดสอบ &nbsp; : &nbsp;</b></font></td>
					<td align=left >
						<font size=2 face=tahoma color=black><b>
							&nbsp; General English Proficiency Online Test
						</b></font>
					</td>
				</tr>
				<tr  height=25>
					<td align=right><font size=2 face=tahoma color=black><b>คะแนนที่ได้ &nbsp; : &nbsp; </b></font></td>
					<td align=left >
						<font size=2 face=tahoma color=black><b>
							&nbsp; ตอบถูก $correct ข้อ &nbsp; &nbsp; ตอบผิด $wrong ข้อ &nbsp; &nbsp; ไม่ได้ตอบ $unans ข้อ &nbsp; &nbsp; คิดเป็น $percent %
						</b></font>
					</td>
				</tr>
            </table><br>";

    $text_msg[0] = "<font color=red>ไม่สามารถประเมินได้</font>";
    $text_msg[1] = "<font color=brown>พอใช้ ( Low )</font>";
    $text_msg[2] = "<font color=green>ปานกลาง ( Intermediate )</font>";
    $text_msg[3] = "<font color=blue>สูง ( High )</font>";

    $each_percent[1] = (($correct_listening + 0) - ($wrong_listening * 0.25)) + 0;
    $each_percent[2] = (($correct_reading + 0) - ($wrong_reading * 0.25)) + 0;
    $each_percent[3] = (($correct_grammar + 0) - ($wrong_grammar * 0.25)) + 0;

    if ($each_percent[1] <= 0) {
        $skill_msg[1] = $text_msg[0];
    }
    if ($each_percent[1] > 0 && $each_percent[1] <= 10.75) {
        $skill_msg[1] = $text_msg[1];
    }
    if ($each_percent[1] > 10.75 && $each_percent[1] <= 20.75) {
        $skill_msg[1] = $text_msg[2];
    }
    if ($each_percent[1] > 20.75) {
        $skill_msg[1] = $text_msg[3];
    }
    //------------------------------------------------------//
    if ($each_percent[2] <= 0) {
        $skill_msg[2] = $text_msg[0];
    }
    if ($each_percent[2] > 0 && $each_percent[2] <= 14.75) {
        $skill_msg[2] = $text_msg[1];
    }
    if ($each_percent[2] > 14.75 && $each_percent[2] <= 29.75) {
        $skill_msg[2] = $text_msg[2];
    }
    if ($each_percent[2] > 29.75) {
        $skill_msg[2] = $text_msg[3];
    }
    //------------------------------------------------------//
    if ($each_percent[3] <= 0) {
        $skill_msg[3] = $text_msg[0];
    }
    if ($each_percent[3] > 0 && $each_percent[3] <= 10.75) {
        $skill_msg[3] = $text_msg[1];
    }
    if ($each_percent[3] > 10.75 && $each_percent[3] <= 20.75) {
        $skill_msg[3] = $text_msg[2];
    }
    if ($each_percent[3] > 20.75) {
        $skill_msg[3] = $text_msg[3];
    }
    //-------------- CEFR -----------------//
    $cefr_msg[0] = "<font color=red>A0</font>";
    $cefr_msg[1] = "<font color=red>A1</font>";
    $cefr_msg[2] = "<font color=brown>A2</font>";
    $cefr_msg[3] = "<font color=green>B1</font>";
    $cefr_msg[4] = "<font color=blue>B2</font>";
    $cefr_msg[5] = "<font color=blue>C1</font>";
    $cefr_msg[6] = "<font color=blue>C2</font>";

    if ($each_percent[1] <= 0) {
        $cefr_skill[1] = $cefr_msg[0];
    }
    if ($each_percent[1] > 0 && $each_percent[1] <= 6.75) {
        $cefr_skill[1] = $cefr_msg[1];
    }
    if ($each_percent[1] > 6.75 && $each_percent[1] <= 12.75) {
        $cefr_skill[1] = $cefr_msg[2];
    }
    if ($each_percent[1] > 12.75 && $each_percent[1] <= 18.75) {
        $cefr_skill[1] = $cefr_msg[3];
    }
    if ($each_percent[1] > 18.75 && $each_percent[1] <= 24.75) {
        $cefr_skill[1] = $cefr_msg[4];
    }
    if ($each_percent[1] > 24.75 && $each_percent[1] <= 29.75) {
        $cefr_skill[1] = $cefr_msg[5];
    }
    if ($each_percent[1] > 29.75) {
        $cefr_skill[1] = $cefr_msg[6];
    }
    //------------------------------------------------------//
    if ($each_percent[2] <= 0) {
        $cefr_skill[2] = $cefr_msg[0];
    }
    if ($each_percent[2] > 0 && $each_percent[2] <= 8.75) {
        $cefr_skill[2] = $cefr_msg[1];
    }
    if ($each_percent[2] > 8.75 && $each_percent[2] <= 16.75) {
        $cefr_skill[2] = $cefr_msg[2];
    }
    if ($each_percent[2] > 16.75 && $each_percent[2] <= 24.75) {
        $cefr_skill[2] = $cefr_msg[3];
    }
    if ($each_percent[2] > 24.75 && $each_percent[2] <= 32.75) {
        $cefr_skill[2] = $cefr_msg[4];
    }
    if ($each_percent[2] > 32.75 && $each_percent[2] <= 39.75) {
        $cefr_skill[2] = $cefr_msg[5];
    }
    if ($each_percent[2] > 39.75) {
        $cefr_skill[2] = $cefr_msg[6];
    }
    //------------------------------------------------------//
    if ($each_percent[3] <= 0) {
        $cefr_skill[3] = $cefr_msg[0];
    }
    if ($each_percent[3] > 0 && $each_percent[3] <= 6.75) {
        $cefr_skill[3] = $cefr_msg[1];
    }
    if ($each_percent[3] > 6.75 && $each_percent[3] <= 12.75) {
        $cefr_skill[3] = $cefr_msg[2];
    }
    if ($each_percent[3] > 12.75 && $each_percent[3] <= 18.75) {
        $cefr_skill[3] = $cefr_msg[3];
    }
    if ($each_percent[3] > 18.75 && $each_percent[3] <= 24.75) {
        $cefr_skill[3] = $cefr_msg[4];
    }
    if ($each_percent[3] > 24.75 && $each_percent[3] <= 29.75) {
        $cefr_skill[3] = $cefr_msg[5];
    }
    if ($each_percent[3] > 29.75) {
        $cefr_skill[3] = $cefr_msg[6];
    }
    //------------------------------------------------------//

    echo "
            <table align=center width=90% cellpadding=5 cellspacing=2 border=0>
                <tr height=25 >
                    <td align=center width=20% bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>ทักษะ ( Skill )</b></font></td>
                    <td align=center width=45% bgcolor='#aaaaaa' colspan=3><font size=2 face=tahoma color='#ffffff'><b>คะแนน ( Score )</b></font></td>
                    <td align=center bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>ระดับความสามารถ ( Level )</b></font></td>
                    <td align=center bgcolor='#aaaaaa'><font size=2 face=tahoma color='#ffffff'><b>CEFR</b></font></td>
                </tr>
                <tr height=25 >
                    <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>การฟัง ( Listening )</b></font></td>
                    <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก " . ($correct_listening + 0) . " ข้อ </font></td>
                    <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด " . ($wrong_listening + 0) . " ข้อ </font></td>
                    <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ " . ($unans_lestening + 0) . " ข้อ </font></td>
                    <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[1]</font></td>
                    <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[1]</font></td>
                </tr>
                <tr height=25>
                    <td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
                        <b>คิดเป็น " . (round($each_percent[1], 2) + 0) . " / " . ($correct_listening + $wrong_listening + $unans_lestening + 0) . " คะแนน </b>
                    </font></td>
                </tr>
                <tr height=25 >
                    <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>การอ่าน ( Reading )</b></font></td>
                    <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก " . ($correct_reading + 0) . " ข้อ </font></td>
                    <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด " . ($wrong_reading + 0) . " ข้อ </font></td>
                    <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ " . ($unans_reading + 0) . " ข้อ </font></td>
                    <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[2]</font></td>
                    <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[2]</font></td>
                </tr>
                <tr height=25>
                    <td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
                        <b>คิดเป็น " . (round($each_percent[2], 2) + 0) . " / " . ($correct_reading + $wrong_reading + $unans_reading + 0) . " คะแนน </b>
                    </font></td>
                </tr>
                <tr height=25 >
                    <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma><b>ไวยากรณ์ ( Grammar )</b></font></td>
                    <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบถูก " . (($correct_grammar) + 0) . " ข้อ </font></td>
                    <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ตอบผิด " . (($wrong_grammar) + 0) . " ข้อ </font></td>
                    <td align=center bgcolor='#e0e0e0'><font size=2 face=tahoma >ไม่ได้ตอบ " . (($unans_grammar) + 0) . " ข้อ </font></td>
                    <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$skill_msg[3]</font></td>
                    <td align=center bgcolor='#e0e0e0' rowspan=2><font size=2 face=tahoma >$cefr_skill[3]</font></td>
                </tr>
                <tr height=25>
                    <td align=center bgcolor='#e0e0e0' colspan=3><font size=2 face=tahoma >
                        <b>คิดเป็น " . (round($each_percent[3], 2) + 0) . " / " . ($correct_grammar + $wrong_grammar + $unans_grammar + 0) . " คะแนน </b>
                    </font></td>
                </tr>
            </table><br>";

    $color_a = "bgcolor='#f0f0f0'";
    $color_b = "bgcolor='#ffe0e0'";
    $color_bottom = "bgcolor='#C4FAFC'";
    $color_top_score = "bgcolor='#E2F9F9'";
    if ($percent <= 0) {
        $color[0] = $color_b;
        $color_m[0] = $color_b;
    }
    else {
        $color[0] = $color_a;
        $color_m[0] = $color_a;
    }
    if ($percent >= 0.25 && $percent <= 7.75) {
        $color[1] = $color_b;
        $color_m[1] = $color_b;
        $color_g[1] = $color_b;
    }
    else {
        $color[1] = $color_a;
        $color_m[1] = $color_a;
        $color_g[1] = $color_a;
    }
    if ($percent > 7.75 && $percent <= 15.75) {
        $color[2] = $color_b;
        $color_m[1] = $color_b;
        $color_g[1] = $color_b;
    }
    else {
        $color[2] = $color_a;
    }
    if ($percent > 15.75 && $percent <= 25.75) {
        $color[3] = $color_b;
        $color_m[2] = $color_b;
        $color_g[2] = $color_b;
    }
    else {
        $color[3] = $color_a;
        $color_m[2] = $color_a;
        $color_g[2] = $color_a;
    }
    if ($percent > 25.75 && $percent <= 35.75) {
        $color[4] = $color_b;
        $color_m[2] = $color_b;
        $color_g[2] = $color_b;
    }
    else {
        $color[4] = $color_a;
    }
    if ($percent > 35.75 && $percent <= 45.75) {
        $color[5] = $color_b;
        $color_m[3] = $color_b;
        $color_g[3] = $color_b;
    }
    else {
        $color[5] = $color_a;
        $color_m[3] = $color_a;
        $color_g[3] = $color_a;
    }
    if ($percent > 45.75 && $percent <= 60.75) {
        $color[6] = $color_b;
        $color_m[3] = $color_b;
        $color_g[3] = $color_b;
    }
    else {
        $color[6] = $color_a;
    }
    if ($percent > 60.75 && $percent <= 70.75) {
        $color[7] = $color_b;
        $color_m[4] = $color_b;
        $color_g[4] = $color_b;
    }
    else {
        $color[7] = $color_a;
        $color_m[4] = $color_a;
        $color_g[4] = $color_a;
    }
    if ($percent > 70.75 && $percent <= 80.75) {
        $color[8] = $color_b;
        $color_m[4] = $color_b;
        $color_g[4] = $color_b;
    }
    else {
        $color[8] = $color_a;
    }
    if ($percent > 80.75 && $percent <= 90.75) {
        $color[9] = $color_b;
        $color_m[5] = $color_b;
        $color_g[5] = $color_b;
    }
    else {
        $color[9] = $color_a;
        $color_m[5] = $color_a;
        $color_g[5] = $color_a;
    }
    if ($percent > 90.75 && $percent <= 99.75) {
        $color[10] = $color_b;
        $color_m[6] = $color_b;
        $color_g[5] = $color_b;
    }
    else {
        $color[10] = $color_a;
        $color_m[6] = $color_a;
    }
    if ($percent > 99.75 && $percent <= 100) {
        $color[11] = $color_b;
        $color_m[7] = $color_b;
    }
    else {
        $color[11] = $color_bottom;
        $color_m[7] = $color_bottom;
    }

    //------------- CEFR ----------- //
    if ($percent <= 0) {
        $color_c[0] = $color_b;
    }
    else {
        $color_c[0] = $color_a;
    }
    if ($percent >= 0.25 && $percent <= 15.75) {
        $color_c[1] = $color_b;
    }
    else {
        $color_c[1] = $color_a;
    }
    if ($percent > 15.75 && $percent <= 35.75) {
        $color_c[2] = $color_b;
    }
    else {
        $color_c[2] = $color_a;
    }
    if ($percent > 35.75 && $percent <= 60.75) {
        $color_c[3] = $color_b;
    }
    else {
        $color_c[3] = $color_a;
    }
    if ($percent > 60.75 && $percent <= 80.75) {
        $color_c[4] = $color_b;
    }
    else {
        $color_c[4] = $color_a;
    }
    if ($percent > 80.75 && $percent <= 99.75) {
        $color_c[5] = $color_b;
    }
    else {
        $color_c[5] = $color_a;
    }
    if ($percent > 99.75 && $percent <= 100) {
        $color_c[6] = $color_b;
    }
    else {
        $color_c[6] = $color_bottom;
    }

    echo "
            <table align=center width=90% cellpadding=5 cellspacing=2 border=0>
                <tr height=25>
                    <td align=center bgcolor='#aaaaaa'>
                        <font size=2 face=tahoma color='#ffffff'><b>GEPOT by EOL</b></font>
                    </td>
                    <td align=center bgcolor='#aaaaaa'>
                        <font size=2 face=tahoma color='#ffffff'><b>TOEIC</b></font>
                    </td>
                    <td align=center bgcolor='#aaaaaa'>
                        <font size=2 face=tahoma color='#ffffff'><b>CU-TEP</b></font>
                    </td>
                    <td align=center bgcolor='#aaaaaa'>
                        <font size=2 face=tahoma color='#ffffff'><b>TOEFL ITP</b></font>
                    </td>
                    <td align=center bgcolor='#aaaaaa'>
                        <font size=2 face=tahoma color='#ffffff'><b>TOEFL IBT</b></font>
                    </td>
                    <td align=center bgcolor='#aaaaaa'>
                        <font size=2 face=tahoma color='#ffffff'><b>IELTS</b></font>
                    </td>
                    <td align=center bgcolor='#aaaaaa'>
                        <font size=2 face=tahoma color='#ffffff'><b>CEFR</b></font>
                    </td>
                </tr>
                <tr height=25>
                    <td align=center rowspan=2 $color_g[1]>
                        <font size=3 face=tahoma><b>1 - 15</b></font>
                    </td>
                    <td align=center rowspan=2 $color_m[1]>
                        <font size=2 face=tahoma>0 - 250</font>
                    </td>
                    <td align=center $color[1]>
                        <font size=2 face=tahoma> - </font>
                    </td>
                    <td align=center $color[1]>
                        <font size=2 face=tahoma> - </font>
                    </td>
                    <td align=center $color[1]>
                        <font size=2 face=tahoma> - </font>
                    </td>
                    <td align=center $color[1]>
                        <font size=2 face=tahoma>0 - 1</font>
                    </td>
                   
                    <td align=center $color_c[1] rowspan=2><font size=2 face=tahoma >A1</font></td>
                </tr>
                <tr height=25>
                    <td align=center  $color[2]>
                        <font size=2 face=tahoma> - </font>
                    </td>
                    <td align=center $color[2]>
                        <font size=2 face=tahoma> - </font>
                    </td>
                    <td align=center $color[2]>
                        <font size=2 face=tahoma> - </font>
                    </td>
                    <td align=center $color[2]>
                        <font size=2 face=tahoma>1 - 1.5</font>
                    </td>
                    
                </tr>
                <tr height=25>
                    <td align=center rowspan=2 $color_g[2]>
                        <font size=3 face=tahoma><b>16 - 35</b></font>
                    </td>
                    <td align=center rowspan=2 $color_m[2]>
                        <font size=2 face=tahoma>255 - 400</font>
                    </td>
                    <td align=center $color[3]>
                        <font size=2 face=tahoma> - </font>
                    </td>
                    <td align=center $color[3]>
                        <font size=2 face=tahoma>347 - 393</font>
                    </td>
                    <td align=center $color[3]>
                        <font size=2 face=tahoma> - </font>
                    </td>
                    <td align=center $color[3]>
                        <font size=2 face=tahoma>2 - 2.5</font>
                    </td>
                    <td align=center $color_c[2] rowspan=2><font size=2 face=tahoma >A2</font></td>
                </tr>
                <tr height=25>
                    <td align=center $color[4]>
                        <font size=2 face=tahoma> - </font>
                    </td>
                    
                    <td align=center $color[4]>
                        <font size=2 face=tahoma>397 - 433</font>
                    </td>
                    <td align=center $color[4]>
                        <font size=2 face=tahoma> - </font>
                    </td>
                    <td align=center $color[4]>
                        <font size=2 face=tahoma>3 - 3.5</font>
                    </td>
                    
                </tr>
                <tr height=25>
                    <td align=center rowspan=2 $color_g[3]>
                        <font size=3 face=tahoma><b>36 - 60</b></font>
                    </td>
                    <td align=center rowspan=2 $color_m[3]>
                        <font size=2 face=tahoma >405 - 600</font>
                    </td>
                    <td align=center  $color[5]>
                        <font size=2 face=tahoma> - </font>
                    </td>
                    <td align=center $color[5]>
                        <font size=2 face=tahoma>437 - 473</font>
                    </td>
                    <td align=center $color[5]>
                        <font size=2 face=tahoma>41 - 52</font>
                    </td>
                    <td align=center $color[5]>
                        <font size=2 face=tahoma>4</font>
                    </td>
                   
                    <td align=center $color_c[3] rowspan=2><font size=2 face=tahoma >B1</font>
                    </td>
                </tr>
                <tr height=25>
                    <td align=center $color[6]>
                        <font size=2 face=tahoma> 60 </font>
                    </td>
                    <td align=center $color[6]>
                        <font size=2 face=tahoma>477 - 510</font>
                    </td>
                    <td align=center $color[6]>
                        <font size=2 face=tahoma>53 - 64</font>
                    </td>
                    <td align=center $color[6]>
                        <font size=2 face=tahoma>4.5 - 5</font>
                    </td>
                </tr>
                <tr height=25>
                    <td align=center rowspan=2 $color_g[4]>
                        <font size=3 face=tahoma><b>61 - 80</b></font>
                    </td>
                    <td align=center rowspan=2 $color_m[4]>
                        <font size=2 face=tahoma >605 - 780</font>
                    </td>
                    <td align=center $color[7]>
                        <font size=2 face=tahoma> 75 </font>
                    </td>
                    <td align=center $color[7]>
                        <font size=2 face=tahoma>513 - 547</font>
                    </td>
                    <td align=center $color[7]>
                        <font size=2 face=tahoma>65 - 78</font>
                    </td>
                    <td align=center $color[7]>
                        <font size=2 face=tahoma>5.5 - 6</font>
                    </td>
                    
                    <td align=center $color_c[4] rowspan=2><font size=2 face=tahoma >B2</font></td>
                </tr>
                <tr height=25>

                    <td align=center   $color[8]> 
                        <font size=2 face=tahoma> 90 </font>
                    </td>
                    <td align=center $color[8]>
                        <font size=2 face=tahoma>550 - 587</font>
                    </td>
                    <td align=center  $color[8]>
                        <font size=2 face=tahoma>79 - 95</font>
                    </td>
                    <td align=center $color[8]>
                        <font size=2 face=tahoma> 6.5 - 7 </font>
                    </td>
                
                </tr>
                <tr height=25>
                    <td align=center rowspan=2 $color_g[5]>
                        <font size=3 face=tahoma><b>81 - 99</b></font>
                    </td>
                    <td align=center $color_m[5]>
                        <font size=2 face=tahoma >785 - 900</font>
                    </td>
                    <td align=center $color[9]>
                        <font size=2 face=tahoma> 100 </font>
                    </td>
                    <td align=center $color[9]>
                        <font size=2 face=tahoma>590 - 637</font>
                    </td>
                    <td align=center $color[9]>
                        <font size=2 face=tahoma>96 - 110</font>
                    </td>
                    <td align=center $color[9]>
                        <font size=2 face=tahoma>7.5 - 8</font>
                    </td>
                    <td align=center $color_c[5] rowspan=2><font size=2 face=tahoma >C1</font></td>
                </tr>
                <tr height=25>
                    <td align=center $color_m[6]>
                        <font size=2 face=tahoma>905 - 989</font>
                    </td>
                    <td align=center $color[10]>
                        <font size=2 face=tahoma>119</font>
                    </td>
                    <td align=center $color[10]>
                        <font size=2 face=tahoma>640 - 676</font>
                    </td>
                    <td align=center $color[10]>
                        <font size=2 face=tahoma>111 - 119</font>
                    </td>
                    <td align=center $color[10]>
                        <font size=2 face=tahoma>8.5</font>
                    </td>
                </tr>
                <tr>
                    <td align=center colspan=7 $color_top_score>
                        <font size=3 face=tahoma><b> TOP SCORE </b></font>
                    </td>
                </tr>
                <tr>
                    <td align=center $color[11]>
                        <font size=3 face=tahoma><b>100</b></font>
                    </td>
                    <td align=center $color_m[7]>
                        <font size=2 face=tahoma>990</font>
                    </td>
                    <td align=center $color[11]>
                        <font size=2 face=tahoma>120</font>
                    </td>
                    <td align=center $color[11]>
                        <font size=2 face=tahoma>677</font>
                    </td>
                    <td align=center $color[11]>
                        <font size=2 face=tahoma>120</font>
                    </td>
                    <td align=center $color[11]>
                        <font size=2 face=tahoma>9</font>
                    </td>
                    <td align=center $color_c[6]><font size=2 face=tahoma >C2</font></td>
                </tr>
            </table><br><br>&nbsp;
            <center>
                <form>
                    <input type=\"button\" class='yui3-button' value=\"Print this result\" onClick=\"window.open('http://localhost/engtest/EOL/gen_report_gepot.php?result_id=$id','_blank')\"> 
                    <input type=\"button\" class='yui3-button' value=\"Certification TH\" onClick=\"window.open('http://localhost/engtest/EOL/get_certificate_gepot_th.php?result_id=$id','_blank')\">
                    <input type=\"button\" class='yui3-button' value=\"Certification EN\" onClick=\"window.open('http://localhost/engtest/EOL/get_certificate_gepot_eng.php?result_id=$id','_blank')\">
                </form>
            </center><br>";

    if (isset($_COOKIE['arr'])) {
        foreach ($_COOKIE['arr'] as $name => $value) {
            $names = 'arr[' . $name . ']';
            setcookie($names, '', time() - 3600, '/');
        }
    }

    for ($i = 0; $i < 30; $i++) {
        if (isset($_COOKIE['sound_' . $i])) {
            $name = 'sound_' . $i;
            setcookie($name, '', time() - 3600, '/');
        }
    }


}

function display_footer()
{
    echo "
            </div>
        </div>
        <!-----------end main cotent------------>
    </div>
    <!------------------- end container -------------->";
?>
        <script language='javascript'>
        function checkfield(id, name) {
            if (id) {
                var arr = [];
                if (arr == 0) {
                    arr.push(id, name);
                }
                if (arr >= 1) {
                    index = arr.indexOf(id);
                    if (index) {
                        arr.splice(index, index, name);
                    } else {
                        arr.push(id, name);
                    }
                }
                set_cookie('arr[' + id + ']', name, 1);
            }
        }

        function set_cookie(cookiename, cookievalue, hours) {
            var date = new Date();
            // date.setTime(date.getTime() * hours);
            // set time 150 minute => 9000000 (3000X3000), 200 minute => 12000000 (4000X3000)
            date.setTime(date.getTime() + Number(hours) * 4000 * 3000);
            document.cookie = cookiename + "=" + cookievalue + "; path=/;expires = " + date.toGMTString();

        }

        function get_cookies_array() {

            var cookies = {};

            if (document.cookie && document.cookie != '') {
                var split = document.cookie.split(';');
                for (var i = 0; i < split.length; i++) {
                    var name_value = split[i].split("=");
                    name_value[0] = name_value[0].replace(/^ /, '');
                    cookies[decodeURIComponent(name_value[0])] = decodeURIComponent(name_value[1]);
                }
            }
            return cookies;
        }
        var cookies = get_cookies_array();
        for (var name in cookies) {
            var Id = cookies[name];
            var setattr = document.getElementById(Id);
            if (setattr) {
                setattr.setAttribute('checked', 'checked');
            }
        }

        function hide(id, id2, end, no) {
            document.getElementById(id).style.display = 'none';
            document.getElementById(id2).style.display = 'none';
            document.getElementById(end).style.display = '';
            document.getElementById(end).innerHTML =
                "<span style='color: red;'>คุณได้ฟังเสียงนี้ไปแล้ว &#x2713;</span>";


            set_cookie('sound_' + no, no, 1);
        }

        function begintimer() {

            if (!document.images)
                return
            if (parselimit == 1) {
                document.getElementById('quiz_form').submit();
            } else {
                parselimit -= 1
                curmin = Math.floor(parselimit / 60)
                cursec = parselimit % 60
                if (curmin != 0) {
                    curtime = "<b><font face=tahoma size=3>เวลาที่เหลือ : <font color=red> " + curmin +
                        " </font>นาที กับ <font color=red>" + cursec + " </font>วินาที </font></b>"
                    document.config.time_min.value = curmin
                    document.config.time_sec.value = cursec

                } else {
                    curtime = "<b><font face=tahoma size=3>เวลาที่เหลือ <font color=red>" + cursec +
                        " </font>วินาที </font></b>"
                    document.config.time_min.value = curmin
                    document.config.time_sec.value = cursec
                }
                document.getElementById('dplay').innerHTML = curtime;
                setTimeout("begintimer()", 1000)
            }
        }

        function end_play(id, end, no) {
            document.getElementById(id).style.display = 'none';
            document.getElementById(end).style.display = '';
            document.getElementById(end).innerHTML =
                "<span style='color: red;'>คุณได้ฟังเสียงนี้ไปแล้ว &#x2713;</span>";

            set_cookie('sound_' + no, no, 1);
        }
        </script>
    </body>
    <!------------------- end body -------------->

</html>
<!------------------- end html -------------->
<?php
}
function set_time()
{
    echo "
			<form name=config>
				<input type=hidden  value=6000 name='fn_time'  readonly>
				<input type=hidden  name='time_min'  readonly>
				<input type=hidden  name='time_sec'  readonly>
			</form>";
}

function display_time_left()
{
    echo "	<br><br>
			<table id=tbl_time_left align=center width=280 cellpadding=0 cellspacing=0 border=0>
				<tr height=30>
                    <td bgcolor=eeeeee style='border-radius: 5px;'>
						<div id='dplay' align=center></div>
					</td>
                </tr>
			</table>";
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