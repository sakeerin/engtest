<?php
ob_start();
session_start();
include('../config/connection.php');
date_default_timezone_set('Asia/Bangkok');
class info
{

    public function loadinfo($txtOpt)
    {
        include('./config/connection.php');
        include('../config/connection.php');
        //----------------------------------------------------------------//
        if ($_SESSION["x_member_id"]) {

            $member_id = $conn->real_escape_string($_SESSION["x_member_id"]);
            $strSQL = "SELECT * FROM tb_x_member WHERE member_id=?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $member_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $is_ok = $result->num_rows;

            if ($is_ok == 1) {
                $data = $result->fetch_array();
                $gender = $data["gender"];
                $fname = $data["fname"];
                $lname = $data["lname"];
                //--------------switch option menu--------------//

                $msg_image = "http://localhost/engtest/2010/member_images/" . $member_id . ".jpg";
                $data_image = @getimagesize($msg_image);
                //image profile from database
                if ($data_image[0] >= 1 && $data_image[0] - $data_image[0] == 0) {
                    $image_name = $member_id . ".jpg";
                    if ($data_image[1] >= 100) {
                        $height = 100;
                    }
                    else {
                        $height = $data_image[1];
                    }
                }
                else { // no image profile 
                    if ($gender == 0) {
                        $gender = 1;
                    }

                    $msg_image = "https://www.engtest.net/2010/member_images/icon_user_0" . $gender . ".jpg";
                    $height = 100;
                }


?>
<div style="display:inline-block;border:0px solid blue;vertical-align: center !important;">
    <img src="<?= $msg_image; ?>" style="width:54px;height:54px; border-radius:20px;" />
</div>
<div
    style="display:inline-block;border:0px solid blue;line-height:20px;vertical-align: top !important;padding:2px 10px;">
    <span class="bold font-tahoma"
        style="font-size:20px;"><?= $fname . '&nbsp;&nbsp;&nbsp;&nbsp;' . $lname; ?></span><BR>
    <span class="bold font-tahoma text-white"><?= $this->profile($this->check_master()); ?></span>
</div>
<div style="display:inline-block;border:0px solid blue;vertical-align: top !important;">
    <a href="http://localhost/engtest/EOL/eoltest.php">
        <img src="https://www.engtest.net/image2/mainpage/button/enter eol-03.png"
            style="height: 64px;width: 64px; margin-top:-5px;" /></a>
</div>
<div style="display:inline-block;border:0px solid blue;vertical-align: top !important;">
    <a href="http://localhost/engtest/inc/logout.php">
        <img src="https://www.engtest.net/image2/eol system/button/logout-06.png"
            style="max-height: 54px;max-width: 100px;" /></a>
</div>


<?php
                $stmt->close();
            }
        }
        else { // NO Login
            // check form for normal page or test page 
            // echo "Don't have member id!!!";
            if ($txtOpt == 'normal') {
?>
<form method=post action="http://localhost/engtest/inc/login.php">
    <div style="display:inline-block;border:0px solid blue;line-height:8px;vertical-align: top !important;">
        <input type="text" tabindex="1" name="x_user" id="x_user" class="form-control" style="width:180px;"
            placeholder="Username" required><BR>
        <a href="http://localhost/engtest/register/register_account.php" class="over_a" id="signup">
            <span style="font-size:14px;color:#ffffff;">Sign Up / Register</span>
        </a>
    </div>
    <div style="display:inline-block;border:0px solid blue;line-height:8px;vertical-align: top !important;">
        <input type="password" tabindex="2" name="x_pass" id="x_pass" class="form-control" style="width:180px;"
            placeholder="Password" autocomplete="on" required><BR>
        <a href="https://www.engtest.net/forgot_pwd/setpass.php" class="over_a" id="forgot">
            <span style="font-size:14px;color:#ffffff;">Forgot Password?</span>
        </a>
    </div>
    <div style="display:inline-block;vertical-align: top !important;">
        <input type="submit" tabindex="3" id="login" class="btn"
            style="width:80px;background:#f75b1e !important;color:#ffffff;" value="LOGIN">
    </div>
</form>
<?php
            }

        }
        //----------------------------------------------------------------//
        mysqli_close($conn);
    //----------------------------------------------------------------//
    }

