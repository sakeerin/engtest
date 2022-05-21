﻿<?php
include('../inc/header.php');

include('../inc/footer.php');
include('../inc/info_user.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    .text_paragraph {
        font-size: 16px;
    }

    #sub_menu a.active {
        color: orange;
    }

    #sub_menu a {
        color: #00000;
        text-decoration: none;
    }

    #sub_menu a:hover {
        color: orangered;
    }
    </style>
</head>

<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">

        <?= callheader(); ?>

        <div class="row kanit">
            <div class="col-xs-12" style="padding:0px;margin:0px;">
                <div id="apDiv68" style="border-top:1px solid #d27f19;border-bottom:4px solid #f7941d">
                    <center>
                        <div id="apdiv3menubar" style="background:#f3f3f3;">
                            <a href="http://localhost/engtest/info/about_eol.php">
                                <img src="https://www.engtest.net/image2/about web/about-eol.jpg"></a>
                            <a href="http://localhost/engtest/info/whatiseol.php">
                                <img src="https://www.engtest.net/image2/eol system/eol-system.jpg"></a>
                            <a href="#">
                                <img src="https://www.engtest.net/image2/about web/over-security.jpg"></a>
                            <a href="http://localhost/engtest/info/eol.php">
                                <img src="https://www.engtest.net/image2/about web/about-more.jpg"></a>
                        </div>
                    </center>
                </div>
                <div id="sub_menu"
                    style="border-bottom:1px solid #f7941d;padding:10px;text-align:center;background:#f3f3f3;">
                    <a href="http://localhost/engtest/info/safe.php" class="active" style="padding-right:30px;"> •
                        ความปลอดภัยของเว็ปไซต์</a>
                    <a href="http://localhost/engtest/info/privacy.php" style="padding-right:30px;">•
                        นโยบายความเป็นส่วนตัว (Privacy Policy)</a>
                    <a href="http://localhost/engtest/info/stop.php">• การแก้ปัญหาในการร้องเรียน</a>

                </div>
                <div style="padding:0px 150px;border:0px solid blue;" class="taviraj">
                    <center>
                        <div id="apDiv69" class="kanit" style="padding-top:20px;">
                            <h2><strong>ความปลอดภัยของเว็บไซต์</strong><br>
                                <span style="font-size:24px;color:#707070;">www.EngTest.net</span>
                            </h2>
                            <hr style="width:100px;border:2px solid #f7941d" />
                            <img src="https://www.engtest.net/image2/about web/about2-1.jpg" width="100%">
                        </div>
                    </center>
                    <BR><BR>
                    <div class="text_paragraph">
                        ทางเราได้เล็งเห็นถึงความสำคัญของความมั่นคงปลอดภัย (Security)
                        ของลูกค้าที่เข้ามาทำธุรกรรมซื้อสินค้ากับเรา<br>ดังนั้นเราจึงได้กำหนดแนวปฏิบัติสำหรับความมั่นคงปลอดภัยของเว็บไซต์
                        ที่ได้ดำเนินการในปัจจุบัน ดังต่อไปนี้ <br><br>
                        </center>
                        &emsp;1. เว็บไซต์ของเราได้คำนึงถึงการดำเนินงานด้านคอมพิวเตอร์ฮาร์ดแวร์ ซอฟต์แวร์
                        และสัญญาว่าจ้างบริษัทภายนอก<BR>
                        &emsp;&emsp;(Outsourcing Contract) ที่สอดคล้องกับข้อกำหนดตามกฎหมาย <br>
                        &emsp;2.
                        เราได้กำหนดสิทธิของการเข้าถึงข้อมูลบนระบบงานของเว็บไซต์ให้กับพนักงานของบริษัทอย่างชัดเจน <br>
                        &emsp;3. เราได้ทำการสแกนไวรัสในระบบคอมพิวเตอร์และอุปกรณ์ที่ใช้จัดเก็บข้อมูลอย่างสม่ำเสมอ <br>
                        &emsp;4. เราได้ทำการสำรองข้อมูลและซอฟต์แวร์ที่สำคัญอย่างสม่ำเสมอ <br>
                        &emsp;5. เราได้ใช้ระบบ Firewall เพื่อความมั่นคงปลอดภัยทางเครือข่าย โดยใช้ IP table และ Config
                        Server Firewall &amp; Security <br>
                        &emsp;6. ในกรณีที่ท่านมีข้อสงสัยเกี่ยวกับการรักษาความมั่นคงปลอดภัยของเว็บไซต์เรา<BR>
                        &emsp;&emsp;ท่านสามารถติดต่อที่ engtest_eol@hotmail.com หรือ โทร. 02-1708725-6


                    </div>
                    <BR><BR>


                </div>
            </div>

        </div>
    </div>
    <?php footer(); ?>