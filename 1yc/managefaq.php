<?php
ob_start();
session_start();
include('../config/connection.php');
date_default_timezone_set('Asia/Bangkok');
if ($_POST && $_SESSION['x_member_1year']) {
	// $sql = config();
	// $connect = connect($sql);
	// $table = $sql[tb_x_faq1year];
	$now = date("Y-m-d H:i:s");
	if ($_POST['faqtopic'] != '' && strlen($_POST['faqtopic']) <= 500) {
		// trim(htmlspecialchars($_POST['faqtopic']))
		// $value = "userId='" . $_SESSION['x_member_1year'] . "',topic='" . trim(htmlspecialchars($_POST['faqtopic'])) . "',status=1,date=NOW() , view=0 ";
		// insert($table, $value);

		$topic = trim(htmlspecialchars($_POST['faqtopic']));
		$status = 1;
		$view = 0;
		$sql = "INSERT INTO tb_x_faq1year (userId, topic, status, date, view) VALUES (?,?,?,?,?)";
		$query = $conn->prepare($sql);
		$query->bind_param("ssisi", $_SESSION['x_member_1year'], $topic, $status, $now, $view);
		$query->execute();
		$query->close();

		// $where = " where  userId='".$_SESSION[x_member_1year]."' ORDER BY faqId DESC LIMIT 0,1 ";
		// $query = select($table,$where);
		// $sqlquery = "SELECT m.fname,f.faqId, f.topic,f.date,f.view
		//                   FROM  tbl_x_faq1year f, tbl_x_member_1year  m
		//                  WHERE m.id =	f.userId && f.userId='" . $_SESSION[x_member_1year] . "' ORDER BY f.faqId DESC  LIMIT 0,1";
		// $query = mysql_query($sqlquery);
		// $data = mysql_fetch_array($query);

		$strSQL = "SELECT m.fname, f.faqId, f.topic, f.date, f.view
				FROM  tb_x_faq1year f, tb_x_member_1year  m
	   			WHERE m.id = f.userId && f.userId = ? ORDER BY f.faqId DESC  LIMIT 0,1";
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("s", $_SESSION['x_member_1year']);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result->fetch_array();

		echo "	<div class='listfaq' id='$data[faqId]'>
			        <p><b>$data[fname]</b></p>
					<div class='txtcontent'>
			        	<a href='1yearcontent.php?section=faq&faqId=$data[faqId]'><p> $data[topic]</p></a>
					</div>
		            <p align=right>" . process_date(strtotime($data['date'])) . "   View [$data[view]]</p>
				</div>";
		$stmt->close();
	}
	else if ($_POST['faqid'] != '' && strlen($_POST['detail']) <= 500) {

		// $table = $sql[tb_x_faq_ans1year];
		// trim(htmlspecialchars($_POST['faqtopic']))
		// $value = "faqId=$_POST[faqid] ,userId='" . $_SESSION['x_member_1year'] . "',detail='" . trim(htmlspecialchars($_POST['detail'])) . "',date=NOW() ";
		// insert($table, $value);

		$faqId = $conn->real_escape_string($_POST['faqid']);
		$detail = $conn->real_escape_string(trim(htmlspecialchars($_POST['detail'])));
		$sql = "INSERT INTO tb_x_faq_ans1year (faqId, userId, detail, date) VALUES (?,?,?,?)";
		$query = $conn->prepare($sql);
		$query->bind_param("ssss", $faqId, $_SESSION['x_member_1year'], $detail, $now);
		$query->execute();
		$query->close();

		// $sqlquery = "SELECT m.fname,f.faqId, f.detail,f.date
		//                   FROM  tbl_x_faq_ans1year f, tbl_x_member_1year  m
		//                  WHERE m.id =	f.userId && f.faqId = $_POST[faqid] ORDER BY f.ansId DESC  LIMIT 0,1 ";
		// $query = mysql_query($sqlquery);
		// $data = mysql_fetch_array($query);

		$SQL = "SELECT m.fname,f.faqId, f.detail,f.date
				FROM  tb_x_faq_ans1year f, tb_x_member_1year  m
	   			WHERE m.id = f.userId && f.faqId = ? ORDER BY f.ansId DESC  LIMIT 0,1 ";
		$stmt = $conn->prepare($SQL);
		$stmt->bind_param("s", $faqId);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result->fetch_array();

		echo " 	<div class='txtcontentsub' style='margin-left:20px;'>
					    <p><b>Answer :</b></p>
			            <p>$data[detail]</p>
						<font style='float:left;'>By : $data[fname]</font><font style='float:right;'>" . process_date(strtotime($data['date'])) . " </font>
						<div class='clear'></div>
				</div>";
		$stmt->close();
	}
	else {
		echo 'NO';
	}
}
mysqli_close($conn);
function process_date($timestamp)
{
	$diff = time() - $timestamp;
	$periods = array("วินาที", "นาที", "ชั่วโมง");
	$word = "ที่แล้ว";
	if ($diff < 60) {
		$i = 0;
		$diff = ($diff == 1) ? "" : $diff;
		$text = "$diff $periods[$i]$word";
	}
	else if ($diff < 3600) {
		$i = 1;
		$diff = round($diff / 60);
		$diff = ($diff == 3 || $diff == 4) ? "" : $diff;
		$text = "$diff $periods[$i]$word";
	}
	else if ($diff < 86400) {
		$i = 2;
		$diff = round($diff / 3600);
		$diff = ($diff != 1) ? $diff : "" . $diff;
		$text = "$diff $periods[$i]$word";
	}
	else if ($diff < 172800) {
		$diff = round($diff / 86400);
		$text = "$diff  วันที่แล้ว เมื่อเวลา " . date("G:i", $timestamp) . " น.";
	}
	else {
		$thMonth = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
		$date = date("j", $timestamp);
		$month = $thMonth[date("m", $timestamp) - 1];
		$y = date("Y", $timestamp) + 543;
		$t1 = "$date $month $y";
		$t2 = "$date $month";
		if ($timestamp > strtotime(date("Y-01-01 00:00:00"))) {
			$text = " เมื่อวันที่ " . $t2 . " เวลา " . date("G:i ", $timestamp) . " น.";
		}
		else {
			$text = " เมื่อวันที่ " . $t1 . " เวลา " . date("G:i ", $timestamp) . " น.";
		}
	}
	return $text;
}
?>