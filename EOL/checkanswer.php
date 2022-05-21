<?php
session_start();
// error_reporting(E_ALL);
// class checkAnswer
// {
// 	public $link;
// 	function __construct($db)
// 	{
// 		return $this->link = $db;
// 	}

// 	function checkAnswer($answerId, $questionId, $examtype)
// 	{
// 		if ($examtype == 1) {
// 			$where = array('ANSWERS_ID' => $answerId, 'QUESTIONS_ID' => $questionId, 'ANSWERS_CORRECT' => 1);
// 			$this->link->Select('tbl_answers', $where);
// 		}
// 		else {
// 			$where = array('answer_id' => $answerId, 'question_id' => $questionId, 'answer' => 1);
// 			$this->link->Select('tbl_eventest_answer', $where);
// 		}
// 		return $this->link->records;
// 	}

// 	function recordAnswer($answerId, $questionId)
// 	{
// 		$_SESSION[ans][$questionId] = NULL; // clear Old Answer
// 		if ($questionId) {
// 			$_SESSION[ans][$questionId] = $answerId;
// 		}
// 	}


// }

/*---- End Class -------*/

if (isset($_POST['checkanswer']) && $_POST['checkanswer'] === 'checkAns') // Check Post value  from  Ajax
{
	// $db = new DB();
	// $check = new checkAnswer($db);
	include('../config/connection.php');
	$quezid = $_SESSION['quiz_id'][$_POST['questionId']];
	// $answer = $check->checkAnswer($_POST['answerId'], $quezid, $_SESSION['exam_type']);
	$is_correct = '1';

	if ($_SESSION['exam_type'] == 1) {
		$strSQL = "SELECT * FROM tb_answers WHERE ANSWERS_ID = ? && QUESTIONS_ID = ? && ANSWERS_CORRECT = ? ";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("sss", $_POST['answerId'], $quezid, $is_correct);
		$stmt->execute();
		$result = $stmt->get_result();
		$answer = $result->num_rows;
		$stmt->close();
	}
	else {
		$strSQL = "SELECT * FROM tb_eventest_answer WHERE answer_id = ? && question_id = ? && answer = ? ";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("sss", $_POST['answerId'], $quezid, $is_correct);
		$stmt->execute();
		$result = $stmt->get_result();
		$answer = $result->num_rows;
		$stmt->close();
	}




	recordAnswer($_POST['answerId'], $_POST['questionId']);

	if ($answer == 1) {
		$_SESSION['score'] = intval($_SESSION['score']) + 1;
		echo $_SESSION['score'];
	}
	else {
		exit();
	// echo '';
	}

	// $db->CloseConnection();
	// $stmt->close();
	mysqli_close($conn);
// unset($check); // Clear memory varible
// unset($db); // Clear memory varible
}

function recordAnswer($answerId, $questionId)
{
	$_SESSION['ans'][$questionId] = NULL; // clear Old Answer
	if ($questionId) {
		$_SESSION['ans'][$questionId] = $answerId;
	}
}
?>