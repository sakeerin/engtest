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
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:-30px;">

        <?= callheader(); ?>

        <div class="row kanit">
            <div class="col-xs-12" style="padding:0px;margin:0px;">
                <div id="sub_menu"
                    style="border-top:1px solid #f7941d;padding:10px;text-align:center;background:#f3f3f3;">
                    <a href="http://localhost/engtest/shop/product_personal.php" style="padding-right:30px;"> •
                        สินค้า</a>
                    <!-- <a href="http://localhost/engtest/shop/cart.php" style="padding-right:30px;">•
                        ตะกร้าสินค้า</a> -->
                    <a href="http://localhost/engtest/shop/payment.php" style="padding-right:30px;">•
                        วิธีการสั่งซื้อ</a>
                    <a href="http://localhost/engtest/shop/policy-change-product.php" class="active">•
                        นโยบายการเปลี่ยนสินค้า</a>
                </div>
                <div id="apDiv68" style="border-top:1px solid #d27f19;border-bottom:4px solid #f7941d">
                    <center>
                        <div id="apdiv3menubar" style="background:#f3f3f3;">
                            <a href="http://localhost/engtest/shop/policy-change-product.php">
                                <img src="https://www.engtest.net/img/shop/tab-menu-policy/policy-change.jpg"></a>
                            <a href="#">
                                <img src="https://www.engtest.net/img/shop/tab-menu-policy/over-warranty.jpg"></a>
                        </div>
                    </center>
                </div>

                <div style="padding:0px 150px;border:0px solid blue;" class="taviraj">
                    <center>
                        <div id="apDiv69" class="kanit" style="padding-top:20px;">
                            <h2><strong>การรับประกันสินค้า</strong><br>
                                <span style="font-size:24px;color:#707070;">การรับประกันสินค้าตลอดอายุการใช้งาน</span>
                            </h2>
                            <hr style="width:100px;border:2px solid #f7941d" />
                            <img src="https://www.engtest.net/img/shop/warranty.jpg" width="100%">
                        </div>
                    </center>
                    <BR><BR>
                    <div class="text_paragraph">
                        </center>
                        <span style='color:#f7941d'>นโยบายการรับประกันสินค้า</span><BR>
                        สินค้าที่ซื้อจากเว็บไซต์ www.EngTest.net มีการรับประกันสินค้าตลอดอายุการใช้งาน
                        และเมื่อท่านมีปัญหาเรื่องการเข้าใช้งาน ระบบ หรือเข้าใช้งานระบบไม่ได้ สามารถสอบถามมายังบริษัทฯ
                        ได้<BR><BR>

                        <span style='color:#f7941d'>ช่องทางในการสอบถาม</span><BR>
                        &emsp;&emsp;Tel : 02-1708725-6 , 066-1152916 , 066-1152454 , 066-1152545<BR>
                        &emsp;&emsp;E-mail : engtest_eol@hotmail.com<BR>


                    </div>
                    <BR><BR>


                </div>
            </div>

        </div>
    </div>
    <?php footer(); ?>