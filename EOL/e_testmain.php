<?php
session_start();
// error_reporting(E_ALL);
include('../config/connection.php');
$status = 1;
$strSQL = "SELECT * FROM tb_x_member_sub WHERE sub_id = ? && status = ?";
$stmt = $conn->prepare($strSQL);
$stmt->bind_param("si", $_SESSION['x_member_id'], $status);
$stmt->execute();
$result = $stmt->get_result();
$is_have = $result->num_rows;
if ($is_have == 1) {
    $data = $result->fetch_array();
    $_SESSION['group_id'] = $data['type_id'];
    $_SESSION['master_id'] = $data['master_id'];
    $group_type = $data['type_id'];

    $SQL = "SELECT et.*, COUNT(eq.question_id) AS amount FROM tb_eventest AS et LEFT JOIN tb_eventest_question AS eq ON eq.exam_id = et.exam_id WHERE et.create_by = ? GROUP BY et.exam_id ORDER BY et.exam_id DESC";
    $query = $conn->prepare($SQL);
    $query->bind_param("s", $data['master_id']);
    $query->execute();
    $result = $query->get_result();
    $numexam = $result->num_rows;

}
else {

    echo "
        <table align=center width=100% cellspacing=0 cellpadding=0 border=0>
            <tr height=300>
                <td align=center>
                    <br><br>
                    <font size=2 face=tahoma color='red'>Sorry , EOL  Multi Learning is limited for corporate members only. </font>
                    <br><br>
                    <a target=_blank href='http://localhost/engtest/shop/product_corporate.php'>
                        <font size=2 face=tahoma color='blue'>&raquo; Click here to get EOL product details &laquo;</font>
                    </a>
                    <br><br>
                    <font size=2 face=tahoma color='green'>More Details Contact us : engtest_eol@hotmail.com, englishonline.eol@gmail.com or 02-1708725-6 </font>
                    <br><br>&nbsp;
                <td>
            </tr>
        </table>";
    return false;
}

?>
<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet" />

<link rel='stylesheet' href='http://localhost/engtest/bootstrap/css/e_testmain.css' />
<link rel='stylesheet' href='http://localhost/engtest/js/scroller/scroller.css' />
<!-- <link rel='stylesheet' href='https://www.engtest.net/css/table.css' /> -->

<style type='text/css'>
.content {
    background: #ffff;
}

.bnt-test {
    width: 60px;
    margin: 0px;
    border-radius: 4px;
}
</style>

<div style="background:#545454;height:80px;">
    <div
        style="font-size:32px;color:#FFF;line-height: 80px;text-align:left;vertical-align: middle !important; padding:0px 100px;">
        <div style="position:relative;">
            <img src="http://localhost/engtest/images/icon/icon_corporate.png"
                style="position:absolute;top:10px;width:65px;">
            <div style="display: inline-block;vertical-align: middle;position:absolute;left:80px;" class="oswald">
                CORPORATE MEMBER'S USE
            </div>
        </div>
    </div>
</div>

<center>
    <div id='listexam' class='nano' style='width:100%; height:800px; background:#ffffff;'>
        <div class='content'>
            <table>
                <tr>
                    <td colspan="4" align='right'><img
                            src='http://localhost/engtest/images/image2/eol system/ecop/eol_contest.jpg'>
                </tr>
            </table>
            <table cellspacing='0' class='exam '>
                <!-- cellspacing='0' is important, must stay -->
                <tr>
                    <th width=51%>ชุดข้อสอบ</th>
                    <th width=15%>จำนวนข้อ</th>
                    <th width=15%>เวลาสอบ</th>
                    <th width=19%></th>
                </tr><!-- Table Header -->
                <?php

