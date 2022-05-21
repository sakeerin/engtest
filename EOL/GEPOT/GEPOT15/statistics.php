<?php
// include('../config/connection.php');
session_start();
corporate_statistics_main();


function corporate_statistics_main()
{
?>
<ul class='tabs'>
    <a href='?section=business&&status=statistics&&action=view_group'>
        <li data-tab-target='#overview' class="<?=($_GET['action'] == "view_group") ? "active" : ""; ?> tab">Overview
            Statistic</li>
    </a>
    <a href='?section=business&&status=statistics&&action=view_graph'>
        <li data-tab-target='#evaluation' class="<?=($_GET['action'] == "view_graph") ? "active" : ""; ?> tab">
            Test & Evaluation</li>
    </a>
    <a href='?section=business&&status=statistics&&action=view_contest'>
        <li data-tab-target='#contest' class="<?=($_GET['action'] == "view_contest") ? "active" : ""; ?> tab">EOL
            Contest</li>
    </a>
</ul>
<hr>
<div class='tab-content'>
    <div id='overview' data-tab-content class="<?=($_GET['action'] == "view_group") ? "active" : ""; ?>">
        <?php overview_statistic(); ?>
    </div>
    <div id='evaluation' data-tab-content class="<?=($_GET['action'] == "view_graph") ? "active" : ""; ?>">
        <?php evaluation_statistic(); ?>
    </div>
    <div id='contest' data-tab-content class="<?=($_GET['action'] == "view_contest") ? "active" : ""; ?>">
        <?php eol_contest_statistic(); ?>
    </div>
</div>
<?php
}