    // public function checktime() {
    //     return 'OK';
    // }

    private function check_master()
    {
        include('./config/connection.php');
        include('../config/connection.php');
        $type = "";
        if ($_SESSION["x_member_id"]) {
            $member_id = $conn->real_escape_string($_SESSION["x_member_id"]);
        }

        $strSQL = "SELECT * FROM tb_x_member_amount WHERE member_id=?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $is_ok = $result->num_rows;
        $stmt->close();
        // if corporate user
        if ($is_ok == 1) {
            $type = "master";
        }

        // check if personal user
        if ($is_ok == 0) {
            $strSQL = "SELECT * FROM tb_x_member WHERE member_id=?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $member_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $is_member = $result->num_rows;
            $stmt->close();

            if ($is_member == 1) {
                $type = "personal";
                $refill = 0;
                $number = 1;
                //---------------------------------------------------------------------------------------//

                $msg = "SELECT a.sub_id,a.master_id,b.amount FROM tb_x_member_sub AS a,tb_x_member_amount AS b WHERE a.sub_id=? && a.master_id=b.member_id && b.amount >= ? && a.status=?";
                $query = $conn->prepare($msg);
                $query->bind_param("sii", $member_id, $number, $number);
                $query->execute();
                $result = $query->get_result();
                $is_sub = $result->num_rows;

                // check subuser 
                if ($is_sub == 1) {
                    $data = $result->fetch_array();
                    $master_id = $data["master_id"];
                    $sub_id = $data["sub_id"];
                    $amount = $data["amount"];
                    $query->close();
                    //---------------------------------------------------------------------------------------//
                    $now = date("Y-m-d H:i:s");
                    $strSQL = "SELECT * FROM tb_x_member_time WHERE member_id=? && started_date<=? && stop_date>=?";
                    $stmt = $conn->prepare($strSQL);
                    $stmt->bind_param("sss", $member_id, $now, $now);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $is_available = $result->num_rows;
                    $stmt->close();

                    if ($is_available == 0) {
                        $k = 1;
                        //--------------------------------------------------------------------------------//

                        $msg = "SELECT * FROM tb_x_member_spacial WHERE member_id=? && started_date <= ? && stop_date >= ?";
                        $query = $conn->prepare($msg);
                        $query->bind_param("sss", $master_id, $now, $now);
                        $query->execute();
                        $result = $query->get_result();
                        $is_sp = $result->num_rows;
                        $query->close();

                        if ($is_sp == 1) {
                            $k = 0;
                        }
                        //--------------------------------------------------------------------------------//

                        $remaining_time = $amount - $k;
                        $strSQL = "UPDATE tb_x_member_amount SET amount=? WHERE member_id =?";
                        $sub_query = $conn->prepare($strSQL);
                        $sub_query->bind_param("is", $remaining_time, $master_id);
                        $sub_query->execute();
                        $sub_query->close();
                        //----------------------//
                        $start = date("Y-m-d H:i:s");
                        $stop = date("Y-m-d H:i:s", time() + (60 * 60 * 24 * 1));
                        $card_id = 0;
                        $sql = "INSERT INTO tb_x_member_time (member_id, card_id, started_date, stop_date, create_date) VALUES (?,?,?,?,?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sisss", $member_id, $card_id, $start, $stop, $start);
                        $stmt->execute();
                        $stmt->close();

                        $refill = 1;
                    //----------------------//
                    }
                //---------------------------------------------------------------------------------------//
                }
                // check personal user
                if ($refill == 0) {

                    $strSQL = "SELECT * FROM tb_x_member_total WHERE member_id=? && amount >= '1' ";
                    $sub_stmt = $conn->prepare($strSQL);
                    $sub_stmt->bind_param("s", $member_id);
                    $sub_stmt->execute();
                    $result = $sub_stmt->get_result();
                    $is_have = $result->num_rows;
                    $sub_stmt->close();
                    if ($is_have == 1) {
                        //---------------------------------------------------------------------------------------//
                        $now = date("Y-m-d H:i:s");
                        $msg = "SELECT * FROM tb_x_member_time WHERE member_id=? && started_date <= ? && stop_date >= ?";
                        $query = $conn->prepare($msg);
                        $query->bind_param("sss", $member_id, $now, $now);
                        $query->execute();
                        $result = $query->get_result();
                        $is_available = $result->num_rows;
                        $query->close();
                        if ($is_available == 0) {
                            $strSQL = " UPDATE tb_x_member_total SET amount=(amount-1) WHERE member_id=? ";
                            $stmt = $conn->prepare($strSQL);
                            $stmt->bind_param("s", $member_id);
                            $stmt->execute();
                            $stmt->close();
                            //----------------------//
                            $start = date("Y-m-d H:i:s");
                            $stop = date("Y-m-d H:i:s", time() + (60 * 60 * 24 * 1));
                            $card_id = -1;
                            $sql = "INSERT INTO tb_x_member_time (member_id, card_id, started_date, stop_date, create_date) VALUES (?,?,?,?,?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("sisss", $member_id, $card_id, $start, $stop, $start);
                            $stmt->execute();
                            $stmt->close();
                        //----------------------//
                        }
                    //---------------------------------------------------------------------------------------//
                    }
                }
            //---------------------------------------------------------------------------------------//
            }
        }

