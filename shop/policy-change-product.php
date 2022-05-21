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
        font-size: 18px;
        text-decoration: none;
    }

    #sub_menu a:hover {
        color: orangered;
    }

    .title_font_color {
        color: #fb921d;
    }
    </style>
</head>

<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">

        <?= callheader(); ?>

        <div class="row kanit">
            <div class="col-xs-12" style="padding:0px;margin:0px;">
                <div id="sub_menu"
                    style="border-top:1px solid #f7941d;padding:10px;text-align:center;background:#f3f3f3;">
                    <a href="http://localhost/engtest/shop/product_personal.php" style="padding-right:30px;"> •
                        สินค้า</a>
                    <!-- <a href="https://www.engtest.net/shop/cart.php" style="padding-right:30px;">• ตะกร้าสินค้า</a> -->
                    <a href="http://localhost/engtest/shop/payment.php" style="padding-right:30px;">•
                        วิธีการสั่งซื้อ</a>
                    <a href="http://localhost/engtest/shop/policy-change-product.php" class="active">•
                        นโยบายการเปลี่ยนสินค้า</a>
                </div>
                <div id="apDiv68" style="border-top:1px solid #d27f19;border-bottom:4px solid #f7941d">
                    <center>
                        <div id="apdiv3menubar" style="background:#f3f3f3;">
                            <a href="#">
                                <img src="https://www.engtest.net/img/shop/tab-menu-policy/over-policy-change.jpg"></a>
                            <a href="http://localhost/engtest/shop/warranty.php">
                                <img src="https://www.engtest.net/img/shop/tab-menu-policy/warranty.jpg"></a>
                        </div>
                    </center>
                </div>

                <div style="padding:0px 150px;border:0px solid blue;" class="taviraj">
                    <center>
                        <div id="apDiv69" class="kanit" style="padding-top:20px;">
                            <h2><strong>นโยบายการเปลี่ยนสินค้า</strong><br>
                                <span style="font-size:24px;color:#707070;">การยกเลิกการสั่งซื้อ</span>
                            </h2>
                            <hr style="width:100px;border:2px solid #f7941d" />
                            <img src="https://www.engtest.net/img/shop/policy-change-product.jpg" width="100%">
                        </div>
                    </center>
                    <BR><BR>
                    <div class="text_paragraph">
                        </center>
                        <span style='color:#f7941d'>เงื่อนไขการยกเลิกคำสั่งซื้อ</span><BR>
                        1. ท่านสามารถยกเลิกธุรกรรมการสั่งซื้อได้ ในกรณีที่สินค้ายังไม่ถูกส่งออกไปเท่านั้น<BR>
                        2. บริษัทฯ จะคืนเงินค่าสินค้าหลังจากหักค่าดำเนินการแล้ว
                        โดยโอนเงินเข้าบัญชีที่มีชื่อผู้สั่งซื้อสินค้า เป็นเจ้าของบัญชีเท่านั้น<BR><BR>

                        <span style='color:#f7941d'>การแจ้งยกเลิกคำสั่งซื้อ</span><BR>
                        หากท่านต้องการยกเลิกคำสั่งซื้อ โปรดติดต่อเจ้าหน้าที่ทาง Call Center : 02-170-8725-6<BR>
                        หรือ E-mail : engtest_eol@hotmail.com<BR><BR>

                        <center>
                            <div id="apDiv69" class="kanit" style="padding-top:20px;">
                                <h2><span style="font-size:24px;color:#707070;">การคืนสินค้า</span></h2>
                                <hr style="width:100px;border:2px solid #f7941d" />
                            </div>
                        </center>
                        <span style='color:#f7941d'>นโยบายการคืนสินค้า</span><BR>
                        เพื่อเป็นการสร้างความพึงพอใจสูงสุดให้กับท่าน
                        เมื่อท่านได้รับสินค้าแล้วกรุณาตรวจสอบความเรียบร้อยของสินค้า หากพบว่ามีความ
                        ผิดพลาดที่เกิดจากทางบริษัทฯ ท่านสามารถเปลี่ยน / คืนสินค้าได้ ดังนี้<BR><BR>

                        <span style='color:#f7941d'>สำหรับ EOL Refill Card, 1 Year Card, GEPOT Card</span><BR>
                        &emsp;&emsp;&emsp;&emsp;หากบริษัทฯ
                        จัดส่งสินค้าให้ท่านผิดจากรายละเอียดการยืนยันการสั่งซื้อที่ท่านได้ระบุไว้
                        กรุณาติดต่อกลับเพื่อคืนสินค้าภายใน 7 วันทำการ นับตั้งแต่วันที่ได้รับสินค้า ทางบริษัทฯ
                        จะจัดส่งสินค้าที่ถูกต้องให้ท่านโดยไม่คิดค่าใช้จ่ายใดๆ ทั้งสิ้น โดยจะต้องไม่มีการ ใช้งานใดๆ
                        ทั้งสิ้น หากท่านได้เริ่มใช้สินค้าแล้วท่านจะไม่สามารถเปลี่ยนหรือขอคืนสินค้าได้
                        กรุณาส่งสินค้ากลับคืนมายังบริษัทฯ ผ่าน ทาง E-Mail ของบริษัทฯ กรุณาระบุด้วยว่าต้องการขอเปลี่ยน /
                        คืนสินค้า ด้วยสาเหตุหรือข้อผิดพลาดใด เมื่อบริษัทฯ ได้รับสินค้าและ
                        ตรวจสอบความผิดพลาดตามที่แจ้งมาแล้ว จะทำการเปลี่ยนสินค้า/คืนค่าสินค้าให้ตามที่ตกลงไว้
                        ทั้งนี้ทั้งนั้นการเปลี่ยนหรือคืนสินค้า ได้ต่อเมื่อเป็นความผิดพลาดที่เกิดจากทางบริษัทฯ
                        เท่านั้น<BR><BR>

                        <span style='color:#f7941d'>สำหรับ EOL Corporate Card</span><BR>
                        &emsp;&emsp;&emsp;&emsp;หากบริษัทฯ
                        จัดส่งสินค้าให้ท่านผิดจากรายละเอียดการยืนยันการสั่งซื้อที่ท่านได้ระบุไว้
                        กรุณาติดต่อกลับเพื่อคืนสินค้าภายใน 7 วันทำการ นับตั้งแต่วันที่ได้รับสินค้า ทางบริษัทฯ
                        จะจัดส่งสินค้าที่ถูกต้องให้ท่านโดยไม่คิดค่าใช้จ่ายใดๆ ทั้งสิ้น โดยสินค้าที่ถูกส่ง
                        กลับมาต้องอยู่ในสภาพเดิมเหมือนตอนที่ท่านรับสินค้ามา และเอกสารคู่มืออยู่ครบถ้วน
                        กรุณาส่งสินค้ากลับคืนมายังบริษัทฯด้วยช่อง ทางที่ตรวจสอบได้ เช่น บริการไปรษณีย์แบบ EMS
                        ซึ่งทางบริษัทฯ จะเป็นผู้รับภาระค่าส่งกลับโดยคืนให้พร้อมกับสินค้า ที่ส่งไปใหม่ /
                        การคืนเงินค่าสินค้า เมื่อบริษัทฯ ได้รับสินค้าและตรวจสอบความผิดพลาดตามที่แจ้งมาแล้ว
                        จะทำการเปลี่ยนสินค้า / คืนค่าสินค้าให้ ตามที่ตกลงไว้
                        ทั้งนี้ทั้งนั้นการเปลี่ยนหรือคืนสินค้าได้ต่อเมื่อเป็นความผิดพลาดที่เกิดจากทางบริษัทฯ
                        เท่านั้น<BR>

                        <span style='color:#f7941d'>ช่องทางในการติดต่อเพื่อเปลี่ยน / คืนสินค้า</span><BR><BR>
                        &emsp;&emsp;Tel : 02-1708725-6 , 066-1152916 , 066-1152454 , 066-1152545<BR>
                        &emsp;&emsp;E-mail : engtest_eol@hotmail.com<BR>


                    </div>
                    <BR><BR>


                </div>
            </div>

        </div>
    </div>
    <?php footer(); ?>