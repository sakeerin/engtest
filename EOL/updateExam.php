<?php
include('../config/connection.php');
session_start();
if (isset($_POST['save'])) 
{
	$exam_id = $conn->real_escape_string(trim($_POST['examid']));
	if ($_POST['examname'] == '' || $_POST['time'] == '') {
		$message = 'โปรดกรอกข้อมูลให้ครบถ้วน';
	}
	else {

		$exam_name = $conn->real_escape_string(trim($_POST['examname']));
		$testtime = $conn->real_escape_string(trim($_POST['time']));
		$exam_type = $conn->real_escape_string(trim($_POST['exam_type']));
		if (isset($_POST['exam_active'])) {
			$active = $conn->real_escape_string(trim($_POST['exam_active']));
		}
		else {
			$active = '0';
		}
		// $table = 'tbl_eventest';
		// $set = array('exam_name' => $_POST['examname'], 'testtime' => $_POST['time'], 'test_type' => $_POST['exam_type'], 'active' => $active);
		// $where = array('exam_id' => $exam_id);
		// $exam->updateExam($table, $set, $where);
		// $exam->deleteGroup($exam_id);
		//$exam = new Exam();

		$strSQL = "UPDATE tb_eventest SET exam_name = ?, testtime = ?, test_type = ?, active = ?  WHERE exam_id = ?";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("sssss", $exam_name, $testtime, $exam_type, $active, $exam_id);
		$stmt->execute();
		$stmt->close();

		$sql = "DELETE FROM tb_eventest_allowgroup WHERE exam_id = ?";
		$query = $conn->prepare($sql);
		$query->bind_param("s", $exam_id);
		$query->execute();
		$query->close();

		$date = date('Y-m-d H:i:s');
		$numgroup = count($_POST['allowgroup']);
		$group = $_POST['allowgroup'];

		for ($i = 0; $i < $numgroup; $i++) {
			// $vars = array('exam_id' => $exam_id,
			// 	'group_type' => $group[$i],
			// 	'create_date' => $date);
			// $exam->insertGroup($vars);

			$group_type = $group[$i];
			if ($group_type == 1)
				continue;

			$str = "INSERT INTO tb_eventest_allowgroup (exam_id, group_type, create_date) VALUES (?,?,?)";
			$sub_stmt = $conn->prepare($str);
			$sub_stmt->bind_param("sss", $exam_id, $group_type, $date);
			$sub_stmt->execute();
			$sub_stmt->close();
		}
		mysqli_close($conn);

	}


}
if (isset($_GET['del_exam'])) 
{
	// $delexam = new Exam();
	$examId = $conn->real_escape_string(trim($_GET['del_exam']));
	$Id = $conn->real_escape_string(trim($_GET['id']));

	if ($_SESSION['admin_id']) {

		// if ($delexam->deleteExam($examId, $Id)) {
		// 	header("Location:../mainoffice.php?section=office&&status=list&&type=19-01");
		// }

		$strSQL = "DELETE FROM tb_eventest WHERE exam_id = ? && create_by = ?";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("ss", $examId, $Id);
		$stmt->execute();
		$stmt->close();
		header("Location:../mainoffice.php?section=office&&status=list&&type=19-01");
	}
	elseif ($_SESSION['x_member_id']) {
		// if ($delexam->deleteExam($examId, $_SESSION['x_member_id'])) {
		// 	header("Location:?section=business&status=e-test");
		// }

		$strSQL = "DELETE FROM tb_eventest WHERE exam_id = ? && create_by = ?";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("ss", $examId, $_SESSION['x_member_id']);
		$stmt->execute();
		$stmt->close();
		header("Location:?section=business&&status=e-test");
	}
	else {
		$message = 'การลบข้อสอบมีข้อผิดพลาด';
	}
	// $exam->dbClose();	
	mysqli_close($conn);
}
?>