<?php
ob_start();
session_start();
include('../config/connection.php');
// global $conn;
date_default_timezone_set('Asia/Bangkok');
if ($_SESSION['x_member_1year'] != '') {
    $strSQL = "SELECT * FROM tb_x_member_1year WHERE id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_1year']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have) {
        $data = $result->fetch_array();
    }


    $SQL = "SELECT logid FROM  tb_x_log_member_1year WHERE id = ? ORDER BY logdate DESC LIMIT 0,1";
    $query = $conn->prepare($SQL);
    $query->bind_param("s", $_SESSION['x_member_1year']);
    $query->execute();
    $result = $query->get_result();
    $is_have = $result->num_rows;
    if ($is_have == 1) {
        $logtime = $result->fetch_array();
        $now = date("Y-m-d H:i:s");
        $str = "UPDATE tb_x_log_member_1year SET outdate = ? WHERE logid = ? ";
        $sub_query = $conn->prepare($str);
        $sub_query->bind_param("ss", $now, $logtime['logid']);
        $sub_query->execute();
        $sub_query->close();
    }
    $query->close();
    mysqli_close($conn);
}
else {
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>หลักสูตรเรียนภาษาอังกฤษออนไลน์ 1 ปี</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://www.engtest.net/image2/1 year icon.ico">

    <!-- Bootstrap CSS -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <style type="text/css">
    img.bg {
        /* Set rules to fill background */
        min-height: 100%;
        min-width: 1024px;

        /* Set up proportionate scaling */
        width: 100%;
        height: auto;

        /* Set up positioning */
        position: fixed;
        top: 0;
        left: 0;
    }

    /* html {
        background: url(https://www.engtest.net/image2/1 year/lessons(bg)-01.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='https://www.engtest.net/image2/1 year/lessons(bg)-01.jpg', sizingMethod='scale');
        -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='https://www.engtest.net/image2/1 year/lessons(bg)-01.jpg', sizingMethod='scale')";
    } */

    body {
        background-color: #9EF0DE;
        margin: 0 auto;
        padding: 0;
        width: 88%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    @media screen and (max-width: 1024px) {

        /* Specific to this particular image */
        img.bg {
            /* left: 50%; */
            /* margin-left: -512px; */
            /* 50% */
            width: auto;
            /* height: auto; */
        }

    }

    a:link {
        color: #000;
        text-decoration: none;
    }

    a:visited {
        color: #9999CC;
        text-decoration: none;
    }

    a:hover {
        color: #000;
        text-decoration: none;
    }

    a:active {
        text-decoration: none;
    }

    .head {
        background-color: #8e8a8a;
        height: 60px;
        width: auto;
        margin-left: -140px;
        margin-right: -250px;
    }

    /*---------------------div faq --------------------*/
    .divfaq {
        margin-top: 10px;
        height: 200px;
        width: 700px;
    }

    .divfaq textarea.tx {
        width: 700px;
        height: 80px;
        border: 1px solid rgb(255, 124, 17);
        border-radius: 3px;
    }

    .divfaq textarea.tx:focus {
        outline: 0;
        border: 1px solid rgb(255, 124, 17);
        -moz-box-shadow: 0px 0px 5px rgb(251, 229, 64);
        -webkit-box-shadow: 0px 0px 5px rgb(251, 229, 64);
        box-shadow: 0px 0px 5px rgb(251, 229, 64);
    }

    .divfaq input.btn {
        float: right;
        margin-left: 20px;
        font-size: 14px;
        height: 27px;
        width: 70px;
        color: #666;
        border: 1px solid #999;
        font-weight: bold;
        cursor: pointer;
        border-radius: 3px;
    }

    .divfaq input.btn:hover {
        color: #333;
        border: 1px solid #333;
    }

    .page {
        text-align: right;
        margin-right: 100px;
        margin-top: 25px;
        font-size: 18px;
    }

    .delete {
        text-align: right;
        margin-right: 100px;
    }

    .delete a {
        color: red;
        text-decoration: none;
    }

    .delete a:link {
        color: red;
        text-decoration: none;
    }

    /*---------------------div show --------------------------*/
    .divshowfaq {
        font-family: Arial, Helvetica, sans-serif;
        min-height: 150px;
        height: auto;
        width: 700px;
    }

    .listfaq {
        border-radius: 8px;
        margin-top: 20px;
        padding: 10px;
        height: auto;
        width: 700px;
        background-image: linear-gradient(bottom, rgb(255, 124, 17) 6%, rgb(251, 229, 64) 79%);
        background-image: -o-linear-gradient(bottom, rgb(255, 124, 17) 6%, rgb(251, 229, 64) 79%);
        background-image: -moz-linear-gradient(bottom, rgb(255, 124, 17) 6%, rgb(251, 229, 64) 79%);
        background-image: -webkit-linear-gradient(bottom, rgb(255, 124, 17) 6%, rgb(251, 229, 64) 79%);
        background-image: -ms-linear-gradient(bottom, rgb(255, 124, 17) 6%, rgb(251, 229, 64) 79%);

        background-image: -webkit-gradient(linear,
                left bottom,
                left top,
                color-stop(0.06, rgb(255, 124, 17)),
                color-stop(0.79, rgb(251, 229, 64)));
    }

    .txtcontent,
    .txtcontentsub {
        padding: 5px;
        margin-top: 10px;
        border-radius: 8px;
        color: #000000;
        width: 690px;
        height: auto;
        background-color: #ccc;
    }

    .clear {
        clear: both;
    }

    .txtcontentsub {
        width: 670px;
        background-color: #fff;
    }

    .txtcontent p,
    .txtcontentsub p {
        color: #000000;
        padding-left: 2px;
    }
    </style>
</head>

<body>
    <img src="https://www.engtest.net/image2/1 year/lessons(bg)-01.jpg" class="bg">
    <a href="../1yearcourse.php" title="Home">
        <img src="https://www.engtest.net/image2/1 year/button/home-08.png" width="45" height="43"
            style="position:absolute;z-index:250;left:50%;margin-left:350px;top:8px;">
    </a>

    <div style="position:relative;">
        <div class="head">
            <center>
                <img src="https://www.engtest.net/image2/1 year/status-02.png"
                    style="position:absolute;z-index:200;left:50%;margin-left:-680px; border-bottom-left-radius: 35%; border-bottom-right-radius: 35%;">
            </center>
        </div>

        <br>

        <a href="http://localhost/engtest/inc/logout.php" title="logout">
            <img src="https://www.engtest.net/image2/1 year/button/log-out.png" width="45" height="42"
                style="position:absolute;z-index:250;left:50%;margin-left:420px;top:9px;"></a>
        <div style="position:absolute;z-index:200;left:50%;margin-left:-470px; top:15px;font-weight:bold;">
            Welcome :
            <?php
if ($data['fname'] == "") {
    echo $data['user'];
}
else {
    echo $data['fname'];
}
?>
        </div>
        <div style="position:relative; width: 1050px;margin: 0px auto; top: 60px;">
            <img src="<?php
if ($_GET['section'] == 'logtime') {
    echo 'https://www.engtest.net/image2/1 year/font(record)-14.png';
}
else if ($_GET['section'] == 'faq') {
    echo 'https://www.engtest.net/image2/1 year/font(Q&A)-15.png';
}
else {
    echo 'https://www.engtest.net/image2/1 year/font(lessons)-12.png';
}
?>" style="float:left;margin-left:30%;margin-top:50px;">
            <div style="position:absolute;float:left;margin-left:50px;margin-top:89px;z-index:200;">
                <a href="1yearlist.php" style="width:200px;height:100px;">
                    <img src="https://www.engtest.net/image2/1 year/button/back-13.png">
                </a>
            </div>
            <img src="https://www.engtest.net/image2/1 year/logo 1 year-09.png" style="float:right;">
        </div>
    </div>
    <div style="position:relative; width: 1050px; margin: 0px auto;">
        <!-- <form name="form1" action="my-pass-forgot.send.php" method="post"> -->
        <div class="pjblock" align="center">
            <!-- <br /> -->
            <table style="font-size:10pt;">
                <tr>
                    <td>
                        <br><br>
                        <table width=90% align=center style='z-index:500;'>
                            <tr>
                                <td style='padding:10px;'>
                                    <div align=left style='background:#fff;padding:10px;width:1020px;min-height:300px;height:auto;-moz-box-shadow: 0px 5px 18px #333;margin-top:77px;
                               -webkit-box-shadow:  0px 5px 18px #333;
                               box-shadow:0px 5px 18px #333; border-radius: 8px;'>
                                        <table width=80% align=center style='z-index:500;'>
                                            <tr>
                                                <td>
                                                    <?php
if ($_GET['section'] == 'logtime') {
    timeLog();
}
elseif ($_GET['section'] == 'faq') {
    faq_ans();
}
else {
    main_lesson();
}
?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <br><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <!-- </form> -->
    </div>


    <!-- jQuery -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <!-- Bootstrap JavaScript -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

    <script src='http://localhost/engtest/bootstrap/js/jquery.min.js'>
    </script>
    <!-- <script src='https://www.engtest.net/js/jquery.autosize-min.js'>
    </script> -->
    <script type="text/javascript">
    function MM_preloadImages() { //v3.0
        var d = document;
        if (d.images) {
            if (!d.MM_p) d.MM_p = new Array();
            var i, j = d.MM_p.length,
                a = MM_preloadImages.arguments;
            for (i = 0; i < a.length; i++)
                if (a[i].indexOf("#") != 0) {
                    d.MM_p[j] = new Image;
                    d.MM_p[j++].src = a[i];
                }
        }
    }

    // window.onload = function() {
    //     $('.tx').autosize();
    //     $('.tx').autosize({
    //         append: "\n"
    //     });
    // }

    window.onload = function() {
        MM_preloadImages();
    }

    function addfaq() {
        if ($('#txtfaq').val() != '') {
            $.ajax({
                type: "POST",
                url: "managefaq.php",
                data: {
                    faqtopic: $('#txtfaq').val()
                },
                beforeSend: function() {
                    $("#imag_load").show();
                },
                complete: function() {
                    $("#imag_load").hide();
                },
                success: function(response) {

                    if (response != 'NO') {
                        $(".divshowfaq").prepend(
                            response);
                        $("#diverror").hide();
                    } else {
                        $("#diverror").show();
                    }
                    $("#imag_load").hide();
                    $("#txtfaq").val('');
                },
                error: function(error) {
                    //$("#showpost").append('<p align="center">ข้อมูลผิดพลาด</p>');
                }
            });
        }
    }

    function ans(id) {
        if ($('#txtfaq').val() != '') {
            $.ajax({
                type: "POST",
                url: "managefaq.php",
                data: {
                    detail: $('#txtfaq').val(),
                    faqid: id
                },
                beforeSend: function() {
                    $("#imag_load").show();
                },
                complete: function() {
                    $("#imag_load").hide();
                },
                success: function(response) {

                    if (response != 'NO') {
                        $(".listfaq").append(response);
                        $("#diverror").hide();
                    } else {
                        $("#diverror").show();
                    }
                    $("#imag_load").hide();
                    $("#txtfaq").val('');
                },
                error: function(error) {
                    //$("#showpost").append('<p align="center">ข้อมูลผิดพลาด</p>');
                }
            });
        }
    }
    </script>
</body>

</html>

<?php
function timeLog()
{
    include('../config/connection.php');
    $strSQL = "SELECT * FROM tb_x_log_member_1year WHERE id = ? ORDER BY logdate DESC";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_1year']);
    $stmt->execute();
    $result = $stmt->get_result();
    $re_num = $result->num_rows;
    if ($re_num >= 1) {
        echo "	<br>	
				<table id='table_" . $_SESSION['x_member_1year'] . "' align=center width=100% cellpadding=5 cellspacing=1 border=0 >
					<tr>
						<td width=35% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>Last login</b></font></td>
						<td width=20% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>From</b></font></td>
						<td width=20% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>Untill</b></font></td>
						<td width=20% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>Total time</b></font></td>
					</tr>";

        for ($k = 1; $k <= $re_num; $k++) {
            $data = $result->fetch_array();
            $splittime1 = explode(" ", $data['logdate']);
            $splittime2 = explode(" ", $data['outdate']);
            $timediff[$k] = diff2time($splittime1[1], $splittime2[1]);
            $lastime = $data["logdate"];
            $hour = floor($timediff[$k] / 60);
            if ($hour > 0) {
                $htxt = $hour . " ชั่วโมง ";
            }
            else {
                $htxt = "";
            }

            $total = "<font color=green title='$lastime'> $htxt " . floor($timediff[$k] % 60) . ' นาที </font>';
            //------------------------------------------------------------------------------------------//

            echo "
                    <tr>
                        <td bgcolor='#f0f0f0' align=left>
                            <font size=2 face=tahoma color='blue'>&nbsp;&nbsp;" . process_date(strtotime($data['logdate'])) . "</font>
                        </td>
                        <td bgcolor='#f0f0f0' align=center>
                            <font size=2 face=tahoma color='brown'>$data[logdate]</font>
                        </td>
                        <td bgcolor='#f0f0f0' align=center>
                            <font size=2 face=tahoma color='green'>$data[outdate]</font>
                        </td>
                        <td bgcolor='#f0f0f0' align=center>
                            <font size=2 face=tahoma color='red'>$total</font>
                        </td>
                    </tr>";

        }
        $hour = floor(array_sum($timediff) / 60);
        if ($hour > 0) {
            $htxt = $hour . " ชั่วโมง ";
        }
        $sum = "<font color=red > $htxt " . floor(array_sum($timediff) % 60) . ' นาที </font>';
        echo "  <tr>
					<td bgcolor='#f0f0f0' align=center >
                        <font size=2 face=tahoma color='brown'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                    </td>
					<td bgcolor='#f0f0f0' align=center >
                        <font size=2 face=tahoma color='brown'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                    </td>
				    <td bgcolor='#f0f0f0' align=center>
                        <font size=2 face=tahoma color='red'><b>รวมเวลา</b></font>
                    </td>				
				    <td bgcolor='#f0f0f0' align=center>
                        <font size=2 face=tahoma color='red'>$sum</font>
                    </td>	
				</tr>
			</table>";

    }
    else {
        echo "<center><h3 style='color:red;'> - No data -</h3></center>";
    }
    $stmt->close();
    mysqli_close($conn);
}

function faq_ans()
{
    if ($_GET['section'] == 'faq' && $_GET['faqId'] && ($_SESSION['x_member_1year'] == 1)) {
        //echo 'Admin page ans';
        detailFaq();
        formAns();
    }
    else if ($_GET['section'] == 'faq' && $_GET['faqId']) {
        //echo 'member page ans';
        detailFaq();
        formAns();
    }
    else if ($_GET['section'] == 'faq') {
        //echo 'member page ';
        main_faq();
    }
    else {
        echo 'No page';
    }
}

function main_lesson()
{
    include('../config/connection.php');
    $topic_id = $conn->real_escape_string($_GET["topic_id"]);
    $strSQL = "SELECT * FROM tb_web_topic WHERE topic_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $topic_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have) {
        $data = $result->fetch_array();
        $detail = stripslashes($data['topic_detail']);
        echo $detail;
    }
    $stmt->close();
    mysqli_close($conn);
}
function diff2time($time_a, $time_b)
{
    $now_time1 = strtotime(date("Y-m-d " . $time_a));
    $now_time2 = strtotime(date("Y-m-d " . $time_b));
    $time_diff = abs($now_time2 - $now_time1);
    // $time_diff_h=floor($time_diff/3600); // จำนวนชั่วโมงที่ต่างกัน  
    // $time_diff_m=floor(($time_diff%3600)/60); // จำวนวนนาทีที่ต่างกัน  
    $time_diff_m = floor($time_diff / 60);
    // $time_diff_s=($time_diff%3600)%60; // จำนวนวินาทีที่ต่างกัน  
    return $time_diff_m;

}

function process_date($timestamp)
{
    $diff = time() - $timestamp;
    $periods = array("วินาที", "นาที", "ชั่วโมง");
    $word = "ที่แล้ว";
    if ($diff < 60) { // second
        $i = 0;
        $diff = ($diff == 1) ? "" : $diff;
        $text = "$diff $periods[$i]$word";
    }
    else if ($diff < 3600) { // minutes
        $i = 1;
        $diff = round($diff / 60);
        $diff = ($diff == 3 || $diff == 4) ? "" : $diff;
        $text = "$diff $periods[$i]$word";
    }
    else if ($diff < 86400) { // hours
        $i = 2;
        $diff = round($diff / 3600);
        $diff = ($diff != 1) ? $diff : "" . $diff;
        $text = "$diff $periods[$i]$word";
    }
    else if ($diff < 172800) { // days
        $diff = round($diff / 86400);
        $text = "$diff  วันที่แล้ว เมื่อเวลา " . date("G:i", $timestamp) . " น.";
    }
    else {
        $thMonth = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $date = date("j", $timestamp);
        $month = $thMonth[date("m", $timestamp) - 1];
        $y = date("Y", $timestamp) + 543;
        $t1 = "$date $month $y";
        $t2 = "$date $month";
        if ($timestamp > strtotime(date("Y-01-01 00:00:00"))) {
            $text = " เมื่อวันที่ " . $t2 . " เวลา " . date("G:i ", $timestamp) . " น.";
        }
        else {
            $text = " เมื่อวันที่ " . $t1 . " เวลา " . date("G:i ", $timestamp) . " น.";
        }
    }
    return $text;
}

function detailFaq()
{
    include('../config/connection.php');
    $faqId = $conn->real_escape_string($_GET["faqId"]);
    $strSQL = "UPDATE tb_x_faq1year SET view = view+1 WHERE faqId = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $faqId);
    $stmt->execute();
    $stmt->close();

    $SQL = "SELECT m.user, m.fname, f.faqId, f.topic, f.date, f.view FROM tb_x_faq1year f, tb_x_member_1year m WHERE m.id = f.userId && f.faqId = ?";
    $query = $conn->prepare($SQL);
    $query->bind_param("s", $faqId);
    $query->execute();
    $result = $query->get_result();
    $data = $result->fetch_array();
    $name_ques = $data['fname'] ?? $data['user'];

    $str = "SELECT * FROM tb_x_member_1year  WHERE id = ?";
    $sub_stmt = $conn->prepare($str);
    $sub_stmt->bind_param("s", $_SESSION['x_member_1year']);
    $sub_stmt->execute();
    $result = $sub_stmt->get_result();
    $data_admin = $result->fetch_array();
    $admin = $data_admin['admin'];
    $sub_stmt->close();


    echo "  <div class='divshowfaq'>
			    <div class='listfaq' id='$data[faqId]'>
			        <p><b>$name_ques</b></p>
					<div class='txtcontent'>
			            <p>$data[topic]</p>
						<p align=right>" . process_date(strtotime($data['date'])) . "</p>
					</div>";

    $strSQL = "SELECT m.user, m.fname, f.faqId, f.detail, f.date, f.ansId FROM tb_x_faq_ans1year f, tb_x_member_1year m WHERE m.id = f.userId && f.faqId = ? ORDER BY f.ansId ASC";
    $sub_query = $conn->prepare($strSQL);
    $sub_query->bind_param("s", $data['faqId']);
    $sub_query->execute();
    $result = $sub_query->get_result();

    if ($admin == 1) {
        while ($data = $result->fetch_array()) {
            $name_ans = $data['fname'] ?? $data['user'];
            echo "
					<div class='txtcontentsub' style='margin-left:20px;'>
					    <p><b>Answer :</b></p>
			            <p>$data[detail]</p>
						    <font style='float:left;'>By : $name_ans</font><font style='float:right;'>" . process_date(strtotime($data['date'])) . " </font>
						    <br>
						<div class='delete'>  
						    <a href='#' onclick=\"javascript:
							    if(confirm('Do you want to delete this answer ?'))
							    {	window.location='1yearcontent.php?section=faq&faqId=$_GET[faqId]&delfaq=$data[ansId]&action=delfaq';	}
						    \">ลบ </a>
						</div>
						<div class='clear'></div>
					</div>";
        }
        if ($_GET['action'] == "delfaq") {
            include('../config/connection.php');
            $strSQL = "DELETE FROM tb_x_faq_ans1year WHERE ansId = ? && faqId = ? ";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ss", $_GET['delfaq'], $_GET['faqId']);
            $stmt->execute();
            $stmt->close();
            header("Location:?section=$_GET[section]&faqId=$_GET[faqId]");
        }
        if ($_GET['action'] == "delete_faq") {
            // $sql = config();
            // $connect = connect($sql);
            // $table = $sql[tb_x_faq1year];
            // $where = " where faqId = $_GET[faqId]";

            // $query = select($table, $where);
            // $is_sub = mysql_num_rows($query);

            $strSQL = "SELECT * FROM tb_x_faq1year WHERE faqId = ? ";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $_GET['faqId']);
            $stmt->execute();
            $result1 = $stmt->get_result();
            $is_faq = $result1->num_rows;
            $stmt->close();

            // $query2 = select("tbl_x_faq_ans1year", $where);
            // $is_sub2 = mysql_num_rows($query2);

            $SQL = "SELECT * FROM tb_x_faq_ans1year WHERE faqId = ? ";
            $query = $conn->prepare($SQL);
            $query->bind_param("s", $_GET['faqId']);
            $query->execute();
            $result2 = $query->get_result();
            $is_faq_ans = $result2->num_rows;
            $query->close();

            if ($is_faq_ans >= 1) {
                // delete("tbl_x_faq_ans1year", $where);
                $SQL = "DELETE FROM tb_x_faq_ans1year WHERE faqId = ? ";
                $query = $conn->prepare($SQL);
                $query->bind_param("s", $_GET['faqId']);
                $query->execute();
                $query->close();
            }

            if ($is_faq == 1) {
                // delete($table, $where);
                $strSQL = "DELETE FROM tb_x_faq1year WHERE faqId = ? ";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("s", $_GET['faqId']);
                $stmt->execute();
                $stmt->close();
            }
            header("Location:?section=$_GET[section]&page=1");
        }
    }
    while ($data = $result->fetch_array()) {
        $name_ans = $data['fname'] ?? $data['user'];
        echo "
				<div class='txtcontentsub' style='margin-left:20px;'>
					<p><b>Answer :</b></p>
			        <p>$data[detail]</p>
					<font style='float:left;'>By : $name_ans </font><font style='float:right;'>" . process_date(strtotime($data['date'])) . " </font>
					<div class='clear'></div>
				</div>";
    }
    echo "
		    </div>
		</div>";
    $sub_query->close();
    mysqli_close($conn);
}