function overview_statistic()
{
    include('../config/connection.php');
    if ($_GET['action'] == "view_group") {
        echo "
            <link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/engtest/calendar/epoch_styles.css\" />
            <script type=\"text/javascript\" src=\"http://localhost/engtest/calendar/epoch_classes.js\"></script>
            <script type=\"text/javascript\">
            /*You can also place this code in a separate file and link to it like epoch_classes.js*/
                var ax,bx,cx,ex;      
                window.onload = function () {
                    ax  = new Epoch('epoch_popup','popup',document.getElementById('popup_container_a'));
                    bx  = new Epoch('epoch_popup','popup',document.getElementById('popup_container_b'));
                };
            </script>";
        $group_id = isset($_POST["group_id"]) ? $_POST["group_id"] : $_SESSION["group_id"];
        $_SESSION["group_id"] = $group_id;
    }

    echo "<center><h1>Overview Statistic</h1></center>";
    // if ($_GET["action"] == "view_group") {
    //     $group_id = isset($_POST["group_id"]) ? $_POST["group_id"] : $_SESSION["group_id"];
    //     $_SESSION["group_id"] = $group_id;
    // header("Location:?section=$_GET[section]&&status=$_GET[status]&&$_GET[action]=view_group");
    // }
    // $strSQL = "SELECT tb_x_member.member_id, tb_x_member.fname, tb_x_member.lname FROM tb_x_member_sub,tb_x_member WHERE tb_x_member_sub.master_id = ? && tb_x_member_sub.sub_id = tb_x_member.member_id && tb_x_member.fname != '' && tb_x_member_sub.type_id = ?";
    // $stmt = $conn->prepare($strSQL);
    // $stmt->bind_param("ss",$_SESSION['x_member_id'],$_SESSION['group_id']);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $num = $result->num_rows;
    // $stmt->close();
    // if ($num >= 1) {

    //--------------------------------------------------------------------------//
    if (isset($_POST["start"]) && isset($_POST["stop"])) {
        // $_SESSION["start"] = trim($_POST["start"]);
        // $_SESSION["stop"] = trim($_POST["stop"]);
        $start = trim($_POST["start"]);
        $stop = trim($_POST["stop"]);
        $time_event = " && ( create_date >= '$start' && create_date <= '$stop' ) ";
    }
    else {
        $start = date("Y-m-d", time() - (60 * 60 * 24 * 30));
        $stop = date("Y-m-d", time() + (60 * 60 * 24 * 1));
        $time_event = " && ( create_date >= '$start' && create_date <= '$stop' ) ";
    }

    //---------------------------------------------------------------------------------------//
    // form select date
    //---------------------------------------------------------------------------------------//
    echo "
			<table align='center' width='60%' bgcolor='#f0f0f0' cellpadding='0' cellspacing='0' border='0' style='border-radius: 8px;'>
				<form method='post'  id='placeholder' action='?section=$_GET[section]&&status=$_GET[status]&&action=view_group'>	
					<tr height='50' valign='middle'>
						<td align='right' width='13%'><font size='2' face=tahoma color=black><b>From &nbsp; : &nbsp;</b></font></td>
						<td align='left' width='27%'>&nbsp;<input id='popup_container_a' type='text' name='start' value='$start' size='15' style='height:23px;border-radius:8px;border:1px solid #bbb2ae' required></td>
						<td align='right' width='13%'><font size='2' face=tahoma color=black><b>Until &nbsp; : &nbsp;</b></font></td>
						<td align='left' width='27%'>&nbsp;<input id='popup_container_b' type='text' name='stop' value='$stop' size='15' style='height:23px;border-radius:8px;border:1px solid #bbb2ae' required></td>
					</tr>
                    <tr height=50>
                        <td align=right width=7%><font size=2 face=tahoma><b>View &nbsp; : &nbsp;</b></font></td>
                        <td align=left width=40% colspan='2'>
                            <select name='group_id' style='float:left; height:28px; background:#b3e9ff; border: 2px solid #6ccff7; border-radius:5px;' title='Please select group you want view'>";
    //--------------------------------------------------------------------------//
    // }

    $type_id = 0;
    $SQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
    $query = $conn->prepare($SQL);
    $query->bind_param("si", $_SESSION['x_member_id'], $type_id);
    $query->execute();
    $result = $query->get_result();
    $each_group = $result->num_rows;
    $query->close();
    $type_name = "None Group&nbsp;[ " . $each_group . " ]";

    echo "<option value='0'>$type_name</option>";

    $sql = "SELECT * FROM tb_x_member_type WHERE member_id = ? ORDER BY name";
    $sub_stmt = $conn->prepare($sql);
    $sub_stmt->bind_param("s", $_SESSION['x_member_id']);
    $sub_stmt->execute();
    $result = $sub_stmt->get_result();
    $rows = $result->num_rows;

    $j = 1;
    while ($row = $result->fetch_assoc()) {
        $temp_id[$j] = $row['type_id'];
        $temp_name[$j] = $row['name'];
        $j++;
    }
    $sub_stmt->close();

    if ($rows >= 1) {
        for ($i = 1; $i <= $rows; $i++) {
            $type_name = $temp_name[$i]; // name
            $type_id = $temp_id[$i]; // type_id 
            //-----------------------------------------------------------------------------------------------//
            // $table = $sql[tb_x_member_sub];
            // $where = " where master_id='$_SESSION[x_member_id]' && type_id='$type_id' ";
            // $x_query = select($table, $where);
            // $each_group = mysql_num_rows($x_query);

            $strSQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
            $sub_query = $conn->prepare($strSQL);
            $sub_query->bind_param("ss", $_SESSION['x_member_id'], $type_id);
            $sub_query->execute();
            $result = $sub_query->get_result();
            $each_group = $result->num_rows;
            $type_name = $type_name . "&nbsp;[ " . $each_group . " ]";
            $sub_query->close();
            //-----------------------------------------------------------------------------------------------//
            if ($type_id == $_SESSION["group_id"]) {
                $select = "selected";
            }
            else {
                $select = "";
            }
            echo "<option value='$type_id' $select>$type_name </option>";
        }
    }
    echo "  </select></td>
            <td align='center' width='20%'><input type='submit' value='View Statistics' style='font-weight:bold;' class='view_statistic'></td>
        </form>
    </table><br>";

    //------------------------------viewstatistic--------------------------------//
    //-----------------------------แสดงรายละเอียดสติถิ------------------------------//

    echo "<table align=center width=90% cellpadding=5 cellspacing=1 border=0 >
				<tr height=25 bgcolor='#aaaaaa'>
					<td width=5% align=center rowspan=2><font size=2 face=tahoma color=white><b>No.</b></font></td>
					<td width=22% align=center rowspan=2><font size=2 face=tahoma color=white><b>Name</b></font></td>
					<td width=75% align=center colspan=5><font size=2 face=tahoma color=white><b>Statistics &nbsp; : &nbsp; Most Percent [ Test Amount ] </b></font></td>
				</tr>
				<tr height=40>
					<td align=center width=15% bgcolor='#aaaaaa'>
						<font color='white' face=tahoma size=2><b>Beginner</b></font>
					</td>
					<td align=center width=15% bgcolor='#aaaaaa'>
						<font color='white' face=tahoma size=2><b>Lower<br>Intermediate</b></font>
					</td>
					<td align=center width=15% bgcolor='#aaaaaa'>
						<font color='white' face=tahoma size=2><b>Intermediate</b></font>
					</td>
					<td align=center width=15% bgcolor='#aaaaaa'>
						<font color='white' face=tahoma size=2><b>Upper<br>Intermediate</b></font>
					</td>
					<td align=center width=15% bgcolor='#aaaaaa'>
						<font color='white' face=tahoma size=2><b>Advanced</b></font>
					</td>
				</tr>
		  </table>";

    $strSQL = "SELECT tb_x_member.member_id, tb_x_member.fname, tb_x_member.lname FROM tb_x_member_sub,tb_x_member WHERE tb_x_member_sub.master_id = ? && tb_x_member_sub.sub_id = tb_x_member.member_id && tb_x_member.fname != '' && tb_x_member_sub.type_id = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $_SESSION['x_member_id'], $_SESSION['group_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->num_rows;

    $j = 1;
    while ($data = $result->fetch_assoc()) {
        $temp_id[$j] = $data['member_id'];
        $temp_fname[$j] = $data['fname'];
        $temp_lname[$j] = $data['lname'];
        $j++;
    }
    $stmt->close();

    for ($i = 1; $i <= $num; $i++) {
        $amount = NULL;
        $correct = NULL;
        $percent = NULL;
        $total_correct = NULL;
        $total_amount = NULL;
        $total_percent = NULL;
        $most_percent = NULL;
        $amount = NULL;
        //-----------------------------------------------------------------------------------------------------------------------------------//
        $member_id = $temp_id[$i];
        $fname = $temp_fname[$i];
        $lname = $temp_lname[$i];
        echo "<br>
				  <table align=center width=90% cellpadding=5 cellspacing=0 border=0>	
				    <tr height=25 valign=top>
					    <td width=5% align=center rowspan=7 bgcolor='#e0e0e0'><font size=2 face=tahoma >$i.</font></td>
						<td align=left bgcolor='#e0e0e0' colspan=6>
							<a target=_blank href='?section=$_GET[section]&&action=report&&member_id=$member_id'>
								<font color='black' face=tahoma size=2> $fname &nbsp; &nbsp; $lname &nbsp; &nbsp; </font>
							</a>
						</td>
					</tr>";
        //------------------------------------------------------------------------------------------------------//
        //----------------------------------- V.3 The Most / [Amount] -------------------------------------------//
        //------------------------------------------------------------------------------------------------------//	
        for ($skill = 1; $skill <= 10; $skill++) {
            if ($skill == 6) {
                $skill = 7;
            }
            if ($skill == 8) {
                $skill = 10;
            }
            for ($level = 1; $level <= 5; $level++) {
                // $msg = " select result_id,level_id,skill_id,percent from tbl_w_result where
                // 				member_id='$member_id' && level_id='$level' && skill_id='$skill' $time_event
                // 				order by percent DESC
                // 				";
                // $test_query = mysql_query($msg);
                // $rows = mysql_num_rows($test_query);

                $sql = "SELECT result_id,level_id, skill_id, percent FROM tb_w_result WHERE member_id = ? && level_id = ? && skill_id = ? $time_event order by percent DESC";
                $sub_stmt = $conn->prepare($sql);
                $sub_stmt->bind_param("sss", $member_id, $level, $skill);
                $sub_stmt->execute();
                $result = $sub_stmt->get_result();
                $rows = $result->num_rows;
                if ($rows == 0) {
                    $most_percent[$level][$skill] = 0;
                    $amount[$level][$skill] = 0;
                }
                if ($rows >= 1) {
                    $amount[$level][$skill] = $rows;
                    $test_data = $result->fetch_array();
                    // -------------- percent -------------------- //
                    $most_percent[$level][$skill] = $test_data['percent'];
                }
                $sub_stmt->close();
            }
        }
        //-------------------------------------------------------------------------------//
        $skill_name = array("", "Reading Comprehension", "Listening Comprehension", "Semi - Speaking", "Semi - Writing",
            "Grammar", "", "Vocabulary", "", "", "Multiple Skills");
        $level_name = array("", "Beginner", "Lower Intermediate", "Intermediate", "Upper Intermediate", "Advanced");
        for ($skill = 1; $skill <= 10; $skill++) {
            if ($skill == 6) {
                $skill = 7;
            }
            if ($skill == 8 || $skill == 9) {
                $skill = 10;
            }
            echo "<tr height=25>";
            if ($skill == 10) {
                echo "
						<td width=5% align=center rowspan=8 bgcolor='#e0e0e0' >
							<img id='icon_" . $member_id . "_a' src='http://localhost/engtest/2010/temp_images/icon_plus.jpg' width=20 border=0 title='Click Here to view refill history'
								onclick=\"javascript:
											document.getElementById('icon_" . $member_id . "_a').style.display='none';
											document.getElementById('icon_" . $member_id . "_b').style.display='';
											document.getElementById('table_" . $member_id . "').style.display='';
							\"><img id='icon_" . $member_id . "_b' src='http://localhost/engtest/2010/temp_images/icon_sub.jpg' width=20 border=0 style='display:none'
								onclick=\"javascript:
											document.getElementById('icon_" . $member_id . "_b').style.display='none';
											document.getElementById('icon_" . $member_id . "_a').style.display='';
											document.getElementById('table_" . $member_id . "').style.display='none';
							\">
						</td>
							";
            }

            echo "
						<td align=right width=22% bgcolor='#f0f0f0'>
							<font color='black' face=tahoma size=2>$skill_name[$skill] &nbsp;&nbsp; </font>
						</td>
						<td width=15% align=right bgcolor='#e0e0e0'>
							<font color='black' face=tahoma size=2>" . ($most_percent[1][$skill] + 0) . " % [ " . ($amount[1][$skill] + 0) . " ] &nbsp; </font>
						</td>
						<td width=15% align=right bgcolor='#f0f0f0'>
							<font color='black' face=tahoma size=2>" . ($most_percent[2][$skill] + 0) . " % [ " . ($amount[2][$skill] + 0) . " ] &nbsp; </font>
						</td>
						<td width=15% align=right bgcolor='#e0e0e0'>
							<font color='black' face=tahoma size=2>" . ($most_percent[3][$skill] + 0) . " % [ " . ($amount[3][$skill] + 0) . " ] &nbsp; </font>
						</td>
						<td width=15% align=right bgcolor='#f0f0f0'>
							<font color='black' face=tahoma size=2>" . ($most_percent[4][$skill] + 0) . " % [ " . ($amount[4][$skill] + 0) . " ] &nbsp; </font>
						</td>
						<td width=15% align=right bgcolor='#e0e0e0'>
							<font color='black' face=tahoma size=2>" . ($most_percent[5][$skill] + 0) . " % [ " . ($amount[5][$skill] + 0) . " ] &nbsp; </font>
						</td>
					</tr>
				";
        }
        echo "</table>";
        //------------------------------//
        //--------login time------------//	
        //------------------------------//
        // $sql_sub = "SELECT * FROM tbl_x_log_member where member_id='$member_id' && logdate Between '$_SESSION[start]' and '$_SESSION[stop]' order by logdate DESC";
        // $sub_query = mysql_query($sql_sub);
        // $num_log = mysql_num_rows($sub_query);

        $sql_sub = "SELECT * FROM tb_x_log_member where member_id = ? && logdate BETWEEN '$start' and '$stop' order by logdate DESC";
        $stmt = $conn->prepare($sql_sub);
        $stmt->bind_param("s", $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $num_log = $result->num_rows;
        // echo $num_log;
        if ($num_log >= 1) {
            echo "		
			    	<table id='table_" . $member_id . "' align=center width=90% cellpadding=5 cellspacing=1 border=0 style='display:none'>
				    	<tr>
					    	<td width=28% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>Last login</b></font></td>
						    <td width=10% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>From</b></font></td>
						    <td width=10% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>Untill</b></font></td>
						    <td width=35% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>Test</b></font></td>
						    <td width=18% bgcolor='#aaaaaa' align=center><font size=2 face=tahoma color=white><b>Total time</b></font></td>
					    </tr>";
            $timediff = NULL;
            // $k = 1;
            $l = 1;
            while ($datatime = $result->fetch_assoc()) {
                $temp_logdate[$l] = $datatime["logdate"];
                $temp_outdate[$l] = $datatime["outdate"];
                $l++;
            }
            for ($n = 1; $n <= $num_log; $n++) {
                $splittime1[$n] = explode(" ", $temp_logdate[$n]);
                $splittime2[$n] = explode(" ", $temp_outdate[$n]);
                $timediff[$n] = (strtotime($temp_outdate[$n]) - strtotime($temp_logdate[$n])) / 60;
                $hour = floor($timediff[$n] / 60);
                if ($hour > 0) {
                    $htxt = $hour . " ชั่วโมง ";
                }
                else {
                    $htxt = "";
                }
                $total = "<font color=green> $htxt " . floor($timediff[$n] % 60) . ' นาที </font>';
                // -----------------------------------------query test  with time login -------------------------------//
                try {
                    //-------- ใช้เก็บชื่อระดับการทดสอบ test & evaluation และ eol contest ---------------//
                    $strSQL = "SELECT * FROM tb_w_result WHERE  member_id = ? AND create_date BETWEEN '$temp_logdate[$n]' AND '$temp_outdate[$n]' ";
                    //$test_query = select($table,$where);		//$datatest = mysql_num_rows($test_query);
                    // $test_query = mysql_query($sql);

                    $query = $conn->prepare($strSQL);
                    $query->bind_param("s", $member_id);
                    $query->execute();
                    $result = $query->get_result();
                    $testEol = "";
                    while ($datatest = $result->fetch_assoc()) {
                        if ($datatest['etest_id'] == 0) {
                            $testEol .= "" . $skill_name[$datatest["skill_id"]] . " - " . $level_name[$datatest["level_id"]] . " <br>";
                        }
                        elseif ($datatest['etest_id'] > 0) {
                            $name = get_name_contest($datatest['etest_id']);
                            $testEol .= "" . $name . "<br>";
                        }
                    }
                    $query->close();
                    // ------------ ใช้เก็บชื่อระดับการทดสอบ eol standard test  ------------ // 
                    $SQL = "SELECT * FROM tb_w_result_est WHERE member_id = ? AND create_date BETWEEN '$temp_logdate[$n]' AND '$temp_outdate[$n]'";
                    $sub_stmt = $conn->prepare($SQL);
                    $sub_stmt->bind_param("s", $member_id);
                    $sub_stmt->execute();
                    $result_est = $sub_stmt->get_result();
                    $is_true = $result_est->num_rows;
                    if ($is_true > 0) {
                        $testEol .= " EOL Standard Test <br>";
                    }
                    $sub_stmt->close();

                    if ($testEol == "") {
                        $testEol = "-";
                    }
                }
                catch (Exception $e) {
                    echo $e;
                }
                $st = explode(" ", $temp_logdate[$n]);
                $en = explode(" ", $temp_outdate[$n]);
                echo "
					    <tr>
						    <td bgcolor='#f0f0f0' align=left><font size=2 face=tahoma color='blue'>&nbsp;&nbsp;" . process_date(strtotime($temp_logdate[$n])) . "</font></td>
						    <td bgcolor='#f0f0f0' align=center><font size=2 face=tahoma color='brown' title='$temp_logdate[$n]'>$st[1]</font></td>
						    <td bgcolor='#f0f0f0' align=center><font size=2 face=tahoma color='green' title='$temp_outdate[$n]'>$en[1] </font></td>
							<td bgcolor='#f0f0f0' align=center><font size=2 face=tahoma color='green'>$testEol </font></td>
						    <td bgcolor='#f0f0f0' align=center><font size=2 face=tahoma color='red'>$total </font></td>
					    </tr>
							";
            // $k++;
            }
            $hour = floor(array_sum($timediff) / 60);
            // echo $hour."<br>";
            if ($hour > 0) {
                $htxt = $hour . " ชั่วโมง ";
            }
            $sum = "<font color=red > $htxt " . floor(array_sum($timediff) % 60) . ' นาที </font>';
            echo "  <tr>
                        <td bgcolor='#f0f0f0' align=left><font size=2 face=tahoma color='blue'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
						<td bgcolor='#f0f0f0' align=center ><font size=2 face=tahoma color='brown'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
						<td bgcolor='#f0f0f0' align=center ><font size=2 face=tahoma color='brown'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
						<td bgcolor='#f0f0f0' align=center><font size=2 face=tahoma color='red'><b>รวมเวลา</b></font></td>				
				        <td bgcolor='#f0f0f0' align=center><font size=2 face=tahoma color='red'>$sum </font></td>	
					</tr>
				</table>";
        }
        else {
            echo "<table id='table_" . $member_id . "' align=center width=90% cellpadding=5 cellspacing=1 border=0 style='display:none' bgcolor='#f0f0f0'>
				    <tr><td>ไม่พบข้อมูล </td></tr>
				  </table>";
        }
        $stmt->close();
    }
    if ($num == 0) {
        echo
            "<br>
            <table width=90% align=center cellpadding=5 cellspacing=0 border=0 style='background:#f0f0f0; border-radius:10px;'>
                <tr height='20px'>
                    <td align=center><font size=2 face=tahoma color='red'> - Didn't find any result - </font></td>
                </tr>
                <tr height='20px'>
                    <td align=center><font size=2 face=tahoma color='red'> - Please select correct items you want view - </font></td>
                </tr>
            </table>";
    }
    echo "<br>&nbsp;";
    mysqli_close($conn);
}

function get_name_contest($etest_id)
{
    include('../config/connection.php');
    $SQL = "SELECT exam_name FROM tb_eventest WHERE exam_id = ?";
    $sub_query = $conn->prepare($SQL);
    $sub_query->bind_param("s", $etest_id);
    $sub_query->execute();
    $result = $sub_query->get_result();
    $exam_name = $result->fetch_array();
    $name = $exam_name['exam_name'];
    $sub_query->close();
    return $name;
}

function evaluation_statistic()
{
    include('../config/connection.php');
    if ($_GET['action'] == "view_graph") {
        echo "
			<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/engtest/calendar/epoch_styles.css\" />
			<script type=\"text/javascript\" src=\"http://localhost/engtest/calendar/epoch_classes.js\"></script>
			<script type=\"text/javascript\">
			/*You can also place this code in a separate file and link to it like epoch_classes.js*/
				var cx, ex;      
			    window.onload = function () {
                     cx  = new Epoch('epoch_popup','popup',document.getElementById('date_graph_a'));
                     ex  = new Epoch('epoch_popup','popup',document.getElementById('date_graph_b'));
				};
			</script>";
        $group_id = isset($_POST["group_id"]) ? $_POST["group_id"] : $_SESSION["group_id"];
        $_SESSION["group_id"] = $group_id;
    }

    $type_id = 0;
    $SQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
    $query = $conn->prepare($SQL);
    $query->bind_param("si", $_SESSION['x_member_id'], $type_id);
    $query->execute();
    $result = $query->get_result();
    $each_group = $result->num_rows;
    $query->close();
    $type_name_graph = "None Group&nbsp;[ " . $each_group . " ]";
    echo "<center><h1>Test & Evaluetion</h1></center>";
    echo "
		<table align='center' width='95%' cellpadding='5' cellspacing='0' border='0'>
        <form id='view_form_graph' method='post' action='?section=$_GET[section]&&status=$_GET[status]&&action=view_graph' 
        style='background:#f0f0f0;height:30px;padding:5px;'>
			<tr height=30>
				<td align=center width=90%>
                    <select name='group_id' style='height:28px;'>
                        <option value='0'>$type_name_graph</option>";

    if (isset($_POST["start"]) && isset($_POST["stop"])) {
        $start = trim($_POST["start"]);
        $stop = trim($_POST["stop"]);
    }
    else {
        $start = date("Y-m-d", time() - (60 * 60 * 24 * 30));
        $stop = date("Y-m-d", time() + (60 * 60 * 24 * 1));
    }
    $SQL = "SELECT * FROM tb_x_member_type WHERE member_id = ? ORDER BY name";
    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("s", $_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->num_rows;
    $j = 1;
    while ($row = $result->fetch_assoc()) {
        $temp_id[$j] = $row['type_id'];
        $temp_name[$j] = $row['name'];
        $j++;
    }
    $stmt->close();
    for ($i = 1; $i <= $rows; $i++) {
        // $datagraph = $result->fetch_array();
        $type_name = $temp_name[$i];
        $type_id = $temp_id[$i];
        //-----------------------------------------------------------------------------------------------//
        // $table = $sql[tb_x_member_sub];
        // $where = " where master_id='$_SESSION[x_member_id]' && type_id='$type_id' ";
        // $x_query = select($table, $where);
        // $each_group = mysql_num_rows($x_query);

        $strSQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
        $query = $conn->prepare($strSQL);
        $query->bind_param("ss", $_SESSION['x_member_id'], $type_id);
        $query->execute();
        $result = $query->get_result();
        $each_group = $result->num_rows;
        $type_name = $type_name . "&nbsp;[ " . $each_group . " ]";
        $query->close();
        //-----------------------------------------------------------------------------------------------//
        if ($type_id == $_SESSION["group_id"]) {
            $select = "selected";
        }
        else {
            $select = "";
        }
        echo "<option value='$type_id' $select>$type_name </option>";
    }
    if ($_POST["skill_id"]) {
        $selecSkill[$_POST["skill_id"]] = 'selected';
    }
    else {
        $selecSkill[$_POST["skill_id"]] = '';
    }
    // ===================== form select skill column 2 =================== // 
    echo "
            </select>
            <select name='skill_id' style='margin-left:10px; height:28px;'>
                <option value=1 $selecSkill[1]> Reading Comprehension</option>
                <option value=2 $selecSkill[2]> Listening Comprehension</option>
                <option value=3 $selecSkill[3]> Semi - Speaking</option>
                <option value=4 $selecSkill[4]> Semi - Writing</option>
                <option value=7 $selecSkill[7]> Vocabulary </option>
                <option value=5 $selecSkill[5]> Grammar </option>
                <option value=10 $selecSkill[10]> Multiple Skills </option>
            </select>";
    // ======================= set sselect level ============================= //
    if ($_POST["level_id"]) {
        $selectLevel[$_POST["level_id"]] = 'selected';
    }
    else {
        $selectLevel[$_POST["level_id"]] = '';
    }
    // ------------------------ FORM LEVEL AND DATE column 3 and 4 ------------------------------------//
    echo "
            <select name='level_id' style='margin-left:10px; height:28px;'>
                <option value=1 $selectLevel[1]>Beginner</option>
                <option value=2 $selectLevel[2]>Lower Intermediate</option>
                <option value=3 $selectLevel[3]>Intermediate</option>
                <option value=4 $selectLevel[4]>Upper Intermediate</option>
                <option value=5 $selectLevel[5]>Advanced </option>
            </select>
            </td>
        </tr>
        <tr>
            <td align=center width=90%>
                <b>From : </b><input type='text' id='date_graph_a' name='start' value='$start' style='margin-left:10px; width:100px; height:26px;border-radius:8px;border:1px solid #bbb2ae;'>&nbsp;&nbsp;
                <b>Until : </b><input type='text' id='date_graph_b' name='stop' value='$stop' style='margin-left:10px; width:100px; height:26px;border-radius:8px;border:1px solid #bbb2ae;'>
                <select name='sortdata' style='margin-left:10px; height: 28px;'>";

    if ($_POST["sortdata"]) {
        $selectsort[$_POST["sortdata"]] = 'selected';
    }
    else {
        $selectsort[$_POST["sortdata"]] = '';
    }
    // form of sort ID and POINT column 5
    echo "
				<option value=1 $selectsort[1]>Sort by ID</option>
				<option value=2 $selectsort[2]>Sort by Point</option>
			</select>
			<input type='submit' name='view_graph' value='View Graph' style='font-weight:bold; margin-left:10px; height:28px;' class='view_graph'>
        </td>
        </tr>
	</form>
    </table>";


    if ($_POST['start'] != '' && $_POST['stop'] != '' && $_POST['group_id'] != '' && $_POST['skill_id'] != '' && $_POST['level_id'] != '') {
        // echo "Success";
        $skill_name[1] = "Reading Comprehension";
        $skill_name[2] = "Listening Comprehension";
        $skill_name[3] = "Semi-Speaking";
        $skill_name[4] = "Semi-Writing";
        $skill_name[5] = "Grammar";
        $skill_name[6] = "Intergrated Skill : Cloze Test";
        $skill_name[7] = "Vocabulary ";
        $skill_name[10] = "Multiple Skills";

        echo "<br><br>";
        echo "<font size=3><b> " . $skill_name[$_POST['skill_id']] . "</b></font><br>";
        echo "<table align='center' width='100%' bgcolor='#ccc' cellpadding='0' cellspacing='0' style='border-radius: 5px;'>";
        // -------- Sort by ID-------- //
        if ($_POST['sortdata'] == 1) {

            $SQL = "SELECT tb_w_result.result_id,tb_w_result.member_id,tb_x_member.fname,tb_x_member.lname,tb_w_result.percent, tb_w_result.create_date  FROM tb_w_result, tb_x_member WHERE tb_w_result.member_id in ( SELECT tb_x_member.member_id FROM  tb_x_member, tb_x_member_sub WHERE tb_x_member_sub.master_id = '$_SESSION[x_member_id]' &&  tb_x_member_sub.sub_id = tb_x_member.member_id  && tb_x_member_sub.type_id = '$_POST[group_id]' ) and tb_w_result.member_id = tb_x_member.member_id
		       and tb_w_result.skill_id = ? and tb_w_result.level_id = ? and tb_w_result.create_date BETWEEN '$start' and '$stop' GROUP BY tb_x_member.member_id,tb_w_result.create_date";

            // $result_query = mysql_query($sql);
            $stmt = $conn->prepare($SQL);
            $stmt->bind_param("ss", $_POST['skill_id'], $_POST['level_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->num_rows;

            echo $rows;

            $x = 1;
            $j = 1;
            while ($data = $result->fetch_assoc()) {
                $temp_result_id[$j] = $data['result_id'];
                $temp_member_id[$j] = $data['member_id'];
                $temp_fname[$j] = $data['fname'];
                $temp_lname[$j] = $data['lname'];
                $temp_percent[$j] = $data['percent'];
                $temp_create_date[$j] = $data['create_date'];
                $j++;
            }
            for ($n = 1; $n <= $rows; $n++) {

                // $where = " where result_id='" . $result[result_id] . "' group by quiz_id ";
                $strSQL = "SELECT * FROM tb_w_result_detail WHERE result_id = ? GROUP BY quiz_id";
                // $query = mysql_query($sub_sql);
                // $total_amount = mysql_num_rows($query);

                $query = $conn->prepare($strSQL);
                $query->bind_param("s", $temp_result_id[$n]);
                $query->execute();
                $result = $query->get_result();
                $total_amount = $result->num_rows;
                $j = 1;
                while ($sub_data = $result->fetch_assoc()) {
                    $temp_id[$j] = $sub_data['quiz_id'];
                    $j++;
                }
                // echo $total_amount . "<br>";

                if ($total_amount >= 1) {
                    $amount = 0;

                    for ($i = 1; $i <= $total_amount; $i++) {
                        // $sub_data = mysql_fetch_array($query);
                        // $table = "tbl_answers";
                        // $point_query = mysql_query($msg);
                        // $is_true = mysql_num_rows($point_query);
                        $correct = 1;
                        $msg = "SELECT ANSWERS_ID FROM tb_answers WHERE QUESTIONS_ID = ? && ANSWERS_CORRECT = ?";
                        $sub_stmt = $conn->prepare($msg);
                        $sub_stmt->bind_param("si", $temp_id[$i], $correct);
                        $sub_stmt->execute();
                        $result_ans = $sub_stmt->get_result();
                        $is_true = $result_ans->num_rows;

                        if ($is_true == 1) {
                            $check = $result_ans->fetch_array();
                            // $table = "tbl_w_result_detail";
                            $sql = "SELECT ans_id FROM tb_w_result_detail WHERE result_id= ? && quiz_id= ? && ans_id = ? ";
                            $sub_query = $conn->prepare($sql);
                            $sub_query->bind_param("sss", $temp_result_id[$n], $temp_id[$i], $check['ANSWERS_ID']);
                            $sub_query->execute();
                            $result_ans = $sub_query->get_result();
                            $is_correct = $result_ans->num_rows;
                            // $a_check_query = mysql_query($msg);
                            // $is_correct = mysql_num_rows($a_check_query);
                            if ($is_correct == 1) {
                                $amount = $amount + 1;
                            }
                        }
                    }
                }

                $amount = $amount + 0;

                echo "<tr style='padding:5px; height:30px;'> 
			                <td width=2%><b><center>$x</center></b></td>
					        <td width=11%><a target='_blank' 
						    	href='?section=$_GET[section]&&action=report&&member_id=$temp_member_id[$n]&&report_section=academic&&result_id=$temp_result_id[$n]'><b>$temp_create_date[$n] </b></a></td>							
                            <td width=10%> $temp_fname[$n]    $temp_lname[$n] </td>
						    <td width=10%> <img src='https://www.engtest.net/2010/temp_images/bar_07.png' width='" . ($temp_percent[$n] * 4) . "' height='20' style='border-radius: 5px;'/></td>
						    <td width=5%><b>$temp_percent[$n] %</b></td>      
						    <td width=6%><b>$amount / $total_amount ข้อ</b></td>    
					  </tr>";
                $x++;
            }
            echo "</table>";
            if ($rows == 0) {
                echo
                    "<br>
                    <table width=90% align=center cellpadding=5 cellspacing=0 border=0 style='background:#f0f0f0; border-radius:10px;'>
                        <tr height='20px'>
                            <td align=center><font size=2 face=tahoma color='red'> - Didn't find any result - </font></td>
                        </tr>
                        <tr height='20px'>
                            <td align=center><font size=2 face=tahoma color='red'> - Please select correct items you want view - </font></td>
                        </tr>
                    </table>";
            }
        // break;
        }
        else {
            // -------- Sort by Point -------- //
            $SQL = "SELECT tb_w_result.result_id,tb_w_result.member_id,tb_x_member.fname,tb_x_member.lname,tb_w_result.percent, tb_w_result.create_date  FROM tb_w_result , tb_x_member WHERE tb_w_result.member_id in ( SELECT tb_x_member.member_id FROM  tb_x_member  , tb_x_member_sub  WHERE tb_x_member_sub.master_id = '$_SESSION[x_member_id]' &&  tb_x_member_sub.sub_id = tb_x_member.member_id  && tb_x_member_sub.type_id = '$_POST[group_id]' ) and tb_w_result.member_id = tb_x_member.member_id
		       and tb_w_result.skill_id = ? and tb_w_result.level_id = ? and tb_w_result.create_date BETWEEN '$start' and '$stop' GROUP BY tb_x_member.member_id,tb_w_result.create_date order by percent DESC, tb_w_result.create_date ASC";

            $stmt = $conn->prepare($SQL);
            $stmt->bind_param("ss", $_POST['skill_id'], $_POST['level_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->num_rows;
            echo $rows . "<br>";
            $x = 1;
            $j = 1;
            while ($data = $result->fetch_assoc()) {
                $temp_result_id[$j] = $data['result_id'];
                $temp_member_id[$j] = $data['member_id'];
                $temp_fname[$j] = $data['fname'];
                $temp_lname[$j] = $data['lname'];
                $temp_percent[$j] = $data['percent'];
                $temp_create_date[$j] = $data['create_date'];
                $j++;
            }
            for ($n = 1; $n <= $rows; $n++) {

                $strSQL = "SELECT * FROM tb_w_result_detail WHERE result_id = ? GROUP BY quiz_id";
                $query = $conn->prepare($strSQL);
                $query->bind_param("s", $temp_result_id[$n]);
                $query->execute();
                $result = $query->get_result();
                $total_amount = $result->num_rows;
                $j = 1;
                while ($sub_data = $result->fetch_assoc()) {
                    $temp_id[$j] = $sub_data['quiz_id'];
                    $j++;
                }
                if ($total_amount >= 1) {
                    $amount = 0;

                    for ($i = 1; $i <= $total_amount; $i++) {
                        // $sub_data = mysql_fetch_array($query);
                        // $table = "tbl_answers";
                        // $point_query = mysql_query($msg);
                        // $is_true = mysql_num_rows($point_query);
                        $correct = 1;
                        $msg = "SELECT ANSWERS_ID FROM tb_answers WHERE QUESTIONS_ID = ? && ANSWERS_CORRECT = ?";
                        $sub_stmt = $conn->prepare($msg);
                        $sub_stmt->bind_param("si", $temp_id[$i], $correct);
                        $sub_stmt->execute();
                        $result_ans = $sub_stmt->get_result();
                        $is_true = $result_ans->num_rows;
                        // echo $is_true."<br>";

                        if ($is_true == 1) {
                            $check = $result_ans->fetch_array();
                            $sql = "SELECT ans_id FROM tb_w_result_detail WHERE result_id= ? && quiz_id= ? && ans_id = ? ";
                            $sub_query = $conn->prepare($sql);
                            $sub_query->bind_param("sss", $temp_result_id[$n], $temp_id[$i], $check['ANSWERS_ID']);
                            $sub_query->execute();
                            $result_ans = $sub_query->get_result();
                            $is_correct = $result_ans->num_rows;
                            if ($is_correct == 1) {
                                $amount = $amount + 1;
                            }
                        }
                    }
                }
                $amount = $amount + 0;

                echo "<tr style='padding:5px; height:30px;'> 
			                <td width=2%><b><center>$x</center></b></td>
					        <td width=11%><a target='_blank' 
						    	href='?section=$_GET[section]&&action=report&&member_id=$temp_member_id[$n]&&report_section=academic&&result_id=$temp_result_id[$n]'><b>$temp_create_date[$n] </b></a></td>							
                            <td width=10%> $temp_fname[$n]    $temp_lname[$n] </td>
						    <td width=10%> <img src='https://www.engtest.net/2010/temp_images/bar_07.png' width='" . ($temp_percent[$n] * 4) . "' height='20' style='border-radius: 5px;'/></td>
						    <td width=5%><b>$temp_percent[$n] %</b></td>      
						    <td width=6%><b>$amount / $total_amount ข้อ</b></td>    
					  </tr>";
                $x++;
            }
            echo "</table>";
            if ($rows == 0) {
                echo
                    "<br>
                    <table width=90% align=center cellpadding=5 cellspacing=0 border=0 style='background:#f0f0f0; border-radius:10px;'>
                        <tr height='20px'>
                            <td align=center><font size=2 face=tahoma color='red'> - Didn't find any result - </font></td>
                        </tr>
                        <tr height='20px'>
                            <td align=center><font size=2 face=tahoma color='red'> - Please select correct items you want view - </font></td>
                        </tr>
                    </table>";
            }
        }
    }
    else {
        echo "<br><br>";
        echo "<font size=3><b> Reading Comprehension </b></font><br>";
        echo "<table align='center' width='100%' bgcolor='#ccc' cellpadding='0' cellspacing='0' style='border-radius: 5px;'>";

        $skill_id = 1;
        $level_id = 1;
        $SQL = "SELECT DISTINCT tb_w_result.result_id,tb_w_result.member_id,tb_x_member.fname,tb_x_member.lname,tb_w_result.percent, tb_w_result.create_date  FROM tb_w_result , tb_x_member WHERE tb_w_result.member_id in ( SELECT tb_x_member.member_id FROM  tb_x_member  , tb_x_member_sub   WHERE tb_x_member_sub.master_id = '$_SESSION[x_member_id]' &&  tb_x_member_sub.sub_id = tb_x_member.member_id  && tb_x_member_sub.type_id = '$_SESSION[group_id]' ) and tb_w_result.member_id = tb_x_member.member_id
		   and tb_w_result.skill_id = ? and tb_w_result.level_id = ? and tb_w_result.create_date BETWEEN '$start' and '$stop' GROUP BY tb_x_member.member_id,tb_w_result.create_date";

        $stmt = $conn->prepare($SQL);
        $stmt->bind_param("ii", $skill_id, $level_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->num_rows;
        echo "<br>" . $rows;

        $x = 1;
        $j = 1;
        while ($data = $result->fetch_assoc()) {
            $temp_result_id[$j] = $data['result_id'];
            $temp_member_id[$j] = $data['member_id'];
            $temp_fname[$j] = $data['fname'];
            $temp_lname[$j] = $data['lname'];
            $temp_percent[$j] = $data['percent'];
            $temp_create_date[$j] = $data['create_date'];
            $j++;
        }
        for ($n = 1; $n <= $rows; $n++) {

            $strSQL = "SELECT * FROM tb_w_result_detail WHERE result_id = ? GROUP BY quiz_id";

            $query = $conn->prepare($strSQL);
            $query->bind_param("s", $temp_result_id[$n]);
            $query->execute();
            $result = $query->get_result();
            $total_amount = $result->num_rows;
            $j = 1;
            while ($sub_data = $result->fetch_assoc()) {
                $temp_id[$j] = $sub_data['quiz_id'];
                $j++;
            }

            if ($total_amount >= 1) {
                $amount = 0;

                for ($i = 1; $i <= $total_amount; $i++) {

                    $correct = 1;
                    $msg = "SELECT ANSWERS_ID FROM tb_answers WHERE QUESTIONS_ID = ? && ANSWERS_CORRECT = ?";
                    $sub_stmt = $conn->prepare($msg);
                    $sub_stmt->bind_param("si", $temp_id[$i], $correct);
                    $sub_stmt->execute();
                    $result_ans = $sub_stmt->get_result();
                    $is_true = $result_ans->num_rows;

                    if ($is_true == 1) {
                        $check = $result_ans->fetch_array();
                        $sql = "SELECT ans_id FROM tb_w_result_detail WHERE result_id= ? && quiz_id= ? && ans_id = ? ";
                        $sub_query = $conn->prepare($sql);
                        $sub_query->bind_param("sss", $temp_result_id[$n], $temp_id[$i], $check['ANSWERS_ID']);
                        $sub_query->execute();
                        $result_ans = $sub_query->get_result();
                        $is_correct = $result_ans->num_rows;
                        if ($is_correct == 1) {
                            $amount = $amount + 1;
                        }
                    }
                }
            }

            $amount = $amount + 0;

            echo "<tr style='padding:5px; height:30px;'> 
			            <td width=2%><b><center>$x</center></b></td>
				        <td width=10%><a target='_blank' 
					    	href='?section=$_GET[section]&&action=report&&member_id=$temp_member_id[$n]&&report_section=academic&&result_id=$temp_result_id[$n]'><b>$temp_create_date[$n] </b></a></td>							
                        <td width=10%> $temp_fname[$n]    $temp_lname[$n] </td>
					    <td width=10%> <img src='https://www.engtest.net/2010/temp_images/bar_07.png' width='" . ($temp_percent[$n] * 4) . "' height='20' style='border-radius: 5px;'/></td>
					    <td width=5%><b>$temp_percent[$n] %</b></td>      
					    <td width=5%><b>$amount / $total_amount ข้อ</b></td>    
				  </tr>";
            $x++;
        }
        echo "</table>";
        if ($rows == 0) {
            echo
                "<br>
                <table width=90% align=center cellpadding=5 cellspacing=0 border=0 style='background:#f0f0f0; border-radius:10px;'>
                    <tr height='20px'>
                        <td align=center><font size=2 face=tahoma color='red'> - Didn't find any result - </font></td>
                    </tr>
                    <tr height='20px'>
                    <td align=center><font size=2 face=tahoma color='red'> - Please select correct items you want view - </font></td>
                </tr>
                </table>";
        }


    }
    mysqli_close($conn);

}
function eol_contest_statistic()
{
    include('../config/connection.php');
    if ($_GET['action'] == "view_contest") {
        echo "
			<link rel=\"stylesheet\" type=\"text/css\" href=\"http://localhost/engtest/calendar/epoch_styles.css\" />
			<script type=\"text/javascript\" src=\"http://localhost/engtest/calendar/epoch_classes.js\"></script>
			<script type=\"text/javascript\">
			/*You can also place this code in a separate file and link to it like epoch_classes.js*/
				var e, f;      
			    window.onload = function () {
                    e  = new Epoch('epoch_popup','popup',document.getElementById('popup_contest_a'));
                    f  = new Epoch('epoch_popup','popup',document.getElementById('popup_contest_b'));
				};
			</script>";
        $group_id = isset($_POST["group_id"]) ? $_POST["group_id"] : $_SESSION["group_id"];
        $_SESSION["group_id"] = $group_id;
    }

    //--------------------------------------------//
    // $sql_recal = "SELECT * FROM (
    //     -- ดึงตาราง tbl_x_member, tbl_w_result, tbl_w_result_detail, tbl_answers, tbl_x_member
    //     SELECT Z.CREATE_DATE, Z.RESULT_ID,C.MEMBER_ID, C.USER, C.PASS, (
    //     SUM( B.ANSWERS_CORRECT ) / COUNT( A.RESULT_DETAIL_ID )
    //     ) *100 AS CORRECT_PERCENTAGE, Z.PERCENT AS WRONG_PERCENTAGE, Z.ETEST_ID
    //     FROM tb_x_member_sub AS Y 
    //     -- where memner_id = sub_id
    //     LEFT JOIN tb_w_result AS Z ON (Z.member_id = Y.sub_id)  
    //     -- where result_id = result_id
    //     LEFT JOIN tb_w_result_detail AS A ON ( A.RESULT_ID = Z.RESULT_ID )
    //     -- where question = quiz_id
    //     LEFT JOIN tb_answers AS B ON ( B.QUESTIONS_ID = A.QUIZ_ID
    //     AND B.ANSWERS_CORRECT = '1'
    //     AND B.ANSWERS_ID = A.ANS_ID )
    //     LEFT JOIN tb_x_member AS C ON ( C.MEMBER_ID = Z.MEMBER_ID )
    //     WHERE Y.MASTER_ID = '" . $_SESSION['x_member_id'] . "' AND Y.type_id='" . $group_id . "'
    //     GROUP BY Z.RESULT_ID
    //     ) AS M

    //     WHERE M.CORRECT_PERCENTAGE <> M.WRONG_PERCENTAGE";

    // $stmt_recal = $conn->prepare($sql_recal);
    // $stmt_recal->execute();
    // $result = $stmt_recal->get_result();
    // $num_recal = $result->num_rows;


    // for ($x = 1; $x <= $num_recal; $x++) {
    //     $row_recal = $result->fetch_array();

    //     $sql_recal_update = "UPDATE tb_w_result SET 
    //                         percent = '" . $row_recal['CORRECT_PERCENTAGE'] . "'
    //                         WHERE result_id = '" . $row_recal['RESULT_ID'] . "' AND member_id = '" . $row_recal['MEMBER_ID'] . "' AND etest_id = '" . $row_recal['ETEST_ID'] . "';";
    //     // mysql_query($sql_recal_update);
    //     $query_recal = $conn->prepare($sql_recal_update);
    //     $query_recal->execute();


    // }
    //===================================//

    if (isset($_POST["start"]) && isset($_POST["stop"])) {
        $start = trim($_POST["start"]);
        $stop = trim($_POST["stop"]);
    }
    else {
        $start = date("Y-m-d", time() - (60 * 60 * 24 * 30));
        $stop = date("Y-m-d", time() + (60 * 60 * 24 * 1));
    }

    $type_id = 0;
    $strSQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
    $query = $conn->prepare($strSQL);
    $query->bind_param("si", $_SESSION['x_member_id'], $type_id);
    $query->execute();
    $result = $query->get_result();
    $each_group = $result->num_rows;
    $query->close();

    $type_name_graph = "None Group&nbsp;[ " . $each_group . " ]";
    echo "<center><h1>EOL Contest</h1></center>";

    echo "<table align='center' width='90%' cellpadding='5' cellspacing='0' border='0'>	
            <form id='view_contest' method=post action='?section=$_GET[section]&&status=$_GET[status]&&action=view_contest'>
				<tr height=30>
					<td align=center width=80%>
					    <select name='group_id' style='margin-left:10px; height: 28px;'>
					        <option value='0'>$type_name_graph</option>";

    $SQL = "SELECT * FROM tb_x_member_type WHERE member_id = ? ORDER BY name";
    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("s", $_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->num_rows;
    $j = 1;
    while ($row = $result->fetch_assoc()) {
        $temp_id[$j] = $row['type_id'];
        $temp_name[$j] = $row['name'];
        $j++;
    }
    $stmt->close();
    for ($i = 1; $i <= $rows; $i++) {
        $type_name = $temp_name[$i];
        $type_id = $temp_id[$i];
        //-----------------------------------------------------------------------------------------------//
        // $table = $sql[tb_x_member_sub];
        // $where = " where master_id='$_SESSION[x_member_id]' && type_id='$type_id' ";
        // $x_query = select($table, $where);
        // $each_group = mysql_num_rows($x_query);

        $strSQL = "SELECT * FROM tb_x_member_sub WHERE master_id = ? && type_id = ?";
        $query = $conn->prepare($strSQL);
        $query->bind_param("ss", $_SESSION['x_member_id'], $type_id);
        $query->execute();
        $result = $query->get_result();
        $each_group = $result->num_rows;
        $type_name = $type_name . "&nbsp;[ " . $each_group . " ]";
        $query->close();
        //-----------------------------------------------------------------------------------------------//
        if ($type_id == $_SESSION["group_id"]) {
            $select = "selected";
        }
        else {
            $select = "";
        }
        echo "<option value='$type_id' $select>$type_name </option>";


    }
    echo "</select>
    &nbsp;&nbsp;<select name='group_con' style='margin-left:10px; height:28px;'>";

    $sql = "SELECT * FROM tb_eventest WHERE create_by = ? order by create_date desc";
    $sub_stmt = $conn->prepare($sql);
    $sub_stmt->bind_param("s", $_SESSION['x_member_id']);
    $sub_stmt->execute();
    $result = $sub_stmt->get_result();
    $row = $result->num_rows;
    $j = 1;
    while ($data = $result->fetch_assoc()) {
        $temp_id[$j] = $data['exam_id'];
        $temp_name[$j] = $data['exam_name'];
        $j++;
    }
    $sub_stmt->close();
    for ($i = 1; $i <= $row; $i++) {
        $_SESSION['group_con'] = $temp_id[1];
        if ($temp_id[$i] == $_POST['group_con']) {
            $selected = "selected";
        }
        else {
            $selected = "";
        }

        echo "<option value='$temp_id[$i]' $selected>$temp_name[$i] </option>";
    }
    echo "
            </select>
        </td>
    </tr>
    <tr height=30>
        <td align=center width=80%>
            <b>From&nbsp;:</b>
            <input id='popup_contest_a' type=text name=start value='$start' style='margin-left:10px; width:100px; height:26px;border-radius:8px;border:1px solid #bbb2ae;'>
            <b>&nbsp;&nbsp;Until &nbsp;:</b>
            <input id='popup_contest_b' type=text name=stop value='$stop' style='margin-left:10px; width:100px; height:26px;border-radius:8px;border:1px solid #bbb2ae;'>
            &nbsp;&nbsp;<input type='submit' value='View Contest' style='font-weight:bold; margin-left:10px; height:28px;' class='view_contest' name='submit'>
        </td>
    </tr>
    </form>
    </table>";

    //--------------------------------------------//
    $group_con = $_POST['group_con'] ?? $_SESSION['group_con'];

    echo $group_con . "<br>";
    $sql_recal = "SELECT * FROM (
        -- ดึงตาราง tbl_x_member, tbl_w_result, tbl_w_result_detail, tbl_answers, tbl_x_member
        SELECT Z.CREATE_DATE, Z.RESULT_ID,C.MEMBER_ID, C.USER, C.PASS, (
        SUM( B.ANSWERS_CORRECT ) / COUNT( A.RESULT_DETAIL_ID )
        ) *100 AS CORRECT_PERCENTAGE, Z.PERCENT AS WRONG_PERCENTAGE, Z.ETEST_ID
        FROM tb_x_member_sub AS Y 
        -- where memner_id = sub_id
        LEFT JOIN tb_w_result AS Z ON (Z.member_id = Y.sub_id)  
        -- where result_id = result_id
        LEFT JOIN tb_w_result_detail AS A ON ( A.RESULT_ID = Z.RESULT_ID )
        -- where question = quiz_id
        LEFT JOIN tb_answers AS B ON ( B.QUESTIONS_ID = A.QUIZ_ID
        AND B.ANSWERS_CORRECT = '1'
        AND B.ANSWERS_ID = A.ANS_ID )
        LEFT JOIN tb_x_member AS C ON ( C.MEMBER_ID = Z.MEMBER_ID )
        WHERE Y.MASTER_ID = '" . $_SESSION['x_member_id'] . "' AND Y.type_id='" . $group_id . "' AND Z.ETEST_ID='" . $group_con . "'
        GROUP BY Z.RESULT_ID
        ) AS M

        WHERE M.CORRECT_PERCENTAGE <> M.WRONG_PERCENTAGE";

    $stmt_recal = $conn->prepare($sql_recal);
    $stmt_recal->execute();
    $result = $stmt_recal->get_result();
    $num_recal = $result->num_rows;

    for ($x = 1; $x <= $num_recal; $x++) {
        $row_recal = $result->fetch_array();

        $sql_recal_update = "UPDATE tb_w_result SET 
                            percent = '" . $row_recal['CORRECT_PERCENTAGE'] . "'
                            WHERE result_id = '" . $row_recal['RESULT_ID'] . "' AND member_id = '" . $row_recal['MEMBER_ID'] . "' AND etest_id = '" . $row_recal['ETEST_ID'] . "';";
        $query_recal = $conn->prepare($sql_recal_update);
        $query_recal->execute();
    }
    $stmt_recal->close();
    //===================================//
    if ($_POST['submit']) {
        echo "Your is submitted<br>";

        // ไม่ควรใช้ MAX(tb_w_result.result_id) เพราะมันจะไปหา result_id ตัวล่าสุด บางกรณี result_id ตัวล่าสุดไม่ใช่เป็นคะแนนสูงสุดก็ได้
        // ควรใช้  SELECT DISTINCT tb_w_result.result_id ...
        // กรณีผู้ใช้ทำข้อสอบหลายครั้ง ให้แสดงทั้งหมด เพื่อแอดมินหาค่าที่ถูกต้อง
        // $strSQL = "SELECT tb_w_result.result_id,tb_w_result.member_id,tb_x_member.fname,tb_x_member.lname,max(tb_w_result.percent) as per,tb_w_result.create_date FROM tb_w_result , tb_x_member WHERE tb_w_result.member_id in ( SELECT tb_x_member.member_id FROM  tb_x_member  , tb_x_member_sub WHERE tb_x_member_sub.master_id = ? &&  tb_x_member_sub.sub_id = tb_x_member.member_id  && tb_x_member_sub.type_id = ? ) and tb_w_result.member_id = tb_x_member.member_id and tb_w_result.skill_id = '0' and tb_w_result.level_id = '0' and tb_w_result.etest_id = ? and tb_w_result.create_date BETWEEN '$start' and '$stop' GROUP BY tb_x_member.member_id,tb_w_result.create_date ASC order by per DESC, tb_w_result.create_date ASC";
        $strSQL = "SELECT DISTINCT MAX(tb_w_result.result_id) as result_id,tb_w_result.member_id,tb_x_member.fname,tb_x_member.lname,max(percent) as per,tb_w_result.create_date FROM tb_w_result , tb_x_member WHERE tb_w_result.member_id in ( SELECT tb_x_member.member_id FROM  tb_x_member  , tb_x_member_sub   WHERE tb_x_member_sub.master_id = ? &&  tb_x_member_sub.sub_id=tb_x_member.member_id  && tb_x_member_sub.type_id = ? ) and tb_w_result.member_id = tb_x_member.member_id and tb_w_result.skill_id = '0' and tb_w_result.level_id = '0' and tb_w_result.etest_id = ? and tb_w_result.create_date BETWEEN '$start' and '$stop' GROUP BY tb_x_member.member_id ASC order by per DESC , tb_w_result.create_date ASC";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("sss", $_SESSION['x_member_id'], $_POST['group_id'], $_POST['group_con']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->num_rows;
        echo $row . "<br>";
        $j = 1;
        while ($data_result = $result->fetch_assoc()) {
            $temp_result[$j] = $data_result['result_id'];
            $temp_member[$j] = $data_result['member_id'];
            $temp_fname[$j] = $data_result['fname'];
            $temp_lname[$j] = $data_result['lname'];
            $temp_percent[$j] = $data_result['per'];
            $temp_date[$j] = $data_result['create_date'];
            $j++;
        }
        $stmt->close();
        $str = "SELECT exam_name FROM tb_eventest WHERE exam_id = ?";
        $query = $conn->prepare($str);
        $query->bind_param("s", $_POST['group_con']);
        $query->execute();
        $result = $query->get_result();
        $data = $result->fetch_array();
        $head = $data['exam_name'];
        $query->close();
        // echo $head . "<br>";

        echo "<br>";
        echo "<table align=center width=95% bgcolor='#ccc' cellpadding=0 cellspacing=0 style='padding:10px; border-radius:5px;'>";
        // ======================== แสดงหัวข้อชุดข้อสอบที่เลือก ================================ //
        echo "<tr style='height:30px;'><td colspan='5'><b>$head</b></td></tr>";
        if ($row >= 1) {
            for ($x = 1; $x <= $row; $x++) {
                echo
                    "<tr style='height:30px;'> 
                        <td width=2%><b>$x</b></td>
                        <td width=20%>
                            <a target='_blank' href='?section=$_GET[section]&&action=report&&member_id=$temp_member[$x]&&report_section=contest&&result_id=$temp_result[$x]'>
                            <b>$temp_date[$x] </b></a>
                        </td>      
                        <td width=20%> $temp_fname[$x]    $temp_lname[$x]</td>
                        <td align=left><img src='https://www.engtest.net/2010/temp_images/bar_07.png' width='" . ($temp_percent[$x] * 4) . "' height='20' style='border-radius:5px'/></td>
                        <td width=10% align=center><b>$temp_percent[$x] %</b></td>      
                    </tr>";
            }
        }
        else {
            echo "<tr style='height:20px;'><td colspan='5' align=center><font color='red' face=tahoma size=3> - Not Found - </font></td></tr>
                  <tr style='height:20px;'><td colspan='5' align=center><font color='red' face=tahoma size=2> - Please select correct items you want view - </font></td></tr>";
        }

        echo "</td></tr></table>";



    }
    else {
        echo "Your is not submit<br>";
        // echo $_SESSION['group_con'] . "<br>";
        $strSQL = "SELECT DISTINCT MAX(tb_w_result.result_id) as result_id,tb_w_result.member_id,tb_x_member.fname,tb_x_member.lname,max(percent) as per,tb_w_result.create_date FROM tb_w_result , tb_x_member WHERE tb_w_result.member_id in ( SELECT tb_x_member.member_id FROM  tb_x_member  , tb_x_member_sub   WHERE tb_x_member_sub.master_id = ? &&  tb_x_member_sub.sub_id=tb_x_member.member_id  && tb_x_member_sub.type_id = ? ) and tb_w_result.member_id = tb_x_member.member_id and tb_w_result.skill_id = '0' and tb_w_result.level_id = '0' and tb_w_result.etest_id = ? and tb_w_result.create_date BETWEEN '$start' and '$stop' GROUP BY tb_x_member.member_id ASC order by per DESC , tb_w_result.create_date ASC";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("sss", $_SESSION['x_member_id'], $_SESSION['group_id'], $_SESSION['group_con']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->num_rows;
        echo $row . "<br>";
        $j = 1;
        while ($data_result = $result->fetch_assoc()) {
            $temp_result[$j] = $data_result['result_id'];
            $temp_member[$j] = $data_result['member_id'];
            $temp_fname[$j] = $data_result['fname'];
            $temp_lname[$j] = $data_result['lname'];
            $temp_percent[$j] = $data_result['per'];
            $temp_date[$j] = $data_result['create_date'];
            $j++;
        }
        $stmt->close();
        $str = "SELECT exam_name FROM tb_eventest WHERE exam_id = ?";
        $query = $conn->prepare($str);
        $query->bind_param("s", $_SESSION['group_con']);
        $query->execute();
        $result = $query->get_result();
        $data = $result->fetch_array();
        $head = $data['exam_name'];
        $query->close();

        // echo $head . "<br>";
        echo "<br>";
        echo "<table align=center width=95% bgcolor='#ccc' cellpadding=0 cellspacing=0 style='padding:10px; border-radius:5px;'>";
        // ======================== แสดงหัวข้อชุดข้อสอบที่เลือก ================================ //
        echo "<tr style='height:30px;'><td colspan='5'><b>$head</b></td></tr>";
        if ($row >= 1) {
            for ($x = 1; $x <= $row; $x++) {
                echo
                    "<tr style='height:30px;'> 
                        <td width=2%><b>$x</b></td>
                        <td width=20%>
                            <a target='_blank' href='?section=$_GET[section]&&action=report&&member_id=$temp_member[$x]&&report_section=contest&&result_id=$temp_result[$x]'>
                            <b>$temp_date[$x] </b></a>
                        </td>      
                        <td width=20%> $temp_fname[$x]    $temp_lname[$x]</td>
                        <td align=left><img src='https://www.engtest.net/2010/temp_images/bar_07.png' width='" . ($temp_percent[$x] * 4) . "' height='20' style='border-radius:5px'/></td>
                        <td width=10% align=center><b>$temp_percent[$x] %</b></td>      
                    </tr>";
            }
        }
        else {
            echo "<tr style='height:20px;'><td colspan='5' align=center><font color='red' face=tahoma size=3> - Not Found - </font></td></tr>
                  <tr style='height:20px;'><td colspan='5' align=center><font color='red' face=tahoma size=2> - Please select correct items you want view - </font></td></tr>";
        }

        echo "</td></tr></table>";
    }
    mysqli_close($conn);

}
?>