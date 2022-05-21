﻿<?php
include('../inc/header.php');
include('../inc/footer.php');
include('../inc/info_user.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">

        <?= callheader(); ?>


        <div class="row kanit">
            <div class="col-xs-12" style="padding:0px 0px;">
                <div id="apDiv68"
                    style="border-top:1px solid #d27f19;border-bottom:4px solid #f7941d;background:#f3f3f3;">
                    <center>
                        <a href="http://localhost/engtest/exam_list/admission.php" class="over_a">
                            <img src="https://www.engtest.net/image2/stdtest/over-admission1.jpg" width="15%">
                        </a>
                        <a href="http://localhost/engtest/exam_list/cu-tep.php" class="over_a">
                            <img src="https://www.engtest.net/image2/stdtest/cu-tep1.jpg" width="15%">
                        </a>
                        <a href="http://localhost/engtest/exam_list/cefr.php" class="over_a">
                            <img src="https://www.engtest.net/UserFiles/stdtest/cefr1.jpg" width="10%">
                        </a>
                        <a href="http://localhost/engtest/exam_list/toefl.php" class="over_a">
                            <img src="https://www.engtest.net/image2/stdtest/toefl1.jpg" width="15%">
                        </a>
                        <a href="http://localhost/engtest/exam_list/toeic.php" class="over_a">
                            <img src="https://www.engtest.net/image2/stdtest/toeic1.jpg" width="15%">
                        </a>
                        <a href="http://localhost/engtest/exam_list/ielts.php" class="over_a">
                            <img src="https://www.engtest.net/image2/stdtest/ielts1.jpg" width="15%">
                        </a>
                    </center>
                </div>
                <br>
                <center>
                    <div id="apDiv69" class="kanit" style="padding-top:20px;">
                        <h2><strong>ADMISSION</strong><br>
                            <span style="font-size:24px;color:#707070;">ระบบแอดมิดชั่น</span>
                        </h2>
                        <hr style="width:100px;border:2px solid #f7941d" />
                    </div>
                </center>
                <div style="padding:0px 150px;border:0px solid blue;" class="taviraj">
                    <img src="https://www.engtest.net/image2/stdtest/admission.jpg" width="100%">
                    <BR><BR><BR>
                    <font color="orange">Admission</font> หรือชื่อเต็มๆ ว่า Central University Admissions System ก็คือ
                    ระบบกลาง สำหรับจัดการคัดเลือกบุคคล เพื่อเข้าศึกษาต่อในอุดมศึกษา ที่เด็กมัธยมชั้นปีที่ 6
                    แทบทุกคนจะได้พบเจอ ซื่งระบบ Admission มีองค์ประกอบคะแนนดังนี้ <br>

                    1. GPAX 20% (ใช้ 6 ภาคการศึกษา) <br>
                    2. O-NET 30% <br>
                    3. GAT/PAT 50% สัดส่วนแล้วแต่คณะและสาขาวิชา <br>

                    ผู้ที่ต้องการเข้าศึกษาต่อในระดับมหาวิทยาลัยจะต้องทำการสอบ เพื่อให้ได้คะแนนทุกส่วน จากนั้น
                    จึงนำคะแนนทั้งหมดมารวม และยื่นเลือกคณะกันอีกที โดย GPAX และ O-NET นั้นทุกคณะจะ
                    ใช้ในอัตราส่วนเดียวกันคือ GPAX 20% และ O-NET 30% ส่วนอีก 50% จะคิดจาก GAT และ PAT
                    ซึ่งตรงนี้จะแตกต่างกันไปในแต่ละคณะ <br>

                    การสอบ O-NET, GAT และ PAT จะถูกจัดโดย สถาบันทดสอบทางการศึกษาแห่งชาติ หรือ สทศ. <br>
                    <BR>
                    1. <font color="orange">GPAX</font> <br>
                    ในการยื่นคะแนน Admission 20%ของคะแนนทั้งหมดนั้นจะคิดมาจาก GPAX ซึ่ง GPAX นั้นก็คือ เกรดเฉลี่ยสะสม 6
                    ภาค การศึกษา หรือก็เกรดเฉลี่ยสะสมของชั้นมัธยมปลาย (มัธยม 4, 5, 6 นั่นเอง) <br>
                    <BR>
                    2. <font color="orange">O-NET</font> <br>
                    Ordinary National Education Test หรือที่เราเรียกกันติดปากว่า O-NET
                    เป็นการทดสอบทางการศึกษาแห่งชาติขั้นพื้นฐาน
                    ซึ่งเป็นการวัดผลการศึกษาขั้นพื้นฐาน โดย O-NET จะทดสอบใน 5 กลุ่ม สาระการเรียนรู้ซึ่งได้แก่ <br>
                    1. สังคมศึกษา ศาสนาและวัฒนธรรม <br>
                    2. ภาษาไทย <br>
                    3. คณิตศาสตร์ <br>
                    4. อังกฤษ <br>
                    5. วิทยาศาตร์ <br>
                    <font color="red">อัพเดต : O-NET ปรับลดข้อสอบเหลือแค่ 5 กลุ่มสาระการเรียนรู้ เริ่มปีการศึกษา 2558
                        <br>
                    </font>
                    <BR>
                    3. <font color="orange">GAT</font> <br>
                    GAT ย่อมาจาก General Aptitude Test หมายถึง ความถนัดทั่วไป ดังนั้น GAT คือการทดสอบความถนัดทั่วไป
                    เพื่อเป็นการวัดความรู้หรือศักยภาพการเรียนในมหาวิทยาลัยให้ประสบความสำเร็จ แบ่งเป็น 2 ส่วน <br>
                    1.ความรู้ความสามารถในการอ่าน เขียน วิเคราะห์ แก้ปัญหา <br>
                    2.ความรู้ความสามารถในการใช้ภาษาอังกฤษ
                    คะแนนของ GAT นั้นคิดเป็นสัดส่วน 10 - 50% ของคะแนะนรวมในระบบ Admission<br>
                    <BR>
                    4. <font color="orange">PAT</font><br>
                    PAT ย่อมาจาก Professional and Academic Aptitude Test หมายถึง
                    ความรู้และความถนัดทางด้านวิชาการและวิชาชีพ มีทั้งหมด 7 ประเภท<br>
                    PAT1 ความถนัดทางคณิตศาสตร์<br>
                    PAT2 ความถนัดทางวิทยาศาสตร์<br>
                    PAT3 ความถนัดทางวิศวกรรมศาสตร์<br>
                    PAT4 ความถนัดทางสถาปัตกรรมศาสตร์<br>
                    PAT5 ความถนัดทางวิชาชีพครู<br>
                    PAT6 ความถนัดทางศิลปกรรมศาสตร์<br>
                    PAT7 ความถนัดทางภาษาต่างประเทศ<br>
                    PAT 7.1 ความถนัดทางภาษาฝรั่งเศส<br>
                    PAT 7.2 ความถนัดทางภาษาเยอรมัน<br>
                    PAT 7.3 ความถนัดทางภาษาญี่ปุ่น<br>
                    PAT 7.4 ความถนัดทางภาษาจีน<br>
                    PAT 7.5 ความถนัดทางภาษาอาหรับ<br>
                    PAT 7.6 ความถนัดทางภาษาบาลี<br>

                    คะแนนในส่วน PAT นี้จะคิดเป็น 0 - 40% ของคะแนน Admission ทั้งหมด <br>

                    ตัวอย่างสัดส่วนคะแนนที่ใช้การ Admission ของบางกลุ่มสาขาวิชา <br>
                    • คณะทันตแพทยศาสตร์ <br>
                    GPAX 20% , O-NET 30% , GAT 20% PAT 1 10% และ PAT 2 20% <br>

                    • คณะวิศกรรมศาสตร์ <br>
                    GPAX 20%, O-NET 30%, GAT 15%, PAT 2 15%, PAT 3 20% <br>

                    • คณะนิเทศศาสตร์, คณะอักษรศาสตร์, คณะศิลปศาสตร์, คณะมนุษยศาสตร์, คณะรัฐศาสตร์, คณะนิติศาสตร์,
                    คณะสังคมวิทยา, คณะสังคมสงเคราะห์ศาสตร์ <br>
                    รูปแบบที่ 1 GPAX 20% , O-NET 30% , GAT 30% และ PAT 1 20% <br>
                    รูปแบบที่ 2 GPAX 20% , O-NET 30% และ GAT 50% <br>
                    รูปแบบที่ 3 GPAX 20% , O-NET 30% , GAT 30% และ PAT 7 20% <br>
                    <hr>
                </div>
            </div>
            <br>
        </div>
    </div>

    <?php footer(); ?>