        if (!trim($type)) {
            session_destroy();
            header("Location:?section=$_GET[section]");
        }
        mysqli_close($conn);
        return $type;
    }

    public function profile($check_master)
    {
        include('./config/connection.php');
        include('../config/connection.php');
        //-------------------------------------------------------//

        if ($_SESSION["x_member_id"]) {
            $member_id = $conn->real_escape_string($_SESSION["x_member_id"]);
        }
        $strSQL = "SELECT * FROM tb_x_member WHERE member_id=?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $is_have = $result->num_rows;

        if ($is_have == 1) {
            $data = $result->fetch_array();
            $fname = $data["fname"];
            $lname = $data["lname"];
            $stmt->close();
            if (($_GET["status"] != "edit_profile" || $_GET["status"] != "edit_profile" || $_GET["status"] != "edit_profile") && !trim($fname) && !trim($lname)) {
                $profile_display = 0;
                header("Location:?section=$_GET[section]&&status=edit_profile");
            }
            else {
                if (!trim($fname) && !trim($lname)) {
                    $profile_display = 0;
                }
                else {
                    $profile_display = 1;
                }
            }
            if ($profile_display == 1) {
                $now = date("Y-m-d H:i:s");
                if ($check_master == "personal") {
                    $msg = "SELECT * FROM tb_x_member_time WHERE member_id=? && stop_date >= ? ORDER BY stop_date DESC LIMIT 0,1 ";
                    $query = $conn->prepare($msg);
                    $query->bind_param("ss", $member_id, $now);
                    $query->execute();
                    $result = $query->get_result();
                    $is_have = $result->num_rows;
                    if ($is_have == 1) {
                        $data = $result->fetch_array();
                        $stop = $data["stop_date"];
                        $msg_air_time = "Available Time : $stop";
                    }
                    else {

                        $strSQL = "SELECT * FROM tb_x_member_time WHERE member_id=? ORDER BY stop_date DESC LIMIT 0,1 ";
                        $stmt = $conn->prepare($strSQL);
                        $stmt->bind_param("s", $member_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $sub_have = $result->num_rows;
                        if ($sub_have == 1) {
                            $data = $result->fetch_array();
                            $stop = $data["stop_date"];
                            $msg_air_time = "Available Time : $stop ";
                        }
                        else {
                            $msg_air_time = "Available Time : - ";
                        }
                    }

                    $msg = "SELECT * FROM tb_x_member_total WHERE member_id=?";
                    $stmt = $conn->prepare($msg);
                    $stmt->bind_param("s", $member_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $is_have = $result->num_rows;
                    if ($is_have == 1) {
                        $total_data = $result->fetch_array();
                        $available = $total_data["amount"];
                        if ($total_data["amount"] >= 1) {
                            $total_msg = "Total Available Day : $available days";
                        }
                        if ($total_data["amount"] == 0) {
                            $total_msg = "Total Available Day : $available days";
                        }
                    }
                    if ($is_have == 0) {
                        $total_msg = "Total Available Day : 0 days";
                    }
                    $query->close();
                    $stmt->close();
                    $text = $msg_air_time . "<BR>" . $total_msg;
                }
                if ($check_master == "master") {

                    $strSQL = "SELECT * FROM tb_x_member_amount WHERE member_id=?";
                    $query = $conn->prepare($strSQL);
                    $query->bind_param("s", $member_id);
                    $query->execute();
                    $result = $query->get_result();
                    $is_have = $result->num_rows;
                    if ($is_have == 1) {
                        $data = $result->fetch_array();
                        $amount = $data["amount"];
                        $msg_air_time = " <b><font size=2 face=tahoma color=white>Available Amount : $amount Day(s)</font></b>";
                        //-----------------------------------------------------------------------------------------//

                        $msg = "SELECT * FROM tb_x_member_spacial WHERE member_id=? && started_date <= ? && stop_date >= ? ";
                        $stmt = $conn->prepare($msg);
                        $stmt->bind_param("sss", $member_id, $now, $now);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $is_sp = $result->num_rows;
                        if ($is_sp == 1) {
                            $data = $result->fetch_array();
                            $start = $data["started_date"];
                            $stop = $data["stop_date"];
                            $max_amount = $data["amount"];
                            $stmt->close();

                            $strSQL = "SELECT sub_id FROM tb_x_member_sub WHERE master_id=?";
                            $sub_stmt = $conn->prepare($strSQL);
                            $sub_stmt->bind_param("s", $member_id);
                            $sub_stmt->execute();
                            $result = $sub_stmt->get_result();
                            $all_sub = $result->num_rows;
                            $sub_stmt->close();
                            $msg_air_time = "Available From :  $start <br> Available Until : $stop <br> Sub Account Amount : $all_sub / $max_amount ";
                        }
                        //-----------------------------------------------------------------------------------------//

                        $msg = "SELECT * FROM tb_x_member_spacial WHERE member_id=? && ( started_date > ? || stop_date < ?) ";
                        $sub_query = $conn->prepare($msg);
                        $sub_query->bind_param("sss", $member_id, $now, $now);
                        $sub_query->execute();
                        $result = $sub_query->get_result();
                        $is_sp = $result->num_rows;
                        if ($is_sp == 1) {
                            $data = $result->fetch_array();
                            $start = $data["started_date"];
                            $stop = $data["stop_date"];
                            $max_amount = $data["amount"];
                            $sub_query->close();

                            $msg_query = "SELECT sub_id FROM tb_x_member_sub WHERE master_id=? ";
                            $stmt_query = $conn->prepare($msg_query);
                            $stmt_query->bind_param("s", $member_id);
                            $stmt_query->execute();
                            $result = $stmt_query->get_result();
                            $all_sub = $result->num_rows;
                            $stmt_query->close();
                            $msg_air_time = "Available From :  $start <br> Available Until : $stop <br>Sub Account Amount : $all_sub / $max_amount";
                        }
                    //-----------------------------------------------------------------------------------------//
                    }
                    $text = $msg_air_time;
                }

            }
        }
        //-------------------------------------------------------//
        mysqli_close($conn);
        return $text;
    }

}
?>