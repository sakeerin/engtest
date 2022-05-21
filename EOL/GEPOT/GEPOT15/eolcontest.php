<?php
ob_start();
session_start();
// error_reporting(E_ALL);
include('../inc/user_info.php');
include('../config/connection.php');


check_duel_login();
check_available_time();
display_header();
main_page();
display_footer();


function display_header()
{
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>English Test Online :: ระบบทดสอบภาษาอังกฤษออนไลน์ </title>
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/eolcontest.css">

    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/mainpage.css">
    <!-- <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/systemtest.css"> -->

    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/tabbar.css">

    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai&display=swap" rel="stylesheet">
    <style type='text/css'>
    .f-thai {
        font-family: 'IBM Plex Sans Thai' !important;
    }

    .checkanswer {
        position: absolute;
        margin-left: 40%;
        margin-top: 20%;
        display: none;
    }

    /* .bt_green {
        border-width: 0px;
        padding: 0px;
        margin: 0px;
        background-color: #ffffff;
        cursor: pointer;
        color: green;
        font-size: 10pt;
        font-family: tahoma;
        font-weight: bold;
        padding: 3px;
    } */
    </style>

</head>

<body>

    <?php
}


function main_page()
{
?>
    <div id='container'>
        <?php display_profile(); ?>
        <!------- main content------- -->
        <div id='content'>
            <div id='pic_border'>
                <img src='http://localhost/engtest/images/image2/eol system/head-box-02.png' width='1024' />
            </div>

            <div id='content-div'>
                <?php
    if ($_GET['action'] == 'test') {
        xtest();
    }
    elseif ($_GET['action'] == "record") {
        record_ans();
    }
    elseif ($_GET['action'] == "result") {
        display_result();
    }
    elseif ($_GET['exam'] != '') {
        set_test();
    }
    else {
        header('Location:eoltest.php?section=business&&action=eolcontest');
    }
?>
            </div>
        </div>

        <?php

}
function display_footer()
{
?>
        <div>
            <center style="margin-bottom:10px; margin-top:-3px;"><b>Copyright © 2022 By English Online Co.,Ltd. All
                    rights
                    reserved.</b>
            </center>
        </div>
</body>
<script src='http://localhost/engtest/js/jquery-1.9.0.min.js'></script>
<!-- <script src='https://www.engtest.net/js/jquery-1.9.0.min.js'></script> -->
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->
<!-- <script src="http://code.jquery.com/jquery-2.0.0.js"></script> -->
<script>
function recordAnswer() {
    var idAnswer = $('input[name=choose]:checked').val();
    var quiz = parseInt($('#quiz_id').val());
    if (idAnswer) {
        $.ajax({
            type: "POST",
            url: "checkanswer.php",
            data: {
                checkanswer: 'checkAns',
                answerId: idAnswer,
                questionId: quiz
            },
            beforeSend: function() {
                //$("#imgloading").show();
            },
            complete: function() {
                //$("#imgloading").hide();
            },
            success: function(response) {
                var checkInt = parseInt(response);
                if (response != '') {
                    $('#score').html(response);
                    $('#checkCorrect').fadeIn();
                    setTimeout(imghidden('checkCorrect'), 4000);
                    document.quiz_form.submit();
                } else {
                    $('#checkIncorrect').fadeIn();
                    setTimeout(imghidden('checkIncorrect'), 4000);
                    document.quiz_form.submit();
                }

            },
            error: function(error) {
                //$("#showpost").append('<p align="center"></p>');
            }
        });

    }

}

function imghidden(id) {
    $('#' + id).fadeOut();
}
</script>
<script language="javascript">
function begintimer() {
    if (!document.images)
        return
    if (parselimit == 1)
        // alert('หมดเวลาสำหรับการทำข้อสอบ');
        // เหตุการณ์ที่ต้องการให้เกิดขึ้น
        // window.location='page.php'; ถ้าต้องการให้กระโดดไปยัง Page อื่น
        fin_form.submit();
    else {
        parselimit -= 1
        curmin = Math.floor(parselimit / 60)
        cursec = parselimit % 60
        if (curmin != 0) {
            curtime = "<font face=tahoma size=2>เวลาที่เหลือ : <font color=red> " + curmin +
                " </font>นาที กับ <font color=red> " + cursec + " </font>วินาที </font>"
            document.config.time_min.value = curmin
            document.config.time_sec.value = cursec
            document.quiz_form.time_left.value = parselimit
            document.next_form.time_left.value = parselimit
            document.back_form.time_left.value = parselimit
            document.num_form.time_left.value = parselimit
        } else if (cursec == 0) {
            alert('หมดเวลาแล้วจ้า');
        } else {
            curtime = "<font face=tahoma size=2>เวลาที่เหลือ <font color=red>" + cursec +
                " </font>วินาที </font>"
            document.config.time_min.value = curmin
            document.config.time_sec.value = cursec
            document.quiz_form.time_left.value = parselimit
            document.next_form.time_left.value = parselimit
            document.back_form.time_left.value = parselimit
            document.num_form.time_left.value = parselimit
        }
        document.getElementById('dplay').innerHTML = curtime;
        setTimeout("begintimer()", 1000)
    }
}
</script>

</html>
<?php
}

