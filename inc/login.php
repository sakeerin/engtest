<?php
ob_start();
session_cache_expire(30);
session_start();
include('../config/connection.php');
if (trim($_POST["x_user"]) && trim($_POST["x_pass"])) 
{
	// echo "Section A";
	// if($_SESSION["x_member_1year"]!='' ){
	//    header("Location:../1yearcourse.php");
	//    exit();
	// }
	//----------------connect databae------------------//
	date_default_timezone_set('Asia/Bangkok');
	$date = date("Y-m-d H:i:s");
	$enddate = date("Y-m-d H:i:s", strtotime("-30 minute", strtotime($date)));
	//$enddate = date ("Y-m-d H:i:s", strtotime());
	// set status user 
	// $table = $sql[tb_x_member_1year];	
	// $value = " status=0 ";		
	// $where = " where  time_login<='$enddate' ";
	// update($table,$value,$where);

	// $strSQL = "UPDATE tb_x_member_1year SET status=0 WHERE time_login <= '$enddate'";
	// mysqli_query($conn,$strSQL);


	//-----------------query--x member-1year-------------// 
	// $table = $sql[tb_x_member_1year];			
	// $where = " where user='$_POST[x_user]' && pass='$_POST[x_pass]' && status=0 ";
	// $query = select($table,$where);		
	// $is_ok = mysql_num_rows($query);

	$user = $conn->real_escape_string($_POST["x_user"]);
	$pwd = $conn->real_escape_string($_POST["x_pass"]);
	$status = 0;

	$msg = "SELECT * FROM tb_x_member_1year WHERE user=? && pass=? && status=? ";
	// $query = mysqli_query($conn,$msg);
	// $is_ok = mysqli_num_rows($query);

	$stmt = $conn->prepare($msg);
	$stmt->bind_param("ssi", $user, $pwd, $status);
	$stmt->execute();
	$result = $stmt->get_result();
	$is_ok = $result->num_rows;
	if ($is_ok == 1) //---if member ture---//
	{
		//echo "Yes : 1 Year <br>";	// 2015-05-18 test login
		echo "Section B 1 year<br>";
		$data = $result->fetch_array();
		$member_id = $data["id"];
		$member_user = $data["user"];
		$member_pass = $data["pass"];
		$stmt->close();
		//$member_active = $data[active];
		$now = date("Y-m-d H:i:s");

		if ($data["active"] == 1) {
			// $value = " status=1,time_login=NOW() ";		
			// $where = " where id='$member_id' ";
			// update($table,$value,$where);
			echo "Section C 1 year<br>";
			// $now = date("Y-m-d H:i:s");
			$status = 1;
			$strSQL = "UPDATE tb_x_member_1year SET status=?, time_login=? WHERE id=? ";
			// mysqli_query($conn,$strSQL);

			$query = $conn->prepare($strSQL);
			$query->bind_param("iss", $status, $now, $member_id);
			$query->execute();
			$query->close();

		}
		if ($data["active"] == 0) {
			// $now = date("Y-m-d H:i:s");
			$date = date("Y-m-d H:i:s");
			$enddate = date("Y-m-d H:i:s", strtotime("+1 year +4 week", strtotime($date)));

			// $value = " status=1,active=1 , startdate='$date' ,enddate='$enddate',time_login=NOW() , admin=0 ";		
			// $where = " where id='$member_id' ";
			// update($table,$value,$where);
			echo "Section D 1 year<br>";
			$status = 1;
			$active = 1;
			$admin = 0;
			$str = "UPDATE tb_x_member_1year SET status=?, active=?, startdate=?, enddate=?, time_login=?, admin=? WHERE id=? ";
			// mysqli_query($conn,$str);

			$query = $conn->prepare($str);
			$query->bind_param("iisssis", $status, $active, $date, $enddate, $now, $admin, $member_id);
			$query->execute();
			$query->close();
		}

		//------ insert logtime member 1year-----//
		// $table = $sql[tbl_x_log_member_1year];
		// $value = " id='$member_id' , logdate=NOW() , outdate=NOW() ";	
		// insert($table,$value);

		$sql = "INSERT INTO tb_x_log_member_1year (id, logdate, outdate) VALUES (?,?,?)";
		// mysqli_query($conn,$sql);

		$query = $conn->prepare($sql);
		$query->bind_param("sss", $member_id, $now, $now);
		$query->execute();
		$query->close();
		//------ insert logtime member 1year-----//

		// session_register("x_member_1year");
		$_SESSION["x_member_1year"] = $conn->real_escape_string($member_id);
		echo $_SESSION["x_member_1year"] . "<br>";

		header("Location:../1yearcourse.php");
	//-- ----------------------------------------------- --//			
	}
	elseif ($is_ok == 0) {
		//-----------------query--x-member-------------//
		// $table = $sql[tb_x_member];			
		// $where = " where user='$_POST[x_user]' && pass='$_POST[x_pass]' ";
		// $query = select($table,$where);	
		// $is_ok = mysql_num_rows($query);
		// echo "Section C <br>";
		$strSQL = "SELECT * FROM tb_x_member WHERE user=? && pass=?";
		// $query = mysqli_query($conn,$strSQL);
		// $is_ok = mysqli_num_rows($query);
		$stmt = $conn->prepare($strSQL);
		$stmt->bind_param("ss", $user, $pwd);
		$stmt->execute();
		$result = $stmt->get_result();
		$is_ok = $result->num_rows;

		if ($is_ok == 1) //---if member ture---//
		{
			// echo "x member <br>";
			//echo "No : 1 Year : Login Pass <br>";	// 2015-05-18 test login

			$data = $result->fetch_array();
			$member_id = $data["member_id"];
			$_SESSION["x_member_id"] = $conn->real_escape_string($member_id);
			$ip = $_SERVER["REMOTE_ADDR"];
			// echo $_SESSION["x_member_id"]."<br>";
			//-- ----------------------------------------------- --//	
			$session_id = session_id();
			$now = date("Y-m-d H:i:s");
			// $outdate = date ("Y-m-d H:i:s", strtotime("+30 minute", strtotime($now)));
			//echo "$member_id : $session_id <br>";
			// $table = $sql[tb_x_login];			
			// $where = " where member_id='$member_id' ";
			// $query = select($table,$where);		
			// $is_have = mysql_num_rows($query);

			$str = "SELECT * FROM tb_x_login WHERE member_id=? ";
			// $query = mysqli_query($conn,$str);
			// $is_have = mysqli_num_rows($query);

			$query = $conn->prepare($str);
			$query->bind_param("s", $member_id);
			$query->execute();
			$result = $query->get_result();
			$is_have = $result->num_rows;
			$query->close();



			if ($is_have == 1) {
				// echo "Section B <br>";
				// $value = " session_id='$session_id' , create_date='$now' ";		
				// $where = " where member_id='$member_id' ";
				// update($table,$value,$where);

				$smg = "UPDATE tb_x_login SET ssid=?, create_date=? WHERE member_id=?";
				// mysqli_query($conn,$smg);

				$query = $conn->prepare($smg);
				$query->bind_param("sss", $session_id, $now, $member_id);
				$query->execute();
				$query->close();

			}



			if ($is_have == 0) {
				// echo "Section C <br>";
				// $value = " member_id='$member_id' , session_id='$session_id' , create_date='$now' ";	
				// insert($table,$value);

				$msg = "INSERT INTO tb_x_login (member_id,ssid,create_date) VALUES(?,?,?)";
				// $query = mysqli_query($conn,$msg);

				$query = $conn->prepare($msg);
				$query->bind_param("sss", $member_id, $session_id, $now);
				$query->execute();
				$query->close();
			// if ($query) {
			// 	echo "Success!!! <br>";
			// }else{
			// 	echo "Fale!!! <br>";
			// }

			}

			// echo "Section D <br>";

			// update  logflie user 
			// $table = $sql[tb_x_member_type];			
			// $where = " where member_id='$member_id' ";
			// $query = select($table,$where);		
			// $is_have = mysql_num_rows($query);

			$sql = "SELECT * FROM tb_x_member_type WHERE member_id=?";
			// $query = mysqli_query($conn,$sql);
			// $is_have = mysqli_num_rows($query);

			$query = $conn->prepare($sql);
			$query->bind_param("s", $member_id);
			$query->execute();
			$result = $query->get_result();
			$is_have = $result->num_rows;
			$query->close();

			// echo "Section E <br>"; 

			// check  corporate or user 

			if ($is_have == 0) {
				// $table = $sql[tb_x_log_member];
				// $value = " member_id='$member_id' , logdate='$now' , outdate='$now' , logip='$ip'";	
				// insert($table,$value);

				$logSQL = "INSERT INTO tb_x_log_member (member_id, logdate, outdate, logip) VALUES(?, ?, ?, ?)";
				// mysqli_query($conn,$logSQL);

				$query = $conn->prepare($logSQL);
				$query->bind_param("ssss", $member_id, $now, $now, $ip);
				$query->execute();

			// echo "Section F <br>"; 
			}
			// else{
			// echo "Section G <br>"; 
			// }

			header("Location: ../EOL/eoltest.php?section=business");
		//-- ----------------------------------------------- --//			
		}
		else {
			//echo "No : 1 Year : Login Not Pass <br>";	// 2015-05-18 test login
			header("Location:../index.php");
		}
	}







	//-----------------query--general-member-------------//
	// $table = $sql[tb_x_general];			
	// $where = " where user='$_POST[x_user]' && pass='$_POST[x_pass]' ";
	// $query = select($table,$where);		
	// $is_ok = mysql_num_rows($query);

	$strSQL = "SELECT * FROM tb_x_member_general WHERE user=? && pass=?";
	$stmt = $conn->prepare($strSQL);
	$stmt->bind_param("ss", $user, $pwd);
	$stmt->execute();
	$result = $stmt->get_result();
	$is_ok = $result->num_rows;
	// $stmt->close();

	if ($is_ok == 1) //---if member ture---//
	{
		$data = $result->fetch_array();
		$member_id = $data["member_id"];
		$_SESSION["y_member_id"] = $member_id;
		setcookie("y_member_id", $member_id, time() + 9000, "/");
		$_SESSION["fname"] = isset($data['fname']) ? $data['fname'] : '';
		$_SESSION["lname"] = isset($data['lname']) ? $data['lname'] : '';
		$ip = $_SERVER['REMOTE_ADDR'];
		$stmt->close();
		//-- ----------------------------------------------- --//	
		$session_id = session_id();
		$now = date("Y-m-d H:i:s");
		// $table = $sql[tb_x_general_login];			
		// $where = " where member_id='$member_id' ";
		// $query = select($table,$where);		
		// $is_have = mysql_num_rows($query);

		$sql = "SELECT * FROM tb_x_general_login WHERE member_id=?";
		$query = $conn->prepare($sql);
		$query->bind_param("s", $member_id);
		$query->execute();
		$result = $query->get_result();
		$is_have = $result->num_rows;
		$query->close();

		if ($is_have == 1) {
			// $value = " session_id='$session_id' , create_date='$now' ";		
			// $where = " where member_id='$member_id' ";
			// update($table,$value,$where);

			$smg = "UPDATE tb_x_general_login SET session_id = ?, create_date = ? WHERE member_id = ? ";
			$query = $conn->prepare($smg);
			$query->bind_param("sss", $session_id, $now, $member_id);
			$query->execute();
			$query->close();

		}
		if ($is_have == 0) {
			// $value = " member_id='$member_id' , session_id='$session_id' , create_date='$now' ";	
			// insert($table,$value);

			$smg = "INSERT INTO tb_x_general_login (member_id, session_id, create_date) VALUES(?,?,?)";
			$query = $conn->prepare($smg);
			$query->bind_param("sss", $member_id, $session_id, $now);
			$query->execute();
			$query->close();
		}

		// $table = $sql[tb_x_log_member_general];
		// $value = " member_id='$member_id' , logdate='$now' , outdate='$now' , logip='$ip'";	
		// insert($table,$value);

		$str = "INSERT INTO tb_x_log_member_general (member_id, logdate, outdate, logip) VALUES (?,?,?,?)";
		$query = $conn->prepare($str);
		$query->bind_param("ssss", $member_id, $now, $now, $ip);
		$query->execute();
		$query->close();
		//echo now();

		header("Location: ../EOL/register_general.php");
	//-- ----------------------------------------------- --//			
	}










	
//------------------------------------------//			
	mysqli_close($conn);
//------------------------------------------//
}
else 
{
	header("Location:../index.php");
}

?>