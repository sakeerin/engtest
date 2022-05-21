<?php
ob_start();
include('../config/connection.php');

// $lesson_obj = new CustomLesson();
// $data = $lesson_obj->getRowLessonList($_SESSION['x_member_id']);
// $count = $data['row_record'];

$strSQL = "SELECT count(1) AS row_record FROM tb_lesson_custom WHERE createdby = ? ORDER BY createddate";
$stmt = $conn->prepare($strSQL);
$stmt->bind_param("s", $_SESSION['x_member_id']);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_array();
$count = $data['row_record'];
$stmt->close();
if ($count > 0) {
    if ($count > 1) {
        // $data = $lesson_obj->getLessonListAll($_SESSION['x_member_id']);

        $strSQL = "SELECT * FROM tb_lesson_custom WHERE createdby = ? ORDER BY createddate";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_SESSION['x_member_id']);
        $stmt->execute();
        $result_lesson = $stmt->get_result();

    }
    else {
        // $data[] = $lesson_obj->getLessonListAll($_SESSION['x_member_id']);

        $strSQL = "SELECT * FROM tb_lesson_custom WHERE createdby = ? ORDER BY createddate";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_SESSION['x_member_id']);
        $stmt->execute();
        $result_lesson = $stmt->get_result();
    }
}


if ($_GET['method'] == "active") {
    // $data = $lesson_obj->setLessonActive($_GET['lessonid']); //	 print_r($data);

    $lessonId = $conn->real_escape_string(trim($_GET['lessonid']));
    $strSQL = "SELECT active FROM tb_lesson_custom WHERE createdby = ? && lesson_id = ?";
    $query = $conn->prepare($strSQL);
    $query->bind_param("ss", $_SESSION['x_member_id'], $lessonId);
    $query->execute();
    $result = $query->get_result();
    $record = $result->fetch_array();
    $active = ($record['active'] == 0) ? 1 : 0;

    $str = "UPDATE tb_lesson_custom SET active = ? WHERE createdby = ? && lesson_id = ?";
    $sub_query = $conn->prepare($str);
    $sub_query->bind_param("iss", $active, $_SESSION['x_member_id'], $lessonId);
    $sub_query->execute();
    header('Location: eoltest.php?section=business&status=e-test&action=view_lesson');

}
mysqli_close($conn);
?>
<!-- <link href='https://www.engtest.net/css/bootstrap.min.css' rel='stylesheet'> -->

<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
<link href="http://localhost/engtest/bootstrap/css/custom_lesson.css" rel="stylesheet">


<div id="view_lesson" style="min-height:350px;">
    <div class="pull-right">
        <a href='?section=business&status=e-test&action=create_lesson'>
            <button id='add' class='bnt-etest btn-lesson'> + สร้างบทเรียนแบบกำหนดเอง</button>
        </a>
    </div>
    <table class="table table-hover table-bordered table-stripped" id="table-viewlesson" border="1">
        <thead>
            <tr>
                <th style="width:40px;">ลำดับ</th>
                <th style="wdith:300px;">หัวข้อบทเรียน</th>
                <th style="width:150px;">วันที่สร้าง</th>
                <th style="width:50px;">สถานะ</th>
                <th style="width:150px;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
while ($data = $result_lesson->fetch_assoc()) { ?>
            <tr>
                <td class="text-center"><?=($i); ?></td>
                <td><?= $data['lesson_name']; ?></td>
                <td class="text-center"><?= date("d/m/Y", strtotime($data['createddate'])); ?></td>
                <td class="text-center">
                    <a
                        href='?section=business&status=e-test&action=view_lesson&method=active&lessonid=<?= $data['lesson_id']; ?>'><?=($data['active']) ? "แสดง" : "ซ่อน"; ?></a>
                </td>
                <td class="text-center">
                    <a href='?section=business&status=e-test&action=edit_lesson&method=edit&lessonid=<?= $data['lesson_id']; ?>'
                        class="btn btn-sm btn-warning"> แก้ไข</a>
                    <a href='?section=business&status=e-test&action=delete_lesson&method=delete&lessonid=<?= $data['lesson_id']; ?>'
                        class="btn btn-sm btn-danger"> ลบ</a>
                </td>
            </tr>
            <?php
    $i++;
}
$stmt->close();
?>
        </tbody>
    </table>
</div>