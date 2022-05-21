<?php
ob_start();
session_start();
include('../config/connection.php');
date_default_timezone_set('Asia/Bangkok');

if ($_SESSION["x_member_1year"] != '') {
    // $sql = config();
    // $connect = connect($sql);
    // $table = $sql[tb_x_member_1year];
    // $table = "tb_x_member_1year";
    // $value = " status='0' ";
    // $where = " where  id='" . $_SESSION["x_member_1year"] . "' ";
    // update($table, $value, $where);
    $member_id = $_SESSION["x_member_1year"];
    $status = 0;
    $strSQL = "UPDATE tb_x_member_1year SET status = ? WHERE id = ? ";
    // mysqli_query($conn,$strSQL);

    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("is", $status, $member_id);
    $stmt->execute();
    $stmt->close();
    //------------------update time---------------------//
    // $query = mysql_query("SELECT logid FROM  tbl_x_log_member_1year WHERE id='" . $_SESSION[x_member_1year] . "' ORDER BY logdate DESC LIMIT 0,1");
    // $data = mysql_fetch_array($query);
    // $table = $sql[tbl_x_log_member_1year];
    // $value = " outdate=NOW() ";
    // $where = " WHERE  logid ='$data[logid]' ";
    // update($table, $value, $where);
    $str = "SELECT logid FROM tb_x_log_member_1year WHERE id=? ORDER BY logdate DESC LIMIT 0,1";
    // $query = mysqli_query($conn,$str);
    // $data = mysqli_fetch_array($query);

    $stmt = $conn->prepare($str);
    $stmt->bind_param("s", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array();
    $logid = $data["logid"];
    $stmt->close();

    $smg = "UPDATE tb_x_log_member_1year SET outdate=? WHERE logid=?";
    // mysqli_query($conn,$smg);

    $now = date("Y-m-d H:i:s");
    $query = $conn->prepare($smg);
    $query->bind_param("ss", $now, $logid);
    $query->execute();





}
// logout x_member 

if ($_SESSION["x_member_id"] != '') {
    // $sql = config();
    // $connect = connect($sql);
    // $table = $sql[tb_x_log_member];
    // $query = mysql_query("SELECT id FROM  tbl_x_log_member WHERE member_id='" . $_SESSION[x_member_id] . "' ORDER BY logdate DESC LIMIT 0,1");
    // $data = mysql_fetch_array($query);
    // $value = " outdate=NOW() ";
    // $where = " WHERE  id ='$data[id]' ";
    // update($table, $value, $where);
    $now = date("Y-m-d H:i:s");
    $member_id = $_SESSION["x_member_id"];
    $strSQL = "SELECT id FROM tb_x_log_member WHERE member_id=? ORDER BY logdate DESC LIMIT 0,1";
    // $query = mysqli_query($conn,$strSQL);
    // $data = mysqli_fetch_array($query);

    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array();
    $id = $data["id"];
    $stmt->close();

    $str = "UPDATE tb_x_log_member SET outdate=? WHERE id=?";
    // mysqli_query($conn,$str);

    $query = $conn->prepare($str);
    $query->bind_param("ss", $now, $id);
    $query->execute();
    $query->close();

// echo $_SESSION["x_member_id"]."<br>";
// echo $id."<br>";

}

// log_out_general
if ($_SESSION["y_member_id"] != '' || $_COOKIE["y_member_id"] != '') {
    $now = date("Y-m-d H:i:s");
    $member_id = $_SESSION["y_member_id"] ?? $_COOKIE["y_member_id"];
    $strSQL = "SELECT id FROM tb_x_log_member_general WHERE member_id=? ORDER BY logdate DESC LIMIT 0,1";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array();
    $id = $data["id"];
    $stmt->close();

    $str = "UPDATE tb_x_log_member_general SET outdate=? WHERE id=?";
    $query = $conn->prepare($str);
    $query->bind_param("ss", $now, $id);
    $query->execute();
    $query->close();

    if (isset($_COOKIE['y_member_id'])) {
        $name = 'y_member_id';
        setcookie($name, '', time() - 3600, '/');
    }
    if (isset($_COOKIE['etest'])) {
        $name = 'etest';
        setcookie($name, '', time() - 3600, '/');
    }


}
mysqli_close($conn);
// unset($_SESSION["x_member_id"]);
// unset($_SESSION["x_member_1year"]);

// Unset all of the session variables
$_SESSION = [];

// Delete the session cookie
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}
session_destroy();

header("Location: ../index.php");
exit;

?>