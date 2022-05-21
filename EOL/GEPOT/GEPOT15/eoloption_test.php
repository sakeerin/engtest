<?php
function corporate_main() {

    //var_dump($_SESSION);

    include('./config/connection.php');
    include('../config/connection.php');
    if (!$_SESSION["group_id"]) {
        $_SESSION["group_id"] = 0;
    }
  
    // ================================================================================================ //
    // ======================================== fn for form view statistic ============================ //
    if ($_GET["action"] == "view_group" && $_POST["group_id"] >= 0 && $_POST["group_id"] - $_POST["group_id"] == 0) {
        $group_id = $_POST["group_id"];
        $_SESSION["group_id"] = $group_id;
        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&");
    }
    if ($_GET["action"] == "set_status" && $_GET["member_id"] >= 1) {
        if (isset($_SESSION["x_member_id"])) {
            $member_id = $_SESSION["x_member_id"];
        }
        if (isset($_GET["member_id"])) {
            $sub_id = $_GET["member_id"];
        }
        
        // $table = $sql[tb_x_member_sub];
        // $where = " where master_id='$_SESSION[x_member_id]' && sub_id='$_GET[member_id]' ";
        // $query = select($table, $where);
        // $is_sub = mysql_num_rows($query);

        $strSQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && sub_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ss", $member_id, $sub_id);
        $stmt->execute();
        $result = $stmt->get_result();       
        $is_sub = $result->num_rows;
        
        if ($is_sub == 1) {
            $data = $result->fetch_array();
            $status = $data["status"];
            if ($status == 0) {
                $set = 1;
            } 
            if ($status == 1) {
                $set = 0;
            }
            // $value = " status='$set' ";
            // update($table, $value, $where);

            $msg = "UPDATE tb_x_member_sub SET status = ? WHERE master_id = ? && sub_id = ?";
            $query = $conn->prepare($msg);
            $query->bind_param("iss", $set, $member_id, $sub_id);
            $query->execute();
            $query->close();
        }
        $stmt->close();
        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&page=$_GET[page]");
    }
    //-----------------------------------------------------------------------------------------------//
    if ($_GET["action"] == "left_group" && $_GET["member_id"] >= 1) {

        if (isset($_SESSION["x_member_id"])) {
            $member_id = $_SESSION["x_member_id"];
        }
        if (isset($_GET["member_id"])) {
            $sub_id = $_GET["member_id"];
        }

        // $table = $sql[tb_x_member_sub];
        // $where = " where master_id='$_SESSION[x_member_id]' && sub_id='$_GET[member_id]' ";
        // $query = select($table, $where);
        // $is_sub = mysql_num_rows($query);

        $strSQL = "SELECT * FROM tb_x_member_sub  WHERE master_id = ? && sub_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ss", $member_id, $sub_id);
        $stmt->execute();
        $result = $stmt->get_result();       
        $is_sub = $result->num_rows;
        $stmt->close();

        if ($is_sub == 1) {
            // $value = " type_id='0' ";
            $type_id = 0;
            
            // update($table, $value, $where);

            $msg = "UPDATE tb_x_member_sub SET type_id = ? WHERE master_id = ? && sub_id = ?";
            $query = $conn->prepare($msg);
            $query->bind_param("iss", $type_id, $member_id, $sub_id);
            $query->execute();
            $query->close();
        }
        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&page=$_GET[page]");
    }
    //-----------------------------------------------------------------------------------------------//
    if ($_GET["action"] == "delete_sub" && $_GET["member_id"] >= 1) {
        
        // $table = $sql[tb_x_member_sub];
        // $where = " where master_id='$_SESSION[x_member_id]' && sub_id='$_GET[member_id]' ";
        // $query = select($table, $where);
        // $is_sub = mysql_num_rows($query);

        if (isset($_SESSION["x_member_id"])) {
            $member_id = $_SESSION["x_member_id"];
        }
        if (isset($_GET["member_id"])) {
            $sub_id = $_GET["member_id"];
        }
        
        $strSQL = "SELECT * FROM tb_x_member_sub  WHERE master_id = ? && sub_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ss", $member_id, $sub_id);
        $stmt->execute();
        $result = $stmt->get_result();       
        $is_sub = $result->num_rows;
        $stmt->close();

        if ($is_sub == 1) {
            $smg = "DELETE FROM tb_x_member_sub WHERE master_id = ? && sub_id = ?";
            $query = $conn->prepare($smg);
            $query->bind_param("ss", $member_id, $sub_id);
            $query->execute();
            $query->close();
            // delete($table, $where);
        }
        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&page=$_GET[page]");
    }
    //-----------------------------------------------------------------------------------------------//
    //-----------------------------------------------------------------------------------------------//
    if ($_GET["action"] == "all_limit" && $_POST["member_id"]) {
        //var_dump($_POST[member_id]);
        if (isset($_SESSION["x_member_id"])) {
            $x_member_id = $_SESSION["x_member_id"];
        }
        $member_id = $_POST["member_id"];
        if ($member_id) {
            sort($member_id);
            $count = count($member_id);
        }
        if ($count >= 1) {
            // $table = $sql[tb_x_member_sub];
            // $value = " status='0' ";
            $status = 0;
            for ($i = 0; $i < $count; $i++) {
                $id = $member_id[$i];
                // $where = " where master_id='$_SESSION[x_member_id]' && sub_id='$member_id[$i]' ";
                // update($table, $value, $where);

                $strSQL = "UPDATE tb_x_member_sub SET status = ? WHERE master_id = ? && sub_id = ?";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("iss", $status, $x_member_id, $id);
                $stmt->execute();
                $stmt->close();

            }
        }
        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&page=$_GET[page]");
    }
    if ($_GET["action"] == "all_unlimit" && $_POST["member_id"]) {
        //var_dump($_POST[member_id]);
        $member_id = $_POST["member_id"];
        if ($member_id) {
            sort($member_id);
            $count = count($member_id);
        }
        if ($count >= 1) {
            // $table = $sql[tb_x_member_sub];
            // $value = " status='1' ";
            $status = 1;
            for ($i = 0; $i < $count; $i++) {
                // $where = " where master_id='$_SESSION[x_member_id]' && sub_id='$member_id[$i]' ";
                // update($table, $value, $where);

                $strSQL = "UPDATE tb_x_member_sub SET status = ? WHERE master_id = ? && sub_id = ?";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("iss", $status, $_SESSION['x_member_id'], $member_id[$i]);
                $stmt->execute();
                $stmt->close();
            }
        }
        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&page=$_GET[page]");
    }
    if ($_GET["action"] == "all_left" && $_POST["member_id"]) {
        //var_dump($_POST[member_id]);
        $member_id = $_POST["member_id"];
        if ($member_id) {
            sort($member_id);
            $count = count($member_id);
        }
        if ($count >= 1) {
            // $table = $sql[tb_x_member_sub];
            // $value = " type_id='0' ";
            $type_id = 0;
            for ($i = 0; $i < $count; $i++) {
                // $where = " where master_id='$_SESSION[x_member_id]' && sub_id='$member_id[$i]' ";
                // update($table, $value, $where);

                $strSQL = "UPDATE tb_x_member_sub SET type_id = ? WHERE master_id = ? && sub_id = ?";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("iss", $type_id, $_SESSION['x_member_id'], $member_id[$i]);
                $stmt->execute();
                $stmt->close();
            }
        }
        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&page=$_GET[page]");
    }
    if ($_GET["action"] == "all_delete" && $_POST["member_id"]) {
        //var_dump($_POST[member_id]);
        $member_id = $_POST["member_id"];
        if ($member_id) {
            sort($member_id);
            $count = count($member_id);
        }
        if ($count >= 1) {
            // $table = $sql[tb_x_member_sub];
            for ($i = 0; $i < $count; $i++) {
                // $where = " where master_id='$_SESSION[x_member_id]' && sub_id='$member_id[$i]' ";
                // delete($table, $where);

                $smg = "DELETE FROM tb_x_member_sub WHERE master_id = ? && sub_id = ?";
                $query = $conn->prepare($smg);
                $query->bind_param("ss", $_SESSION['x_member_id'], $member_id[$i]);
                $query->execute();
                $query->close();
            }
        }
        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&page=$_GET[page]");
    }
    if ($_GET["action"] == "all_move" && $_POST["member_id"]) {
        //print_r ($_POST,0);
        //exit;

        $member_id = $_POST["member_id"];
        if ($member_id) {
            sort($member_id);
            $count = count($member_id);
        }


        if ($count >= 1 && $_POST["type_id"] == 0) {
            // $table = $sql[tb_x_member_sub];
            // $value = " type_id='0' ";
            $type_id = 0;
            for ($i = 0; $i < $count; $i++) {
                // $where = " where master_id='$_SESSION[x_member_id]' && sub_id='$member_id[$i]' ";
                // update($table, $value, $where);

                $strSQL = "UPDATE tb_x_member_sub SET type_id = ? WHERE master_id = ? && sub_id = ?";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("iss", $type_id, $_SESSION['x_member_id'], $member_id[$i]);
                $stmt->execute();
                $stmt->close();
            }
        } else if ($count >= 1) {
            // $table = $sql[tb_x_member_type];
            // $where = " where member_id='$_SESSION[x_member_id]' && type_id='$_POST[type_id]' ";
            // $query = select($table, $where);
            // $is_group = mysql_num_rows($query);

            $strSQL = "SELECT * FROM tb_x_member_type  WHERE member_id = ? && type_id = ?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ss", $_SESSION['x_member_id'], $_POST['type_id']);
            $stmt->execute();
            $result = $stmt->get_result();       
            $is_group = $result->num_rows;
            $stmt->close();

            if ($is_group == 1) {
                // $table = $sql[tb_x_member_sub];
                // $value = " type_id='$_POST[type_id]' ";
                $type_id = $_POST['type_id'];
                for ($i = 0; $i < $count; $i++) {
                    // $where = " where master_id='$_SESSION[x_member_id]' && sub_id='$member_id[$i]' ";
                    // update($table, $value, $where);

                    $strSQL = "UPDATE tb_x_member_sub SET type_id = ? WHERE master_id = ? && sub_id = ?";
                    $query = $conn->prepare($strSQL);
                    $query->bind_param("sss", $type_id, $_SESSION['x_member_id'], $member_id[$i]);
                    $query->execute();
                    $query->close();
                    
                }
            }
        }
        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&page=$_GET[page]");
    }
    // ==================== add group ======================= //
    if ($_GET["action"] == "add_group" && trim($_POST["group_name"])) {
        $group_name = trim($_POST["group_name"]);

        // $table = $sql[tb_x_member_type];
        // $value = " member_id='$_SESSION[x_member_id]' , name='$group_name'  ";
        // insert($table, $value);

        $strSQL = "INSERT INTO tb_x_member_type (member_id, name) VALUES (?,?)";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ss", $_SESSION['x_member_id'],$group_name);
        $stmt->execute();
        $stmt->close();
        
        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&");
    }
    //  ------------ rename group ---------------------------//
    if ($_GET["action"] == "re_group" && trim($_POST["rename"])) {
        $group_name = trim($_POST["rename"]);

        // $table = $sql[tb_x_member_type];
        // $value = "name='$group_name'  ";
        // $where = " where type_id='" . $_POST[idrename] . "' &&  member_id='" . $_SESSION[x_member_id] . "'  ";
        // update($table, $value, $where);

        $strSQL = "UPDATE tb_x_member_type SET name = ? WHERE member_id = ? && type_id = ?";
        $query = $conn->prepare($strSQL);
        $query->bind_param("sss", $group_name, $_SESSION['x_member_id'], $_POST['idrename']);
        $query->execute();
        $query->close();

        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&");
    }
    //  ------------ rename group ---------------------------//

    if ($_GET["action"] == "delete_group") {
        // $table = $sql[tb_x_member_type];
        // $value = " member_id='$_SESSION[x_member_id]' , name='$group_name'  ";
        if ($_POST["group_id"] >= 1) {
            $group_id = $_POST["group_id"];
            $type_id = 0;

            // $table = $sql[tb_x_member_sub];
            // $value = " type_id='0' ";
            // $where = " where master_id='$_SESSION[x_member_id]' && type_id='$group_id' ";
            // update($table, $value, $where);
            
            $strSQL = "UPDATE tb_x_member_sub SET type_id = ? WHERE master_id = ? && type_id = ?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("iss", $type_id, $_SESSION['x_member_id'], $group_id);
            $stmt->execute();
            $stmt->close();

            // $table = $sql[tb_x_member_type];
            // $where = " where member_id='$_SESSION[x_member_id]' && type_id='$group_id' ";
            // delete($table, $where);

            $smg = "DELETE FROM tb_x_member_type WHERE member_id = ? && type_id = ?";
            $query = $conn->prepare($smg);
            $query->bind_param("ss", $_SESSION['x_member_id'], $group_id);
            $query->execute();
            $query->close();
        }
        header("Location: http://localhost/engtest/EOL/eoltest.php?section=$_GET[section]&&");
    }
    //-----------------------------------------------------------------------------------------------//
    //-----------------------------------------------------------------------------------------------//
    //-----------------------------------------------------------------------------------------------//
    
    // $table = $sql[tb_x_member_sub] . "," . $sql[tb_x_member];
    if ($_SESSION["group_id"] >= 0) {
        // $ex_event = " && tbl_x_member_sub.type_id='$_SESSION[group_id]' ";
        $group_id = $_SESSION["group_id"];
        $ex_event = " && a.type_id='$group_id' ";
    }
    // $where = " where tbl_x_member_sub.master_id='$_SESSION[x_member_id]' && tbl_x_member_sub.sub_id=tbl_x_member.member_id $ex_event order by $sql[tb_x_member].user ";
    // $query = select($table, $where);
    // $num = mysql_num_rows($query);

    $strSQL = "SELECT * FROM tb_x_member_sub AS a, tb_x_member AS b WHERE a.master_id = ? && a.sub_id=b.member_id $ex_event ORDER BY b.user";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();       
    $num = $result->num_rows;
    $stmt->close();

    $all_list = $num;
    if ($num >= 1) {
        //---------------------------- Set Page --------------------------------//
        $all = $num;
        if ($_GET["action"] == "set_per_page") {
            if ($_POST["per_page"]) {
                $_SESSION["per_page"] = $_POST["per_page"];
            }
        }
        if (!$_SESSION["per_page"]) {
            $per_page = 25;
        }
        if ($_SESSION["per_page"]) {
            $per_page = $_SESSION["per_page"];
        }
        if ($_SESSION["per_page"] != "all") {
            $all_page = $num / $per_page;
            $arr = explode(".", $all_page);
            if ($arr[1] >= 1) {
                $all_page = $arr[0] + 1;
            } else {
                $all_page = $arr[0];
            }
        }
    }
    //---------------------------------------------------------------------------------//	
    //---------------------------- FORM VIEW STATISTICS ------------------------------- //

    echo "
				<table align=center width=90% cellpadding=5 cellspacing=0 border=0>
					<tr height=30>
						<td align=right width=7%><font size=2 face=tahoma><b>View :</b></font></td>
						<form id='view_form' method=post action='?section=$_GET[section]&&action=view_group' >
						<td align=left width=50%>
							<select name='group_id' id='group_id'>
				";
    //-----------------------------------------------------------------------------------------------//
    // $table = $sql[tb_x_member_sub];
    // $where = " where master_id='$_SESSION[x_member_id]' && type_id='0' ";
    // $sub_query = select($table, $where);
    // $each_group = mysql_num_rows($sub_query);

    $type_id = 0;
    $strSQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("si", $_SESSION['x_member_id'], $type_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $each_group = $result->num_rows; 
    $stmt->close();

    $type_name = "None Group&nbsp;[ " . $each_group . " ]";
    //-----------------------------------------------------------------------------------------------//
    echo "
										<option value='0'>$type_name</option>
				";
    // $table = $sql[tb_x_member_type];
    // $where = " where member_id='$_SESSION[x_member_id]' order by name ";
    // $query = select($table, $where);
    // $rows = mysql_num_rows($query);

    $msg = "SELECT * FROM tb_x_member_type WHERE member_id = ? ORDER BY name";
    $query = $conn->prepare($msg);
    $query->bind_param("s", $_SESSION['x_member_id']);
    $query->execute();
    $result = $query->get_result();
    $rows = $result->num_rows; 


    if ($rows >= 1) {
        for ($i = 1; $i <= $rows; $i++) {
            $data = $result->fetch_array();
            $type_name = $data["name"];
            $type_id = $data["type_id"];
            //-----------------------------------------------------------------------------------------------//
            // $table = $sql[tb_x_member_sub];
            // $where = " where master_id='$_SESSION[x_member_id]' && type_id='$type_id' ";
            // $sub_query = select($table, $where);
            // $each_group = mysql_num_rows($sub_query);

            $strSQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ss", $_SESSION['x_member_id'],$type_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $each_group = $result->num_rows; 
            $stmt->close();

            $type_name = $type_name . "&nbsp;[ " . $each_group . " ]";
            //-----------------------------------------------------------------------------------------------//
            if ($type_id == $_SESSION["group_id"]) {
                $select = "selected";
            } else {
                $select = "";
            }
            echo "
										<option value='$type_id' $select>$type_name </option>
									";
        }
    }
    // $query->close();
    echo "			</select>
							<input type='submit' value='View'>
							<input type='button' value='Edit' class='modalInput' rel='#prompt1' onclick='rename()'>
							<input type='button' value='Delete This Group'
									onclick=\"javascript:
												if(confirm('Do you want to delete this group ?'))
												{	
													if(confirm('Are you sure ? If you delete this group the member in this group will be None Group.'))
													{	
														document.getElementById('view_form').action='?section=$_GET[section]&&action=delete_group';
														document.getElementById('view_form').submit();
													}
												}
											\"
							>
						</td>
						</form>
						<form id='add_form' method=post action='?section=$_GET[section]&&action=add_group' >
						<td align=right width=33%><input type=text name='group_name' size=30></td>
						<td align=left width=17%>
							<input type='submit' value='Create New Group'
									onclick=\"javascript:
												if(confirm('Do you want to create new group ?'))
												{	document.getElementById('add_form').submit();	}
											\"
							>
						</td>
						</form>
					</tr>
				</table>
				<br>
				";
    if ($num >= 1) {
        //----------------------------------------------------------------------------------------------------------//	
        if ($_GET["page"] && ($_GET["page"] - $_GET["page"] == 0 && $_GET["page"] >= 1)) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }
        if ($_SESSION["per_page"]) {
            $amount = $_SESSION["per_page"];
        } else {
            $amount = 25;
        }
        $start = ($page - 1) * $amount;
        $limit = " limit $start,$amount";
        if ($_SESSION["per_page"] == "all") {
            $limit = "";
        }
        // $table = $sql[tb_x_member_sub] . "," . $sql[tb_x_member];
        // $where = " where tbl_x_member_sub.master_id='$_SESSION[x_member_id]' && tbl_x_member_sub.sub_id=tbl_x_member.member_id  $ex_event order by $sql[tb_x_member].member_id $limit ";

        $strSQL = "SELECT * FROM tb_x_member_sub AS a, tb_x_member AS b WHERE a.master_id = ? && a.sub_id = b.member_id $ex_even ORDER BY b.member_id $limit";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_SESSION['x_member_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows; 
        // $stmt->close();

        //-----------------//
        // $event_table = $table;
        // $event_where = $where;
        //-----------------//
        // $query = select($table, $where);
        // $num = mysql_num_rows($query);
        //---------------------------- Set Page --------------------------------//
        echo "	<table align=center width=90% cellpadding=0 cellspacing=2 border=0  class='noborder'>
					<!-- <form id='co_refill_form' name='co_refill_form' method=post action='?section=$_GET[section]&&action=co_refill&&page=$_GET[page]'> -->
					<form id='member_list' name='member_list' method=post >
						<tr height=30>
							<td width=4% bgcolor='#FAAC58' align=center >
								<div onclick=\"javascript:select_all();\" style='cursor:pointer;'><font size=2 face=tahoma color=white title='Select All'><b>All</b></font></div>
								<input type=hidden id='all_status' value='select'>
							</td>
							<td width=24% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>First name - Last name</b></font></td>
							<td width=13% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>Username</b></font></td>
							<td width=13% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>Password</b></font></td>
							<td width=16% bgcolor='#676868' align=center><font size=2 face=tahoma color=white><b>Oprerating time</b></font></td>
							<td width=30% bgcolor='#676868' align=center color=white><font size=2 face=tahoma color=white><b>Management</b></font></td>
						</tr>
			";
        for ($i = 1; $i <= $num; $i++) {
            $data = $result->fetch_array();
            if (trim($data["fname"]) && trim($data["lname"])) {
                $is_mem = "true";
                $fname = $data["fname"];
                $lname = $data["lname"];
            } else {
                $is_mem = "false";
                $msg_name = "<div align=center><font color=red face=tahoma size=2> - </font></div>";
            }
            //-------------------------------------------------------------------------------------//
            $member_id = $data["member_id"];
            $day = date("Y-m-d");
            $enddate = date("Y-m-d H:i:s", strtotime($day));

            // $table = $sql[tb_x_log_member];
            // $where = " where member_id='$data[member_id]' &&  logdate >='$enddate' order by logdate DESC   ";
            // $sub_query = select($table, $where);
            // $is_have = mysql_num_rows($sub_query);

            $smg = "SELECT * FROM tb_x_log_member WHERE member_id = ? && logdate >= ? ORDER BY logdate DESC";
            $query = $conn->prepare($smg);
            $query->bind_param("ss", $member_id,$enddate);
            $query->execute();
            $result = $query->get_result();
            $is_have = $result->num_rows; 

            if ($is_have >= 1) {
                $timediff = array();
                $t = 0;
                while ($sub_data = $result->fetch_array()) {
                    // your code
                    $splittime1 = explode(" ", $sub_data["logdate"]);
                    $splittime2 = explode(" ", $sub_data["outdate"]);
                    $timediff[$t] = diff2time($splittime1[1], $splittime2[1]);
                    $lastime = $sub_data["logdate"];
                    $t++;
                }
                $hour = floor(array_sum($timediff) / 60);
                if ($hour > 0) {
                    $htxt = $hour . " ชั่วโมง ";
                }
                $stop_msg = "<font color=green title='$lastime'> $htxt " . floor(array_sum($timediff) % 60) . ' นาที </font>';
                
            } else {
                
                // $table = $sql[tb_x_log_member];
                // $where = " where member_id='$data[member_id]'  order by logdate DESC  limit 0,1";
                // $sub_query = select($table, $where);
                // $is_have = mysql_num_rows($sub_query);
                
                $strSQL = "SELECT * FROM tb_x_log_member WHERE member_id = ? ORDER BY logdate LIMIT 0,1";
                $sub_query = $conn->prepare($strSQL);
                $sub_query->bind_param("s", $member_id);
                $sub_query->execute();
                $result = $sub_query->get_result();
                $is_have = $result->num_rows; 

                if ($is_have == 1) {
                    $sub_data = $result->fetch_array();
                    $lastime = $sub_data["logdate"];
                    $stop_msg = "<font color=red title='เข้าใช้ครั่งล่าสุดเมื่อ " . $lastime . "'> " . $lastime . "</font>";
                } else {
                    $stop_msg = "<font color='red'> - </font>";
                }
                $sub_query->close();
            }
            $query->close();
            //-------------------------------------------------------------------------------------//
            $list_num = $i + (($page - 1) * $amount);
            if ($is_mem == "true") {
                $msg_name = "<table align=center width=100% cellpadding=0 cellspacing=0 border=0>
									<tr>
										<td align=left width=40%>
											<font color='blue' face=tahoma size=2>&nbsp;" . $fname . "&nbsp;</font>
										</td>
										<td align=left width=60%>
											<font color='blue' face=tahoma size=2>&nbsp;" . $lname . "&nbsp;</font>
										</td>
									</tr>
								</table>";
            }
            if ($i % 2 == 0) {
                $color = "#f0f0f0";
            } else {
                $color = "#f7f7f7";
            }
            if ($data["status"] == 1) {
                $img_status = "unlimit.png";
                $img_title = "Allow this Sub Account get Available Date from Master Account  - Click to Change as Limited";
            }
            if ($data["status"] == 0) {
                $img_status = "limit.png";
                $img_title = "Not allow this Sub Account get Available Date from Master Account  - Click to Change as Unlimited";
            }
            // ================================================================================================================ //
            // ==================================== menu management => system page for admin ================================== //
            // ================================================================================================================ //
            echo "
						<tr height=28 >
							<td bgcolor='#FAAC58' align=center>
								<input type='checkbox' id='member_id[$i]' name='member_id[$i]' value='$data[member_id]' title='[$list_num]' >
								<!-- <font size=2 face=tahoma ><b>&nbsp;[$list_num]&nbsp;</b></font> -->
							</td>
							<td bgcolor='$color' align=left>$msg_name</td>
							<td bgcolor='$color' align=center><font size=2 face=tahoma id='userdata_$data[member_id]'><b>$data[user]</b></font></td>
							<td bgcolor='$color' align=center><font size=2 face=tahoma ><b>$data[pass]</b></font></td>
							<td bgcolor='$color' align=center><font size=2 face=tahoma >$stop_msg</font></td>
							<td bgcolor='white' align=center>
								<img src='../image2/eol system/icon/$img_status' border=0 style='cursor:pointer;margin-right:15px;' 
									title='$img_title'
									onclick=\"javascript:
												if(confirm('Do you want to change the member status ?'))
												{	window.location='?section=$_GET[section]&&action=set_status&&member_id=$data[member_id]&&page=$_GET[page]';	}
											\"
								>
								<a target=_blank href='?section=$_GET[section]&&action=report&&member_id=$data[member_id]' title='View Personal Report'><img src='../image2/eol system/icon/report-02.png' border=0  style='margin-right:15px;'></a>
								<img src='../image2/eol system/icon/move-04.png' border=0 style='cursor:pointer;margin-right:15px;'
									 title='Move current group'
									onclick=\"javascript:
												if(confirm('Do you want to bring this member out of this group to none group ?'))
												{	window.location='?section=$_GET[section]&&action=left_group&&member_id=$data[member_id]&&page=$_GET[page]';	}
											\"
								>
								<button class='modalInput' rel='#prompt2' type='botton' style='background:none; border:none;' id='$data[member_id]' onclick='edit_subAcc(this)'><img src='../image2/eol system/icon/edit-03.png' border=0 style='cursor:pointer;margin-right:15px;'
									title='Edit Username and Password'
								></button>
								<img src='../image2/eol system/icon/bin.png' border=0 style='cursor:pointer'
									title='Delete this Sub Account from this Corporate Card'
									onclick=\"javascript:
												if(confirm('Do you want to delete this member from your member ?'))
												{	window.location='?section=$_GET[section]&&action=delete_sub&&member_id=$data[member_id]&&page=$_GET[page]';	}
											\"
								>
							</td>
						</tr>
					";
            //----------------- Checked All - Uncheck All ---------------------------//
            $msg_check_all_a = $msg_check_all_a . "document.getElementById('member_id[$i]').checked='checked';";
            $msg_check_all_b = $msg_check_all_b . "document.getElementById('member_id[$i]').checked='';";
        }
        echo "
						<script language=\"javascript\">
							function select_all()
							{
								if(document.getElementById('all_status').value=='select')
								{
									$msg_check_all_a
									document.getElementById('all_status').value='remove';
								}
								else
								{
									$msg_check_all_b
									document.getElementById('all_status').value='select';
								}
							}
						</script>
						";
        //----------------------------------------------//
        echo "	<input type=hidden id='type_id' name='type_id' size=5 value='0'>  
					</form>
					</table>";
    }

    echo "
				<table align=center width=90% cellpadding=5 cellspacing=0 border=0 >
				<form method=post action='?section=$_GET[section]&&action=set_per_page'>	
					<tr valign=top>
						<td width=10% align=right><font size=2 face=tahoma color=red><b>Page :</b></font></td>
						<td width=100% align=left>
				";

    for ($p = 1; $p <= $all_page; $p++) {
        if ($p >= 1 && $p < 10) {
            $page_num = "[00$p]";
        }
        if ($p > 9 && $p < 100) {
            $page_num = "[0$p]";
        }
        if ($p > 100) {
            $page_num = "[$p]";
        }

        if ($_GET["page"] == $p) {
            $p_color = "#DF013A";
        } else {
            $p_color = "black";
        }

        if ((!$_GET["page"] || $_GET["page"] - $_GET["page"] != 0 || $_GET["page"] <= 0) && $p == 1) {
            $p_color = "red";
        }
        echo " &nbsp;<a href='?section=$_GET[section]&&page=$p'><font size=2 face=tahoma color='$p_color'>$page_num</font></a> ";
        if ($p % 20 == 0) {
            echo "<br>";
        }
    }

    echo "
						</td>
					</tr>
				</form>
				</table><br>
				";
    //-----------------------------------------------------------------------------------//	
    //------- Footer Manage by Selected Items: -> Limit, Unlimit, Delete ----------------//	
    //-----------------------------------------------------------------------------------//	
    if ($num >= 1) {
        echo "<br>
			<table align=center width=90% cellpadding=1 cellspacing=0 border=0 bgcolor='#676868'>
			<tr><td>
				<table align=center width=100% cellpadding=0 cellspacing=0 border=0 >
					<tr height=50>
						<td width=18% align=right bgcolor='white'>
							<font size=2 face=tahoma color='#676868'><b>Selected Items&nbsp;&nbsp;:&nbsp;&nbsp;</b></font>
						</td>
						<td width=7% align=left bgcolor='white'>
						   <center>
							<img src='../image2/eol system/icon/limit.png' border=0 style='cursor:pointer'
								title='Change them as Limited - Not allow these Sub Account get Available Date from Master Account'
								onclick=\"javascript:
											if(confirm('Do you want to change the status of the following members to be Limited ?'))
											{	
												document.getElementById('member_list').action='?section=$_GET[section]&&action=all_limit&&page=$_GET[page]';
												document.getElementById('member_list').submit();
											}
										\"
							><br>
                            <font style='color:#FFB700;'>Limit</font>
                            </center>
						</td>
						<td width=7% align=left bgcolor='white'>
						  <center>
							<img src='../image2/eol system/icon/unlimit.png' border=0  style='cursor:pointer'
								title='Change them as Unlimited - Allow these Sub Account get Available Date from Master Account'
								onclick=\"javascript:
											if(confirm('Do you want to change the status of the following members to be Unlimited ?'))
											{	
												document.getElementById('member_list').action='?section=$_GET[section]&&action=all_unlimit&&page=$_GET[page]';
												document.getElementById('member_list').submit();
											}
										\"
							>
							<br>
                            <font style='color:#00C12B;'>Unlimit</font>
                            </center>
						</td>
						<td width=7% align=left bgcolor='white'>
						  <center>
							<img src='../image2/eol system/icon/bin.png' border=0  style='cursor:pointer'
								title='Delete them from this Corporate Card'
								onclick=\"javascript:
											if(confirm('Do you want to bring the following members out of this Corporate Card ?'))
											{	
												document.getElementById('member_list').action='?section=$_GET[section]&&action=all_delete&&page=$_GET[page]';
												document.getElementById('member_list').submit();
											}
										\"
							>
							<br>
                            <font style='color:red;'>Delete</font>
                            </center>
						</td>
						<td width=13% align=right bgcolor='white'>
						    <img src='../image2/eol system/icon/move-to.png' border=0 style='margin-right:35px;'>
						    <br>
							<font size=2 face=tahoma color='#676868'><b>Move To&nbsp;&nbsp;:&nbsp;&nbsp;</b></font>
						</td>
						<td width=30% align=left bgcolor='white'>
							<select id='ref_id' >
			";
        //-----------------------------------------------------------------------------------------------//
        // $table = $sql[tb_x_member_sub];
        // $where = " where master_id='$_SESSION[x_member_id]' && type_id='0' ";
        // $sub_query = select($table, $where);
        // $each_group = mysql_num_rows($sub_query);

        $type_id = 0;
        $strSQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("si", $_SESSION['x_member_id'],$type_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $each_group = $result->num_rows; 
        $stmt->close();

        $type_name = "None Group&nbsp;[ " . $each_group . " ]";
        //-----------------------------------------------------------------------------------------------//
        echo "
												<option value='0'>$type_name </option>
			";
        // $table = $sql[tb_x_member_type];
        // $where = " where member_id='$_SESSION[x_member_id]' ";
        // $query = select($table, $where);
        // $rows = mysql_num_rows($query);

        $strSQL = "SELECT * FROM tb_x_member_type WHERE member_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s", $_SESSION['x_member_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->num_rows; 
        
        if ($rows >= 1) {
            for ($i = 1; $i <= $rows; $i++) {
                $data = $result->fetch_array();
                $type_name = $data["name"];
                $type_id = $data["type_id"];
                //-----------------------------------------------------------------------------------------------//
                // $table = $sql[tb_x_member_sub];
                // $where = " where master_id='$_SESSION[x_member_id]' && type_id='$type_id' ";
                // $sub_query = select($table, $where);
                // $each_group = mysql_num_rows($sub_query);

                $msg = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
                $query = $conn->prepare($msg);
                $query->bind_param("ss",$_SESSION['x_member_id'],$type_id);
                $query->execute();
                $result = $query->get_result();
                $each_group = $result->num_rows; 
                $query->close();

                $type_name = $type_name . "&nbsp;[ " . $each_group . " ]";
                //-----------------------------------------------------------------------------------------------//
                echo "
												<option value='$type_id' >$type_name </option>
											";
            }
        }
        // $stmt->close();
        echo "
							</select>
							<input type='button' value='&nbsp;Set&nbsp;' onclick=\"javascript:
								if(confirm('Do you want to bring the following members into the selected group ?'))
								{	
									document.getElementById('type_id').value=document.getElementById('ref_id').value;	
									document.getElementById('member_list').action='?section=$_GET[section]&&action=all_move&&page=$_GET[page]';
									document.getElementById('member_list').submit();
								}
							\">
						</td>
					</tr>
				</table>
			</td></tr>
			</table>
			";
    }
    //---------------------------------------------------------------------------//
    //---------------------- Footer & Add Member From ---------------------------//
    //---------------------------------------------------------------------------//
    $sp_allow = 1;
    // $table = $sql[tb_x_member_spacial];
    // $where = " where member_id='$_SESSION[x_member_id]' ";
    // $query = select($table, $where);
    // $is_sp = mysql_num_rows($query);

    $strSQL = "SELECT * FROM tb_x_member_spacial WHERE member_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s",$_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_sp = $result->num_rows; 

    if ($is_sp == 1) {
        $sp_data = $result->fetch_array();
        $max_amount = $sp_data["amount"];

        // $table = $sql[tb_x_member_sub];
        // $msg_query = " select sub_id from $table where master_id='$_SESSION[x_member_id]' ";
        // $query = mysql_query($msg_query);
        // $all_sub = mysql_num_rows($query);

        $msg = "SELECT sub_id FROM tb_x_member_sub WHERE master_id = ?";
        $query = $conn->prepare($msg);
        $query->bind_param("s",$_SESSION['x_member_id']);
        $query->execute();
        $result = $query->get_result();
        $all_sub = $result->num_rows; 
        $query->close();
        if ($all_sub >= $max_amount) {
            $sp_allow = 0;
        }
    }
    // $stmt->close();
    if ($sp_allow == 1) {
        //---------------------------------------------------------------------------//
        echo "<br>
			<table align=center width=60% cellpadding=0 cellspacing=0 border=0>
				<tr valign=top>
					<td width=100%>	<!-- 60 % -->
 			";
        if ($_GET["action"] == "add_member") {
            if (strlen(trim($_POST["add_user"])) >= 8 && strlen(trim($_POST["add_pass"])) >= 8 && strlen(trim($_POST["add_re"])) >= 8 &&
                    strlen(trim($_POST["add_user"])) <= 20 && strlen(trim($_POST["add_pass"])) <= 20 && strlen(trim($_POST["add_re"])) <= 20) {
                if (trim($_POST["add_pass"]) == trim($_POST["add_re"])) {
                    // $table = $sql[tb_x_member];
                    // $where = " where user='" . trim($_POST[add_user]) . "' ";
                    // $query = select($table, $where);
                    // $is_same = mysql_num_rows($query);

                    $user = trim($_POST["add_user"]);
                    $strSQL = "SELECT * FROM tb_x_member WHERE user = ?";
                    $sub_query = $conn->prepare($strSQL);
                    $sub_query->bind_param("s",$user);
                    $sub_query->execute();
                    $result = $sub_query->get_result();
                    $is_same = $result->num_rows; 
                    $sub_query->close();

                    if ($is_same >= 1) {
                        $error = "<font size=2 face=tahoma color=red>This Username is already created.</font>";
                    }
                    if ($is_same == 0) {
                        // $sub_table = $sql[tb_x_member];
                        // $sub_where = " order by member_id DESC limit 0,1 ";
                        // $sub_query = select($sub_table, $sub_where);
                        // $is_have = mysql_num_rows($sub_query);

                        $msg = "SELECT * FROM tb_x_member ORDER BY member_id DESC LIMIT 0,1";
                        $query = $conn->prepare($msg);
                        $query->execute();
                        $result = $query->get_result();
                        $is_have = $result->num_rows; 

                        if ($is_have == 1) {
                            $sub_data = $result->fetch_array();
                            $last_id = $sub_data["member_id"] + 1;
                        }
                        if ($is_have == 0) {
                            $last_id = 1;
                        }
                        $query->close();
                        $now = date("Y-m-d H:i:s");

                        // $table = $sql[tb_x_member_sub];
                        // $value = " master_id='$_SESSION[x_member_id]' , sub_id='$last_id' ,type_id='$_POST[user_newgroup]' ";
                        // insert($table, $value);

                        $strSQL = "INSERT INTO tb_x_member_sub (master_id, sub_id, type_id) VALUES(?,?,?)";
                        $stmt = $conn->prepare($strSQL);
                        $stmt->bind_param("sis",$_SESSION['x_member_id'],$last_id,$_POST['user_newgroup']);
                        $stmt->execute();
                        $stmt->close();

                        $_SESSION["group_id_addAcc"] = $_POST["user_newgroup"];

                        // $table = $sql[tb_x_member];
                        // $value = " member_id='$last_id' , user='$_POST[add_user]' , pass='$_POST[add_pass]' , create_date='$now' ";
                        // insert($table, $value);
                        
                        $msg = "INSERT INTO tb_x_member (member_id, user, pass, create_date) VALUES(?,?,?,?)";
                        $stmt = $conn->prepare($msg);
                        $stmt->bind_param("isss",$last_id,$_POST['add_user'],$_POST['add_pass'],$now);
                        $stmt->execute();
                        $stmt->close();
                        

                        header("Location:?section=$_GET[section]&&page=$_GET[page]");
                    }
                } else {
                    $error = "<font size=2 face=tahoma color=red>Re-Password is not same as your password</font>";
                }
            } else {
                $error = "<font size=2 face=tahoma color=red>Please Insert Username , Password and Re-Password <br> as 8-20 characters long</font>";
            }
        }
        //-----------------------------------------------------------------------------------//	
        echo "
								<table align=center width=100% cellpadding=0 cellspacing=0 border=0>
								<form method=post action=?section=$_GET[section]&&action=add_member&&page=$_GET[page]>
									<tr height=30 bgcolor='#ff7c06'>
										<td align=center colspan=3><font face=tahoma size=2 color=white><b> :: Add New Member :: </b></font></td>
									</tr>
								";
        if ($_GET["action"] == "add_member" && $error) {
            echo "
													<tr height=10 bgcolor='#ffeadc'><td colspan=3></td></tr>
													<tr height=25 bgcolor='#ffeadc'>
                                                        <td align=center colspan=3>
                                                            <font face=tahoma size=2 color=red>
															    $error
                                                            </font>
                                                        </td>
													</tr>
													<tr height=10 bgcolor='#ffeadc'><td colspan=3></td></tr>
													";
        } else {
            echo "<tr height=10 bgcolor='#ffeadc'><td colspan=3></td></tr>";
        }
        echo "
							        <tr height=25 bgcolor='#ffeadc'>
										<td width=27% align=right ><font face=tahoma size=2 color=black><b> Add to Group </b></font></td>
										<td width=5% align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
										<td width=68% align=left>
										 <select id='user_newgroup'  name='user_newgroup'>
			                        ";
        //-----------------------------------------------------------------------------------------------//
        // $table = $sql[tb_x_member_sub];
        // $where = " where master_id='$_SESSION[x_member_id]' && type_id='0' ";
        // $sub_query = select($table, $where);
        // $each_group = mysql_num_rows($sub_query);

        $type_id = 0;
        $strSQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("si",$_SESSION['x_member_id'],$type_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $each_group = $result->num_rows; 
        $stmt->close();

        $type_name = "None Group&nbsp;[ " . $each_group . " ]";


        //-----------------------------------------------------------------------------------------------//
        echo "<option value='0'>$type_name </option>";
        // select  group type
        // $table = $sql[tb_x_member_type];
        // $where = " where member_id='$_SESSION[x_member_id]' ";
        // $query = select($table, $where);
        // $rows = mysql_num_rows($query);

        $msg = "SELECT * FROM tb_x_member_type WHERE member_id = ?";
        $stmt = $conn->prepare($msg);
        $stmt->bind_param("s",$_SESSION['x_member_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->num_rows; 

        //$groupid = trim($_POST[user_newgroup]);
        if ($rows >= 1) {
            for ($i = 1; $i <= $rows; $i++) {
                $data = $result->fetch_array();
                $type_name = $data["name"];
                $type_id = $data["type_id"];
                if ($type_id == $_SESSION["group_id_addAcc"]) {
                    $selectgroup = "selected";
                } else {
                    $selectgroup = "";
                }
                //-----------------------------------------------------------------------------------------------//
                // $table = $sql[tb_x_member_sub];
                // $where = " where master_id='$_SESSION[x_member_id]' && type_id='$type_id' ";
                // $sub_query = select($table, $where);
                // $each_group = mysql_num_rows($sub_query);

                $strSQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
                $query = $conn->prepare($strSQL);
                $query->bind_param("ss",$_SESSION['x_member_id'],$type_id);
                $query->execute();
                $result = $query->get_result();
                $each_group = $result->num_rows; 
                $query->close();


                $type_name = $type_name . "&nbsp;[ " . $each_group . " ]";

                //-----------------------------------------------------------------------------------------------//
                echo "
												<option value='$type_id' $selectgroup >$type_name </option>
											";
            }
        }
        echo "
							             </select>
										</td>
									</tr>
									<tr height=25 bgcolor='#ffeadc'>
										<td width=27% align=right ><font face=tahoma size=2 color=black><b> Username </b></font></td>
										<td width=5% align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
										<td width=68% align=left><input type=text size=15 name=add_user value=$_POST[add_user]>
											<font face=tahoma size=2 color=brown>* 8-20 Characters long</font>
										</td>
									</tr>
									<tr height=5 bgcolor='#ffeadc'><td colspan=3></td></tr>
									<tr height=25 bgcolor='#ffeadc'>
										<td align=right><font face=tahoma size=2 color=black><b> Password </b></font></td>
										<td align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
										<td align=left><input type=password size=15 name=add_pass>
											<font face=tahoma size=2 color=brown>* 8-20 Characters long</font>
										</td>
									</tr>
									<tr height=5 bgcolor='#ffeadc'><td colspan=3></td></tr>
									<tr height=25 bgcolor='#ffeadc'>
										<td align=right><font face=tahoma size=2 color=black><b> Re - Password </b></font></td>
										<td align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
										<td align=left><input type=password size=15 name=add_re>
											<font face=tahoma size=2 color=brown>* Same as Password</font>
										</td>
									</tr>
									<tr height=10 bgcolor='#ffeadc'><td colspan=3></td></tr>
									<tr height=25 bgcolor='#ffeadc'>
                                        <td align=left colspan=3>
                                            <font face=tahoma size=2 color=blue>
                                                &nbsp; * Please use \"a-z\" , \"A-Z\" , \"0-9\" , \"-\" , \"_\" , \"@\" or \".\"  <br> 
                                                &nbsp;&nbsp;&nbsp;&nbsp; to create Username and Password <br>
                                                &nbsp; * You can create Username as abcde_01 - abcde_10 ,<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;  abcde01 - abcde10  or abcde-01 - abcde-10<br> 
                                                &nbsp; * You can't duplicate usernames <br>
                                            </font>
                                        </td>
									</tr>
									<tr height=10 bgcolor='#ffeadc'><td colspan=3></td></tr>
									<tr height=25 bgcolor='#ffeadc'>
										<td align=right><font face=tahoma size=2 color=black><b>&nbsp;</b></font></td>
										<td align=center width=60><font face=tahoma size=2 color=black><b>&nbsp;</b></font></td>
										<td align=left>
											<input type=submit size=20 value='&nbsp; Add  &nbsp;' style='margin-left:50px;'>&nbsp;
										</td>
									</tr>
									<tr height=22 bgcolor='#ffeadc'>
										<td align=center colspan=3><font face=tahoma size=2 color=black><b>&nbsp;</b></font></td>
									</tr>
								</form>
								</table>
								";
        echo "	
					</td>
				</tr>
			</table><br>&nbsp;
			";
    } else {
        echo "<br>&nbsp;";
    }
    //-----------------------------------------------------------------------------------//	
    // mysql_close($connect);
}
?>