<?php
ob_start();
session_start();
include('config/connection.php');
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>หลักสูตรเรียนภาษาอังกฤษออนไลน์ 1 ปี</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://www.engtest.net/image2/1 year icon.ico">
    <!-- CSS -->
    <!-- <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'> -->

    <link href="http://localhost/engtest/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Styling -->
    <style type="text/css">
    body {
        background-color: #000000;
        margin: 0 auto;
        width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    label {
        font-size: 15px;
        font-weight: bold;
    }
    </style>
</head>

<body>

    <div style='position:relative;'>
        <center>
            <img src="https://www.engtest.net/image2/1 year/button/status.png"
                style="position:absolute;z-index:200;left:50%;margin-left:-680px;">
        </center>
        <img src="https://www.engtest.net/image2/1 year/bg-01.jpg"
            style="position:absolute;left:50%;margin-left:-680px;">
        <a href="1yc/1yearcontent.php?section=faq&page=1" title="กระดานถาม ตอบ"
            style="position:absolute;z-index:230;left:50%;margin-left:300px;top:100px;font-weight:bold;font-size:18px;color:#000;text-decoration: none;">
            <img src="https://www.engtest.net/image2/1 year/button webboard.png" width="151" height="127">
        </a>
        <a href="1yc/1yearcontent.php?section=logtime" title="ประวัติการใช้งาน"
            style="position:absolute;z-index:230;left:50%;margin-left:230px;top:250px;font-weight:bold;font-size:18px;color:#000;text-decoration: none;">
            <img src="https://www.engtest.net/image2/1 year/button history.png" width="150">
        </a>
        <a href="1yc/1yearlist.php" title="เข้าสู่บทเรียน"
            style="position:absolute;z-index:230;left:50%;margin-left:330px;top:390px;font-weight:bold;font-size:18px;color:#000;text-decoration: none;">
            <img src="https://www.engtest.net/image2/1 year/button EnterLessons.png" width="200">
        </a>
        <a href="#" class='modalInput' rel='#prompt1' title="Edit profile" data-toggle="modal" data-target="#modalForm">
            <img src="https://www.engtest.net/image2/1 year/button/edit.png" width="45" height="39"
                style="position:absolute;z-index:250;left:50%;margin-left:350px;top:7px;">
        </a>
        <a href="http://localhost/engtest/inc/logout.php" title="logout">
            <img src="https://www.engtest.net/image2/1 year/button/log-out.png" width="45" height="39"
                style="position:absolute;z-index:250;left:50%;margin-left:420px;top:7px;">
        </a>
        <div style="position:absolute;z-index:200;left:50%;margin-left:-466px; top:15px;font-weight:bold;width:100%;">
            Welcome :
            <?php
        	if($data['fname']==""){
			    echo $data['user'];
			}else{
			    echo $data['fname'] ;
			}
	   ?>
        </div>
        <center>
            <div style="position:absolute;left:50%;z-index:200;top:660px;margin-left:270px;">
                <table width="353" border="0" cellpadding="2" cellspacing="1">
                    <tr>
                        <td width="115" rowspan="4">
                            <span class="style1">
                                <!---------------- Server Time ---------------------->
                                <div id="server_time" style="color:#FFFFFF;font-size:40px;">&nbsp;</div>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="mount" style="color:#FFFFFF;font-weight:bold;">&nbsp;</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="year" style="color:#FFFFFF;font-size:18px;font-weight:bold;">&nbsp;</div>
                        </td>
                    </tr>
                </table>
            </div>
        </center>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalForm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <form role="form">
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" id="fname" placeholder="Enter your Firstname"
                                value="<?= $data['fname']; ?>"
                                <?php if($_SESSION["x_member_1year"] == 4) echo "disabled";?>>
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" id="lname" placeholder="Enter your Lastname"
                                value="<?= $data['lname']; ?>"
                                <?php if($_SESSION["x_member_1year"] == 4) echo "disabled";?>>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email"
                                value="<?= $data['email']; ?>"
                                <?php if($_SESSION["x_member_1year"] == 4) echo "disabled";?>>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submitBtn" onclick="editprofile()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    $current_server_time = date("Y")."/".date("m")."/".date("d")." ".date("H:i:s");
?>
    <!-- Script -->
    <!-- <script src='https://www.engtest.net/js/jquery-1.9.0.min.js'></script> -->
    <script src='http://localhost/engtest/bootstrap/js/jquery.min.js'></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script> -->
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>
    <script type='text/javascript'>
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

    window.onload = function() {
        MM_preloadImages();
    }

    function editprofile() {
        var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        var fname = $('#fname').val();
        var lname = $('#lname').val();
        var email = $('#email').val();
        if (fname.trim() == '') {
            alert('Please enter your Firstname.');
            $('#fname').focus();
            return false;
        } else if (lname.trim() == '') {
            alert('Please enter your Lastname.');
            $('#lname').focus();
            return false;
        } else if (email.trim() == '') {
            alert('Please enter your email.');
            $('#email').focus();
            return false;
        } else if (email.trim() != '' && !reg.test(email)) {
            alert('Please enter valid email.');
            $('#email').focus();
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "1yc/edit1year.php",
                data: 'fname=' + fname + '&lname=' + lname + '&email=' + email,
                beforeSend: function() {
                    $('.submitBtn').attr("disabled", "disabled");
                    $('.modal-body').css('opacity', '.5');
                },
                success: function(msg) {
                    if (msg == 'ok') {
                        $('#fname').val('');
                        $('#lname').val('');
                        $('#email').val('');
                        $('.statusMsg').html(
                            '<span style="color:green;">Edit Profile Success.</p>'
                        );
                        setInterval('location.reload()', 1000);
                    } else {
                        $('.statusMsg').html(
                            '<span style="color:red;">Some problem occurred, please try again.</span>');
                    }
                    $('.submitBtn').removeAttr("disabled");
                    $('.modal-body').css('opacity', '');
                },

            });

        }
    }

    function pad(n) {
        return ("0" + n).slice(-2);
    }

    function server_date(now_time) {
        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        current_time1 = new Date(now_time);
        current_time2 = current_time1.getTime() + 1000;
        current_time = new Date(current_time2);

        server_time.innerHTML = current_time.getHours() + ":" + ("0" + current_time.getMinutes()).slice(-2);
        mount.innerHTML = current_time.getDate() + "  " + monthNames[current_time.getMonth()];
        year.innerHTML = current_time.getFullYear();

        setTimeout("server_date(current_time.getTime())", 1000);
    }

    setTimeout("server_date('<?=$current_server_time?>')", 1000);
    </script>
</body>

</html>