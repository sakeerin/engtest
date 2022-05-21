<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include('../inc/user_info.php');
include('../config/connection.php');

if ($_SESSION["x_member_id"] == '') {
    echo "<script type=\"text/javascript\">
                 window.location=\"http://localhost/engtest/\";
          </script>";
    exit;
}

$allow = 0;
if ($_SESSION['x_member_id']) {
    //------------------------------------------------//
    $now = date("Y-m-d H:i:s");

    $strSQL = "SELECT * FROM tb_x_member_time WHERE member_id = ? && started_date <= ? && stop_date >= ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("sss", $_SESSION['x_member_id'], $now, $now);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_ok = $result->num_rows;
    if ($is_ok == 1) {
        $allow = 1; /* echo " Pass [2011]<br>"; */
    }
    $stmt->close();
    if ($is_ok == 0) {

        $SQL = "SELECT * FROM tb_x_member_amount WHERE member_id = ?";
        $query = $conn->prepare($SQL);
        $query->bind_param("s", $_SESSION['x_member_id']);
        $query->execute();
        $result = $query->get_result();
        $is_master = $result->num_rows;
        if ($is_master == 1) {
            $allow = 1; /* echo "Master [2011] <br>"; */
        }
        $query->close();
    }
//------------------------------------------------//
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>English Test Online :: ระบบทดสอบภาษาอังกฤษออนไลน์ </title>
    <link rel="shortcut icon" type="image/x-icon" href="http://localhost/engtest/images/image2/neweol-logo.ico">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/mainpage.css">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/systemtest.css">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/tabbar.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">

    <style type="text/css">
    .oswald {
        font-family: 'Oswald' !important;
    }

    .kanit {
        font-family: 'Kanit' !important;
    }

    .btn-ecop {
        -webkit-border-radius: 43;
        -moz-border-radius: 43;
        border-radius: 43px;
        font-family: Arial;
        color: #ffffff;
        font-size: 20px;
        padding: 8px 15px 8px 15px;
        border: solid #ffffff 3px;
        text-decoration: none;
        width: 190px;
    }

    .btn-ecop:hover {
        background: #3cb0fd !important;
        text-decoration: none;
        cursor: pointer;
    }

    #containerMain {
        position: relative;
        align: center;
        margin: 0 auto;
        width: 1024px;
        min-height: 700px;
        height: auto;
        clear: both;
    }

    .topic_list_header {
        -webkit-border-top-left-radius: 20px;
        -webkit-border-top-right-radius: 20px;
        -moz-border-radius-topleft: 20px;
        -moz-border-radius-topright: 20px;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    .topic_list_footer {
        -webkit-border-bottom-right-radius: 20px;
        -webkit-border-bottom-left-radius: 20px;
        -moz-border-radius-bottomright: 20px;
        -moz-border-radius-bottomleft: 20px;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
    }
    </style>

</head>

<body>
    <div id='containerMain'>
        <div id='header'>
            <!-- <img src='../image2/mainpage/dbd-head.gif' width='927' height='148'
                style='margin:10px 0 0 16px; top:-10px;' /> -->
            <a href='http://localhost/engtest/index.php'><img
                    src='http://localhost/engtest/images/image2/logo/logo-02.png' width='270' height='118'
                    style='float:left;margin-left:20px; margin-top: 175px;' /></a>
            <!---- info user ----->
            <div id='info_user'>
                <?php
$data = new info();
echo $data->loadinfo('test');
if ($_SESSION['x_member_id']) {
    echo '	
				   <div id="logoutPic">
                        <a href="http://localhost/engtest/inc/logout.php"><img src="http://localhost/engtest/images/image2/eol system/button/logout-06.png" style="margin-top:10px; margin-left:20px;" /></a>
                  </div> ';
}
?>

            </div>
        </div>
        <!------- main content--------->
        <div id='content'>
            <div id='pic_border'>
                <img src='http://localhost/engtest/images/image2/eol system/head-box-02.png' width='1024' />
            </div>
            <div id='content-div'>
                <table name=maintb align=center width=100% cellpadding=0 cellspacing=0 border=0>
                    <tr>
                        <td align=center>

                            <?php

if (!$_GET['skill_id'] && !$_GET['level_id']) {
    elearning_main();
}
if ($_GET['skill_id'] && !$_GET['level_id']) {
    echo "<script type=\"text/javascript\">
			    window.location=\"?section=elearning&&skill_id=$_GET[skill_id]&&level_id=2\";
	      </script>";
    exit();
}
if ($_GET['level_id']) {
    e_topic_list($allow);
}
?>

                        </td>
                    </tr>
                    <tr height=10>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-----------end main cotent------------>
    </div>
    <!------------------- footer -------------->
    <div>
        <!-- < include 'inc/footer-new.php'; ?> -->
        <center style="margin-bottom:10px; margin-top:-3px;"><b>Copyright © 2022 By English Online Co.,Ltd. All rights
                reserved.</b>
        </center>
    </div>
    <script src='http://localhost/engtest/bootstrap/js/jquery.min.js'></script>
    <script language="javascript">
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
</body>

</html>

<?php
function elearning_main()
{
?>
<div class="tabbed" style="border-bottom: 4px solid #ec5c27 !important;">
    <ul>
        <a href="http://localhost/engtest/EOL/eoltest.php?section=bussiness&&status=edit_profile">
            <li class="" id="tab_profile">Profile</li>
        </a>
        <a href="http://localhost/engtest/EOL/eoltest.php?section=business&&status=refill">
            <li class="" id="tab_refill">Refill</li>
        </a>

        <a href="http://localhost/engtest/corporate/ecop.php">
            <li class="active" id="tab_corporate">Multi - Learning</li>
        </a>
        <a href="http://localhost/engtest/EOL/eoltest.php?section=business">
            <li class="" id="tab_eolsystem">SYSTEM Page</li>
        </a>
    </ul>
</div>


<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top">
        <td width="100%" align="center">
            <div style="width:980px;">
                <div style="background:#545454;height:80px;">
                    <div
                        style="font-size:32px;color:#FFF;line-height: 80px;text-align:left;vertical-align: middle !important; padding:0px 100px;">
                        <div style="position:relative;">
                            <img src="http://localhost/engtest/images/icon/icon_corporate.png"
                                style="position:absolute;top:10px;width:65px;">
                            <div style="display: inline-block;vertical-align: middle;position:absolute;left:80px;"
                                class="oswald">
                                CORPORATE MEMBER'S USE
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background:#00a9a4;height:250px;">
                    <div
                        style="font-size:42px;color:#FFF;text-align:left;vertical-align: middle !important; padding:0px 100px;">
                        <div style="position:relative;padding-top:20px;">
                            <div style="vertical-align: middle;position:absolute;left:0px;" class="oswald">EOL TESTING /
                                EOL CONTEST <BR>
                                <div style="font-size:22px;line-height: 28px;" class="kanit">
                                    ชุดทดสอบที่สร้างโดย อาจารย์ ผู้ดูแล<BR />หรือ Administrator ของผู้ใช้งาน<BR /><BR />
                                    <a href="http://localhost/engtest/EOL/eoltest.php?section=business&&action=eolcontest"
                                        title="EOL Testing">
                                        <button type="button" class="btn-ecop kanit" style="background:#e7906c;">EOL
                                            Testing <div style="display:inline-block;transform: rotate(0deg);">➤</div>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <img src="http://localhost/engtest/images/icon/icon_eol_contest.png"
                                style="position:absolute;top:10px;right:0px;width:350px;" />
                        </div>
                    </div>
                </div>
                <div style="background:#027EA0;height:250px;">
                    <div
                        style="font-size:42px;color:#FFF;text-align:right;vertical-align: middle !important; padding:0px 100px;">
                        <div style="position:relative;padding-top:20px;">
                            <div style="vertical-align: middle;position:absolute;right:0px;" class="oswald">EOL
                                LESSONS<BR>
                                <div style="font-size:22px;line-height: 28px;text-align: right !important;"
                                    class="kanit">
                                    เนื้อหาบทเรียนที่จัดทำโดย อาจารย์ ผู้ดูแล<BR />
                                    ใช้สำหรับภายในองค์กรของผู้ใช้งาน<BR /><BR />
                                    <a href="?section=elearning&&skill_id=8" title="Read Lesson">
                                        <button type="button" class="btn-ecop kanit" style="background:#e7906c;">
                                            <div style="display:inline-block;transform: rotate(180deg);">➤</div> Read
                                            Lesson
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <img src="http://localhost/engtest/images/icon/icon_content_lesson.png"
                                style="position:absolute;top:30px;left:0px;" />
                        </div>
                    </div>
                </div>
                <div style="background:#e6916c;height:250px;">
                    <div
                        style="font-size:42px;color:#FFF;text-align:left;vertical-align: middle !important; padding:0px 100px;">
                        <div style="position:relative;padding-top:20px;">
                            <div style="vertical-align: middle;position:absolute;left:0px;" class="oswald">VIDEO
                                LESSONS<BR>
                                <div style="font-size:22px;line-height: 28px;" class="kanit">
                                    บทเรียนในรูปแบบของไฟล์วิดีโอ<BR />
                                    สามารถรับชมได้ในรูปแบบออนไลน์<BR /><BR />
                                    <a href="?section=elearning&&skill_id=7" title="Play Video">
                                        <button type="button" class="btn-ecop kanit" style="background:#e7906c;">Play
                                            Video <div style="display:inline-block;transform: rotate(0deg);">➤</div>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <img src="http://localhost/engtest/images/icon/icon_video_lesson.png"
                                style="position:absolute;top:20px;right:0px;" />
                        </div>
                    </div>
                </div>
                <div
                    style="background:#545454;height:50px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">

                </div>
            </div>
        </td>
    </tr>
</table>
<?php
}
function e_topic_list()
{
    include('../config/connection.php');
?>
<div class="tabbed" style="border-bottom: 4px solid #ec5c27 !important;">
    <ul>
        <a href="http://localhost/engtest/EOL/eoltest.php?section=bussiness&&status=edit_profile">
            <li class="" id="tab_profile">Profile</li>
        </a>
        <a href="http://localhost/engtest/EOL/eoltest.php?section=business&&status=refill">
            <li class="" id="tab_refill">Refill</li>
        </a>
        <a href="http://localhost/engtest/corporate/ecop.php">
            <li class="active" id="tab_corporate">Multi - Learning</li>
        </a>
        <a href="http://localhost/engtest/EOL/eoltest.php?section=business">
            <li class="" id="tab_eolsystem">SYSTEM Page</li>
        </a>
    </ul>
</div>
<?php
    $status = 1;
    $strSQL = "SELECT * FROM tb_x_member_sub WHERE sub_id = ? && status = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("si", $_SESSION['x_member_id'], $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    $stmt->close();
    mysqli_close($conn);
    if ($is_have == 0) {
        echo "
                    <table align=center width=100% cellspacing=0 cellpadding=0 border=0>
                        <tr height=300>
                            <td align=center>
                                <br><br>
                                <font size=2 face=tahoma color='red'>Sorry , EOL  Multi Learning is limited for corporate members only. </font>
                                <br><br>
                                <a target=_blank href='http://localhost/engtest/shop/product_corporate.php'>
                                    <font size=2 face=tahoma color='blue'>&raquo; Click here to get EOL product details &laquo;</font>
                                </a>
                                <br><br>
                                <font size=2 face=tahoma color='green'>More Details Contact us : engtest_eol@hotmail.com, englishonline.eol@gmail.com or 02-1708725-6 </font>
                                <br><br>&nbsp;
                            <td>
                        </tr>
                    </table>";
        return false;
    }
    if ($_GET['skill_id'] == 7) {
        $title_topic_en = "VIDEO LESSONS";
        $title_topic_th = "หัวข้อบทเรียนไฟล์วิดีโอ";
        $title_topic_bg = "#e6916c";
        $bottom_border_color = "#027EA0";
        $title_topic_icon = "http://localhost/engtest/images/icon/icon_video_lesson.png";
    }
    elseif ($_GET['skill_id'] == 8) {
        $title_topic_en = "EOL LESSONS";
        $title_topic_th = "หัวข้อเนื้อหาบทเรียน";
        $title_topic_bg = "#027EA0";
        $bottom_border_color = "#e6916c";
        $title_topic_icon = "http://localhost/engtest/images/icon/icon_content_lesson.png";
    }
?>
<div style="width:980px;">
    <div style="background:#545454;height:80px;">
        <div
            style="font-size:32px;color:#FFF;line-height: 80px;text-align:left;vertical-align: middle !important; padding:0px 100px;">
            <div style="position:relative;">
                <img src="http://localhost/engtest/images/icon/icon_corporate.png"
                    style="position:absolute;top:10px;width:65px;">
                <div style="display: inline-block;vertical-align: middle;position:absolute;left:80px;" class="oswald">
                    CORPORATE MEMBER'S USE
                </div>
            </div>
        </div>
    </div>

    <div style="background:<?= $title_topic_bg; ?>;">
        <div style="color:#FFF;text-align:center;vertical-align: middle !important; padding:10px 100px;">
            <img src="<?= $title_topic_icon; ?>" style="height:150px;" />
            <div style="font-size:42px;vertical-align: middle;" class="oswald"><?= $title_topic_en; ?></div>
            <div style="font-size:20px;line-height: 28px;" class="kanit"><?= $title_topic_th; ?></div><BR>
            <div style="background:<?= $bottom_border_color; ?>;display: inline-block;width:88px;height:10px;font-size:10px;border-radius:5px;"
                class="kanit">
                &nbsp;</div>
        </div>
        <BR />
        <div class="topic_list_header kanit" style="width:740px;background:#324d60;color:#FFF;text-align: left;">
            <div style="font-size:18px;padding:10px 30px;"><?= $title_topic_en; ?></div>
        </div>
    </div>


</div>

<center>
    <div style="width:980px;">
        <div style="background:<?= $title_topic_bg; ?>;">
            <div class=" kanit" style="width:740px;background:#FFF;color:#000;text-align: left;">
                <div style="font-size:18px;padding:10px 10px;">
                    <?php

    if (!$_GET['topic_id']) {
        if ($_GET['skill_id'] == 8 && $_GET['level_id'] == 2) {
            display_custom_lesson();
        }
        elseif ($_GET['skill_id'] == 7 && $_GET['level_id'] == 2) {
            display_video_lesson();
        }
    }
    elseif ($_GET['topic_id']) {
        if ($_GET['skill_id'] == 7) {
            display_video_lesson_detail();
        }
        elseif ($_GET['skill_id'] == 8) {
            display_custom_lesson_detail();
        }
    }

?>
                </div>
            </div>
        </div>
    </div>
</center>

<center>
    <div style="width:980px;">
        <div style="background:<?= $title_topic_bg; ?>;">
            <div class="topic_list_footer kanit" style="width:740px;background:#324d60;color:#FFF;text-align: left;">
                <div style="font-size:18px;padding:10px 30px;">&nbsp;</div>
            </div>
            <BR>
        </div>

        <tr>
            <td bgcolor='#555555' align='right' width=1000><a href="http://localhost/engtest/corporate/ecop.php"><img
                        src='http://localhost/engtest/images/image2/eol system/ecop/btn_backsite.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
            </td>
        </tr>
    </div>
</center>

<?php
}

function display_custom_lesson()
{
    include('../config/connection.php');
    $active = 1;
    $strSQL = "SELECT A.lesson_id,A.lesson_name,A.active,A.createdby 
    FROM tb_lesson_custom AS A
    LEFT JOIN tb_x_member_sub AS B ON (B.master_id=A.createdby)
    WHERE A.active = ? AND  B.sub_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("is", $active, $_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    $font = "<font size=2 face=tahoma color=black><b>";
    if ($num > 0) {
        echo "<table align=center width=90% cellpadding=0 cellspacing=0 border=0 >";
        for ($i = 1; $i <= $num; $i++) {
            $data = $result->fetch_array();
            echo "
				<tr valign=top height=25 style='line-height:30px;'>
					<td align=center width=5%>$font $i</td>
					<td align=left width=80%>
						<a href=?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=$_GET[level_id]&&topic_id=$data[lesson_id] title=\"$data[lesson_name]\">
										$font $data[lesson_name] </a>
					</td>
				</tr>";
        }
        echo "</table>";
    }
    $stmt->close();
    mysqli_close($conn);
}

function display_video_lesson()
{
    include('../config/connection.php');
    $type = "1$_GET[skill_id]-0$_GET[level_id]";
    $active = 1;
    $strSQL = "SELECT topic_name,admin_id,topic_id FROM tb_web_topic WHERE type_id = ? && topic_active = ? order by topic_name ASC ";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("si", $type, $active);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    $font = "<font size=2 face=tahoma color=black><b>";
    //--------------------------------------------------//
    if ($num >= 1) {
        echo "<table align=center width=90% cellpadding=0 cellspacing=0 border=0 >";
        for ($i = 1; $i <= $num; $i++) {
            $data = $result->fetch_array();
            echo "
					<tr valign=top height=25>
						<td align=center width=5%>$font $i</td>
						<td align=left width=80%>
							<a href=?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=$_GET[level_id]&&topic_id=$data[topic_id] title=\"$data[topic_name]\">
										$font $data[topic_name] </a>
						</td>
					</tr>";
        }
        echo "</table>";
    }
    $stmt->close();
    mysqli_close($conn);
}

function display_custom_lesson_detail()
{
    include('../config/connection.php');
    $active = 1;
    $lesson_id = $_GET['topic_id'];
    $strSQL = "SELECT A.lesson_id,A.lesson_name,A.lesson_content,A.active,A.createdby 
    FROM tb_lesson_custom AS A
    WHERE A.active = ? AND A.lesson_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ii", $active, $lesson_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    echo "<div style='margin:20px;'>";
    if ($num > 0) {
        $data = $result->fetch_array();
        echo "<span style='font-size:24px;'>" . $data['lesson_name'] . "</span>";
        echo "<div class='MsoNormal' style='background: rgb(244, 176, 131); border-radius: 5px;'><span style='font-size: 12pt; font-family: Tahoma, sans-serif;'>&nbsp;</span></div>";
        echo "<div>" . $data['lesson_content'] . "</div>";
    }
    echo "</div>";
    $stmt->close();
    mysqli_close($conn);

}

function display_video_lesson_detail()
{
    include('../config/connection.php');
    $active = 1;
    $topic_id = $_GET['topic_id'];
    $strSQL = "SELECT * FROM tb_web_topic where topic_id = ? && topic_active = ? ";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("si", $topic_id, $active);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;
    if ($num == 1) {
        $data = $result->fetch_array();
        $detail = stripslashes($data['topic_detail']);
        echo "	<div align=left>
					$detail
				</div>
				<br><br>";
    }
    $stmt->close();
    mysqli_close($conn);

}
?>