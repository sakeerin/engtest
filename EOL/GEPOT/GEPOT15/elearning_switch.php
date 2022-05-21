<?php
ob_start();
session_start();
include('../config/connection.php');
$_GET['section'] = $_GET['section'] ?? "elearning";
//-------------------------------------------------------------------------------------------------//
if ($_GET['skill_id'] >= 1 && $_GET['reason_id'] >= 1) {

    $skill_id = $conn->real_escape_string($_GET['skill_id']);
    $reason_id = $conn->real_escape_string($_GET['reason_id']);
    $strSQL = "SELECT * FROM tb_e_switch WHERE SKILL_ID = ? && DETAIL_ID = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $skill_id, $reason_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->num_rows;
    //echo "Both <br>";
    if ($rows == 1) {

        $data = $result->fetch_array();
        $topic_id = $data['TOPIC_ID'];

        header("Location:../lessons/elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1&&topic_id=$topic_id");
        exit();
    }
    else {
        // echo "is work";
        header("Location:../lessons/elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1");
        exit();
    }
}
else {
    if ($_GET['skill_id'] >= 1) {
        // echo "Only Skill<br>";
        header("Location:../lessons/elearning.php?section=$_GET[section]&&skill_id=$_GET[skill_id]&&level_id=1");
        exit();
    }
    else {
        // echo "None <br><br>";
        header("Location:../lessons/elearning.php");
        exit();
    }
}
//-------------------------------------------------------------------------------------------------//
?>