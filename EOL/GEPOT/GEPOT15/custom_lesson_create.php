<?php
ob_start();
include('../config/connection.php');
$method = $_GET['method'];

$lessonId = $conn->real_escape_string(trim($_GET['lessonid']));
if ($method == "delete") {
    // $data = $lesson_obj->deleteLesson($_GET['lessonid']);
    $strSQL = "DELETE FROM tb_lesson_custom WHERE createdby = ? && lesson_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss",$_SESSION['x_member_id'],$lessonId);
    $stmt->execute();
    $stmt->close();
    header('Location: eoltest.php?section=business&status=e-test&action=view_lesson');
} elseif ($method == "edit") {
    $title = "แก้ไขบทเรียนแบบกำหนดเอง";
    // $lessonId = $_GET['lessonid'];
    // $data = $lesson_obj->getLesson($_SESSION['x_member_id'], $_GET['lessonid']);
    $strSQL = "SELECT * FROM tb_lesson_custom WHERE createdby = ? && lesson_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss",$_SESSION['x_member_id'],$lessonId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array();
    $stmt->close();
} elseif (($_POST['method'] == "create") && ((trim($_POST['lesson_name']) <> "") || (trim($_POST['lesson_content']) <> ""))) {
    //echo "Insert Content";
    // $data = $lesson_obj->addLesson(trim($_POST['lesson_name']), trim($_POST['lesson_content']));
    $active = 0;
    $now = date("Y-m-d H:i:s");
    $lesson_name = $conn->real_escape_string(trim($_POST['lesson_name']));
    $lesson_content = trim($_POST['lesson_content']);
    $strSQL = "INSERT INTO tb_lesson_custom (lesson_name, lesson_content, active, createdby, createddate, modifiedby, modifieddate) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ssissss", $lesson_name, $lesson_content, $active, $_SESSION['x_member_id'] , $now, $_SESSION['x_member_id'],$now);
    $stmt->execute();
    $stmt->close();
    header('Location: eoltest.php?section=business&status=e-test&action=view_lesson');
} elseif (($_POST['method'] == "edit") && ((trim($_POST['lesson_name']) <> "") || (trim($_POST['lesson_content']) <> ""))) {
    // $data = $lesson_obj->editLesson($_POST['lesson_id'],trim($_POST['lesson_name']), trim($_POST['lesson_content']));
    $now = date("Y-m-d H:i:s");
    $lesson_id = $conn->real_escape_string(trim($_POST['lesson_id']));
    $lesson_name = $conn->real_escape_string(trim($_POST['lesson_name']));
    $lesson_content = trim($_POST['lesson_content']);
    $strSQL = "UPDATE tb_lesson_custom SET lesson_name = ?, lesson_content = ?, modifiedby = ?, modifieddate = ? WHERE createdby = ? && lesson_id = ? ";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ssssss",$lesson_name,$lesson_content,$_SESSION['x_member_id'],$now,$_SESSION['x_member_id'],$lesson_id);
    $stmt->execute();
    header('Location: eoltest.php?section=business&status=e-test&action=view_lesson');
} else {
    $method = "create";
    $title = "สร้างบทเรียนแบบกำหนดเอง";
}
// $lesson_obj->dbClose();
mysqli_close($conn);
if ($title == "") {
    exit();
}
?>
<!-- <link href='http://localhost/engtest/bootstrap/css/bootstrap.min.css' rel='stylesheet'> -->
<!-- <link href='https://www.engtest.net/css/bootstrap.min.css' rel='stylesheet'> -->
<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
<link href="http://localhost/engtest/bootstrap/css/custom_lesson.css" rel="stylesheet">

<!-- <script type="text/javascript" src="https://www.engtest.net/ckeditor/ckeditor.js"></script> -->

<!-- <script src="https://cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script> -->

<div id='create_lesson'>
    <a href='?section=business&status=e-test&action=view_lesson'>
        <button id='add' class='bnt-etest btn-lesson'> • บทเรียนทั้งหมด</button>
    </a>
    <form method='post' action='eoltest.php?section=business&status=e-test&action=create_lesson' id="frm_create_lesson">
        <input type="hidden" id="method" name="method" value="<?= $method; ?>">
        <input type="hidden" id="lesson_id" name="lesson_id" value="<?= $lessonId; ?>">
        <table border=0 class='create_custom tbl_create_custom' align=center bgcolor=#F2F2F2
            style="width:100% !important;">
            <tr>
                <td colspan="2">
                    <center><b>
                            <h3 style='color:#000000;' class="kanit"><?= $title; ?></h3>
                        </b></center>
                    <div align='left'>
                        <font color=blue><b><u>ข้อกำหนด</u></b></font><br>
                        <font color='blue' align='left'>ห้ามละเมิดลิขสิทธิ์ผู้อื่น มีความผิดตามกฎหมายและบริษัท
                            อิงลิชออนไลน์ จำกัด จะไม่รับผิดชอบการกระทำใดๆทั้งสิ้น<br>
                            และสงวนสิทธิ์ในการตรวจสอบพร้อมทั้งแก้ไขบทเรียนแบบกำหนดเองโดยไม่ต้องแจ้งให้ทราบล่วงหน้า
                        </font>
                    </div><br>
                </td>
            </tr>
            <tr>
                <td style='width:130px;'>หัวข้อบทเรียน </td>
                <td style=''><input type='text' name='lesson_name' class='form-control' maxlength='100' required
                        style='width:100% !important;margin-left:-5px;'
                        value="<?= str_replace('"','&#34;',$data['lesson_name']); ?>" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div>เนื้อหา</div>
                    <textarea id='lesson_content' name='lesson_content' class='form-control' placeholder=''
                        rows='15'><?= $data['lesson_content']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:left;">
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript" src="http://localhost/engtest/js/ckeditor/ckeditor.js"></script>

<!-- <script src="//cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script> -->
<script type="text/javascript">
CKEDITOR.replace('lesson_content');
// CKEDITOR.on('instanceReady', function(ev) {
//     ev.editor.dataProcessor.writer.selfClosingEnd = '>';
// });
</script>

<?php
?>