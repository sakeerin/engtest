<?php
ob_start();
session_start();
main_e_test();
date_default_timezone_set('Asia/Bangkok');

function main_e_test(){
    echo "<style type='text/css'>
            :focus { outline: 0; }
            table.exam { border-spacing: 0; } 
            table.exam  a:link {
                color: #666;
                font-weight: bold;
                text-decoration:none;
            }
            table.exam  a:visited {
                color: #999999;
                font-weight:bold;
                text-decoration:none;
            }
            table.exam  a:active,
            table.exam  a:hover {
                color: #bd5a35;
                text-decoration:underline;
            }
            table.exam  {
                font-family:Arial, Helvetica, sans-serif;
                color:#666;
                width:100%;
                font-size:12px;
                text-shadow: 1px 1px 0px #fff;
                background:#eaebec;
                -moz-border-radius:3px;
                -webkit-border-radius:3px;
                border-radius:3px;
                -moz-box-shadow: 0 1px 2px #d1d1d1;
                -webkit-box-shadow: 0 1px 2px #d1d1d1;
                box-shadow: 0 1px 2px #d1d1d1;
            }
            table.exam  th {
                padding:21px 25px 22px 25px;
                border:none;
                border-top:1px solid #fafafa;
                border-bottom:1px solid #e0e0e0;
                color:#ffffff;
                text-shadow: 1px 1px 1px #333;
                background: #FF9900;
            }
            table.exam  th:first-child{
                text-align: left;
                padding-left:20px;
            }
            table.exam  tr:first-child th:first-child{
                -moz-border-radius-topleft:3px;
                -webkit-border-top-left-radius:3px;
                border-top-left-radius:3px;
            }
            table.exam  tr:first-child th:last-child{
                -moz-border-radius-topright:3px;
                -webkit-border-top-right-radius:3px;
                border-top-right-radius:3px;
            }
            table.exam  tr{
                text-align: center;
                padding-left:20px;
            }
            table.exam  tr td:first-child{
                text-align: left;
                width:43%;
                padding-left:20px;
                border-left: 0;
            }
            table.exam tr td {
                padding:15px;
                border-top: 1px solid #ffffff;
                border-bottom:1px solid #e0e0e0;
                border-left: 1px solid #e0e0e0;
                
                background: #fafafa;
                background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
                background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
            }
            table.exam  tr.even td{
                background: #f6f6f6;
                background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
                background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
            }
            table.exam  tr:last-child td{
                border-bottom:0;
            }
            table.exam  tr:last-child td:first-child{
                -moz-border-radius-bottomleft:3px;
                -webkit-border-bottom-left-radius:3px;
                border-bottom-left-radius:3px;
            }
            table.exam  tr:last-child td:last-child{
                -moz-border-radius-bottomright:3px;
                -webkit-border-bottom-right-radius:3px;
                border-bottom-right-radius:3px;
            }
            table.exam  tr:hover td{
            cursor:pointer;
                background: #E5F3FA;
                background: -webkit-gradient(linear, left top, left bottom, from(#E5F3FA), to(#E1EEF5));
                background: -moz-linear-gradient(top,  #E5F3FA,  #E1EEF5);	
            }
            table.exam  tr.selected td {
                cursor:pointer;
                background: #E5F3FA;
                background: -webkit-gradient(linear, left top, left bottom, from(#E5F3FA), to(#E1EEF5));
                background: -moz-linear-gradient(top,  #E5F3FA,  #E1EEF5);	
            }
            .btn-edit{
                height:28px;
                width:auto;
                margin-left:15px;
                padding-left:5px;
                padding-right:5px;
                margin-bottom:10px;
                font-weight:bold;
                color:#ffffff;
                cursor:pointer;
                border:1px solid #F08411;;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
                background:#F08411; !important;
                -webkit-box-shadow: 1px 1px 1px #D9D9D9;
                -moz-box-shadow:  1px 1px 1px #D9D9D9;
                box-shadow:  1px 1px 1px #D9D9D9;
            }
            .btn-edit:hover{
                border:1px solid #F08411;
                background:#F08411;
                -webkit-box-shadow: no;
                -moz-box-shadow:  no;
                box-shadow:  no;
                font-size: 15px;
            }
            .bnt-delete{
                height:28px;
                width:auto;
                margin-left:15px;
                padding-left:5px;
                padding-right:5px;
                margin-bottom:10px;
                font-weight:bold;
                color:#ffffff;
                cursor:pointer;
                border:1px solid #EA1919;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
                background:#EA1919 !important;
                -webkit-box-shadow: 1px 1px 1px #D9D9D9;
                -moz-box-shadow:  1px 1px 1px #D9D9D9;
                box-shadow:  1px 1px 1px #D9D9D9;
            }
            .bnt-delete:hover{
                border:1px solid #EA1919;
                background:#EA1919;
                -webkit-box-shadow: no;
                -moz-box-shadow:  no;
                box-shadow:  no;
                font-size: 15px;
            }
            .bnt-etest {
                height:28px;
                width:auto;
                margin-left:15px;
                padding-left:5px;
                padding-right:5px;
                margin-bottom:10px;
                font-weight:bold;
                color:#ffffff;
                cursor:pointer;
                border:1px solid #147CCC;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
                background:#1685DB;
                -webkit-box-shadow: 1px 1px 1px #D9D9D9;
                -moz-box-shadow:  1px 1px 1px #D9D9D9;
                box-shadow:  1px 1px 1px #D9D9D9;
            }
            .bnt-etest:hover{
                border:1px solid #116BB0;
                background:#1273BD;
                -webkit-box-shadow: no;
                -moz-box-shadow:  no;
                box-shadow:  no;
                font-size: 15px;
            }
            .bnt-etest.btn-lesson{
                background:#00B800 !important;
                border:1px solid #00B800;
            }
            .bnt-etest.btn-lesson:hover{
                background:#006600 !important;
                border:1px solid #006600;
                font-size: 15px;
            }
            .bnt-edit {
                color:#666;
                border:1px solid #DEDEDE;
                background:#EBEBEB;
            }
            .bnt-edit:hover{
                border:1px solid #DEDEDE;
                background:#D1D1D1;
            }
            .setright{
                float:right;
            }
            table.detailform tr td {
                padding:5px;	
            }
            #detailexam,#creat_exam, #create_custom{
                font-family:Arial, Helvetica, sans-serif;
                color: #666;
                font-size:12px;
                font-weight: bold;
                text-decoration:none;
                width:335px; 
                height:575px;
                background:#ffffff;
                color:#666;
                border:1px solid #E3E3E3;
                float:left;
                margin-top:-75px;
                margin-left:10px;
                padding:5px;
            }
            #creat_exam, #create_custom{
                margin-top:0px;
                margin-left:0px;
                width:948px;
                background-image:url('https://www.engtest.net/image2/eol system/add test.png');	
                background-repeat:no-repeat;
                background-position:left bottom;					   
            }
            #detailexam input.txtdetail,#creat_exam input.txtdetail , #create_custom input.txtdetail {
                border:1px solid #e0e0e0;
                padding-left:5px;
                height:28px;
                width:180px
            }
            #detailexam input.txtdetail:hover,#creat_exam input.txtdetail:hover, #create_custom input.txtdetail:hover{
                border:1px solid #3FC8FA;
                -webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.2);
                -moz-box-shadow:  1px 1px 1px rgba(0,0,0,.2);
                box-shadow:  1px 1px 1px rgba(0,0,0,.2);
            }
            #detailexam input.txtdetail:focus,#creat_exam input.txtdetail:focus ,#create_custom input.txtdetail:focus{
                border:1px solid #1273BD;
            }
            #creat_exam{
                border:none;
            }
            #create_custom{
                position:relative;
                width:900px;
                height:auto;
                border:none;
                left:50%;
                margin-left:-450px;
                float: none;
            }
            table.tbl_create_custom {
                width:800px;
                background:#f6f6f6;
                opacity:0.9;    
                border-radius:10px; 
            }
            table.tbl_create_custom td{
                padding:5px 10px 5px 10px;   
            }
            #listgroup_name {
                width:auto; 
                height:250px;
                font-weight:normal;
                margin-top:5px;
                border:1px solid #E3E3E3;
                margin-bottom:20px;
                border-radius: 5px;
            }
            #listgroup_name input.checkbok_group{
                height:15px;
                width:15px;
            }
            .selector{
                height:32px;
                width:150px;
                border:1px solid #e0e0e0;
                border-radius: 5px;
            }
            .tbcreate_exam{
                opacity:0.8;
            }
            .btnadd_exam,.btnremove_exam{
                float:right;
                margin-right:15px;
                cursor:pointer;
                border:none;
                width:30px;
                height:30px;
                background:none;
                background-image:url('http://localhost/engtest/images/image2/eol system/plus.png');	
                background-repeat:no-repeat;
                background-position:center;
            }
            .btnremove_exam{
                margin-top: 2px;
                margin-left:5px;
                margin-right:0px;
                background:none;
                background-image:url('http://localhost/engtest/images/image2/eol system/delete.png');	
                background-repeat:no-repeat;
                background-position:center;
            }
            .btnadd_exam:hover,.btnremove_exam:hover{
                opacity:0.8;
            }
            #creat_exam_div{
                position:relative;
                background-color:#F2F2F2;
                opacity:0.8;
                width:850px;
                height:500px;
                overflow: auto;
                border-radius: 8px;
            }
            .radio lable{
                position:relative;
                margin-right:10px;
            }
            .txtdetail {
                border-radius: 5px;
                margin-right: 5px;
            }
            #detailexam{
                border-radius: 5px;
            }
            .back{
                display: block;
                width: 90px;
                background: #4E9CAF;
                padding: 9px 5px;
                text-align: center;
                border-radius: 5px;
                color: white;
                font-weight: bold;
                
            }
            .back:hover{
                text-decoration: none;
                color: white;
                background: #286090;
            }
           
            </style>
            <link rel='stylesheet' href='http://localhost/engtest/js/scroller/scroller.css' />
            <link href='http://localhost/engtest/bootstrap/toggle-switch/toggleswitch.css' rel='stylesheet' type='text/css' />
            <div style='position:relative; width:960px; height:auto; background:#FFFFFF;border:1px solid #E3E3E3;padding:5px; padding-top:15px; border-radius:5px;margin-top:15px;'> ";

 if($_GET['action'] == 'create_customize'){
      create_exam_customize();
 }elseif($_GET['action'] == 'create'){
      create_exam_system();
 }elseif($_GET['action'] == 'edit'){
      editExam();
 }elseif($_GET['action'] == 'view'){
      listExam();
 }elseif($_GET['action'] == 'create_lesson'){
      create_lesson();
 }elseif($_GET['action'] == 'view_lesson'){
      view_lesson();
 }elseif(($_GET['action'] == 'edit_lesson') && ($_GET['lessonid'] <> '')){
      edit_lesson();
 }elseif(($_GET['action'] == 'delete_lesson') && ($_GET['lessonid'] <> '')){
      delete_lesson();
 }else{
     if(isset($_SESSION['createExamId']))
          unset($_SESSION['createExamId']);
     if(isset($_SESSION['createExamId']))
          unset($_SESSION['createExam_name']);
     list_exam();
 }       

   echo" <div style='clear:both;'></div></div>
            <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js'></script>
            <script type='text/javascript' src='http://localhost/engtest/bootstrap/toggle-switch/jquery.toggleswitch.js'></script>
            <script type='text/javascript' src='http://localhost/engtest/js/scroller/nanoscroller.min.js'></script>
            <script type='text/javascript'>
                jQuery(document).ready(function ($) {
                    $('.toggleswitch').toggleSwitch();
                });
                $('#listgroup_name ,#examlist').nanoScroller();
                $('#listgroup_name ,#examlist').nanoScroller({ sliderMinHeight: 30 });
            </script>";
 }

 function list_exam(){
    include('updateExam.php');
    include('../config/connection.php');
   
    $strSQL = "SELECT et.*, COUNT(eq.question_id) AS amount FROM tb_eventest AS et LEFT JOIN tb_eventest_question AS eq ON eq.exam_id = et.exam_id WHERE et.create_by = ?  GROUP BY et.exam_id ORDER BY et.exam_id DESC";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s",$_SESSION['x_member_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->num_rows; 
    
    echo "<div style='widht:100%;height:45px;'> 
              <a href='?section=business&status=e-test&action=view_lesson'> 
                  <button  id='add' class='bnt-etest btn-lesson'> o บทเรียนทั้งหมด</button>
              </a>
              <a href='?section=business&status=e-test&action=create_lesson'> 
                  <button  id='add' class='bnt-etest btn-lesson'> + สร้างบทเรียนแบบกำหนดเอง</button>
              </a>
              <a href='?section=business&status=e-test&action=create_customize'>
                  <button  id='add' class='bnt-etest setright'> + สร้างชุดข้อสอบแบบกำหนดเอง </button>
              </a> 
              <a href='?section=business&status=e-test&action=create'> 
                  <button  id='add' class='bnt-etest setright'> + สร้างชุดข้อสอบจากระบบ</button>
              </a>
          </div> 
          <div style='width:600px; height:auto; background:#ffffff;border:1px solid #FF9900;float:left; border-radius:5px;'>
              <table cellspacing='0' class='exam'> <!-- cellspacing='0' is important, must stay -->
                  <tr><th width=52%>รายละเอียดชุดข้อสอบ</th><th width=14%>ดูชุดข้อสอบ</th><th width=16%>จำนวนข้อ</th><th width=15% align=left>เวลาสอบ</th><th width=18% align=left>สถานะการใช้งาน</th></tr><!-- Table Header -->
              </table>
          </div><!-- header table ----->
          <div id='examlist' class='nano' style='width:600px; height:510px; background:#ffffff; border:1px solid #E3E3E3; float:left;'>
              <div class='content' >
                  <table cellspacing='0' class='exam'> <!-- cellspacing='0' is important, must stay -->";
                  
    if (isset($_GET['detail'])) {
        $setselect = $_GET['detail'];
        $examId = $conn->real_escape_string(trim($_GET['detail']));
    }else {
        $setselect = 0;
        $examId = '';
    }
    
    $class = '';
    $i = 0;
    if ($rows <= 1) {
        $data = $result->fetch_array();
        $class = "class='selected' " ;
		$examId = $data['exam_id'];
        if ($data['exam_type'] == 2) {
            
            $amount = get_amount_exam_customize($examId);
        }
        else{
            $amount = $data['amount'];
        }
        
        echo '<tr ',$class,'><td><a href="?section=business&status=e-test&detail='.$data['exam_id'].'">',$data['exam_name'],'</a></td>
		<td><a href="?section=business&&status=e-test&action=view&examId='.$data['exam_id'].'&page=1">',"View",'</a></td>
		<td>',$amount,'</td>
		<td>',$data['testtime'],'</td>
		<td>','<b>',($data['active'] == 1 ? "ON" : "OFF"),'</b></td>
		</tr>';
    }else {
        while($data = $result->fetch_assoc()) {
            $view = "View";
            $class = (($i%2) == 0 ? "class='even' " : '');
            $class = ($data['exam_id'] == $setselect ? "class='selected' " : $class);
            $class = ($setselect == $i ? "class='selected' " : $class);
            $examId = ($examId == '' ? $data['exam_id'] : $examId);
            if($data['exam_type'] === 2)
            {
                $amount = get_amount_exam_customize($data['exam_id']);
            }else{
                $amount = $data['amount'];
            }
            echo '<tr ',$class,'><td><a href="?section=business&status=e-test&detail='.$data['exam_id'].'">',$data['exam_name'],'</a></td>
            <td><a href="?section=business&&status=e-test&action=view&examId='.$data['exam_id'].'&page=1">',$view,'</a></td>
            <td>',$amount,'</td>
            <td>',$data['testtime'],'</td>
            <td>','<b>',($data['active'] == 1 ? "ON" : "OFF"),'</b></td>
            </tr>';
            $i++;    
        }  
    }
    
    $stmt->close();
    echo "
		    	</table>
		    </div>
		</div>";
        
    $strSQL = "SELECT et.*, COUNT(eq.question_id) AS amount FROM tb_eventest AS et LEFT JOIN tb_eventest_question AS eq ON eq.exam_id = et.exam_id WHERE et.create_by = ? && et.exam_id = ? GROUP BY et.exam_id ORDER BY et.exam_id DESC";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss",$_SESSION['x_member_id'],$examId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->num_rows; 
    $examdetail = $result->fetch_array();
    $stmt->close();
    
    $group_type = 0;
    $noneGroup = "SELECT * FROM tb_eventest_allowgroup WHERE exam_id = ? && group_type = ?";
    $sub_stmt = $conn->prepare($noneGroup);
    $sub_stmt->bind_param("si",$examId,$group_type);
    $sub_stmt->execute();
    $result = $sub_stmt->get_result();
    $nonegroup = $result->num_rows;
    $sub_stmt->close();

    $testactive = $examdetail['active'];
    if($examdetail['exam_type'] == 2)
    {
        $amountlist = get_amount_exam_customize($examdetail['exam_id']);
        $btnEdit = '<button  id="add" class="btn-edit setright" ><a href="?section=business&&status=e-test&action=edit&examId='.$examdetail['exam_id'].'" style="color:white"> แก้ไขข้อสอบ</a></button> '; 
    }else{
        $amountlist = $examdetail['amount'];
    }
    $seted = ($testactive == 1 ? "checked='checked'" : "");

    $allowGroup = "SELECT * FROM tb_x_member_type
            LEFT JOIN tb_eventest_allowgroup 
            ON tb_x_member_type.type_id = tb_eventest_allowgroup.group_type 
            AND tb_eventest_allowgroup.exam_id = ?
            WHERE tb_x_member_type.member_id = ? ";
    $query = $conn->prepare($allowGroup);
    $query->bind_param("ss",$examId,$_SESSION['x_member_id']);
    $query->execute();
    $result_allowGroup = $query->get_result();
    $numgroup = $result_allowGroup->num_rows;
    
    echo "
		 <div id='detailexam' >
			<form method='post' action='eoltest.php?section=business&&status=e-test&detail=".$examdetail['exam_id']."'> 
			    <table border=0 class='detailform'>
			        <input type='hidden' value='".$examdetail['exam_id']."' name='examid'/>
				    <tr><td>ชุดข้อสอบ </td><td><input type='text' name='examname' value='".$examdetail['exam_name']."' class='txtdetail' style='width:240px;' /></td></tr>
				    <tr><td>วันที่ </td><td>".$examdetail['create_date']."</td></tr>
				    <tr><td>จำนวนข้อ  </td><td>".$amountlist."</td></tr>
				    <tr><td>เวลาสอบ   </td><td><input type='text' name='time' value='".$examdetail['testtime']."'class='txtdetail' style='width:50px;' maxlength='3' onkeypress='checknum()' /> นาที</td></tr>
				    <tr><td>รูปแบบการทดสอบ   </td><td><input type='radio' name='exam_type' value='1' ".($examdetail['test_type'] == 1 ? "checked='checked'" : "").">สอบเก็บคะแนน<br>
				    <input type='radio' name='exam_type' value='2' ".($examdetail['test_type'] == 2 ? "checked='checked'" : "").">การแข่งขัน</td></tr>
				    <tr><td>เปิดใช้งาน </td><td><input type='checkbox' name='exam_active' id='opt1' value='1' class='toggleswitch' ".$seted ."/></td></tr>
				</table>
				เลือกกลุ่มที่สอบ 
				<div id='listgroup_name' class='nano'>
				    <div class='content' style='padding-left:10px; padding-top:10px;'>
                        <input type='checkbox' name='allowgroup[]' value='0' class='checkbok_group' ".($nonegroup == 1 ? "checked='checked'" : "" )." > nonegroup <br>";
                        if($numgroup == 1){
                            $group = $result_allowGroup->fetch_array();
                            echo "<input type='checkbox' name='allowgroup[]' value='".$group['type_id']."' ".($group['allow_id'] !='' ? "checked='checked'" : "")." class='checkbok_group'> ".$group['name'] ."<br>";
                        }else{
                            while($group = $result_allowGroup->fetch_assoc()) {
                                echo "<input type='checkbox' name='allowgroup[]' value='".$group['type_id']."' ".($group['allow_id'] != '' ? "checked='checked'" : "")." class='checkbok_group'> ".$group['name'] ."<br>";
                            } 
                        }

                        echo " <input type='hidden' name='allowgroup[]' value='1' >";
                        $query->close();
              echo "</div>
                </div>
                <input type='submit'  name='save' id='save' class='bnt-etest setright' value='บันทึก' style='width:50px;'>
            </form>
                    $btnEdit 
                    <button  id='add' class='bnt-delete setright' onclick='delexam()'> ลบชุดข้อสอบ</button>
                    <div id='alert-error'>
                    <font color=red >".$message." </font>
                    </div> 
        </div>
        <div style='clear:both;'></div>
        <script>
            function delexam(){
                var r=confirm('คุณต้องการลบชุดข้อสอบหรือไม่')
                if (r==true)
                {
                    location.href='?section=business&status=e-test&del_exam=".$examdetail['exam_id']."';
                }
            }
        </script>"; 
       
        mysqli_close($conn);
       
        
 }

 function get_amount_exam_customize($exam_id){
    include('../config/connection.php');
    $strSQL = "SELECT * FROM tb_eventest_question_custom WHERE exam_id = ?";
    $query = $conn->prepare($strSQL);
    $query->bind_param("s",$exam_id);
    $query->execute();
    $result = $query->get_result();
    $amount = $result->num_rows;
    $query->close();
    mysqli_close($conn);

    return $amount;
 }


