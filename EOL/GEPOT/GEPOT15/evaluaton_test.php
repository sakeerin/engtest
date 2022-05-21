<?php
session_start();
main_test();

function main_test()
{
    include('../config/connection.php');
    // ini_set("display_errors", "1");
    // error_reporting(E_ALL);
    // echo "TEST & EVALUATION<br>";

    unset($_SESSION['x_skill_id']);
    unset($_SESSION['x_level_id']);
    unset($_SESSION['amount']);
    unset($_SESSION['quiz_id']);
    unset($_SESSION['ans']);
    unset($_SESSION['all_time']);
    unset($_SESSION['fn_time']);
    if ($_GET['sub_action'] == "set_test") {
        if ($_GET['skill_id'] >= 1 && $_GET['level_id'] >= 1 && $_GET['skill_id'] - $_GET['skill_id'] == 0 && $_GET['level_id'] - $_GET['level_id'] == 0) {
            $_SESSION['x_skill_id'] = $_GET['skill_id'];
            $_SESSION['x_level_id'] = $_GET['level_id'];

            echo "<script type=\"text/javascript\">
			            window.location=\"systemtest.php?action=set_test\";
		          </script>";

            exit();
        }
        else {
            header("Location:?section=$_GET[section]&&action=academic");
            exit();
        }
    }

    //------------------------------------------------------------//
    $allow = NULL;
    for ($skill = 1; $skill <= 10; $skill++) {
        if ($skill == 6) {
            $skill = 7;
        }
        if ($skill == 8) {
            $skill = 10;
        }
        for ($level = 1; $level <= 5; $level++) {
            $data_list = NULL;
            $percent = 0;
            $msg_button[$skill][$level] = " disabled=\"true\" ";
            $msg_not_allow[$skill][$level] = " <font size=2 face=tahoma color=red>Must pass the lower level at least 50%</font> ";
            //----------------------------------------------------------------//
            // $table = $sql[tb_w_result];
            // $msg = " select percent from $table where 
            //                  member_id='$_SESSION[x_member_id]' && level_id='$level' && skill_id='$skill'
            //               group by percent order by percent DESC limit 0,1 ";
            // $query = mysql_query($msg);
            // $is_have = mysql_num_rows($query);

            // if ($is_have == 1) {
            //     $data = mysql_fetch_array($query);
            //     $percent = $data[percent];
            //     if ($percent >= 50) {
            //         $msg_button[$skill][$level] = "";
            //         $msg_not_allow[$skill][$level] = "";
            //     }
            // }
            $strSQL = "SELECT percent FROM tb_w_result WHERE member_id = ? && level_id = ? && skill_id = ? GROUP BY percent ORDER BY percent DESC limit 0,1";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("sss", $_SESSION['x_member_id'], $level, $skill);
            $stmt->execute();
            $result = $stmt->get_result();
            $is_have = $result->num_rows;
            if ($is_have == 1) {
                $data = $result->fetch_array();
                $percent = $data['percent'];
                if ($percent >= 50) {
                    $msg_button[$skill][$level] = "";
                    $msg_not_allow[$skill][$level] = "";
                }
            }
            $stmt->close();
        }
    }
    mysqli_close($conn);
    //------------------------------------------------------------//
    $font = "<font size=3 face=tahoma color=black>";
    //-----------------------------------------------//

    echo "<div style='position:absolute;margin-top:350px;margin-left:px;z-index:;width:970;'>
			<table align=center width=970px cellpading=0 cellspacing=0 border=0 >
				<tr valign=top >
					<td width=60%>
						<table align=center width=70% cellpadding=5 cellspacing=0 border=0>
							<tr height=50>
								<td colspan=2 style='border-top-right-radius:10px;border-top-left-radius:10px; background:#ffb208;'>
									<font size=4 color=white face=tahoma><b>&nbsp; &raquo; Single Skill</b></font><br>
								</td>
							</tr>";

    $skill_name[1] = "Reading Comprehension";
    $skill_name[2] = "Listening Comprehension";
    $skill_name[3] = "Semi-Speaking";
    $skill_name[4] = "Semi-Writing";
    $skill_name[5] = "Grammar";
    $skill_name[6] = "Integradt Skill : Cloze Test";
    $skill_name[7] = "Vocabulary";

    for ($k = 1; $k <= 7; $k++) {
        if ($k != 6) {
            echo "
				<tr height=40>
					<td bgcolor='#fff0d9' colspan=2>
						<div style='cursor:pointer' id='skill_" . $k . "_a'
							onclick=\"javascript:
										document.getElementById('level_list_" . $k . "').style.display='';
										document.getElementById('skill_" . $k . "_a').style.display='none';
										document.getElementById('skill_" . $k . "_b').style.display='';
									\">

							$font <font color=black size=3><b>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&raquo; $skill_name[$k] <br>
							</b></font>
						</div>
						<div style='cursor:pointer; display:none;' id='skill_" . $k . "_b'
							onclick=\"javascript:
										document.getElementById('level_list_" . $k . "').style.display='none';
										document.getElementById('skill_" . $k . "_a').style.display='';
										document.getElementById('skill_" . $k . "_b').style.display='none';
									\">
							$font <font color=black size=3><b>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&laquo; $skill_name[$k] <br>
							</b></font>
						</div>
					</td>
				</tr>
				<tr id='level_list_" . $k . "'  style='display:none;'><td colspan=2 bgcolor='#f7f7f7'>
						";
            $level_name[1] = "Beginner";
            $color[1] = "#ffb208";
            $level_name[2] = "Lower Intermediate";
            $color[2] = "#e29805";
            $level_name[3] = "Intermediate";
            $color[3] = "#c98205";
            $level_name[4] = "Upper Intermediate";
            $color[4] = "#aa6b05";
            $level_name[5] = "Advanced";
            $color[5] = "#8e5503";
            for ($i = 1; $i <= 5; $i++) {
                echo "
					<table align=center width=100% cellpadding=0 cellspacing=0 border=0> 
						<tr height=32 >
							<td width=8%>&nbsp;</td>
							<td width=32% >$font <b><font color='$color[$i]'>&raquo; $level_name[$i]</b></font></font></td>
							<td width=47% align=right>" . $msg_not_allow[$k][$i - 1] . "</td>
							<td width=13% align=right>
								<input class='btn-goto-test' type=button value=' Test ' " . $msg_button[$k][$i - 1] . " style=\"font-size:13px; border:1px solid #ccc; font-weight:bold;\"
									onclick=\"javascript:
									location.href='?section=$_GET[section]&&action=academic&&sub_action=set_test&&skill_id=$k&&level_id=$i';
											\"
								>
							</td>
						</tr>
					</table>";
            }
            echo "</tr>";
        }
    }
    echo "
        <tr height=15><td colspan=2 style='border-bottom-right-radius:10px;border-bottom-left-radius:10px; background:#fff0d9;'></td></tr>
        <!-- ------------------------------------------------------- -->
        <!-- ------------------------------------------------------- -->
        <tr height=25><td colspan=2></td></tr>
    </table>
    <table align=center width=70% cellpadding=5 cellspacing=0 border=0>
        <tr height=50  >
            <td colspan=2 style='border-top-right-radius:10px;border-top-left-radius:10px; background:#ffb208;'>
                <font size=4 color=white face=tahoma><b>&nbsp; &raquo; Multiple Skills</b></font><br>
            </td>
        </tr>
        <tr height=40>
            <td bgcolor='#fff0d9' colspan=2>
                <div style='cursor:pointer' id='multi_a'
                    onclick=\"javascript:
                                document.getElementById('level_multi').style.display='';
                                document.getElementById('multi_a').style.display='none';
                                document.getElementById('multi_b').style.display='';
                            \">
                    $font <font color=black><b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &raquo; Multiple Skills <br>
                    </b></font></font>
                </div>
                <div style='cursor:pointer; display:none;' id='multi_b'
                    onclick=\"javascript:
                                document.getElementById('level_multi').style.display='none';
                                document.getElementById('multi_a').style.display='';
                                document.getElementById('multi_b').style.display='none';
                            \">
                    $font <font color=black><b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &laquo; Multiple Skills <br>
                    </b></font>
                </div>
            </td>
        </tr>
        <tr id='level_multi'  style='display:none;'><td colspan=2 bgcolor='#f7f7f7'>";

    $level_name[1] = "Beginner";
    $color[1] = "#ffb208";
    $level_name[2] = "Lower Intermediate";
    $color[2] = "#e29805";
    $level_name[3] = "Intermediate";
    $color[3] = "#c98205";
    $level_name[4] = "Upper Intermediate";
    $color[4] = "#aa6b05";
    $level_name[5] = "Advanced";
    $color[5] = "#8e5503";
    for ($i = 1; $i <= 5; $i++) {
        echo "
        <table align=center width=100% cellpadding=0 cellspacing=0 border=0> 
            <tr height=32 >
                <td width=8%>&nbsp;</td>
                <td width=32% >$font <b><font color='$color[$i]'>&raquo; $level_name[$i]</b></font></td>
                <td width=47% align=right>" . $msg_not_allow[10][$i - 1] . "</td>
                <td width=13% align=right>
                    <input class='btn-goto-test' type=button value=' Test ' " . $msg_button[10][$i - 1] . " style=\"font-size:13px; border:1px solid #ccc; font-weight:bold;\"
                        onclick=\"javascript:
                                    location.href='?section=$_GET[section]&&action=academic&&sub_action=set_test&&skill_id=10&&level_id=$i';
                                \">
                </td>
            </tr>
</table>";
    }
    echo "
                    </tr>
                    <tr height=15><td colspan=2 style='border-bottom-right-radius:10px;border-bottom-left-radius:10px; background:#fff0d9;'></td></tr>
                    <!-- ------------------------------------------------------- -->
                    <!-- ------------------------------------------------------- -->
                    <tr height=10><td colspan=2></td></tr>
                </table>
            </td>
        </tr>	
    </table><br>&nbsp;
    </div>
    <img src='http://localhost/engtest/images/image2/eol system/bg-test-evo1.png' width='970' height='' style='border-radius:10px;'/>";
//-----------------------------------------------//

}

?>