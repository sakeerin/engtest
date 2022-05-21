<?php
include('../inc/header.php');
include('../inc/info_user.php');
include('../inc/footer.php');



if ($_SESSION['x_member_id'] != '') {
    echo "<script type=\"text/javascript\">
		window.location=\"../index.php\";
	</script>";
    exit();
}
else {
    if ($_GET['action'] == 'add') {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Email is incorrect";
        }
        if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $_POST['email'])) {
            $error['email'] = "Email is incorrect";
        }

        if (!$error) {
            //---------------------------------------------//
            // $table = $sql[tb_x_member];
            // $msg = " select user,pass from $table where email='$_POST[email]' ";
            // $query = mysql_query($msg);
            // $is_have = mysql_num_rows($query);
            if ($is_have == 0) {
                $error['sorry'] = "Sorry your email is not there in our database. Please try again.";
            }
            if ($is_have > 1) {
                $error['email_more_than'] = "Sorry!!! your email registered have more than one. if you want password. Please Contact us.";
            }
            if ($is_have == 1) {
                // $data = mysql_fetch_array($query);

                // $username = $data['user'];

                // $password = $data['pass'];
                function makeRandomPassword()
                {
                    $salt = "abcdefghijklmnpqrstuvwxyz0123456789";
                    srand((double)microtime() * 1000000);
                    $i = 0;
                    while ($i <= 7) {
                        $num = rand() % 33;
                        $tmp = substr($salt, $num, 1);
                        $pass = $pass . $tmp;
                        $i++;
                    }
                    return $pass;
                }
                $random_password = makeRandomPassword();
                $db_password = ($random_password);

                // 1. UPDATE PASSWORD

                // 2. SEND EMAIL TO USER

                $visitor_email = $_POST['email'];

                $message = "Username : " . $username . "New Password : " . $db_password;

                $email_from = 'Engtest.net Webmaste<englishonline.eol@gmail.com>';

                $email_subject = "Your New Password.";

                $email_body = "You have received a new message from english online by EOL System.\n" .
                    "Here is the message:\n" .
                    "======================================\n\n" .
                    "$message \n" .
                    "======================================\n\n" .
                    "http://localhost/engtest/\n" .
                    "Once logged in you can change your password\n\n" .
                    "Thanks!\nSite admin\n\nThis is an automated response, please do not reply! ";

                $headers = "From: $email_from \r\n";

                $headers .= "Reply-To: $visitor_email \r\n";

                mail($visitor_email, $email_subject, $email_body, $headers);

                echo "<script type=\"text/javascript\">
                            alert('Your new password has been send! Please check your email!');
                            window.location=\"../index.php\";
                        </script>";
                exit();
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    .text_paragraph {
        font-size: 16px;
    }

    .text-red {
        color: red;
    }

    .text-center {
        text-align: center;
    }

    #form_register div.row {
        padding: 5px;
        height: 45px;
    }

    #form_register div.row.* {
        padding: 5px;
        height: 45px;
    }
    </style>
    <!-- <link href="http://localhost/engtest/bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen"> -->
</head>

<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">

        <?= callheader(); ?>
        <div class="row kanit">
            <div class="col-xs-12" style="padding:0px;margin:0px;border-top:1px solid grey;">

                <div style="padding:0px 150px;border:0px solid blue;" class="taviraj">
                    <center>
                        <div id="apDiv69" class="kanit" style="padding-top:20px;">
                            <h2><strong>ลืมรหัสผ่าน</strong></h2><br>
                            <span style="font-size:24px;color:#707070;">กรุณากรอก email address
                                ที่ใช้สมัครสมาชิก</span>
                            <hr style="width:100px;border:2px solid #f7941d" />
                        </div>
                    </center>
                    <div class="text_paragraph">
                        <div class="row">
                            <div class="col-xs-12" id="form_register">
                                <form id='register_form' name='register_form' method=post enctype="multipart/form-data"
                                    action='send_email.php?action=add'>
                                    <div class="row">
                                        <div class="col-xs-10 text-center">

                                            <div class="row">
                                                <div class="col-xs-4">E-mail<b class="text-red"> *</b></div>
                                                <div class="col-xs-8"><input type="email" name="email"
                                                        class="form-control" placeholder="email@example.com"
                                                        required="true" value="<?= $_POST['email']; ?>"></div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 text-center">
                                            <BR>
                                            <button type="submit" id="btnregister" class="btn btn-lg btn-info"
                                                style="border:0px; background:orange !important">Submit Email</button>
                                            <BR><BR>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div id="errortext">
                                                <?php

if ($error['email']) {
    $txt = $error['email'] . '\n';
}
if ($error['sorry']) {
    $txt .= $error['sorry'] . '\n';
}
if ($error['email_more_than']) {
    $txt .= $error['email_more_than'] . '\n';
}
if ($error) {
    echo "<script  type=\"text/javascript\">alert('" . $txt . "');</script>";
}
?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php footer(); ?>