function create_lesson(){
	include('custom_lesson_create.php');
}
function edit_lesson(){
	include('custom_lesson_create.php');
}

function delete_lesson(){
	include('custom_lesson_create.php');
}

function view_lesson(){
	include('custom_lesson_view.php');
}

function create_exam_customize()
{

?>


<script type="text/javascript">
function copypaste(str, obj) {
    var orgi_text = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&^*()..,?_+-*/='\"”“:;‘’ ";
    var str_length = str.length;
    var str_length_end = str_length - 1;
    var copypaste = true;
    var Char_At = "";
    for (i = 0; i < str_length; i++) {
        Char_At = str.charAt(i);
        if (orgi_text.indexOf(Char_At) == -1) {
            copypaste = false;
        }
    }

    if (str_length >= 1) {
        if (copypaste == false) {
            obj.value = "";

        }
    }

    return copypaste;
}
</script>

<?php

    include('../config/connection.php');
	$error = '';
	if(isset($_POST['addexam'])) // If add new Exam
	{
		$examname = $conn->real_escape_string(trim($_POST['examname']));
        $testtime = 0;
        $test_type = 1;
        $exam_type = 2;
        $date = date('Y-m-d H:i:s');
		if($examname !='') // If exam name not null
		{
			
            $strSQL = "INSERT INTO tb_eventest (exam_name, testtime, test_type, exam_type, create_by, create_date) VALUES (?,?,?,?,?,?)";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ssiiss",$examname,$testtime,$test_type,$exam_type,$_SESSION['x_member_id'],$date);
            $stmt->execute();
            $stmt->close();

            $SQL = "SELECT * FROM tb_eventest WHERE create_by = ? ORDER BY exam_id DESC LIMIT 0,1";
            $query = $conn->prepare($SQL);
            $query->bind_param("s",$_SESSION['x_member_id']);
            $query->execute();
            $result = $query->get_result();
            $lastId = $result->fetch_array();
            $_SESSION['createExamId'] = $lastId['exam_id'];
			$_SESSION['createExam_name'] = $lastId['exam_name'];
            $query->close();
		}else{
			$message = 'Please insert  Exam name !';
		}
	}
	if(isset($_POST['addQuiz'])) // ----If add quiz--- //
	{
		unset($select_choice);
	    $question = stripslashes(nl2br(check_symbol_special($_POST['quiz'])));
		
		for($i=0 ;$i<4;$i++)
		{
			if($_POST['select_choice'] === '')
			{
				$error = 'Please select correct Answer ';
			}elseif($_POST['choice'][$i] === ''){
				$error = 'Please insert answer ';
			}
				$choice[$i]=$_POST['choice'][$i];
				$select_choice[$i]=$_POST['select_choice'][$i];
		}
		unset($i);
		if($question != '' && !$error)
		{
                $question_text = $question;
                $active = 1;
                $strSQL = "INSERT INTO tb_eventest_question_custom (exam_id, question_text, is_active) VALUES (?,?,?)";
                $stmt = $conn->prepare($strSQL);
                $stmt->bind_param("ssi",$_SESSION['createExamId'],$question_text,$active);
                $stmt->execute();
                $stmt->close();
				
                $SQL = "SELECT * FROM tb_eventest_question_custom WHERE exam_id = ?  ORDER BY question_id DESC LIMIT 0,1";
                $query = $conn->prepare($SQL);
                $query->bind_param("s",$_SESSION['createExamId']);
                $query->execute();
                $result = $query->get_result();
                $questionId = $result->fetch_array();
                
				for($i=0; $i<4; $i++)
				{
					if($select_choice[0]==$i) // Set correct  answer
					{
						$correct = 1;
					}
					else
					{
						$correct  = 0;
					}
					
                    $str = "INSERT INTO tb_eventest_answer (question_id, answer_text, answer) VALUES (?,?,?)";
                    $stmt = $conn->prepare($str);
                    $stmt->bind_param("sss",$questionId['question_id'],$choice[$i],$correct);
                    $stmt->execute();
                    $stmt->close();
				}
                $query->close();
				
                $strSQL = "UPDATE tb_eventest SET testtime = testtime + 1 WHERE exam_id = ?";
                $sub_stmt = $conn->prepare($strSQL);
                $sub_stmt->bind_param("s",$_SESSION['createExamId']);
                $sub_stmt->execute();
                $sub_stmt->close();
                unset($question);
                unset($choice);
                unset($select_choice);
		}
	}
	if($_SESSION['createExamId'] || $_POST['examId'] ) //  If have  SESSION['ExamId'] 
	{
		$disable = '';
		$btnCreate = "";
		if($_POST['examId'])
		{
			$_SESSION['createExamId'] =$_POST['examId'];
			$_SESSION['createExam_name'] = $_POST['examName'];
			$name = $_SESSION['createExam_name'];
		}else
		{
			$name = $_SESSION['createExam_name'];
		}
		
        $strSQL = "SELECT * FROM tb_eventest_question_custom WHERE exam_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s",$_SESSION['createExamId']);
        $stmt->execute();
        $result = $stmt->get_result();
        $currentQuiz = $result->fetch_array();
        $num = $result->num_rows;
        $stmt->close();
	}else
	{
		$disable ='disabled';
		$btnCreate ="<input  type='submit' name='addexam' class='bnt-etest setright' value='สร้างชุดข้อสอบ' style='margin-right:50px;'/>";
		$name = '';
        $strSQL = "SELECT * FROM tb_eventest_question_custom WHERE exam_id = ?";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s",$_SESSION['createExamId']);
        $stmt->execute();
        $result = $stmt->get_result();
        $currentQuiz = $result->fetch_array();
        $num = $result->num_rows;
        $stmt->close();
	}
	
		echo "
			<!-- <link href='http://localhost/engtest/bootstrap/css/bootstrap.min.css' rel='stylesheet'> -->
            <link href='http://localhost/engtest/bootstrap/css/create_exam_customize.css' rel='stylesheet'> 
			    <div id='create_custom'>
				    <center><b><h3 style='color:#000000;'>สร้างชุดข้อสอบแบบกำหนดเอง</h3></b><br><center>
				    <div align = 'left' style='padding-left:50px;'>
                        <font color=blue><b><u>ข้อกำหนด</u><b></font><br>
				        <font color='blue' align = 'left'>ห้ามละเมิดลิขสิทธิ์ผู้อื่น มีความผิดตามกฎหมายและบริษัท อิงลิชออนไลน์ จำกัด จะไม่รับผิดชอบการกระทำใดๆทั้งสิ้น<br> และสงวนสิทธิ์ในการตรวจสอบพร้อมทั้งแก้ไขชุดข้อสอบแบบกำหนดเองโดยไม่ต้องแจ้งให้ทราบล่วงหน้า</font>
				        <br><br><center><font color=red>เลือกข้อสอบอย่างน้อย 10 ข้อขึ้นไปและสูงสุดไม่เกิน 30 ข้อ</font><center>
				    </div><br>
				    <table border=0 class='create_custom tbl_create_custom' align=center bgcolor=#F2F2F2>
                        <form method='post' action='eoltest.php?section=business&status=e-test&action=create_customize'>
                            <tr><td style='padding-top:20px;'>ชุดข้อสอบ </td><td style='padding-top:20px;'>
                                <input type='text' name='examname' class='txtdetail' maxlength='100' style='width:645px;margin-left:5px;' value='".$name."' onkeypress='Input_Eng()' onkeyup='copypaste(this.value,this)' />
                                <br><font color='red'>".$message."</font></td></tr>
                            <tr><td></td><td>".$btnCreate."</td></tr> 
                        </form>
                        <tr><td></td><td>
                        <form class='form-horizontal' role='form' method='post' action='eoltest.php?section=business&status=e-test&action=create_customize'>
                            <fieldset ".$disable.">
                            ข้อ ".($num+1)."<br>
                            <div class='form-group'>
                                <div class='col-lg-11' style='margin-left:10px;'>
                                    <textarea id='quiz' name='quiz' class='form-control' placeholder='Quiz' maxlength='1000' rows='5' onkeypress='Input_Eng()' required>".$question."</textarea>
                                </div>
                            </div>
                            <div class='radio'>
                                <label><input type='radio' id='select_choice[]' name='select_choice[]'  value='0' ".($select_choice[0]==0?'checked':'')."></label>
                                <div  class='form-group'>
                                    <div class='col-lg-11'>
                                        <textarea  name='choice[]' class='form-control' placeholder='Answer' maxlength='200' onkeypress='Input_Eng()' onkeyup='copypaste(this.value,this)'>".$choice[0]."</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class='radio'>
                                <label><input type='radio' id='select_choice[]'  name='select_choice[]'  value='1' ".($select_choice[0]==1?'checked':'')."></label>
                                <div  class='form-group'>
                                    <div class='col-lg-11'>
                                        <textarea  name='choice[]' class='form-control' placeholder='Answer' maxlength='200' onkeypress='Input_Eng()' onkeyup='copypaste(this.value,this)'>".$choice[1]."</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class='radio'>
                                <label><input type='radio' id='select_choice[]' name='select_choice[]'  value='2' ".($select_choice[0]==2?'checked':'')."></label>
                                <div  class='form-group'>
                                    <div class='col-lg-11'>
                                        <textarea  name='choice[]' class='form-control' placeholder='Answer' maxlength='200' onkeypress='Input_Eng()' onkeyup='copypaste(this.value,this)'>".$choice[2]."</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class='radio'>
                                <label><input type='radio' id='select_choice[]' name='select_choice[]'  value='3'  ".($select_choice[0]==3?'checked':'')."></label>
                                <div  class='form-group'>
                                    <div class='col-lg-11'>
                                        <textarea  name='choice[]' class='form-control' placeholder='Answer' maxlength='200' onkeypress='Input_Eng()' onkeyup='copypaste(this.value,this)'>".$choice[3]."</textarea>
                                    </div>
                                </div>
                                
                            </div>
                            <div  class='form-group'>
                                    <div class='col-lg-11' style='margin-left:10px;' >
                                        <font color=red style='text-align:left;'>$error</font>
                                        <input type='submit' name='addQuiz' class='btn btn-success' value='บันทึก'  style='float:right;'/>
                                        </center>
                                    </div>
                                </div>
                            </fieldset>
						</form>
						</td></tr> 
						<tr><td colspan='2' align='right'><center>
							
								<a href='eoltest.php?section=business&&status=e-test&action=edit&examId=".$_SESSION['createExamId']."'><button  class='btn btn-warning' ".($_SESSION['createExamId'] == '' ?'disabled':'').">
									แก้ไขข้อสอบ</button></a>
								&nbsp;&nbsp;&nbsp;&nbsp;";

							echo "<a href='eoltest.php?section=business&&status=e-test'><button  class='btn btn-danger'"; 							
                            if (($num+1) < 11 ) {
								echo " disabled";
							} echo ">สิ้นสุดการสร้างชุดข้อสอบ</button></a>
								</center>
							</td>
						  </tr>
					</table>
			<div style='clear:both;'></div></div><div style='clear:both;'></div>";

            mysqli_close($conn);
}

