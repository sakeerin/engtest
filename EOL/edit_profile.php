<?php
session_start();
edit_profile_main();
// ini_set("display_errors", "1");
// error_reporting(E_ALL);

function edit_profile_main()
{
    include('../config/connection.php');
    // -------------------- //
    $select_a = NULL;
    $select_b = NULL;
    $error = array();
    $check = array(
        1 => 'ระดับประถมศึกษาตอนต้น',
        2 => 'ระดับประถมศึกษาตอนปลาย',
        3 => 'ระดับมัธยมศึกษาตอนต้น',
        4 => 'ระดับมัธยมศึกษาตอนปลาย',
        5 => 'ระดับอุดมศึกษา',
        6 => 'ระดับปริญญาตรี',
        7 => 'ระดับปริญญาโท',
        8 => 'ระดับปริญญาเอก',
        9 => 'อื่นๆ'
    );
    $msg_image = NULL;
    $msg_space = NULL;
    // -------------------- //
    $strSQL = "SELECT * FROM tb_x_member WHERE member_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_have = $result->num_rows;
    if ($is_have == 1) {
        $data = $result->fetch_array();
        $img_path = "http://localhost/engtest/2010/member_images/$data[member_id].jpg";
        $data_image = @getimagesize($img_path);
        if ($data_image[0] >= 1 && $data_image[0] - $data_image[0] == 0) {
            if ($data_image[0] >= 100) {
                $img_width = 90;
            }
            else {
                $img_width = $data_image[0];
            }
            $msg_image = "<img src='http://localhost/engtest/2010/member_images/$_SESSION[x_member_id].jpg' width='$img_width' style='border-radius: 6px;'>";
            $msg_br = "<br>";
            $msg_space = "&nbsp;&nbsp;&nbsp;";
        }
        $fname = $data['fname'] ?? $_POST['fname'];
        $lname = $data['lname'] ?? $_POST['lname'];
        $gender = $data['gender'] ?? $_POST['gender'];
        $education_level = $data['education_level'] ?? $_POST['education_a'];
        $email = $data['email'] ?? $_POST['email'];
        //-------------------------------------------------------------//
        if ($_GET['action'] == "edit_data") {
            if (!$_POST['fname']) {
                $error['fname'] = "Please Insert First Name";
            }
            if (!$_POST['lname']) {
                $error['lname'] = "Please Insert Last Name";
            }
            if (!$_POST['gender']) {
                $error['gender'] = "Please Select Gender";
            }
            if ($_POST['birth']) {
                $arr = explode("-", $_POST['birth']);
                if (count($arr) == 3) {
                    $birth_pass = checkdate($arr[1], $arr[2], $arr[0]); // ใช้ตรวจสอบว่าข้อมูลเป็นวันที่ที่ถูกต้องหรือไม่
                    if ($birth_pass == false) {
                        $error['birth'] = "Date of Birth is incorrect";
                    }
                }
                else {
                    $error['birth'] = "Date of Birth is correct";
                }
            }
            if (!$_POST['education_a'] || $_POST['education_a'] == 0) {
                $error['education_a'] = "Please Insert Education Level";
            }
            if (!$_POST['email']) {
                $error['email'] = "Please Insert Email";
            }
            else {
                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                    $error['email'] = 'Invalid email';
                }
            }
            // if ($_POST['email']) {
            //     if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            //         $error['email'] = 'Invalid email';
            //     }
            // }
            if (trim($_FILES['image']['type'])) {
                if (($_FILES['image']['type'] == "image/jpg" || $_FILES['image']['type'] == "image/jpeg") && $_FILES['image']['size'] <= 100000) {
                    $name = $_SESSION['x_member_id'] . ".jpg";
                    $temp = $_FILES['image']['tmp_name'];
                    $path = "/Applications/XAMPP/xamppfiles/htdocs/engtest/2010/member_images/" . $name;

                    // upload_image($name, $temp, $path);
                    move_uploaded_file($temp, $path);

                    if (file_exists($temp)) {
                        unlink($temp);
                    }
                }
                else {
                    $error['image'] = "Display image type or size is incorrect.";
                }
            }
            if (!$error) {
                $fname = $conn->real_escape_string($_POST['fname']);
                $lname = $conn->real_escape_string($_POST['lname']);
                $gender = $conn->real_escape_string($_POST['gender']);
                $birthday = $conn->real_escape_string($_POST['birth']);
                $education = $conn->real_escape_string($_POST['education_b']);
                $education_level = $conn->real_escape_string($_POST['education_a']);
                $address = $conn->real_escape_string($_POST['address']);
                $email = $conn->real_escape_string($_POST['email']);
                $tel = $conn->real_escape_string($_POST['tel']);

                $SQL = "UPDATE tb_x_member SET fname = ?, lname = ?, gender = ?, birthday = ?, education = ?, education_level = ?, address = ?, email = ?, tel = ? WHERE member_id = ?";
                $query = $conn->prepare($SQL);
                $query->bind_param("ssssssssss", $fname, $lname, $gender, $birthday, $education, $education_level, $address, $email, $tel, $_SESSION['x_member_id']);
                $query->execute();
                $query->close();

                echo "<script type=\"text/javascript\">
                            alert('Sucess update profile complete');
                            window.location = \"eoltest.php?section=business&&\";
                      </script>";
                exit;
            }
        }
        echo "<br>
                <div class='edit-profile'>
                    <p>Welcome to EngTest.net</p>
                </div>
			  <table align=center width=85% cellpadding=0 cellspacing=0 border=0>
                <form enctype=\"multipart/form-data\" method=post action='?section=$_GET[section]&&status=$_GET[status]&&action=edit_data'>	
                    <tr height=60>
                        <td align=center colspan=6 style='border-top-right-radius:10px;border-top-left-radius:10px; background:#3BB9FF;'><font size=3 face=tahoma color=white><b>Profile</b></font></td>
                    </tr>
                    <tr height=75 bgcolor='#fff'>
                        <td align=center colspan=6>
                            <font face=tahoma size=2 color=blue>
                                สามารถใส่ข้อมูลส่วนตัวด้วยภาษาไทยได้และต้องใส่ข้อมูลให้ครบในส่วนที่มีเครื่องหมาย <font face=tahoma size=2 color=red>*</font>
                                <br> การกด Save Profile จะแก้ไขเพียง Profile เท่านั้น จะไม่แก้ไข Password แต่อย่างใด
                            </font>
                        </td>
                    </tr>
                    <tr height=5 bgcolor='#fff'>
                        <td width=15% align=right ><font face=tahoma size=2 color=black><b>
                            <font face=tahoma size=2 color=red>*</font>&nbsp; First Name </b></font>
                        </td>
                        <td width=5% align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
                        <td width=10% align=left><input type=text class='inputstyle' name=fname value='$fname' style='width:83%' required></td>
                        
                        <td width=11% align=right ><font face=tahoma size=2 color=black><b>
                            <font face=tahoma size=2 color=red>*</font>&nbsp; Last Name </b></font>
                        </td>
                        <td width=5% align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
                        <td width=15% align=left><input type=text size=21 class='inputstyle' name=lname  value='$lname' required></td>
                    </tr>
                    <tr height=10 bgcolor='#fff'><td colspan=6></td></tr>
                    <tr height=25 bgcolor='#fff'>
                        <td width='15%' align=right><font face=tahoma size=2 color=black><font face=tahoma size=2 color=red>*</font>&nbsp;<b> Gender </b></font></td>
                        <td width='5%' align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
                        <td width='10%' align=left>
                            <font face=tahoma size=2 color=black><b>";

        if ($gender == 1) {
            $select_a = "checked";
        }
        if ($gender == 2) {
            $select_b = "checked";
        }
        echo "
							<input type=radio name=gender value='1' $select_a>&nbsp;Male
							<input type=radio name=gender value='2' $select_b>&nbsp;Female
						</td>
                        <td width='10%' align=right>
							<font face=tahoma size=2 color=red>*</font>&nbsp;<b>Date of Birth</b>
						</td>
                        <td width=5% align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
                        <td width='11%' alight=left>
                            <!-- ------------------------------------------------------------------------------ -->
							<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/engtest/calendar/epoch_styles.css\" />
							<script type=\"text/javascript\" src=\"http://localhost/engtest/calendar/epoch_classes.js\"></script>
							<script type=\"text/javascript\">
								/*You can also place this code in a separate file and link to it like epoch_classes.js*/
									var a;      
								window.onload = function () {
									a  = new Epoch('epoch_popup','popup',document.getElementById('popup_container_a'));
								};
							</script>
							<!-- ------------------------------------------------------------------------------ -->
                            <input class='inputstyle'  id='popup_container_a' type=text name=birth value='$data[birthday]' size=21 required>
                        </td>
					</tr>
					<tr height=10 bgcolor='#fff'><td colspan=6></td></tr>
					<tr height=25 bgcolor='#fff'>
						<td width='15%' align=right><font face=tahoma size=2 color=black><font face=tahoma size=2 color=red>*</font>&nbsp;<b> Education </b></font></td>
						<td width='5%' align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
						<td width='10%' align=left>
				";
        if ($education_level == 1) {
            $check[1] = "selected";
        }
        if ($education_level == 2) {
            $check[2] = "selected";
        }
        if ($education_level == 3) {
            $check[3] = "selected";
        }
        if ($education_level == 4) {
            $check[4] = "selected";
        }
        if ($education_level == 5) {
            $check[5] = "selected";
        }
        if ($education_level == 6) {
            $check[6] = "selected";
        }
        if ($education_level == 7) {
            $check[7] = "selected";
        }
        if ($education_level == 8) {
            $check[8] = "selected";
        }
        if ($deducation_level == 9) {
            $check[9] = "selected";
        }
        echo "          <select name='education_a' style='height:32px'>
                            <option value='0'>- Select your education level -</option>
                            <option value='1' $check[1]>ระดับประถมศึกษาตอนต้น</option>
                            <option value='2' $check[2]>ระดับประถมศึกษาตอนปลาย</option>
                            <option value='3' $check[3]>ระดับมัธยมศึกษาตอนต้น</option>
                            <option value='4' $check[4]>ระดับมัธยมศึกษาตอนปลาย</option>
                            <option value='5' $check[5]>ระดับอุดมศึกษา</option>
                            <option value='6' $check[6]>ระดับปริญญาตรี</option>
                            <option value='7' $check[7]>ระดับปริญญาโท</option>
                            <option value='8' $check[8]>ระดับปริญญาเอก	</option>
                            <option value='9' $check[9]>อื่นๆ </option>
			            </select>
                    </td>
                    <td width='11%' align='right'><font face=tahoma size=2 color=black><b> School Name </b></font></td>
                    <td width='5%' align='center'><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
			        <td width='10%' align='left'><input  class='inputstyle' type=text size=21 name=education_b value='$data[education]'></td>
			    </tr>
				<tr height=10 bgcolor='#fff'><td colspan=6></td></tr>
				<tr height=25 bgcolor='#fff'>
					<td width='15%' align=right><font face=tahoma size=2 color=black><b> Address </b></font></td>
					<td width='5%' align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
					<td align=left colspan=4>
                        <textarea name='address' style='width:91.6%' rows=3>$data[address]</textarea>
					</td>
				</tr>
				<tr height=10 bgcolor='#fff'><td colspan=6></td></tr>
				<tr height=5 bgcolor='#fff'>
					<td width='15%' align=right ><font face=tahoma size=2 color=black><font face=tahoma size=2 color=red>*</font>&nbsp;<b> E-mail </b></font></td>
					<td width='5%' align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
					<td width='10%' align=left >
						<input class='inputstyle'  type=text name=email  value='$email' style='width:83%' required>&nbsp;&nbsp;&nbsp;
					</td>
                    <td width='11%' align=right><font face=tahoma size=2 color=black><b> Tel. </b></font></td>
                    <td width='5%' align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
                    <td width='10%' align=left><input class='inputstyle'  type=number name=tel  value='$data[tel]' style='width:73%' ></td>
				</tr>
				<tr height=10 bgcolor='#fff'><td colspan=6></td></tr>
				<tr height=25 bgcolor='#fff'>
					<td align=right><font face=tahoma size=2 color=black><b> Display Image </b></font></td>
					<td align=center><font face=tahoma size=2 color=black><b>&nbsp;:&nbsp;</b></font></td>
					<td align=left colspan=4>
						<table align=center width=100% cellpadding=0 cellspacing=0 border=0>
							<tr>
								<td rowspan=2 align=center> $msg_image </td>
								<td width=100%>$msg_space<input  class='inputstyle' name='image' type='file' style='width:31%'></td>
							</tr>
							<tr>
								<td width=100%>
									<font size=2 face=tahoma color=blue>
									 " . $msg_space . "Image Type : .jpg &nbsp; Image Size : Less than 100 KB &nbsp; Width : 100 px &nbsp; Height : 100 px</font>
								</td>
							</tr>
						</table>
					</td>
				</tr>";
        if ($error) {
            echo "
				<tr height=20 bgcolor='#fff'><td colspan=6></td></tr>
				<tr height=20 bgcolor='#fff'>
					<td width=15% align=right ><font face=tahoma size=2 color=black><b>&nbsp;</b></font></td>
					<td width=5% align=center><font face=tahoma size=2 color=black><b>&nbsp;</b></font></td>
					<td align=left colspan=6>
						<font size=2 face=tahoma color=red>";

            if ($error['fname']) {
                echo "&nbsp;$error[fname]<br>";
            }
            if ($error['lname']) {
                echo "&nbsp;$error[lname]<br>";
            }
            if ($error['gender']) {
                echo "&nbsp;$error[gender]<br>";
            }
            if ($error['birth']) {
                echo "&nbsp;$error[birth]<br>";
            }
            if ($error['education_a']) {
                echo "&nbsp;$error[education_a]<br>";
            }
            if ($error['education_b']) {
                echo "&nbsp;$error[education_b]<br>";
            }
            if ($error['address']) {
                echo "&nbsp;$error[address]<br>";
            }
            if ($error['email']) {
                echo "&nbsp;$error[email]<br>";
            }
            if ($error['tel']) {
                echo "&nbsp;$error[tel]<br>";
            }
            if ($error['image']) {
                echo "&nbsp;$error[image]<br>";
            }
            echo "
							</font>
						</td>
					</tr>";
        }
        echo "
					<tr height=20 bgcolor='#fff'><td colspan=6></td></tr>
					<tr height=25 bgcolor='#fff'>
						<td align=right><font face=tahoma size=2 color=black><b>&nbsp;</b></font></td>
						<td align=center><font face=tahoma size=2 color=black><b>&nbsp;</b></font></td>
						<td align=left colspan=4>
							<input type=submit id=reg_submit value=' Save Profile '  class='myButton'>
						</td>
					</tr>
					<tr height=20><td colspan=6 style='border-bottom-right-radius:10px;border-bottom-left-radius:10px; background:#fff;'></td></tr>
				</form>
				</table><br>&nbsp;";

        //---------------------------------------------------------------------//
        //------------------- Check in case have Edit password ----------------//
        //---------------------------------------------------------------------//

        if ($_GET['action'] == "edit_pass") {
            $old = $_POST['old'] ?? '';
            $new_a = $_POST['new_a'] ?? '';
            $new_b = $_POST['new_b'] ?? '';

            if (!$_POST['old']) {
                $error['old'] = "Please Insert Password";
            }
            if (!$_POST['new_a']) {
                $error['new_a'] = "Please Insert New Password";
            }
            if ($_POST['new_a'] && strlen($_POST['new_a']) <= 7) {
                $error['new_a'] = "New Password must have 8-20 Characters long";
                $new_a = '';
            }
            if (!$_POST['new_b']) {
                $error['new_b'] = "Please Insert Re - New Password";
            }
            if ($_POST['new_b'] && strlen($_POST['new_b']) <= 7) {
                $error['new_b'] = "Re - New Password must have 8-20 Characters long";
                $new_b = '';
            }
            if ($_POST['new_a'] != $_POST['new_b']) {
                $error['new_b'] = "Re - New Password not same as New Password";
                $new_b = '';
            }

            if (!$error) {
                $pass = $conn->real_escape_string($_POST['old']);

                $str = "SELECT * FROM tb_x_member WHERE member_id = ? && pass = ?";
                $sub_stmt = $conn->prepare($str);
                $sub_stmt->bind_param("ss", $_SESSION['x_member_id'], $pass);
                $sub_stmt->execute();
                $result = $sub_stmt->get_result();
                $is_same = $result->num_rows;

                if ($is_same == 1) {
                    $new_pass = $conn->real_escape_string($_POST['new_a']);
                    $sql = "UPDATE tb_x_member SET pass = ? WHERE member_id = ?";
                    $sub_query = $conn->prepare($sql);
                    $sub_query->bind_param("ss", $new_pass, $_SESSION['x_member_id']);
                    $sub_query->execute();
                    $sub_query->close();

                    echo "<script type=\"text/javascript\">
					          alert('Sucess password change complete');
							  window.location = \"eoltest.php?section=business&&status=edit_profile\";
						  </script>";
                    exit;
                }
                else {
                    $error['old'] = "Old Password is Incorrect";
                    $old = '';
                }
                $sub_stmt->close();
            }
        }


        if ($_GET['action'] == "" or $_GET['action'] == "edit_data") {
            // ----------- แสดงข้อความ "หากต้องการเปลี่ยน Password โปรดคลิ๊กที่นี่ [Change Password : Click Here]" ------ //
            echo "
				<div id='pass_msg' align=center style='cursor:pointer'
						onclick=\"javascript:document.getElementById('pass_form').style.display='';
									document.getElementById('pass_msg').style.display='none';
								\">			
					<font size=2 face=tahoma color='blue'><b>หากต้องการเปลี่ยน Password โปรดคลิ๊กที่นี่ [Change Password : Click Here]</b></font>
				</div>
				<table id='pass_form' align=center width=70% cellpadding=0 cellspacing=0 border=0 style='display:none'>";
        }

        // -------------- EDIT PASSWORD FORM ----------------- //
        if ($_GET['action'] == "edit_pass") {
            echo "<table id='pass_form' align=center width=70% cellpadding=0 cellspacing=0 border=0 style='display='>";
        }

        echo "
			<form method=post action='?section=$_GET[section]&&status=$_GET[status]&&action=edit_pass'>	
				<tr height=50>
					<td align=center colspan=6 style='border-top-right-radius:10px;border-top-left-radius:10px; background:#0096ce;'><font size=3 face=tahoma color=white><b>Edit Password</b></font></td>
				</tr>
				<tr height=75 bgcolor='#d4f6fc'>
					<td align=center colspan=6>
						<font face=tahoma size=2 color=blue>
							Password ใหม่ต้องยาว 8-20 ตัวอักษรและต้องเป็น a-z , A-Z หรือ 0-9 เท่านั้น <br> การกด Edit Password จะแก้ไขเพียง Password เท่านั้น จะไม่แก้ไข Profile แต่อย่างใด
						</font>
					</td>
				</tr>
				<tr height=25 bgcolor='#d4f6fc'>
					<td align=right width=20%><font size=2 face=tahoma><b>Username</b></font></td>
					<td align=center width=3%><font size=2 face=tahoma><b>&nbsp;:&nbsp;</b></font></td>
					<td align=left width=20%><font size=2 face=tahoma><b>$data[user]</b></font></td>
					<td align=right width=20%><font size=2 face=tahoma><b>Old Password</b></font></td>
					<td align=center width=3%><font size=2 face=tahoma><b>&nbsp;:&nbsp;</b></font></td>
					<td align=left width=24%><input type='password' size='18' name='old' value='$old' placeholder='&nbsp;Old Password' required></td>
				</tr>
				<tr height=10 bgcolor='#d4f6fc'><td colspan=6></td></tr>
				<tr height=25 bgcolor='#d4f6fc'>
					<td align=right width=20%><font size=2 face=tahoma><b>New Password</b></font></td>
					<td align=center ><font size=2 face=tahoma><b>&nbsp;:&nbsp;</b></font></td>
					<td align=left width=22%><input type='password' size='16' name='new_a' value='$new_a' placeholder='&nbsp;New Password' required></td>
					<td align=right width=20%><font size=2 face=tahoma><b>Re - New Password</b></font></td>
					<td align=center ><font size=2 face=tahoma><b>&nbsp;:&nbsp;</b></font></td>
					<td align=left width=24%><input type='password' size='18' name='new_b' value='$new_b' placeholder='&nbsp;Re - New Password' required></td>
				</tr>";
        if ($error) {
            echo "
				<tr height=20 bgcolor='#d4f6fc'><td colspan=6></td></tr>
				<tr height=20 bgcolor='#d4f6fc'>
					<td width=100% align=left colspan=6>
					    <font size=2 face=tahoma color=red>";
            if ($error['old']) {
                echo "<center>$error[old]</center>";
            }
            if ($error['new_a']) {
                echo "<center>$error[new_a]</center>";
            }
            if ($error['new_b']) {
                echo "<center>$error[new_b]</center>";
            }
            echo "
					    </font>
					</td>
				</tr>";
        }
        echo "
				<tr height=20 bgcolor='#d4f6fc'><td colspan=6></td></tr>
				<tr height=25 bgcolor='#d4f6fc'><td colspan=6 align=center><input type=submit value='&nbsp; Edit Password &nbsp;' class='btn-edit-pass'></td></tr>
				<tr height=20 ><td colspan=6 style='border-bottom-right-radius:10px;border-bottom-left-radius:10px; background:#d4f6fc;'></td></tr>
			</form>
		</table><br>&nbsp;";
    }
    $stmt->close();
    mysqli_close($conn);

}