function display_profile()
{
?>
<div id='header'>
    <!-- <img src='https://www.engtest.net/image2/mainpage/dbd-head.gif' width='927' height='148'
        style='margin:10px 0 0 16px; top:-10px;' /> -->
    <img src='http://localhost/engtest/images/image2/logo/logo-02.png' width='270' height='118'
        style='float:left;margin-left:20px; margin-top: 175px;' />
    <!---- info user ----->
    <div id='info_user'>
        <?php $data = new info();
    echo $data->loadinfo('test');
?>
        <div id='logoutPic'>
            <a href='http://localhost/engtest/inc/logout.php'><img
                    src='http://localhost/engtest/images/image2/eol system/button/logout-06.png'
                    style='margin-top:10px; margin-left:20px;' /></a>
        </div>
    </div>
</div>
<?php
}
function set_test()
{
    include('../config/connection.php');
    unset($_SESSION['amount']);
    unset($_SESSION['quiz_id']);
    unset($_SESSION['ans']);
    unset($_SESSION['all_time']);
    unset($_SESSION['score']);
    unset($_SESSION['exam_id']);
    unset($_SESSION['exam_type']);

    $_SESSION['score'] = 0;
    if ($_SESSION['master_id'] == '' && $_GET['exam'] == '') {
        header('Location:eoltest.php?section=business&&action=eolcontest');
        exit;
    }
    else {
        $examId = $conn->real_escape_string($_GET['exam']);
        $strSQL = "SELECT et.*, COUNT(eq.question_id) AS amount FROM tb_eventest AS et LEFT JOIN tb_eventest_question AS eq ON eq.exam_id = et.exam_id WHERE et.create_by = ?  && et.exam_id = ? GROUP BY et.exam_id ORDER BY et.exam_id DESC";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("ss", $_SESSION['master_id'], $examId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->num_rows;
        $listExam = $result->fetch_array();
        $stmt->close();

        $SQL = "SELECT * FROM tb_eventest_allowgroup WHERE exam_id = ? && group_type = ?";
        $query = $conn->prepare($SQL);
        $query->bind_param("ss", $listExam['exam_id'], $_SESSION['group_id']);
        $query->execute();
        $result = $query->get_result();
        $allowgroup = $result->num_rows;
        $query->close();
        if ($row == 0) {
            header('Location:eoltest.php?section=business&&action=eolcontest');
            die();
        }
        elseif ($allowgroup == 0) {
            header('Location:eoltest.php?section=business&&action=eolcontest');
            die();
        }
        else {
            if ($listExam['exam_type'] == 2) {
                $amount = get_amount_exam_customize($listExam['exam_id']);
            }
            else {
                $amount = $listExam['amount'];
            }
            $_SESSION['all_time'] = $listExam['testtime'] * 60;
            $_SESSION['amount'] = $amount;
            $_SESSION['exam_id'] = $conn->real_escape_string($_GET['exam']);
            $_SESSION['exam_type'] = $listExam['exam_type'];

            if ($listExam['exam_type'] == 1) {
                $str = "SELECT * FROM tb_eventest_question WHERE exam_id = ?";
                $query = $conn->prepare($str);
                $query->bind_param("s", $examId);
                $query->execute();
                $result_quiz = $query->get_result();
                $rows = $result_quiz->num_rows;
                $query->close();
            // echo "count quiz = " . $rows . "<br><br>";
            }
            else {
                $str = "SELECT * FROM tb_eventest_question_custom WHERE exam_id = ?";
                $query = $conn->prepare($str);
                $query->bind_param("s", $examId);
                $query->execute();
                $result_quiz = $query->get_result();
                $rows = $result_quiz->num_rows;
                $query->close();
            // echo "count quiz = " . $rows . "<br><br>";
            }
            echo "test type " . $listExam['test_type'] . "<br><br>";
            if ($listExam['test_type'] == 1) {
                $_SESSION['test_type'] = $listExam['test_type'];
                $i = 0;

                while ($quizs = $result_quiz->fetch_assoc()) {
                    $arrayquiz[$i + 1] = $quizs['question_id'];
                    // echo $_SESSION['quiz_id'][$i + 1] = $quizs['question_id'] . "<br>"; // edit
                    // print_r($data['question_id']);
                    $i++;
                }
                $randomquiz = randomQuestion($amount);
                $i = 0;
                foreach ($randomquiz as $key => $value) {
                    $_SESSION['quiz_id'][$i + 1] = $arrayquiz[$value];
                    // echo $_SESSION['quiz_id'][$i + 1] . "<br>";
                    $i++;
                }
            }
            else {
                $_SESSION['test_type'] = $listExam['test_type'];
                $i = 0;
                while ($quizs = $result_quiz->fetch_assoc()) {
                    $_SESSION['quiz_id'][$i + 1] = $quizs['question_id'];
                    // echo $_SESSION['quiz_id'][$i + 1] . "<br>";
                    $i++;
                }
            }

        }
    }
    echo "<table align=center width=90% cellpadding=0 cellspacing=0 border=0 >
    <tr height=30>
        <td width=15% align=right><font size=2 face=tahoma color=black></font></td>
        <td width=75% align=left><font size=2 face=tahoma color=black></font></td>
        <td width=10% align=center>
            <a href='eoltest.php?section=business&&action=eolcontest' style='float:right;' class='f-thai'><font size=4 color=black><b> [ Back ]</b></font></a>
        </td>
    </tr>
 </table>";

    echo "
 <table align=center width=90% cellpadding=0 cellspacing=0 border=0 style='font-size:14px;' class='f-thai'>
     <form action='?action=test' method=post>
         <tr height=25 >
            <td><font size=5 color=blue><b>รายละเอียดของแบบทดสอบ EOL Contest</b></font>
            </td>
         </tr>
         <tr height=25>
            <td><font size=4 > - ชื่อชุดข้อสอบ </font><font size=4 color=green>" . $listExam['exam_name'] . "</font>
            </td>
         </tr>
         <tr height=25>
            <td><font size=4 > - รูปแบบการสอบ  </font><font size=4 color=green>" . ($listExam['test_type'] == 1 ? "สอบเก็บคะแนน" : "การแข่งขัน") . "</font>
            </td>
         </tr>
         <tr height=25>
            <td><font size=4 > - ข้อสอบประเภท 4 ตัวเลือก ให้เลือกเฉพาะข้อที่ถูกต้องที่สุดเท่านั้น </font>
            </td>
         </tr>
         <tr height=25>
            <td><font size=4 > - จำนวนคำถามในแบบทดสอบชุดนี้ : " . $amount . " ข้อ </font>
            </td>
         </tr>
         <tr height=25>
            <td><font size=4 > - ระยะเวลาในการทำแบบทดสอบชุดนี้ : " . $listExam['testtime'] . " นาที  </font>
            </td>
         </tr>
         <tr height=25>
            <td><font size=4 > - ข้อสอบแต่ละข้อมี : 1 คะแนน  </font>
            </td>
         </tr>
         <tr height=25>
            <td><font size=4 > - กดที่ <font color=brown>Start</font> ทางด้านล่างเพื่อเริ่มทำแบบทดสอบ </font>
            </td>
         </tr>
         <tr height=25>
            <td><font size=4 > - เมื่อกดปุ่ม <font color=brown>Start</font> ระบบจะเริ่มจับเวลาทันที </font>
            </td>
         </tr>
         <tr height=25>
            <td><font size=4 > - กดที่ <font color=green>Finish</font> เพื่อประเมินผลแบบทดสอบชุดนี้ </font>
            </td>
         </tr>
         <tr height=25>
            <td><font size=4 color=red><b>".($listExam['test_type'] == 2 ? "- หมายเหตุ" : "")."  </b></font><font size=4 color=green>" . ($listExam['test_type'] == 2 ? "ข้อสอบรูปแบบการแข่งขัน เมื่อท่านกดปุ่ม Record your answer ท่านไม่สามารถเปลี่ยนคำตอบได้อีกแล้ว ดังนั้นเลือกเฉพาะข้อที่ถูกต้องที่สุดเท่านั้น" : "") . "</font>
            </td>
         </tr>
         <tr height=40></tr>
         <tr height=50>
            <td align=center><align=center><input type=submit value=' Start ' class='btn btn-primary f-thai' style='font-weight:bold;' ></div>
            </td>
         </tr>
     </form>
 </table>
</div>";
// ---------------------------- //
mysqli_close($conn);



}

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

function randomQuestion($amount)
{
    for ($i = 0; $i < $amount; $i++) {
        $quiz_num[] = rand(1, $amount);
        $quiz_num = array_unique($quiz_num);
        $count = count($quiz_num);
        if ($count != $amount) {
            $i = $i - 2;
        }
    }
    //sort($quiz_num);
    return $quiz_num;
}

function xtest()
{
    include('../config/connection.php');
    if (count($_SESSION['quiz_id']) == 0) {
        header("Location:eoltest.php?section=business&&action=eolcontest");
        exit;
    }
    set_time();
    if ($_GET['action'] == "test") {
        $sql_realtime = "SELECT * FROM tb_w_realtime WHERE member_id = ? && etest_id = ?";
        $query = $conn->prepare($sql_realtime);
        $query->bind_param("ss", $_SESSION['x_member_id'], $_SESSION['exam_id']);
        $query->execute();
        $result = $query->get_result();
        $num_realtime = $result->num_rows;
        $query->close();

        if ($num_realtime == 0) {
            $percent = '0';
            $create_date = '0000-00-00';
            $end_time = '0000-00-00';
            $currect_time = date("Y-m-d H:i:s");
            $sql_realtime_insert = "INSERT INTO tb_w_realtime (member_id, etest_id, percent, create_date, start_time, end_time) VALUES(?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql_realtime_insert);
            $stmt->bind_param("ssssss", $_SESSION['x_member_id'], $_SESSION['exam_id'], $percent, $create_date, $currect_time, $end_time);
            $stmt->execute();
            $stmt->close();
        }
?>

<body onLoad='begintimer()'>
    <script language='javascript'>
    if (document.images) {
        var parselimit = document.config.fn_time.value
    }
    </script>
    <?php
     display_time_left();
    }

    if ($_SESSION['amount'] && $_SESSION['quiz_id']) {
        if ($_GET['quiz_id'] <= 0) {
            header("Location:?action=test&&quiz_id=1");
        }
        ;
        if ($_GET['quiz_id'] > $_SESSION['amount']) {
            header("Location:?action=test&&quiz_id=$_SESSION[amount]");
        }
        ;
        //-------------------------------------------------------//
        if (!$_GET['quiz_id'] || $_GET['quiz_id'] == 0) {
            $num = 1;
        }
        else {
            $num = $_GET['quiz_id'];
        }
        $quiz_id = $_SESSION['quiz_id'][$num];
        
        if ($_SESSION['exam_type'] == 2) {
            $SQL = "SELECT * FROM tb_eventest_question_custom WHERE question_id = ?";
            $stmt = $conn->prepare($SQL);
            $stmt->bind_param("s", $_SESSION['quiz_id'][$num]);
            $stmt->execute();
            $result_custom = $stmt->get_result();
            $is_have = $result_custom->num_rows;
            $quizCustom = $result_custom->fetch_array();
            $stmt->close();
        }
        else {
            $active = 1;
            $SQL = "SELECT * FROM tb_questions WHERE QUESTIONS_ID = ? && IS_ACTIVE = ?";
            $stmt_quiz = $conn->prepare($SQL);
            $stmt_quiz->bind_param("si", $_SESSION['quiz_id'][$num], $active);
            $stmt_quiz->execute();
            $result = $stmt_quiz->get_result();
            $is_have = $result->num_rows;
            $data = $result->fetch_array();
            $quiz_text = $data['QUESTIONS_TEXT'];
            $skill_id = $data['SKILL_ID'];
            $stmt_quiz->close();
        }
        if ($is_have == 1) {
            $skill_name[1] = "Reading Comprehension";
            $skill_name[2] = "Listening Comprehension";
            $skill_name[3] = "Semi-Speaking";
            $skill_name[4] = "Semi-Writing";
            $skill_name[5] = "Grammar";
            $skill_name[6] = "Intergrated Skill : Cloze Test";
            $skill_name[7] = "Vocabulary ";
            if ($_SESSION['test_type'] == 2) {
                $sql_score = "SELECT SUM(A.ANSWERS_CORRECT) AS SCORE
                FROM tb_answers  AS A 
                WHERE A.ANSWERS_CORRECT = '1'
                AND (";
                for ($i = 1; $i <= count($_SESSION['quiz_id']); $i++) {
                    $sql_score .= ($i <> 1) ? "OR" : "";
                    $sql_score .= " (A.QUESTIONS_ID = '" . $_SESSION['quiz_id'][$i] . "' AND A.ANSWERS_ID = '" . $_SESSION['ans'][$i] . "') ";
                }
                $sql_score .= ")";
                $stmt_score = $conn->prepare($sql_score);
                $stmt_score->execute();
                $result_score = $stmt_score->get_result();
                $num_score = $result_score->num_rows;
                $row_score = $result_score->fetch_array();
                $check_score = $row_score['SCORE'];
                $_SESSION['score'] = $check_score;
                $stmt_score->close();
                // echo "<br>score = ".$_SESSION['score'];

                $sql_realtime = "SELECT * FROM tb_w_realtime WHERE member_id = ? && etest_id =  ?";
                $stmt_realtime = $conn->prepare($sql_realtime);
                $stmt_realtime->bind_param("ss", $_SESSION['x_member_id'], $_SESSION['exam_id']);
                $stmt_realtime->execute();
                $result_realtime = $stmt_realtime->get_result();
                $num_realtime = $result_realtime->num_rows;
                $stmt_realtime->close();
                
                $percent_insert = (count($_SESSION['quiz_id']) > 0) ? ($check_score / count($_SESSION['quiz_id'])) * 100 : 0;
                
                $create_date = date("Y-m-d H:i:s");
                if ($num_realtime == 0) {
                    $end_time = '0000-00-00';
                    $start_time = date("Y-m-d H:i:s");
                    $sql_realtime_insert = "INSERT INTO tb_w_realtime (member_id,etest_id,percent,create_date,start_time,end_time) VALUES(?,?,?,?,?,?)";
                    $stmt_realtime_insert = $conn->prepare($sql_realtime_insert);
                    $stmt_realtime_insert->bind_param("ssisss", $_SESSION['x_member_id'], $_SESSION['exam_id'],$percent_insert,$create_date,$start_time,$end_time);
                    $stmt_realtime_insert->execute();
                    $stmt_realtime_insert->close();
                }else{
                    $sql_realtime_update = "UPDATE tb_w_realtime SET percent = ?, create_date = ? WHERE member_id = ? && etest_id = ?";
                    $stmt_realtime_update = $conn->prepare($sql_realtime_update);
                    $stmt_realtime_update->bind_param("ssss", $percent_insert,$create_date,$_SESSION['x_member_id'], $_SESSION['exam_id']);
                    $stmt_realtime_update->execute();
                    $stmt_realtime_update->close();
                }
                echo "<div id='divscore' style='float:right;background:#DFF0D8;width:100px;height:auto; border-radius: 5px;' >
                        <center>
                            <h1>Score</h1>
					        <h1 id='score'>" . $_SESSION['score'] . "</h1>
                        </center>
                      </div>
					  <div id='checkCorrect' class='checkanswer'>
                         <img src='http://localhost/engtest/images/icon/check-mark-md.png' />
                      </div>
					  <div id='checkIncorrect' class='checkanswer'>
                         <img src='http://localhost/engtest/images/icon/wrong.png' />
                      </div>";
            }
            $skillName =  $skill_name[$skill_id] ? 'Skill : '.$skill_name[$skill_id] : '';
            echo "
				<br>
				<table align=center width=90% border=0 cellpadding=0 cellspacing=0>
					<tr height=30>
						<td width=90% colspan=2>

							<font size=3 face=tahoma color='gray'><b>" . $skillName . "</b></font><br><br>
							<font size=3 face=tahoma><b>No. $num  </b></font>
						</td>
						<td align=right width=10%>&nbsp;</td>
					</tr>";
                    
            if ($_SESSION['exam_type'] == 1) {
                $sql_quiz_map = "SELECT * FROM tb_questions_mapping WHERE QUESTIONS_ID = ?";
                $stmt_quiz_map = $conn->prepare($sql_quiz_map);
                $stmt_quiz_map->bind_param("s",$quiz_id);
                $stmt_quiz_map->execute();
                $result_quiz_map = $stmt_quiz_map->get_result();
                $is_relate = $result_quiz_map->num_rows;
                
                if ($is_relate == 1) {
                    $relate_data = $result_quiz_map->fetch_array();
                    $relate_id = $relate_data['GQUESTION_ID'];
                    $sql_quiz_relate = "SELECT * FROM tb_questions_relate WHERE GQUESTION_ID = ?";
                    $stmt_quiz_relate = $conn->prepare($sql_quiz_relate);
                    $stmt_quiz_relate->bind_param("s",$relate_id);
                    $stmt_quiz_relate->execute();
                    $result_quiz_relate = $stmt_quiz_relate->get_result();
                    $relate_data = $result_quiz_relate->fetch_array();
                    $relate_type = $relate_data['GQUESTION_TYPE_ID'];
                    $relate_text = $relate_data['GQUESTION_TEXT'];
                    $stmt_quiz_relate->close();
                    
                    if ($relate_type == 1) {
                        $msg_relate = $relate_text;
                    }
                    if ($relate_type == 3) {
                        if (is_mobile()) {
                            $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $relate_text);
                            $relate_text = str_replace(".flv", ".mp3", $relate_text);
                            $msg_relate = '<div align=center>
                                            <br>
                                                <audio id="audio" autoplay="autoplay" controls="controls" > 
                                                    <source src="https://www.engtest.net/files/sound/'.$relate_text.'">  
                                                </audio>
                                            <br>&nbsp;
                                          </div> ';
                        } else {
                            $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $relate_text);
                            $relate_text = str_replace(".flv", ".mp3", $relate_text);

                            $msg_relate = '<audio id="audio" autoplay="autoplay" controls="controls" > 
                                                <source src="https://www.engtest.net/files/sound/' . $relate_text . '">  
                                           </audio>';
                        }
                    }
                    if ($relate_type == 2) {
                        $msg_relate = str_replace("/home/engtest/domains/engtest.net/public_html/", "", "../" . $relate_text);
                        $msg_relate = "<div align=center><img src='$msg_relate' border=0 width=300></div>";
                    }
                    echo "
							<tr height=10><td colspan=3></td></tr>
							<tr>
								<td width=100% colspan=3 ><font size=3 face=verdana> $msg_relate </font></td>
							</tr>
							<tr height=10><td colspan=3></td></tr>
						";
                }
                $stmt_quiz_map->close();

            }
             echo "	
							<tr height=10><td width=100% colspan=3></td></tr>
							<tr height=25>
								<td width=100% colspan=3><font size=3 face=verdana>$quiz_text ", $quizCustom['question_text'], "</font></td>
							</tr>
                            <tr height=5><td width=100% colspan=3></td></tr>
						<form name='quiz_form' id='quiz_form' method='post' action='?action=record&&quiz_id=$num' name='quiz'>	
							<input type='hidden' id='quiz_id' value ='" . $num . "' />
							<tr height=25>
								<td  colspan=3 align=left>";
                                
            if ($_SESSION['exam_type'] == 1) { // answer from system exam
                $sql_ans = "SELECT * FROM tb_answers WHERE QUESTIONS_ID = ? ORDER BY ANSWERS_ID";
                $stmt_ans = $conn->prepare($sql_ans);
                $stmt_ans->bind_param("s",$_SESSION['quiz_id'][$num]);
                $stmt_ans->execute();
                $result_ans = $stmt_ans->get_result();
                $ans_num = $result_ans->num_rows;
                // echo "<br> answer num ".$ans_num;
                if ($ans_num >= 1) {
                    $ans_msg = "";
                    while ($ans_data = $result_ans->fetch_assoc()) {
                        $ans_id = $ans_data['ANSWERS_ID'];
                        $ans_text = $ans_data['ANSWERS_TEXT'];
                        // echo "$ans_id : ".$_SESSION['ans'][$num]."<br>";
                        if ($ans_id == $_SESSION['ans'][$num]) {
                            $checked = "checked";
                        } else {
                            $checked = "";
                        }
                        //echo "<br>ANS : ".$_SESSION[ans][$quiz_id]." : "$ans_id."<br>";
                        $ans_msg = $ans_msg . "
												<input type=radio value='" . $ans_id . "' name='choose' $checked > &nbsp; <font face=Verdana size=3>" . $ans_text . "</font><br>	
												";
                    }
                }
                $stmt_ans->close();
                echo "$ans_msg";
                
            }else{ // answer from custom exam
                $sql_ans = "SELECT * FROM tb_eventest_answer WHERE question_id = ? ";
                $stmt_ans = $conn->prepare($sql_ans);
                $stmt_ans->bind_param("s",$_SESSION['quiz_id'][$num]);
                $stmt_ans->execute();
                $result_ans = $stmt_ans->get_result();
                while ($ans_data = $result_ans->fetch_assoc()) {
                    echo '<input type=radio value=', $ans_data['answer_id'], ' name="choose" ', ($ans_data['answer_id'] == $_SESSION['ans'][$num] ? 'checked' : ''), ' > &nbsp; <font face=Verdana size=3>', $ans_data['answer_text'], '</font><br>';
                }
                $stmt_ans->close();
            }
            $back = $num - 1;
            $next = $num + 1;
            if ($num <= 1) {
                $back = $_SESSION['amount'];
            }
            if ($num >= $_SESSION['amount']) {
                $next = 1;
            }
            echo "
					</td>
				</tr>
                <tr height=8></tr>
				<tr height=50>
					<td width=100% colspan=3>
						<input type=hidden name='time_left'>";
                if (isset($_SESSION['ans'][$num]) && $_SESSION['test_type'] == 2) {
                    
                } elseif ($_SESSION['test_type'] == 2 && $_SESSION['ans'][$num] == '') { // If exam test type is contest
                    echo "<input type='button' value='Record your answer' onclick='recordAnswer()' class='btn btn-warning' style='font-weight:bold;'>";
                } else {
                    echo "<input type='submit' value='Record your answer' class='btn btn-warning' style='font-weight:bold;'>";
                }
                echo "
								</td>
							</tr>
							<tr height=50>
								<td></td>
							</tr>
							<tr height=30>
								<td width=100% colspan=3 align=center style='background-color: #fdb83d; border-radius: 4px;'><font size=2 face=tahoma color=black><b>Question Number</b></font><font id='checktxt'></font></td>
							</tr>
							<tr height=10 >
                                <td width=100% colspan=3 align=center></td>
                            </tr>
						</form>
							<tr>
								<form name='num_form' method=post>
								<td colspan=3 align=center><input type=hidden name='time_left'>";
                                
                for ($i = 1; $i <= $_SESSION['amount']; $i++) {
                    $pre = "";
                    $post = "";
                    if (trim($_SESSION['ans'][$i])) {
                        $class = "bt_green";
                        $title = " Answered ";
                    } else {
                        $class = "bt_red";
                        $title = " Unanswer ";
                    }
                    if ($i < 10) {
                        $pre = "&nbsp;&nbsp;";
                        $post = "&nbsp;&nbsp;";
                    } if ($i >= 10 && $i < 100) {
                        $pre = "&nbsp;";
                        $post = "&nbsp;";
                    }
                    echo "&nbsp;<input type='button' class='$class' value='$pre$i$post' title='$title' style=\"cursor:pointer; border-radius:2px; margin-bottom:3px;\";
											onclick=\"javascript:window.document.num_form.action='?action=test&&quiz_id=$i';document.num_form.submit();\">";
                    if ($i % 20 == 0) {
                        echo "<br>";
                    }
                }
                echo "
								</td>
								</form>
							</tr>
							<tr height=50>
								<form name='back_form' method=post action=?action=test&&quiz_id=" . $back . ">
									<input type=hidden name='time_left'>
									<td width=10% align=left>
										<input type=image src='http://localhost/engtest/images/image2/test/back.png' style=\"cursor:pointer\">
									</td>
								</form>
								<td width=80% align=center>
											<font size=2 face=tahoma color=red>Red : Unanswer</font>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<font size=2 face=tahoma color=green>Green : Answered</font>
								</td>
								<form name='next_form' method=post action=?action=test&&quiz_id=" . $next . ">
									<input type=hidden name='time_left'>
									<td width=10% align=right><input type=image  src='http://localhost/engtest/images/image2/test/next.png' style=\"cursor:pointer\"></td>
								</form>
							</tr>
							<tr height=10 ><td width=100% colspan=3 align=center></td></tr>
							<tr height=1 bgcolor='#aaaaaa'><td width=100% colspan=3 align=center></td></tr>
							<tr height=10 ><td width=100% colspan=3 align=center></td></tr>
							<tr height=50 >
							<form name='fin_form' method=post action='?action=result'>
								<td width=100% colspan=3 align=center>
									<input type=button value='&nbsp;&nbsp;&nbsp; Finish &nbsp;&nbsp;&nbsp;' class='btn btn-success' style='font-weight:bold;' onclick=\"javascript:window.location='?action=result';\" >
								</td>
							</form>
							</tr>
						</table>";

        }
    }
    // mysqli_close($conn);
}
function record_ans() {
    
    set_time();
    $_SESSION['ans'][$_GET['quiz_id']] = NULL;   // clear Old Answer
    //---------------------------------------------------------//
    if ($_GET['quiz_id']) {
        $_SESSION['ans'][$_GET['quiz_id']] = $_POST['choose'];
    }
    if ($_GET['quiz_id'] >= 1) {
        $quiz_id = $_GET['quiz_id'] + 1;
    }
    if ($_GET['quiz_id'] == $_SESSION['amount']) {
        $quiz_id = 1;
    }
    header("Location:?action=test&&quiz_id=$quiz_id");
    exit();
    
}