function editExam()
{
    include('../config/connection.php');
	$examId = $conn->real_escape_string(trim($_GET['examId']));
	/* -------update question -------*/
	if(isset($_POST['quizId'])) // ----If add quiz--- //
	{
	    $question = stripslashes(nl2br(check_symbol_special($_POST['quiz'])));
		for($i=0 ;$i<4;$i++)
		{
			if($_POST['select_choice']==='')
			{
				$error = 'Please select correct Answer ';
			}elseif($_POST['choice'][$i] ===''){
				$error = 'Please insert answer ';
			}
				$choice[$i]=$_POST['choice'][$i];
				$select_choice[$i]=$_POST['select_choice'][$i];
		}
		unset($i);
		if($question != '' && !$error)
		{
			$question_text = stripslashes(nl2br(check_symbol_special($_POST['quiz'])));
            $question_id = $conn->real_escape_string(trim($_POST['quizId']));
            
            $strSQL = "UPDATE tb_eventest_question_custom SET question_text = ? WHERE question_id = ?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ss",$question_text,$question_id);
            $stmt->execute();
            $stmt->close();

            $str = "SELECT * FROM  tb_eventest_answer WHERE question_id = ? ";
            $query = $conn->prepare($str);
            $query->bind_param("s",$question_id);
            $query->execute();
            $result_ans = $query->get_result();
            $i = 0;
            while($ans = $result_ans->fetch_assoc())// answer
		    {
                $correct = ($select_choice[0]==$i ? 1 : 0);
			    $ansId = $ans['answer_id'];
                $SQL = "UPDATE tb_eventest_answer SET answer_text = ?, answer = ? WHERE answer_id = ? && question_id = ?";
                $sub_stmt = $conn->prepare($SQL);
                $sub_stmt->bind_param("ssss",$choice[$i],$correct,$ansId,$question_id);
                $sub_stmt->execute();
                $sub_stmt->close();
                $i++;
		    }
            $query->close();
		}
	}/* -------end update question -------*/
	
    $strSQL = "SELECT et.*, COUNT(eq.question_id) AS amount FROM tb_eventest AS et LEFT JOIN tb_eventest_question AS eq ON eq.exam_id = et.exam_id WHERE et.create_by = ?  && et.exam_id = ? GROUP BY et.exam_id ORDER BY et.exam_id DESC";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss",$_SESSION['x_member_id'],$examId);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->num_rows; 
    $listExam = $result->fetch_array();

	if($listExam['exam_type'] == 1 || $rows == 0 || $examId == '' )
	{
		header('Location:eoltest.php?section=business&&status=e-test');
		die();
	}
	else
	{
		if($_GET['quizId']){
			$quizId = $_GET['quizId'];
		}else{
			$quizId = 1;
		}

        $str = "SELECT * FROM tb_eventest_question_custom WHERE exam_id = ?";
        $query = $conn->prepare($str);
        $query->bind_param("s",$examId);
        $query->execute();
        $result = $query->get_result();
        $row = $result->num_rows; 
        $query->close();
    
		if($quizId <= $row )
		{
			$pagination = ceil($quizId/10);
			if($pagination == 1)
			{
				$start = 1;
			}
			else
			{
				$start = (10*($pagination - 1))+1 ;
			}
			if($row < $pagination*10)
			{
				$end = $row;
			}
			else
			{
				$end = $pagination*10;
			}
		}
		else
		{	$quizId = $row;
			$pagination = ceil($quizId/10);
			$start=(10*($pagination - 1))+1;
			$end = $row;
		}
		
        $limit = ($quizId-1).','. 1;
        $SQL = "SELECT * FROM tb_eventest_question_custom WHERE exam_id = ? LIMIT $limit";
        $stmt = $conn->prepare($SQL);
        $stmt->bind_param("s",$examId);
        $stmt->execute();
        $result = $stmt->get_result();
        $quiz = $result->fetch_array();
        $num = $result->num_rows; 

        $str = "SELECT * FROM  tb_eventest_answer WHERE question_id = ? ";
        $query = $conn->prepare($str);
        $query->bind_param("s",$quiz['question_id']);
        $query->execute();
        $result_ans = $query->get_result();
	
		$questionedit = $quiz['question_text'];
		$questionedit = str_replace("<br />","",$questionedit);
		
		echo "
        <!-- <link href='https://www.engtest.net/css/bootstrap.min.css' rel='stylesheet'> -->
        <link href='http://localhost/engtest/bootstrap/css/edit_exam_customize.css' rel='stylesheet'> 
        <link href='http://localhost/engtest/bootstrap/css/pagination.css' rel='stylesheet'> 
            <style type='text/css'> 
            .pagination > li > a {
                font-size: .9rem !important;
                font-weight: 400;
            }
            </style>
			  <div id='create_custom'>
				 <center><b><h3 style='color:#1685DB;'>แก้ไขข้อสอบ</h3></b><br><center>
				 <table border=0 class='create_custom tbl_create_custom' align=center bgcolor=#F2F2F2>
					<form method='post' action='eoltest.php?section=business&status=e-test&action=create_customize'>
                        <tr><td style='padding-top:20px;'>ชุดข้อสอบ </td><td style='padding-top:20px;'><input type='text' name='examname' class='txtdetail' maxlength='100' style='width:645px;margin-left:5px;' value='".$listExam['exam_name']."' disabled/><br><font color='red'>".$message."</font></td></tr>
                        <tr><td></td><td>".$btnCreate."</td></tr> 
					</form>
					<tr><td></td><td>
					<form class='form-horizontal' role='form' method='post' action='eoltest.php?section=business&status=e-test&action=edit&examId=$examId&quizId=".$quizId."'>
					<fieldset ".$disable.">
					    <input type='hidden' name='quizId' value='".$quiz['question_id']."' />
						ข้อ $quizId<br>
						<div class='form-group'>
							<div class='col-lg-11' style='margin-left:10px;'>
								<textarea id='quiz' name='quiz' class='form-control' placeholder='Quiz' maxlength='1000' rows='5' onkeypress='Input_Eng()' onkeyup='copypaste(this.value,this)'>".$questionedit."</textarea>
							</div>
						</div>";
						$i=0;
						while ($answer = $result_ans->fetch_assoc())
						{
							echo "<div class='radio'>
									<label><input type='radio' id='select_choice[]' name='select_choice[]'  value='$i' ".($answer['answer']==1?'checked':'')."></label>
									<div  class='form-group'>
                                        <div class='col-lg-11'>
                                            <textarea  name='choice[]' class='form-control' placeholder='Answer' maxlength='200' onkeypress='Input_Eng()' onkeyup='copypaste(this.value,this)'>".$answer['answer_text']."</textarea>
                                        </div>
									</div>
								</div>";
								$i++;
						}
					echo"
							<div  class='form-group'>
								<div class='col-lg-11' style='margin-left:-50px;'>
									<font color=red style='text-align:left;'>$error</font>
									<input type='submit' name='addQuiz' class='btn btn-success' value='บันทึก'  style='float:right;'/>
								</div>
							</div>
						</fieldset>
						</form>
						</td></tr> 
						
					<table>
						<tr>
                            <td>
                                <div  class='form-group'>
                                    <div class='col-lg-11' style='margin-top:-55px;margin-left:40px;' >
                                        
                                        <a class='back' href='?section=business&&status=e-test&detail=$examId'>กลับสู่หน้าหลัก</a>
                                    </div>
                                </div>
                            </td>
						    <td>
                                <div  class='form-group'>
                                    <div class='col-lg-11' style='margin-top:-55px;margin-left:20px;' >
                                        <form name='edit_addquize' method='post' action='eoltest.php?section=business&status=e-test&action=create_customize&examId=$examId'>
                                            <input type='hidden' name='examId' value='$examId'/>
                                            <input type='hidden' name='examName' value='".$listExam['exam_name']."'/>
                                            <input type='submit' name='addQuiz' class='btn btn-primary' value='เพิ่มข้อสอบ'  style='float:right;margin-left: 20px;'/>
                                        </form>
                                    </div>
                                </div>
						    </td>
                            
					    </tr>
					</table>
					
						<tr><td colspan='2' align='center'>
							<ul class='pagination'>";
			if($start > 1)
			{
				echo '<li><a href="eoltest.php?section=business&&status=e-test&action=edit&examId=',$examId,'&quizId='.($start - 1).'">&laquo;</a></li>';
			}
			for($start; $start<=$end; $start++ )
			{
				echo '<li',($start == $quizId ? ' class="active"':''),'><a href="eoltest.php?section=business&status=e-test&action=edit&examId=',$examId,'&quizId=',$start,'">',$start,'</a></li>';
			}
			if($start <= $row)
			{
				echo '<li><a href="eoltest.php?section=business&&status=e-test&action=edit&examId=',$examId,'&quizId='.($start).'">&raquo;</a></li>';
			}
			echo"
				    </ul></td>
				</tr>
			</table>
			<div style='clear:both;'></div></div><div style='clear:both;'></div>";
	}
    mysqli_close($conn);
}