if ($numexam > 1) {
    $i = 0;
    $j = 0;
    while ($list = $result->fetch_assoc()) {
        $list_id[$j] = $list['exam_id'];
        $list_name[$j] = $list['exam_name'];
        $list_time[$j] = $list['testtime'];
        $list_active[$j] = $list['active'];
        if ($list['exam_type'] == 2) {
            $amount[$j] = get_amount_exam_customize($list['exam_id']);
        }
        else {
            $amount[$j] = $list['amount'];
        }
        $j++;
    }
    for ($j = 0; $j < $numexam; $j++) {
        $str = "SELECT * FROM tb_eventest_allowgroup WHERE exam_id = ? && group_type = ?";
        $sub_query = $conn->prepare($str);
        $sub_query->bind_param("ss", $list_id[$j], $group_type);
        $sub_query->execute();
        $result = $sub_query->get_result();
        $row = $result->num_rows;
        $sub_query->close();

        if ($row == 1 && $list_active[$j] == 1) {
            $btn = "<button  id='add' class='bnt-etest bnt-test' onclick=\"javascript:location.href='eolcontest.php?exam=" . $list_id[$j] . "';\">Test</button>";
        }
        else {
            $btn = "<button  id='add' class='bnt-etest bnt-test gray' disabled>Test</button>";
        }
        $class = (($i % 2) == 0 ? "class='even' " : '');
        echo '<tr ', $class, '><td><b>', $list_name[$j], '</b></td><td>', $amount[$j], '</td><td>', $list_time[$j], '</td><td>', $btn, '</td></tr>';
        $i++;
    }
}
else if ($numexam == 1) {
    $listExam = $result->fetch_array();
    if ($listExam['exam_type'] == 2) {
        $amount = get_amount_exam_customize($listExam['exam_id']);
    }
    else {
        $amount = $listExam['amount'];
    }
    // $exam->checkAllowGroup($listExam['exam_id'], $result['type_id']);
    // $row = $exam->getRow();
    $str = "SELECT * FROM tb_eventest_allowgroup WHERE exam_id = ? && group_type = ?";
    $sub_query = $conn->prepare($str);
    $sub_query->bind_param("ss", $listExam['exam_id'], $group_type);
    $sub_query->execute();
    $result = $sub_query->get_result();
    $row = $result->num_rows;
    $sub_query->close();
    if ($row == 1 && $listExam['active'] == 1) {
        $btn = "<button  id='add' class='bnt-etest bnt-test' onclick=\"javascript:location.href='eolcontest.php?exam=" . $listExam['exam_id'] . "';\">Test</button>";
    }
    else {
        $btn = "<button  id='add' class='bnt-etest bnt-test gray' disabled>Test</button>";
    }
    $class = (($i % 2) == 0 ? "class='even' " : '');
    echo '<tr ', $class, '><td><b>', $listExam['exam_name'], '</b></td><td>', $amount, '</td><td>', $listExam['testtime'], '</td><td>', $btn, '</td></tr>';
}
else {
    echo '<tr><td rowpan=4><center>ไม่มีชุดข้อสอบ</center></td></tr>';
}
mysqli_close($conn);
?>
            </table>
            <table>
                <tr>
                    <td bgcolor='#555555' align='right' width=1000><a
                            href="http://localhost/engtest/corporate/ecop.php"><img
                                src='http://localhost/engtest/images/image2/eol system/ecop/btn_backsite.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</center>
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js'></script>
<script type='text/javascript' src='http://localhost/engtest/js/scroller/nanoscroller.min.js'></script>
<script type='text/javascript'>
jQuery(document).ready(function($) {
    $('#listexam').nanoScroller();
    $('#listexam').nanoScroller({
        sliderMinHeight: 30
    });
});
</script>
<?php
function get_amount_exam_customize($exam_id)
{
    include('../config/connection.php');
    $strSQL = "SELECT * FROM tb_eventest_question_custom WHERE exam_id = ?";
    $query = $conn->prepare($strSQL);
    $query->bind_param("s", $exam_id);
    $query->execute();
    $result = $query->get_result();
    $amount = $result->num_rows;
    $query->close();
    mysqli_close($conn);

    return $amount;

}
?>