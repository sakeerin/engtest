<?php
include('../inc/header-main.php');
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

    .title_font_color {
        color: #fb921d;
        font-weight: bold;
    }

    .btn_shortcut {
        padding: 15px;
        width: 300px;
    }

    .btn_shortcut:hover {
        background: #fb921d;
        color: black;
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
                            <a href="http://localhost/engtest/eol_system/personal.php">
                                <img src="https://www.engtest.net/image2/eol system/eol-personal.jpg"></a>
                            <a href="http://localhost/engtest/eol_system/Intelligence.php">
                                <img src="https://www.engtest.net/image2/eol system/Intelligence-Package.jpg"></a>
                            <a href="http://localhost/engtest/eol_system/corporate.php">
                                <img src="https://www.engtest.net/image2/eol system/eol-corporate-user.jpg"></a>
                            <a href="http://localhost/engtest/eol_system/oneyear.php">
                                <img src="https://www.engtest.net/image2/eol system/1year-course.jpg"></a>
                            <a href="http://localhost/engtest/eol_system/gepot.php">
                                <img src="https://www.engtest.net/image2/eol system/over-gepot.jpg"></a>
                        </div>
                    </center>
                </div>

                <div style="padding:0px 150px;border:0px solid blue;" class="taviraj">
                    <center>
                        <div id="apDiv69" class="kanit" style="padding-top:20px;">
                            <h2><strong>GEPOT ONLINE TESTING</strong><br>
                                <span style="font-size:24px;color:#707070;">การทดสอบวัดระดับความรู้
                                    ภาษาอังกฤษด้วยระบบออนไลน์</span>
                            </h2>
                            <hr style="width:100px;border:2px solid #f7941d" />
                            <img src="https://www.engtest.net/gepot/GEPOT14/Gepot14-website.png" width="100%">
                        </div>
                    </center>
                    <BR><BR>
                    <div class="text_paragraph">
                        <strong><span class="title_font_color">GEPOT</span> ย่อมาจาก General English Proficiency Online
                            Test</strong><br><br>
                        &emsp;&emsp;ไม่ต้องเสียเงินเป็นหลักพันจนเกือบหมื่น เพื่อไปสอบและได้ผลสอบที่ไม่น่าพอใจ
                        แถมยังใช้ประโยชน์ไม่ได้ สำหรับคนที่ต้องการสอบ มาตราฐานภาษาอังกฤษ เพื่อเอาคะแนนไปศึกษาต่อ
                        ไปสมัครงาน ไปต่างประเทศ ฯลฯ เรามีข้อสอบที่ผลิตจากนักวิชาการในมหาวิทยาลัย ชั้นนำของประเทศ
                        สร้างสรรค์ข้อสอบในระบบ เพื่อให้ทุกคนสามารถสอบ เพื่อประเมินตนเองก่อนสอบจริง
                        โดยมีผลเทียบเคียงคะแนน สอบของการสอบมาตราฐานทั้งในและต่างประเทศ (ด้วยเงินแค่หลักร้อย)
                        สอบจนกว่าจะได้คะแนนที่พอใจแล้วค่อยไปเสียเงินหลักพันเกือบ หมื่นเพื่อเอาคะแนนจริงที่น่าพอใจ
                        และได้ใช้ประโยชน์จริงๆ จะดีกว่า
                    </div>
                    <BR><BR>
                    <center>
                        <a href="https://www.engtest.net/shop/product_gepot.php"><button
                                class="btn btn-lg btn-danger kanit btn_shortcut"><i class="fa fa-shopping-basket"></i>
                                Buy 1
                                GEPOT CARD</button></a>
                    </center>
                    <!-- <a href="#"><button class="btn btn-lg btn-confirm kanit btn_shortcut pull-right"><i
                                class="fa fa-sign-in"></i> Log In GEPOT ONLINE TESTING</button></a> -->
                    <BR><BR><BR><BR>
                </div>
            </div>

        </div>
    </div>
    <?php footer(); ?>