function listExam()
{
    include('../config/connection.php');
	$examId = $conn->real_escape_string(trim($_GET['examId']));
	
    $strSQL = "SELECT et.*, COUNT(eq.question_id) AS amount FROM tb_eventest AS et LEFT JOIN tb_eventest_question AS eq ON eq.exam_id = et.exam_id WHERE et.create_by = ?  && et.exam_id = ? GROUP BY et.exam_id ORDER BY et.exam_id DESC";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("ss",$_SESSION['x_member_id'],$examId);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->num_rows; 
    $listExam = $result->fetch_array();
    $typeExam = $listExam['exam_type'];
    $stmt->close();

    echo "<a href='eoltest.php?section=business&status=e-test&detail=$examId' 
                style='float: right; margin-top: 10px; margin-right: 15px;' title='กลับสู่หน้าหลัก'>
                <font size=2 color=black><b> [ Back ]</b></font>
          </a>";
	echo '<center><b>',$listExam['exam_name'],'</b></center><br>';
	if($rows > 0)
	{
		
        if ($typeExam == 1) {
            $str = "SELECT * FROM tb_eventest_question WHERE exam_id = ?";
            $query = $conn->prepare($str);
            $query->bind_param("s",$examId);
            $query->execute();
            $result = $query->get_result();
            $row = $result->num_rows; 
            $query->close();
        }else{
            $str = "SELECT * FROM tb_eventest_question_custom WHERE exam_id = ?";
            $query = $conn->prepare($str);
            $query->bind_param("s",$examId);
            $query->execute();
            $result = $query->get_result();
            $row = $result->num_rows; 
            $query->close();
        }
        
        $page = $_GET['page'];
		$pagenum = ceil($row/10);
		if($_GET['page'] <= $pagenum)
		{
			$limit = $_GET['page'];
			if($limit == 1){
				$i = 1;
                $Limit = 'limit 0,10';
            }else{
                $i = (10*($page - 1)) + 1;
                $Limit = 'limit '.(($page-1)*10).','.$page*10;
            }
				
		}
		else
		{
			$limit = 1;
			$i = 1;
		}
        
        if ($typeExam == 1) {
            $sql = "SELECT QUESTIONS_ID AS question_id, QUESTIONS_TEXT AS question_text FROM  tb_questions 
                    INNER JOIN tb_eventest_question ON tb_questions.QUESTIONS_ID = tb_eventest_question.question_id 
                    WHERE  tb_eventest_question.exam_id = ? $Limit";
            $query = $conn->prepare($sql);
            $query->bind_param("s",$examId);
            $query->execute();
            $result_exam = $query->get_result();
            
        }else {
            $sql = "SELECT question_id , question_text FROM  tb_eventest_question_custom
                    WHERE exam_id = ? $Limit";
            $query = $conn->prepare($sql);
            $query->bind_param("s",$examId);
            $query->execute();
            $result_exam = $query->get_result();
        }
	}
		
	while($list = $result_exam->fetch_assoc()) // question
	{
        // $msg_relate = '';
		if ($listExam['exam_type'] == 1) {
			
            $strSQL = "SELECT * FROM tb_questions_mapping  WHERE QUESTIONS_ID = ?";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("s", $list['question_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $is_relate = $result->num_rows;

            if ($is_relate == 1) {
                $relate_data = $result->fetch_array();
                $relate_id = $relate_data['GQUESTION_ID'];
               
                $SQL = "SELECT * FROM tb_questions_relate WHERE GQUESTION_ID = ? ";
                $sub_query = $conn->prepare($SQL);
                $sub_query->bind_param("s", $relate_id);
                $sub_query->execute();
                $result_data = $sub_query->get_result();
                $relate_data = $result_data->fetch_array();
                $relate_type = $relate_data['GQUESTION_TYPE_ID'];
                $relate_text = $relate_data['GQUESTION_TEXT'];
                $sub_query->close();

                if ($relate_type == 1) {
                    $msg_relate = $relate_text;
                }
                if ($relate_type == 3) {
                    if (is_mobile()) {
                        $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $relate_text);
                        $relate_text = str_replace(".flv", ".mp3", $relate_text);
                        $msg_relate = "	<div align=center>
                                            <br>
                                                <audio controls='controls' preload='none'> 
                                                    <source src='https://www.engtest.net/files/sound/" . $relate_text . "'>  
                                                </audio>
                                            <br>;
                                        </div> ";
                    }
                    else {
                        $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $relate_text);
                        $relate_text = str_replace(".flv", ".mp3", $relate_text);
                        $msg_relate = '<audio id="audio" controls="controls" > <source src="http://www.engtest.net/files/sound/' . $relate_text . '"></audio>';
                    }
                }
                if ($relate_type == 2) {
                    $msg_relate = str_replace("/home/engtest/domains/engtest.net/public_html/", "", "../" . $relate_text);
                    $msg_relate = "<div align=center><img src='$msg_relate' border=0 width=300></div>";
                }
                echo $msg_relate;

            }
            $stmt->close();
            
		}
        
		echo '<div style="margin-left:50px;"><b>',$i,'.&nbsp;</b> ',$list['question_text'],'<br>';
		
        if($typeExam == 1)
		{
			$str = "SELECT ANSWERS_TEXT AS answer_text, ANSWERS_CORRECT AS answer FROM  tb_answers WHERE QUESTIONS_ID = ? ";
            $sub_stmt = $conn->prepare($str);
            $sub_stmt->bind_param("s",$list['question_id']);
            $sub_stmt->execute();
            $result_ans = $sub_stmt->get_result();
		}
        else{
			$str = "SELECT * FROM  tb_eventest_answer WHERE question_id = ?";
            $sub_stmt = $conn->prepare($str);
            $sub_stmt->bind_param("s",$list['question_id']);
            $sub_stmt->execute();
            $result_ans = $sub_stmt->get_result();
		}
        
		while($ans = $result_ans->fetch_assoc())// answer
		{
			echo '<input type="radio"  name="',$i,'"' ,($ans['answer'] == 1 ? 'checked' : ''),' disabled="disabled"><font style="padding-left:5px;">',$ans['answer_text'],'</font><br>';
		}
		echo '</div><br>';
		$i++;
		if($i == 11){break;}
		if($i == 21){break;}
		if($i == 31){break;}
		if($i == 41){break;}
        if($i == 51){break;}
        if($i == 61){break;}
        if($i == 71){break;}
	}
   
	// echo "<link href='https://www.engtest.net/css/bootstrap.min.css' rel='stylesheet'>";
    echo "<link href='http://localhost/engtest/bootstrap/css/pagination.css' rel='stylesheet'>
	  <center><ul class='pagination'>";
			
	for($page=0 ; $page < $pagenum;$page++) // pagination
	{
		echo '<li ',($page+1 == $limit ? 'class="active"' : 'none'),'><a href="?section=business&&status=e-test&action=view&examId=',$examId,'&page=',$page+1,'">',$page+1,'</a></li>';
	}
	echo '</ul></center>';
    $query->close();
    $sub_stmt->close();
    mysqli_close($conn);
    
    
}

