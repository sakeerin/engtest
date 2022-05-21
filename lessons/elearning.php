<?php
ob_start();
session_start();
include('../inc/user_info.php');
include('../config/connection.php');
date_default_timezone_set('Asia/Bangkok');
// $conn->set_charset('utf8mb4');

if ($_SESSION["x_member_id"] == '') {
    echo "<script type=\"text/javascript\">
                 window.location=\"http://localhost/engtest/\";
          </script>";
    exit;
}

$_GET['section'] = $_GET['section'] ?? "elearning";

if ($_SESSION['x_member_id']) {

    $now = date("Y-m-d H:i:s");
    $member_id = $_SESSION['x_member_id'];
    
    $strSQL = "SELECT * FROM tb_x_member_time WHERE member_id = ? && started_date <= ? && stop_date >= ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("sss", $member_id, $now, $now);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_ok = $result->num_rows;
    if ($is_ok == 1) {
        $allow = 1; /* echo " Pass [2011]<br>"; */
    }
    if ($is_ok == 0) {
        
        $SQL = "SELECT * FROM tb_x_member_amount WHERE member_id = ?";
        $query = $conn->prepare($SQL);
        $query->bind_param("s", $member_id);
        $query->execute();
        $result = $query->get_result();
        $is_master = $result->num_rows;
        if ($is_master == 1) {
            $allow = 1; /* echo "Master [2011] <br>"; */
        }
        $query->close();
    }
    $stmt->close();
    mysqli_close($conn);

//------------------------------------------------//
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>English Test Online :: elearning</title>
    <link rel="shortcut icon" type="image/x-icon" href="http://localhost/engtest/images/image2/neweol-logo.ico">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/tabbar.css">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/mainpage.css">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/form-search-lesson-topic.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/pagination.css">
    <style type="text/css">
    .afooter {
        color: #FFFF99;
        text-decoration: none;
    }

    /* #containerMain {
        position: relative;
        align: center;
        margin: 0 auto;
        width: 1024px;
        min-height: 700px;
        height: auto;
        clear: both;
    }

    #container {
        position: relative;
        align: center;
        margin: 0 auto;
        width: 980px;
        min-height: 50px;
        height: auto;
        clear: both;
    } */
    </style>
</head>

<body>
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
                            src='https://www.engtest.net/image2/eol system/button/logout-06.png'
                            style='margin-top:10px; margin-left:20px;' /></a>
                </div>
            </div>
        </div>
        <!------- main content--------->
        <div id='content'>
            <div id='pic_border'>
                <img src='https://www.engtest.net/image2/eol system/head-box-02.png' width='1024' />
            </div>
            <div id='content-div'>
                <table name='maintb' align='center' width='100%' cellpadding=0 cellspacing=0 border=0>
                    <!-- <tr height=10>
                        <td></td>
                    </tr> -->
                    <tr>
                        <td align=center>
                            <?php
    if (!$_GET['skill_id'] && !$_GET['level_id']) {
        elearning_main();
    }
    if ($_GET['skill_id'] && !$_GET['level_id']) {

        echo "<script type=\"text/javascript\">
			       window.location=\"?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1\";
	          </script>";
        exit();
    }
    if ($_GET['level_id']) {
?>
                            <div class="tabbed" style="border-bottom: 4px solid #f7941d !important;">
                                <ul>
                                    <a
                                        href="http://localhost/engtest/EOL/eoltest.php?section=bussiness&&status=edit_profile">
                                        <li class="" id="tab_profile">Profile</li>
                                    </a>
                                    <a href="http://localhost/engtest/EOL/eoltest.php?section=business&&status=refill">
                                        <li class="" id="tab_refill">Refill</li>
                                    </a>
                                    <?php if ($_SESSION['coporate'] == 1) { ?>
                                    <a href="http://localhost/engtest/corporate/ecop.php">
                                        <li class="" id="tab_corporate">Multi - Learning</li>
                                    </a>
                                    <?php }?>
                                    <a href="http://localhost/engtest/EOL/eoltest.php?section=business">
                                        <li class="active" id="tab_eolsystem">SYSTEM Page</li>
                                    </a>
                                </ul>
                            </div>
                            <?php
        e_topic_list($allow);
    }

?>

                        </td>
                    </tr>
                    <!-- <tr height=10>
                        <td></td>
                    </tr> -->
                </table>
            </div>
        </div>
        <!-----------end main cotent------------>
    </div>
    <!------------------- footer -------------->
    <div>
        <center style="margin-bottom:10px; margin-top:-3px;"><b>Copyright © 2022 By English Online Co.,Ltd. All rights
                reserved.</b>
        </center>
    </div>
    <script src='http://localhost/engtest/bootstrap/js/jquery.min.js'></script>
    <script language="javascript">
    $(function() {
        $(window).bind("beforeunload", function(event) {

            var responsetxt = '';
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
<div class="tabbed" style="border-bottom: 4px solid #f7941d !important;">
    <ul>
        <a href="http://localhost/engtest/EOL/eoltest.php?section=bussiness&&status=edit_profile">
            <li class="" id="tab_profile">Profile</li>
        </a>
        <a href="http://localhost/engtest/EOL/eoltest.php?section=bussiness&&status=refill">
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
    <table align=center width=98% cellpadding=0 cellspacing=0 border=0>
        <tr valign=top>
            <td width=100% align=center >
                <img src='http://localhost/engtest/images/image2/eol system/Lessons/bg-08.jpg' border=0 style='border-radius: 10px;     width: 980px;'>
                <div style='position:absolute; top:700px;left:50%;margin-left:150px;'>
                    <a href=?section=$_GET[section]&&skill_id=1 title='Reading Comprehension' >
                        <img src='http://localhost/engtest/images/image2/eol system/Lessons/lessons-1.png' border=0>
                    </a>
                </div>
                <div style='position:absolute;top:350px;left:40%'>
                    <a href=?section=$_GET[section]&&skill_id=2 title='Listening Comprehension' >
                        <img src='http://localhost/engtest/images/image2/eol system/Lessons/lessons-2.png' border=0>
                    </a>
                </div>
                <div  style='position:absolute; top:660px;left:10%;margin-left:10px;'>
                    <a href=?section=$_GET[section]&&skill_id=3 title='Semi - Speaking' >
                        <img src='http://localhost/engtest/images/image2/eol system/Lessons/lessons-3.png' border=0>
                    </a>
                </div>
                <div style='position:absolute;top:220px;'>
                    <a href=?section=$_GET[section]&&skill_id=4&&page=1 title='Semi - Writing' >
                        <img src='http://localhost/engtest/images/image2/eol system/Lessons/lessons-4.png' border=0>
                    </a>
                </div>
                <div style='position:absolute;top:300px;left:85%;'>
                    <a href=?section=$_GET[section]&&skill_id=5 title='Grammar' >
                        <img src='http://localhost/engtest/images/image2/eol system/Lessons/lessons-5.png' border=0>
                    </a>
                </div>
                <div style='position:absolute;top:60px;left:20%;'>
                    <a href=?section=$_GET[section]&&skill_id=7 title='Vocabulary Items' >
                        <img src='http://localhost/engtest/images/image2/eol system/Lessons/lessons-6.png' border=0>
                    </a>
                </div>
            </td>
        </tr>
        <tr>
          <td></td>
        </tr>
    </table>";
}

function e_topic_list($allow)
{

    if ($_GET['skill_id'] == 1 && $_GET['level_id'] != "" && $_GET['topic_id'] != "") {
        echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-reading2.jpg' usemap='#Link' style='border-radius: 10px;'/>
        
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0>";
    }
    else if ($_GET['skill_id'] == 1) {
        echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-reading2.jpg' usemap='#Link' style='border-radius: 10px;'/>
        
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0 style='position:relative; top:10px; left:50%; margin-left:-500px;'>";
    }
    if ($_GET['skill_id'] == 2 && $_GET['level_id'] != "" && $_GET['topic_id'] != "") {
        echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-listening2.jpg' usemap='#Link' style='border-radius: 10px;'/>
        
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0>";
    }
    else if ($_GET['skill_id'] == 2) {
        echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-listening2.jpg' usemap='#Link' style='border-radius: 10px;'/>
        
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0 style='position:relative; top:10px; left:50%; margin-left:-500px;'>";
    }

    if ($_GET['skill_id'] == 3 && $_GET['level_id'] != "" && $_GET['topic_id'] != "") {
        echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-speaking2.jpg' usemap='#Link'  style='border-radius: 10px;'/>
        
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0 >";
    }
    else if ($_GET['skill_id'] == 3) {
        echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-speaking2.jpg' usemap='#Link' style='border-radius: 10px;'/>
        
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0 style='position:relative; top:10px; left:50%; margin-left:-500px;'>";
    }
    if ($_GET['skill_id'] == 4 && $_GET['level_id'] != "" && $_GET['topic_id'] != "") {
        echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-writing2.jpg' usemap='#Link' style='border-radius: 10px;'/>
        
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0>";
    }
    else if ($_GET['skill_id'] == 4) {
        // echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-writing2.jpg' usemap='#Link'/>
        echo "<img src='http://localhost/engtest/images/image2/eol system/Lessons/bg-lessons-writing2.jpg' usemap='#Link' style='border-radius: 10px;'/>
        
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0 style='position:relative; top:10px; left:50%; margin-left:-500px;'>";
    // <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0 style='position:absolute;top:220px;left:50%;margin-left:-460px;'>
    }
    if ($_GET['skill_id'] == 5 && $_GET['level_id'] != "" && $_GET['topic_id'] != "") {
        echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-grammar2.jpg' usemap='#Link' style='border-radius: 10px;'/>
        
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0>";
    }
    else if ($_GET['skill_id'] == 5) {
        echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-grammar2.jpg' usemap='#Link' style='border-radius: 10px;'/>
        
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0 style='position:relative; top:10px; left:50%; margin-left:-500px;'>";
    // <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0 style='position:absolute;top:220px;left:50%;margin-left:-460px;'>
    }
    if ($_GET['skill_id'] == 7 && $_GET['level_id'] != "" && $_GET['topic_id'] != "") {
        echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-vocabulary2.jpg' usemap='#Link' align='left' style='border-radius: 10px;'/>
        
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0 style='table-layout:fixed; width: 100%;'>";
    }
    else if ($_GET['skill_id'] == 7) {
        echo "<img src='https://www.engtest.net/image2/eol system/Lessons/bg-lessons-vocabulary2.jpg' usemap='#Link' style='border-radius: 10px;'/>
        <map name='Link'>
        <area shape='rect' coords='380,24,562,68' alt='Sun' href='elearning.php'>
        <area shape='rect' coords='385,83,563,130' alt='Sun' href='elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&page=1'>
        </map>
        
        <table align=center width=950 height=100% cellpadding=0 cellspacing=0 border=0 style='position:relative; top:10px; left:50%; margin-left:-500px;'>";
    }

    echo "
        <tr valign=top >
            <td width=5%>&nbsp;</td>
            <td width=90% align=center>
        
            </td>
            <td width=5%>&nbsp;</td>
        </tr>
        <tr height=100% valign=top  >
            <td>&nbsp;</td>
            <td align=center >";
    if (!$_GET['topic_id']) {
        display_e_list();
    }
    if ($_GET['topic_id'] && $allow == 1) {
        display_e_detail();
    }
    if ($_GET['topic_id'] && $allow == 0) {
        if (!$_SESSION['x_member_id']) {
            echo "
                <table align=center width=100% cellspacing=0 cellpadding=0 border=0>
                    <tr height=200>
                        <td align=center>
                            <br><br>
                            <font size=2 face=tahoma color='red'>Please Login Before Using EOL E-Learning.</font>
                            <br><br>
                            <a target=_blank href='http://localhost/engtest/inc/login.php'>
                                <font size=2 face=tahoma color='blue'>&raquo; Click here to login page &laquo;</font>
                            </a>
                            <br><br>
                            <font size=2 face=tahoma color='green'>Press F5 or Refresh this page after login to using EOL Elearning</font>
                            <br><br>&nbsp;
                        <td>
                    </tr>
                </table>";
        }
        else {
            echo "
                <table align=center width=100% cellspacing=0 cellpadding=0 border=0>
                    <tr height=200>
                        <td align=center>
                            <br><br>
                            <font size=2 face=tahoma color='red'>Sorry , EOL E-Learning is limited for privileged members only. </font>
                            <br><br>
                            <a target=_blank href='https://www.engtest.net/shop/product_personal.php'>
                                <font size=2 face=tahoma color='blue'>&raquo; Click here to get EOL product details &laquo;</font>
                            </a>
                            <br><br>
                            <font size=2 face=tahoma color='green'>More Details Contact us : engtest_eol@hotmail.com, englishonline.eol@gmail.com or 02-1708725-6 </font>
                            <br><br>&nbsp;
                        <td>
                    </tr>
                </table>";
        }
    }
    echo "
            </td>
            <td>&nbsp;</td>
        </tr>
    </table><br>
    ";
}

function display_e_list()
{
    include('../config/connection.php');
    $type = "1$_GET[skill_id]-0$_GET[level_id]";
    $skill_id = $_GET['skill_id'];
    $level_id = $_GET['level_id'];
    $active = 1;
    $strSQL = "SELECT * FROM tb_web_topic WHERE type_id = ? && topic_active = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $type, $active);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->num_rows;
    $stmt->close();
    $name_topic = $_POST['search'] ?? '';
    $page = $_GET['page'];
    $pagenum = ceil($row / 20);
    if ($_GET['page'] <= $pagenum) {
        $limit = $_GET['page'];
        if ($limit == 1) {
            $i = 1;
            $Limit = 'limit 0,20';
        }
        else {
            $i = (20 * ($page - 1)) + 1;
            $Limit = 'limit ' . (($page - 1) * 20) . ',' . $page * 20;
        }

    }
    else {
        $limit = 1;
        $i = 1;
    }
?>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/pagination.css"> -->
<style type="text/css">
/* Styles for wrapping the search box */
.main {
    width: 40%;
    margin: 0px auto 30px auto;
    position: relative;
    right: -260px;
}
</style>
<div class="main">

    <!-- Another variation with a button -->
    <form action="?section=<?= $_GET['section']?>&&skill_id=<?=$_GET['skill_id']?>&&level_id=1&&page=1" method="post">
        <div class="input-group ">
            <input name="search" type="text" class="form-control" placeholder="Search lesson topic"
                value="<?= $name_topic?>">
            <div class="input-group-append">
                <button class="btn btn-secondary" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>


</div>
<?php

    
    if (isset($_POST['search'])) {
        $search = trim($_POST['search']);
        $topic = "%{$search}%";
        $active = 1;
        $strSQL = "SELECT topic_name,topic_id FROM tb_web_topic WHERE type_id = ? && topic_name like ? && topic_active = ? ORDER BY topic_name ASC ";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("sss", $type,$topic, $active);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
    } else {
        $active = 1;
        $strSQL = "SELECT topic_name,admin_id,topic_id FROM tb_web_topic WHERE type_id = ? && topic_active = ? ORDER BY topic_name ASC $Limit";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ss", $type, $active);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;
    }

    $font = "<font size=3 face=tahoma color=black><b>";
    $skill[1] = "Reading";
    $skill[2] = "Listening";
    $skill[3] = "Speaking";
    $skill[4] = "Semi-Writing";
    $skill[5] = "Grammar";
    $skill[7] = "Vocabulary";
    $level[1] = "Beginner";
    $level[2] = "Intermediate";
    $level[3] = "Advance";
    $msg_skill = $skill[$_GET['skill_id']];
    $msg_level = $level[$_GET['level_id']];
    // echo "<center><h3>$msg_skill</h3><hr></center>";
    if ($num >= 1) {
        while ($data = $result->fetch_assoc()) {

            echo "
                <table align=center width=95% cellpadding=0 cellspacing=0 border=0 >
                    <tr valign=top height=30>
                        <td align=center width=5%>$font $i</td>
                        <td align=left width=80%>
                            <a href=?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=$_GET[level_id]&&topic_id=$data[topic_id] title=\" $data[topic_name]\">
                                $font $data[topic_name] </a>
                        </td>
                        <td align=center width=15%>$font &nbsp;</td>
                    </tr>
                </table>";
            $i++;
            if ($i == 21 || $i == 41 || $i == 61 || $i == 81 || $i == 101 || $i == 101 || $i == 121 || $i == 141 || $i == 161 || $i == 181 || $i == 201 ) {
                break;
            }

        }
        echo "<center><hr style='background:#d1c9c9'></center>";
        echo "<center><ul class='pagination'>";
        for ($page = 0; $page < $pagenum; $page++) // pagination
        {
            echo '<li ', ($page + 1 == $limit ? 'class="active"' : 'none'), '><a href="?section=elearning&&skill_id=', $_GET['skill_id'], '&&level_id=', $_GET['level_id'], '&&page=', $page + 1, '">', $page + 1, '</a></li>';
        }
        echo '</ul></center>';
    }else{
        echo "  <table align=center width=95% cellpadding=0 cellspacing=0 border=0 >
                    <tr valign=top height=30 align=center>
                        <td align=center width=95%><font size=3 face=tahoma color=red><b>Sorry!!! Not Found Data </b></font></td>
                    </tr>
                    <tr valign=top height=30 align=center>
                        <td align=center width=95%><font size=3 face=tahoma color=red> Please try again </font></td>
                    </tr>
                </table>";
    }
    $stmt->close();
    mysqli_close($conn);
}


function display_e_detail()
{

    include('../config/connection.php');
    
    $topic_id = $conn->real_escape_string($_GET['topic_id']);
    $active = 1;
    $strSQL = "SELECT * FROM tb_web_topic WHERE topic_id = ? && topic_active = ? ";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $topic_id, $active);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;

    $font = "<font size=2 face=tahoma color=black><b>";
    echo "<br>";
    if ($num = 1) {
        $data = $result->fetch_array();
        $detail = stripslashes($data['topic_detail']);
        //--------------------------------------------------//
        $skill[1] = "Reading";
        $skill[2] = "Listening";
        $skill[3] = "Speaking";
        $skill[4] = "Writing";
        $skill[5] = "Grammar";
        $skill[7] = "Vocabulary";
        $level[1] = "Beginner";
        $level[2] = "Intermediate";
        $level[3] = "Advance";
        $msg_skill = $skill[$_GET['skill_id']];
        $msg_level = $level[$_GET['level_id']];
        //--------------------------------------------------//

        echo " <div align=left>
        $detail
    </div>
    <br><br>";
        // web_dic();
        relate_topic();
        echo "&nbsp;";
    }
    $stmt->close();
    mysqli_close($conn);
}

function relate_topic()
{
    include('../config/connection.php');

    if ($_GET['topic_id'] == "352" || $_GET['topic_id'] == "397" || $_GET['topic_id'] == "467") {
        $where = " where topic_id='397' || topic_id='352' || topic_id='467' order by topic_name ";
    }
    //-----------------------------------------------------------------------//
    if ($_GET['topic_id'] == "378" || $_GET['topic_id'] == "379") {
        $where = " where topic_id='378' || topic_id='379' order by topic_name ";
    }
    if ($_GET['topic_id'] == "334" || $_GET['topic_id'] == "335") {
        $where = " where topic_id='334' || topic_id='335' order by topic_name ";
    }
    //-----------------------------------------------------------------------//
    if ($_GET['topic_id'] == "380" || $_GET['topic_id'] == "381" || $_GET['topic_id'] == "382") {
        $where = " where topic_id='380' || topic_id='381' || topic_id='382' order by topic_name ";
    }
    if ($_GET['topic_id'] == "336" || $_GET['topic_id'] == "337" || $_GET['topic_id'] == "338") {
        $where = " where topic_id='336' || topic_id='337' || topic_id='338' order by topic_name ";
    }
    //=============================================================================================//
    if ($where != "") {

        $strSQL = "SELECT * FROM tb_web_topic WHERE $where ";
        $stmt = $conn->prepare($strSQL);
        // $stmt->bind_param("ss", $topic_id, $active);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;

        if ($num >= 1) {
            echo "
            <table align=center width=100% cellpadding=0 cellspacing=0 border=0 bgcolor=f0f0f0>
                <tr height=30>
                    <td align=left width=100% colspan=2>
                        <font size=2 face=tahoma><b> &nbsp; Relate Topic </b></font>
                    </td>
                </tr>
                <tr>
                    <td width=5% align=center>&nbsp;</td>
                    <td width=95% align=center>";
            for ($i = 1; $i <= $num; $i++) {
                $data = $result->fetch_array();
                echo "
                        <table align=center width=100% cellpadding=0 cellspacing=0 border=0>
                            <tr height=25>
                                <td align=left width=100%>
                                <br><br><br>
                                    <a target=_blank href='?section=elearning&&skill_id=$_GET[skill_id]&&level_id=$_GET[level_id]&&topic_id=$data[topic_id]'>
                                        <font size=2 face=tahoma color=blue><b> &raquo; $data[topic_name]<b></font>
                                    </a>
                                </td>
                            </tr>
                        </table>";
            }
                echo "
                    </td>
                </tr>
                <tr height=10>
                    <td align=left width=100% colspan=2></td>
                </tr>
            </table>";
        }
    }
    mysqli_close($conn);

}


?>