function formAns()
{
    echo "  <div class='divfaq' style='margin-top:50px;'>
                <form  id='faq_form' name='faq_form' >
                ตอบกลับ : 
                <br>
                <br>
                <textarea id='txtfaq' name='txtfaq' class='tx'  maxlength='1000'></textarea><br><br>
                        <input type='button' id='btnfaq' class='btn' value='Post' onclick='ans($_GET[faqId])'>
                        <input type ='reset'  class='btn' value='Cancel'/>
                </form>
			    <br>
			    <img id='imag_load' src='https://www.engtest.net/image2/eol system/loading2.gif' style='display:none; margin-left:100px;' ><br>
		    </div>";

}

function main_faq()
{
    include('../config/connection.php');
    echo "  <div class='divfaq'>
                <form  id='faq_form' name='faq_form' >
                    หัวข้อ : 
                    <br>
                    <br>
                    <textarea id='txtfaq' class='tx'  maxlength='1000'></textarea>
                    <br><br>
                    <input type='button' id='btnfaq' class='btn' value='Post' onclick='addfaq()'>
                    <input type ='reset'  class='btn' value='Cancel'/>
                </form>
			    <br>
			    <img id='imag_load' src='https://www.engtest.net/image2/eol system/loading2.gif' style='display:none; margin-left:100px;' ><br>
			    <label id='diverror' style='display:none; margin-left:100px;'>มีความผิดพลาดในการเพิ่มข้อมูล</label>
			</div>
			<div class='divshowfaq'>";

    $strSQL = "SELECT * FROM tb_x_member_1year  WHERE id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_1year']);
    $stmt->execute();
    $result = $stmt->get_result();
    $data_admin = $result->fetch_array();
    $admin = $data_admin['admin'];
    $stmt->close();

    $start = ($_GET['page'] - 1) * 10;
    $end = $start + 10;

    if ($admin == 1) {

        $SQL = "SELECT m.user, m.fname, f.faqId, f.topic, f.date, f.view
        FROM  tb_x_faq1year f, tb_x_member_1year m
        WHERE m.id = f.userId ORDER BY f.faqId DESC
        limit $start , $end";
        $stmt = $conn->prepare($SQL);
        $stmt->execute();
        $result1 = $stmt->get_result();

        $str = "SELECT m.fname, f.faqId, f.topic, f.date, f.view
        FROM  tb_x_faq1year f, tb_x_member_1year m
        WHERE m.id = f.userId ORDER BY f.faqId DESC";
        $query = $conn->prepare($str);
        $query->execute();
        $result2 = $query->get_result();
    }
    else {
        $SQL = "SELECT m.user, m.fname, f.faqId, f.topic, f.date, f.view
        FROM  tb_x_faq1year f, tb_x_member_1year m
        WHERE f.userId = ? && m.id = f.userId ORDER BY f.faqId DESC
        limit $start , $end";
        $stmt = $conn->prepare($SQL);
        $stmt->bind_param("s", $_SESSION['x_member_1year']);
        $stmt->execute();
        $result1 = $stmt->get_result();

        $str = "SELECT m.fname, f.faqId, f.topic, f.date, f.view
        FROM  tb_x_faq1year f, tb_x_member_1year m
        WHERE f.userId = ? && m.id = f.userId ORDER BY f.faqId DESC";
        $query = $conn->prepare($str);
        $query->bind_param("s", $_SESSION['x_member_1year']);
        $query->execute();
        $result2 = $query->get_result();
    }
    $max_results = 10;
    $total_results = $result2->num_rows;
    $total_pages = ceil($total_results / $max_results);
    $query->close();
    if ($admin == 1) {
        while ($data = $result1->fetch_array()) {
            $name_ques = $data['fname'] ?? $data['user'];
            echo "  <div class='listfaq' id='$data[faqId]'>
			            <p><b>$name_ques</b></p>
					    <div class='txtcontent'>
					        <p><b>Question : </b></p>
			                <a href='1yearcontent.php?section=faq&faqId=$data[faqId]'><p>$data[topic]</p></a>
						    <p align=right>" . process_date(strtotime($data['date'])) . "   </p>
						    <div class='delete'>
						        <a href='#'
							        onclick=\"javascript:
							        if(confirm('Do you want to delete this Q&A ?'))
							        {	window.location='1yearcontent.php?section=faq&page=1&action=delete_faq&faqId=$data[faqId]';	}
						        \">ลบ</a>
                            </div>
					    </div>";

            $strSQL = "SELECT m.user, m.fname, f.faqId, f.detail, f.date
            FROM tb_x_faq_ans1year f, tb_x_member_1year m
            WHERE m.id = f.userId && f.faqId = ? ORDER BY f.ansId ASC";
            $sub_stmt = $conn->prepare($strSQL);
            $sub_stmt->bind_param("s", $data['faqId']);
            $sub_stmt->execute();
            $result = $sub_stmt->get_result();

            while ($data_sub = $result->fetch_array()) {
                $name_ans = $data_sub['fname'] ?? $data_sub['user'];
                echo "
					    <div class='txtcontentsub' style='margin-left:20px;'>
					        <p><b>Answer :</b></p>
			                <p>$data_sub[detail]</p>
						    <font style='float:left;'>By : $name_ans </font><font style='float:right;'>" . process_date(strtotime($data_sub['date'])) . " </font>
					        <div class='clear'></div>
					    </div>";
            }
            echo "  </div>";
            $sub_stmt->close();
        }
    }

    while ($data = $result1->fetch_array()) {
        $name_ques = $data['fname'] ?? $data['user'];
        echo "  <div class='listfaq' id='$data[faqId]'>
			        <p><b>$name_ques</b></p>
					<div class='txtcontent'>
					    <p><b>Question : </b></p>
			            <a href='1yearcontent.php?section=faq&faqId=$data[faqId]'><p>$data[topic]</p></a>
						<p align=right>" . process_date(strtotime($data['date'])) . "   </p>
					</div>";

        $strSQL = "SELECT m.user, m.fname, f.faqId, f.detail, f.date
                FROM tb_x_faq_ans1year f, tb_x_member_1year m
                WHERE m.id = f.userId && f.faqId = ? ORDER BY f.ansId ASC";
        $sub_stmt = $conn->prepare($strSQL);
        $sub_stmt->bind_param("s", $data['faqId']);
        $sub_stmt->execute();
        $result = $sub_stmt->get_result();

        while ($data_sub = $result->fetch_array()) {
            $name_ans = $data_sub['fname'] ?? $data_sub['user'];
            echo "
                    <div class='txtcontentsub' style='margin-left:20px;'>
                        <p><b>Answer :</b></p>
                        <p>$data_sub[detail]</p>
                        <font style='float:left;'>By : $name_ans </font><font style='float:right;'>" . process_date(strtotime($data_sub['date'])) . " </font>
                        <div class='clear'></div>
                    </div>";
        }
        echo " </div>";
        $sub_stmt->close();
    }
    $stmt->close();
    echo "</div>";

    echo "<div class='page' id='$_GET[page]'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($_GET["page"] == $i) {
            $color = "#DF013A";
        }
        else {
            $color = "black";
        }
        echo "<a href='1yearcontent.php?section=faq&page=$i' style='color:$color;'>$i</a>&nbsp&nbsp&nbsp";
    }
    echo "</div>";
    mysqli_close($conn);

}


?>