function get_answer($question_id,$typeExam){
    include('../config/connection.php');
    if ($typeExam == 1) {
        $str = "SELECT ANSWERS_TEXT AS answer_text, ANSWERS_CORRECT AS answer FROM  tb_answers WHERE QUESTIONS_ID = ? ";
        $sub_stmt = $conn->prepare($str);
        $sub_stmt->bind_param("s",$question_id);
        $sub_stmt->execute();
        $result = $sub_stmt->get_result();
    }else{
        $str = "SELECT * FROM  tb_eventest_answer WHERE question_id = ?";
        $sub_stmt = $conn->prepare($str);
        $sub_stmt->bind_param("s",$question_id);
        $sub_stmt->execute();
        $result = $sub_stmt->get_result();
    }
    return $result;
}

function create_exam_system(){
    include('../config/connection.php');
	if(isset($_POST['add'])){
	    $num=count($_POST['skill_id']); 
		$message='';
		$amountQt=0;
		// check exam num
		for($i=0;$i<$num;$i++)
		{
			$amountQt=$amountQt+$_POST['num'][$i];
			if($_POST['num'][$i]==''){
				$message ='โปรดใ่ส่จำนวนข้อ';
			}
		}
		// check amount question
		if($amountQt > 30)
		{
			$message = 'จำนวนข้อรวมไม่เกิน 30 ข้อ';
		}
		else if ($amountQt < 10)
			$message = 'จำนวนข้อทั้งหมดไม่น้อยกว่า 10 ข้อ';
		

		// check exam name and time
		if($_POST['examname']=='' && $_POST['time']=='')
		{ 
			$message = 'โปรดกรอกข้อมูลให้ครบถ้วน';
		}
		
		if($_POST['examname']=='')
		{ 
			$message = 'โปรดกรอกชื่อชุดข้อสอบ';
		}
		
		if($_POST['time']=='')
		{ 
			$message = 'โปรดกรอกเวลาสอบ ให้ครบถ้วน';
		}
		
		
		if(!$message)
		{
            $date = date('Y-m-d H:i:s');
            $exam_name = $conn->real_escape_string(trim($_POST['examname']));
            $testtime = $conn->real_escape_string(trim($_POST['time']));
            $test_type = 1;
            $exam_type = 1;
            $strSQL = "INSERT INTO tb_eventest (exam_name, testtime, test_type, exam_type, create_by, create_date) VALUES (?,?,?,?,?,?)";
            $stmt = $conn->prepare($strSQL);
            $stmt->bind_param("ssiiss",$exam_name,$testtime,$test_type,$exam_type,$_SESSION['x_member_id'],$date);
            $stmt->execute();
            $stmt->close();

            $SQL = "SELECT * FROM tb_eventest WHERE create_by = ? ORDER BY exam_id DESC LIMIT 0,1";
            $query = $conn->prepare($SQL);
            $query->bind_param("s",$_SESSION['x_member_id']);
            $query->execute();
            $result = $query->get_result();
            $examId = $result->fetch_array();
            
			/*------- loop for add  question--------*/
			for($n=0;$n<$num;$n++)
			{
				
                $test_id = 1;
                $active = 1;
                $skill_id = $conn->real_escape_string(trim($_POST['skill_id'][$n]));
                $level = $conn->real_escape_string(trim($_POST['level'][$n]));
                $topic = $conn->real_escape_string(trim($_POST['topic'][$n]));
                $sql = "SELECT * FROM tb_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && DETAIL_ID = ? && IS_ACTIVE = ?";
                $sub_query = $conn->prepare($sql);
                $sub_query->bind_param("isssi",$test_id,$skill_id,$level,$topic,$active);
                $sub_query->execute();
                $result = $sub_query->get_result();
                $numrow = $result->num_rows;
                $sub_query->close();
                
				$numinsert=0;
				/*-------check question more  amount question */
				if($_POST['num'][$n] <= $numrow &&  $numrow >=1)
				{
					$amount = $_POST['num'][$n]+1;
                    $quiz_num = getRandomQuestion($amount,$numrow);

					for($i=0;$i<$_POST['num'][$n];$i++)
					{
						
                        $str =  "SELECT * FROM tb_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && DETAIL_ID = ? && IS_ACTIVE = ? LIMIT $quiz_num[$i],1";  
                        $sub_stmt = $conn->prepare($str);
                        $sub_stmt->bind_param("isssi",$test_id,$skill_id,$level,$topic,$active);
                        $sub_stmt->execute();
                        $result = $sub_stmt->get_result();
                        $data = $result->fetch_array();
                        $is_have = $result->num_rows;                    
						if($is_have==1)
						{
							
                            $exam_id = $examId['exam_id'];
                            $question_id = $data['QUESTIONS_ID'];
                            $strSQL = "INSERT INTO tb_eventest_question (exam_id, question_id) VALUES (?,?)";
                            $stmt = $conn->prepare($strSQL);
                            $stmt->bind_param("ss",$exam_id,$question_id);
                            $stmt->execute();
                            $stmt->close();
						}
                        $sub_stmt->close();
					}
				}//จำนวน input ข้อสอบมากกว่า ข้อสอบในตาราง
				else
				{
				    if(($_POST['level'][$n] +1) <=5){
				      $upperlevel  = $_POST['level'][$n] +1; 
					}
					if(($_POST['level'][$n] -1) >=1)
					{
					  $lowerlevel = $_POST['level'][$n] -1; 
					}
					for($i=0;$i<$numrow;$i++)
					{
						
                        $str =  "SELECT * FROM tb_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && DETAIL_ID = ? && IS_ACTIVE = ? LIMIT $i,1";  
                        $sub_stmt = $conn->prepare($str);
                        $sub_stmt->bind_param("isssi",$test_id,$skill_id,$level,$topic,$active);
                        $sub_stmt->execute();
                        $result = $sub_stmt->get_result();
                        $data = $result->fetch_array();
                        $is_have = $result->num_rows;  
						if($is_have==1)
						{
                            $exam_id = $examId['exam_id'];
                            $question_id = $data['QUESTIONS_ID'];
                            $strSQL = "INSERT INTO tb_eventest_question (exam_id, question_id) VALUES (?,?)";
                            $stmt = $conn->prepare($strSQL);
                            $stmt->bind_param("ss",$exam_id,$question_id);
                            $stmt->execute();
                            $stmt->close();
						}
						$numinsert++;
                        $sub_stmt->close();
					}// เลือกข้อสอบ ในlevel ที่สูงกว่า เมื่อ input จำนวนข้อสอบที่รับมา มีมากกกว่า
					if($numinsert<=$_POST['num'][$n] && $upperlevel <= 5)
					{
						
                        $sql = "SELECT * FROM tb_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && DETAIL_ID = ? && IS_ACTIVE = ?";
                        $sub_query = $conn->prepare($sql);
                        $sub_query->bind_param("isssi",$test_id,$skill_id,$upperlevel,$topic,$active);
                        $sub_query->execute();
                        $result = $sub_query->get_result();
                        $numrow = $result->num_rows;
                        $sub_query->close();
						$amount = $_POST['num'][$n]-$numinsert;
                        
                        $quiz_num = getRandomQuestion($amount,$numrow);
					    for($i=0;$i<$amount;$i++)
					    {
							
                            $str =  "SELECT * FROM tb_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && DETAIL_ID = ? && IS_ACTIVE = ? LIMIT $i,1";  
                            $sub_stmt = $conn->prepare($str);
                            $sub_stmt->bind_param("isssi",$test_id,$skill_id,$upperlevel,$topic,$active);
                            $sub_stmt->execute();
                            $result = $sub_stmt->get_result();
                            $data = $result->fetch_array();
                            $is_have = $result->num_rows;      
							if($is_have==1)
							{
								
                                $exam_id = $examId['exam_id'];
                                $question_id = $data['QUESTIONS_ID'];
                                $strSQL = "INSERT INTO tb_eventest_question (exam_id, question_id) VALUES (?,?)";
                                $stmt = $conn->prepare($strSQL);
                                $stmt->bind_param("ss",$exam_id,$question_id);
                                $stmt->execute();
                                $stmt->close();
							}
							$numinsert++;
                            $sub_stmt->close();
					   }
					}// เลือกข้อสอบ ในlevel ที่ตำกว่า เมื่อจำนวนใน level ที่สูงกว่าไ่ม่พอ
					if($lowerlevel<=$_POST['num'][$n] && $upperlevel >= 1)
					{
						
                        $sql = "SELECT * FROM tb_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && DETAIL_ID = ? && IS_ACTIVE = ?";
                        $sub_query = $conn->prepare($sql);
                        $sub_query->bind_param("isssi",$test_id,$skill_id,$upperlevel,$topic,$active);
                        $sub_query->execute();
                        $result = $sub_query->get_result();
                        $numrow = $result->num_rows;
                        $sub_query->close();
                        
						$amount = $_POST['num'][$n]-$numinsert;

                        $quiz_num = getRandomQuestion($amount,$numrow);
					    for($i=0;$i<$amount ;$i++)
					    {
							
                            $str =  "SELECT * FROM tb_questions WHERE TEST_ID = ? && SKILL_ID = ? && LEVEL_ID = ? && DETAIL_ID = ? && IS_ACTIVE = ? LIMIT $i,1";  
                            $sub_stmt = $conn->prepare($str);
                            $sub_stmt->bind_param("isssi",$test_id,$skill_id,$upperlevel,$topic,$active);
                            $sub_stmt->execute();
                            $result = $sub_stmt->get_result();
                            $data = $result->fetch_array();
                            $is_have = $result->num_rows;   
							if($is_have==1)
							{
                                $exam_id = $examId['exam_id'];
                                $question_id = $data['QUESTIONS_ID'];
                                $strSQL = "INSERT INTO tb_eventest_question (exam_id, question_id) VALUES (?,?)";
                                $stmt = $conn->prepare($strSQL);
                                $stmt->bind_param("ss",$exam_id,$question_id);
                                $stmt->execute();
                                $stmt->close();
							}
							$numinsert++;
                            $sub_stmt->close();
					   }
					}
				}
			}
			header('Location:?section=business&&status=e-test');
            mysqli_close($conn);
		}
		else
		{
			formCreateExam($message);
		}
	}
	else
	{  
		formCreateExam();
	}
    
}


