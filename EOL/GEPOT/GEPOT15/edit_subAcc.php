<?php
ob_start();
session_start();
require_once "../config/connection.php";
if ($_SESSION["x_member_id"]) 
{
	if (strlen(trim($_POST["rename"])) >= 8 && strlen(trim($_POST["newpass"])) >= 8 && strlen(trim($_POST["repass"])) >= 8 &&
	strlen(trim($_POST["rename"])) <= 20 && strlen(trim($_POST["newpass"])) <= 20 && strlen(trim($_POST["repass"])) <= 20) {
		// ----- check 
		if (trim($_POST["newpass"]) == trim($_POST["repass"])) {

			$rename = $conn->real_escape_string(trim($_POST["rename"]));
			$strSQL = "SELECT * FROM tb_x_member WHERE user = ?";
			$stmt = $conn->prepare($strSQL);
			$stmt->bind_param("s", $rename);
			$stmt->execute();
			$result = $stmt->get_result();
			$is_same = $result->num_rows;
			$data = $result->fetch_array();
			// ---check username----//
			//--- username already---//
			if ($is_same >= 1 && ($data["member_id"] != $_POST["member"])) {
				echo "<font size=2 face=tahoma color=red>This username is already created.</font>";
			}
			//---- no username not already -----//
			if ($is_same == 0 || ($data["member_id"] == $_POST["member"])) {

				$member = $conn->real_escape_string($_POST["member"]);
				$newpass = $conn->real_escape_string($_POST["newpass"]);

				$smg = "UPDATE tb_x_member SET user = ?, pass = ? WHERE member_id = ?";
				$query = $conn->prepare($smg);
				$query->bind_param("sss", $rename, $newpass, $member);
				$is_ok = $query->execute();

				if ($is_ok) {
					echo "OK";
				}
				else {
					echo "Edit SubAccout fail !";
				}
			}
			//----  end no username not already -----//
			$stmt->close();
			$query->close();
			mysqli_close($conn);

		}
		else {
			echo "<font size=2 face=tahoma color=red>Re-Password is not same as your password.</font>";
		}
	}
	else {
		echo "<font size=2 face=tahoma color=red>Please Insert Username , Password and Re-Password <br> as 8-20 characters long</font>";
	}
}
else {
	echo "Please login";
}



?>