function display_time_left()
{
    echo "<br>
		  <table align=center width=250 cellpadding=0 cellspacing=0 border=0>
				<tr height=30><td bgcolor=F2DEDE style='border-radius:5px;'>
					<div id='dplay' align=center></div>
				</td></tr>
		  </table>";
}
function set_time()
{
    if ($_SESSION['all_time'] && $_SESSION['all_time'] - $_SESSION['all_time'] == 0) {
        $_SESSION['fn_time'] = $_SESSION['all_time'];
        unset($_SESSION['all_time']);
    }
    if ($_SESSION['fn_time'] && $_POST['time_left']) {
        $_SESSION['fn_time'] = $_POST['time_left'];
    }
    echo "
		<form name=config>
			<input type=hidden  value='$_SESSION[fn_time]' name='fn_time'  readonly>
			<input type=hidden  name='time_min'  readonly>
			<input type=hidden  name='time_sec'  readonly>
		</form>";
}

function display_result() {
    include('../config/connection.php');
    
    if ($_SESSION['quiz_id']) {
        $num = count($_SESSION['quiz_id']);
    }
    if ($num >= 1) {
        if ($_SESSION['quiz_id']) {
            $count = count($_SESSION['quiz_id']);
            if ($count >= 1) {
                $percent = 0;
                $sum = 0;
                if ($_SESSION['exam_type'] == 1) {
                    //  check answer from  system exam
                    for ($i = 1; $i <= $count; $i++) {
                        $ans_id = $_SESSION['ans'][$i] ??  0;
                        $is_correct = 1;
                        $strSQL = "SELECT * FROM tb_answers WHERE QUESTIONS_ID = ?  && ANSWERS_CORRECT = ? && ANSWERS_ID = ?";
                        $stmt = $conn->prepare($strSQL);
                        $stmt->bind_param("sii", $_SESSION['quiz_id'][$i],$is_correct, $ans_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $correct = $result->num_rows;
                        $stmt->close();

                        if ($correct == 1) {
                            $sum = $sum + 1;
                        }
                    }
                    if ($sum >= 1) {
                        $percent = number_format(( ( $sum / $count ) * 100), 2);
                    }
                }

                if ($_SESSION['exam_type'] == 2) {
                    //  check answer from  system exam
                    for ($i = 1; $i <= $count; $i++) {
                        $is_correct = 1;
                        $SQL = "SELECT * FROM tb_eventest_answer WHERE answer_id = ?  && question_id = ? && answer = ?";
                        $query = $conn->prepare($SQL);
                        $query->bind_param("ssi", $_SESSION['ans'][$i],$_SESSION['quiz_id'][$i],$is_correct);
                        $query->execute();
                        $result = $query->get_result();
                        $correct = $result->num_rows;
                        $query->close();
                        if ($correct == 1) {
                            $sum = $sum + 1;
                        }  
                    }
                    if ($sum >= 1) {
                        $percent = number_format(( ( $sum / $count ) * 100), 2);
                    }
                    
                } else {
                    if ($_SESSION['score'] >= 1) {
                        $percent = number_format(( ( $_SESSION['score'] / $count ) * 100), 2);
                    }
                }
            }
        }
        //------------------------------------------------------------------//
        //get last result id
        $sql_result = "SELECT * FROM tb_w_result ORDER BY result_id DESC limit 0,1";
        $stmt_result = $conn->prepare($sql_result);
        $stmt_result->execute();
        $result_num = $stmt_result->get_result();
        $num = $result_num->num_rows;
        
        if ($num > 0) {
            $data = $result_num->fetch_array();
            $last_id = $data['result_id'] + 1;
        } else {
            $last_id = 1;
        }
        $stmt_result->close();
        //-------------------------------------------------------------------//
       
        $zero = 0;
        $now = date("Y-m-d H:i:s");
        $sql = "INSERT INTO tb_w_result (result_id, member_id, skill_id, level_id, etest_id, percent, create_date) VALUES (?,?,?,?,?,?,?)";
        $sub_query = $conn->prepare($sql);
        $sub_query->bind_param("ssiisss",$last_id, $_SESSION['x_member_id'],$zero, $zero, $_SESSION['exam_id'], $percent,$now);
        $sub_query->execute();
        $sub_query->close();

        //------------------------------------------------------------------//
        if ($_SESSION['quiz_id']) {
            $count = count($_SESSION['quiz_id']);
            if ($count >= 1) {
                for ($i = 1; $i <= $count; $i++) { 
                    $ans_id = $_SESSION['ans'][$i] ??  0;
                    $sql_result_detail = "INSERT INTO tb_w_result_detail (result_id, quiz_id, ans_id) VALUES (?,?,?)";
                    $stmt_result_detail = $conn->prepare($sql_result_detail);
                    $stmt_result_detail->bind_param("ssi",$last_id, $_SESSION['quiz_id'][$i], $ans_id );
                    $stmt_result_detail->execute();
                    $stmt_result_detail->close();
                }
            }
        }

//         $sql_realtime = "SELECT * ";
//         $sql_realtime .= "      FROM tbl_w_realtime";
//         $sql_realtime .= "      WHERE member_id = '" . $_SESSION['x_member_id'] . "'";
//         $sql_realtime .= "            AND etest_id = '" . $_SESSION['exam_id'] . "'";
// //                        echo "<pre>".$sql_realtime."</pre>";
//         $result_realtime = mysql_query($sql_realtime);
//         $num_realtime = mysql_num_rows($result_realtime);

        $percent_insert = $percent;
        $sql_realtime = "SELECT * FROM tb_w_realtime WHERE member_id = ? && etest_id = ?";
        $query = $conn->prepare($sql_realtime);
        $query->bind_param("ss", $_SESSION['x_member_id'], $_SESSION['exam_id']);
        $query->execute();
        $result = $query->get_result();
        $num_realtime = $result->num_rows;
        $query->close();

        if ($num_realtime == 0) {
            $time = date("Y-m-d H:i:s");
            $sql_realtime_insert = "INSERT INTO tb_w_realtime (member_id,etest_id,percent,create_date,start_time,end_time) VALUES(?,?,?,?,?,?)";
            $stmt_realtime_insert = $conn->prepare($sql_realtime_insert);
            $stmt_realtime_insert->bind_param("ssdsss", $_SESSION['x_member_id'], $_SESSION['exam_id'],$percent_insert,$time,$time,$time);
            $stmt_realtime_insert->execute();
            $stmt_realtime_insert->close();
        }else{
            // $create_date = date("Y-m-d H:i:s");
            $sql_realtime_update = "UPDATE tb_w_realtime SET percent = ?, create_date = ?, end_time = ? WHERE member_id = ? && etest_id = ?";
            $stmt_realtime_update = $conn->prepare($sql_realtime_update);
            $stmt_realtime_update->bind_param("dssss", $percent_insert,$now,$now,$_SESSION['x_member_id'], $_SESSION['exam_id']);
            $stmt_realtime_update->execute();
            $stmt_realtime_update->close();
        }
        // if ($num_realtime == 0) {
        //     $sql_realtime_insert = "INSERT INTO tbl_w_realtime ";
        //     $sql_realtime_insert .= "      (member_id,etest_id,percent,create_date,start_time,end_time)";
        //     $sql_realtime_insert .= "      VALUES ('" . $_SESSION['x_member_id'] . "', '" . $_SESSION['exam_id'] . "','" . $percent_insert . "', '".$now."',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);";
        //     $result_realtime_insert = mysql_query($sql_realtime_insert);
        // } else {
        //     $sql_realtime_update = "UPDATE tbl_w_realtime SET";
        //     $sql_realtime_update .= "      percent='" . $percent_insert . "',";
        //     $sql_realtime_update .= "      create_date='".$now."',";
        //     $sql_realtime_update .= "      end_time=CURRENT_TIMESTAMP";
        //     $sql_realtime_update .= "      WHERE member_id = '" . $_SESSION['x_member_id'] . "'";
        //     $sql_realtime_update .= "            AND etest_id = '" . $_SESSION['exam_id'] . "'";
        //     $result_realtime_update = mysql_query($sql_realtime_update);
        // }
    }
    unset($_SESSION['amount']);
    unset($_SESSION['quiz_id']);
    unset($_SESSION['ans']);
    unset($_SESSION['all_time']);
    unset($_SESSION['fn_time']);
    unset($_SESSION['score']);
    unset($_SESSION['exam_type']);

    mysqli_close($conn);
    
    header("Location:eoltest.php?section=business&&action=report&&report_section=contest&&result_id=$last_id");

    exit();
}

function check_duel_login()
{
    include('../config/connection.php');
    $session_id = session_id();
    $strSQL = "SELECT * FROM tb_x_login WHERE member_id = ? && ssid = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $_SESSION['x_member_id'], $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_ok = $result->num_rows;
    if ($is_ok == 0) {
        unset($_SESSION['x_member_id']);
    }
    $stmt->close();
    mysqli_close($conn);

}

function check_available_time()
{
    include('../config/connection.php');
    $now = date("Y-m-d H:i:s");
    $strSQL = "SELECT * FROM tb_x_member_time WHERE member_id = ? && stop_date >= ? ORDER BY stop_date DESC limit 0,1";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss", $_SESSION['x_member_id'], $now);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_ok = $result->num_rows;
    if ($is_ok == 0) {
        echo "<script type=\"text/javascript\">
		            window.location=\"eoltest.php?section=business\";
	          </script>";
        exit();
    }
    $stmt->close();
    mysqli_close($conn);
}

function is_mobile()
{

    // Get the user agent

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Create an array of known mobile user agents
    // This list is from the 21 October 2010 WURFL File.
    // Most mobile devices send a pretty standard string that can be covered by
    // one of these. I believe I have found all the agents (as of the date above)
    // that do not and have included them below. If you use this function, you
    // should periodically check your list against the WURFL file, available at:
    // https://wurfl.sourceforge.net/


    $mobile_agents = array(

        "240x320",
        "acer",
        "acoon",
        "acs-",
        "abacho",
        "ahong",
        "airness",
        "alcatel",
        "allview",
        "amoi",
        "amazon",
        "android",
        "anywhereyougo.com",
        "apple",
        "applewebkit/525",
        "applewebkit/532",
        "archos",
        "asus",
        "audio",
        "au-mic",
        "avantogo",
        "becker",
        "benq",
        "bilbo",
        "bird",
        "blackberry",
        "blazer",
        "bleu",
        "cdm-",
        "compal",
        "coolpad",
        "danger",
        "dbtel",
        "dopod",
        "elaine",
        "eric",
        "etouch",
        "fly ",
        "fly_",
        "fly-",
        "go.web",
        "goodaccess",
        "google",
        "gradiente",
        "grundig",
        "haier",
        "hedy",
        "hitachi",
        "hp",
        "htc",
        "honor",
        "huawei",
        "hutchison",
        "inno",
        "infinix",
        "ipad",
        "ipaq",
        "ipod",
        "iphone",
        "itel",
        "jbrowser",
        "kddi",
        "kgt",
        "kwc",
        "leeco",
        "lenovo",
        "lg ",
        "lg2",
        "lg3",
        "lg4",
        "lg5",
        "lg7",
        "lg8",
        "lg9",
        "lg-",
        "lge-",
        "lge9",
        "longcos",
        "maemo",
        "mercator",
        "meridian",
        "micromax",
        "midp",
        "mini",
        "mitsu",
        "meizu",
        "mmm",
        "mmp",
        "mobi",
        "mot-",
        "moto",
        "motorola",
        "nec-",
        "netfront",
        "newgen",
        "nexian",
        "nf-browser",
        "nintendo",
        "nitro",
        "nokia",
        "nook",
        "novarra",
        "nvidia",
        "obigo",
        "oppo",
        "oneplus",
        "orange",
        "palm",
        "panasonic",
        "pantech",
        "philips",
        "plum",
        "phone",
        "pg-",
        "playstation",
        "poco",
        "pocket",
        "pt-",
        "qc-",
        "qtek",
        "rover",
        "redmi",
        "realme",
        "sagem",
        "sama",
        "samu",
        "sanyo",
        "samsung",
        "sch-",
        "scooter",
        "sec-",
        "sendo",
        "sgh-",
        "sharp",
        "siemens",
        "sie-",
        "softbank",
        "sony",
        "spice",
        "sprint",
        "spv",
        "symbian",
        "tablet",
        "talkabout",
        "tcl-",
        "teleca",
        "telit",
        "tecno",
        "tianyu",
        "tim-",
        "toshiba",
        "tsm",
        "up.browser",
        "utec",
        "utstar",
        "verykool",
        "virgin",
        "vivo",
        "vk-",
        "voda",
        "voxtel",
        "vx",
        "wap",
        "wellco",
        "wig browser",
        "wii",
        "wiko",
        "windows ce",
        "wireless",
        "xolo",
        "xda",
        "xde",
        "xiaomi",
        "yezz",
        "yu",
        "zte"
    );

    // Pre-set $is_mobile to false.

    $is_mobile = false;

    // Cycle through the list in $mobile_agents to see if any of them
    // appear in $user_agent.

    foreach ($mobile_agents as $device) {

        // Check each element in $mobile_agents to see if it appears in
        // $user_agent. If it does, set $is_mobile to true.

        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            // break out of the foreach, we don't need to test
            // any more once we get a true value.
            break;
        }
    }

    return $is_mobile;
}
?>