function getRandomQuestion($amount,$numrow){
    for($i=1;$i<=60;$i++)
    {
        $quiz_num[] = rand(0,$numrow-1);
        $quiz_num = array_unique($quiz_num);	
        $count = count($quiz_num);
        if($count==$amount){	break;	}
        
    }
    sort($quiz_num);
    return $quiz_num;
}



function formCreateExam($message='')
{
    include('../config/connection.php');
	/* session for id input */
	$_SESSION["listId"] = 1;
	/*-----------------------*/
	echo "
        <div id='creat_exam'>
            <a href='eoltest.php?section=business&status=e-test' 
                style='float: right; margin-top: 5px;' title='กลับสู่หน้าหลัก'>
                <font size=2 color=black><b> [ Back ]</b></font>
            </a>
		    <center><b><font size=3>สร้างชุดข้อสอบจากระบบ</font></b><br><br>
			<font color=red>เลือกข้อสอบอย่างน้อย 10 ขึ้นไปและสูงสุดไม่เกิน 30 ข้อ</font><br>
            </center>
			<center>
			    <div id='creat_exam_div'> 
			        <button id='newexam' class='btnadd_exam' title='เพิ่มจำนวนข้อ' onclick='javascript:addNewExam();' style='margin-top:125px;margin-right:15px;'></button>
                    <form id='newexamform' method='post' action='?section=business&status=e-test&action=create'>
			            <table id='tbcreate' border=0 class='detailform tbcreate_exam' align=center bgcolor=#F2F2F2>
				            <tr><td>ชื่อชุดข้อสอบ </td><td><input type='text' name='examname' value='$_POST[examname]' class='txtdetail' style='width:350px;' required></td></tr>
				            <tr><td>เวลาสอบ   </td><td><input type='text' name='time' value='$_POST[time]' class='txtdetail'  style='width:50px;' maxlength='3' onkeypress='checknum()' required> นาที</td></tr>";
	// check value skill //
	if(isset($_POST['skill_id'])){
		$num = count($_POST['skill_id']);
	}
	else{
		$num = 1;
	}
	
	for($n=0;$n<$num;$n++)
	{
	    $select_skill[$_POST['skill_id'][$n]] = 'selected';
		$select_level[$_POST['level'][$n]] = 'selected';
		echo "<tr><td>Skill</td><td>Level<font style='margin-left:125px;'>Topic</font></td></tr>
				<tr>
                    <td>
                        <select id='skill_id1' name='skill_id[]' style='float:left;'class='selector' data-select='1' onchange='changelistExam(this)'>
                            <option value=1  $select_skill[1]> Reading Comprehension</option>
                            <option value=2  $select_skill[2]> Listening Comprehension</option>
                            <option value=3  $select_skill[3]> Semi - Speaking</option>
                            <option value=4  $select_skill[4]> Semi - Writing</option>
                            <option value=7  $select_skill[7]> Vocabulary </option>
                            <option value=5  $select_skill[5]> Grammar </option>
                        </select>
                    </td>
                    <td>
                        <select id='level1' name='level[]' style='float:left;' class='selector' onchange='changelistExam(this)' data-select='1'>
                            <option value=1 $select_level[1]>Beginner</option>
                            <option value=2 $select_level[2]>Lower Intermediate</option>
                            <option value=3 $select_level[3]>Intermediate</option>
                            <option value=4 $select_level[4]>Upper Intermediate</option>
                            <option value=5 $select_level[5]>Advanced </option>
                        </select>
			            <select id='topic1' name='topic[]' style='width:300px;margin-left:5px; margin-right:5px;' class='selector'> ";
        $level = 1;
	    $skill = 1;
		$topic_id =0;
		if(isset($_POST['level']) && isset($_POST['skill_id']))
		{
			$level = $_POST['level'][$n];
			$skill = $_POST['skill_id'][$n];
			$topic_id = $_POST['topic'][$n];
		}

        $strSQL = "SELECT DETAIL_ID,DETAIL_NAME,DETAIL_CODE,SSKILL_ID FROM tb_item_detail WHERE SKILL_ID = ? group by DETAIL_NAME order by DETAIL_ID";
        $stmt = $conn->prepare($strSQL);
        $stmt->bind_param("s",$skill);
        $stmt->execute();
        $resulte_detail = $stmt->get_result();
        
		// print list topic exam
		while($detail = $resulte_detail->fetch_assoc())
		{
			
            $sskil_id = $detail['SSKILL_ID'];
            $detail_id = $detail['DETAIL_ID'];
            $test_id = 1;
            $SQL = "SELECT QUESTIONS_ID FROM tb_questions WHERE TEST_ID = ? && LEVEL_ID = ? && SKILL_ID = ? && SSKILL_ID = ? && DETAIL_ID = ?";
            $query = $conn->prepare($SQL);
            $query->bind_param("issss",$test_id,$level,$skill,$sskil_id,$detail_id);
            $query->execute();
            $result = $query->get_result();
            $amout = $result->num_rows;
            $query->close();
            echo "amout = ".$amout;
			if($amout > 0)
			{
			   // set slected //
				if($topic_id == $detail['DETAIL_ID'])
				{
					$select_topic = 'selected';
				}else{
					$select_topic = '';
				}
				echo ' <option value="',$detail['DETAIL_ID'],'" title="',$detail['DETAIL_NAME'],' " ',$select_topic,'>' ,substr($detail['DETAIL_NAME'],0,48),' [',$amout ,'] </option>';
			}
		}
        $stmt->close();
		    $btn='';
		if($n>=1)
		{
			$btn = '<button class="btnremove_exam" onclick="javascript:Removetr(this);"></button>';
		}
		echo "</select>จำนวน <input type='text' name=num[] value='".$_POST['num'][$n]."' class='txtdetail' style='width:50px;' maxlength='2' onkeypress='checknum()' required/> &nbsp;ข้อ".$btn."</td></tr>";
	}
		echo "
			</table>
			<input type='submit' name='add' id='add' class='bnt-etest setright' style='margin:15px 15px;' value='สร้างชุดข้อสอบ' >
		</form>
		<font color=red>$message</font><img id='imgloading' src='http://localhost/engtest/images/image2/eol system/loading2.gif' style='display:none'/>
		<div id='errordiv' ></div>
		<div style='clear:both;'></div>
	</div>
    </div>
	<div style='clear:both;'></div>";
    mysqli_close($conn);
}

function check_symbol_special($string){
    $result = $string;
    return $result;
}
// if($_POST['addexam'] || $_GET['action'] == 'edit'){
?>
<!-- <script>
window.onload = function() {
    $('#quiz').autosize();
    $('#quiz').autosize({
        append: '\n'
    });
}
</script> -->
<!-- <?php
// }
?> -->