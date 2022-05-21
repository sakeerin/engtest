<?php
include('../inc/header.php'); 
include('../inc/footer.php');
include('../inc/info_user.php');
include('../config/connection.php');
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

    .item_table td {
        padding: 8px;
        font-size: 26px;
        font-weight: bold;

    }

    .purchase_item {
        font-size: 20px;
        background: #f7941d;
        color: #ffffff;
        border: 1px solid #f7941d;
        width: 150px;
    }

    .purchase_item:hover {
        background: #ef5f2d;
        color: black;

    }

    .link_shortcut {
        background: #f5f5f5;
        color: #525252;
        font-size: 24px;
        text-align: center;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 15px;
    }

    .link_shortcut:hover {
        color: red;
    }

    .item_table:hover {
        color: red;
    }
    </style>
</head>
<!-- Bootstrap core CSS -->
<!-- <link href="https://www.engtest.net/assets/fonts/CmPrasanmit/stylesheet.css" rel="stylesheet"> -->

<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">

        <?= callheader(); ?>

        <div class="row kanit">
            <div class="col-xs-12" style="padding:0px;margin:0px;">
                <div id="sub_menu"
                    style="border-top:1px solid #f7941d;padding:10px;text-align:center;background:#f3f3f3;">
                    <a href="http://localhost/engtest/shop/product_personal.php" class="active"
                        style="padding-right:30px;"> • สินค้า</a>
                    <!-- <a href="http://localhost/engtest/shop/cart.php" style="padding-right:30px;">• ตะกร้าสินค้า</a> -->
                    <a href="http://localhost/engtest/shop/payment.php" style="padding-right:30px;">•
                        วิธีการสั่งซื้อ</a>
                    <a href="http://localhost/engtest/shop/policy-change-product.php">• นโยบายการเปลี่ยนสินค้า</a>
                </div>
                <div id="apDiv68" style="border-top:1px solid #d27f19;border-bottom:4px solid #f7941d">
                    <center>
                        <div id="apdiv3menubar" style="background:#f3f3f3;">
                            <a href="#">
                                <img
                                    src="https://www.engtest.net/img/shop/tab-menu-product/over-personal-package.jpg"></a>
                            <a href="http://localhost/engtest/shop/product_intelligence.php">
                                <img
                                    src="https://www.engtest.net/img/shop/tab-menu-product/Intelligence-Package.jpg"></a>
                            <a href="http://localhost/engtest/shop/product_corporate.php">
                                <img src="https://www.engtest.net/img/shop/tab-menu-product/corporate-package.jpg"></a>
                            <a href="http://localhost/engtest/shop/product_1year.php">
                                <img src="https://www.engtest.net/img/shop/tab-menu-product/1year-package.jpg"></a>
                            <a href="http://localhost/engtest/shop/product_gepot.php">
                                <img src="https://www.engtest.net/img/shop/tab-menu-product/gepot-card.jpg"></a>
                        </div>
                    </center>
                </div>

                <div style="padding:0px 150px;border:0px solid blue;" class="CmPrasanmit">
                    <center>
                        <div id="apDiv69" class="CmPrasanmit" style="padding-top:20px;">
                            <h2><strong>EOL PERSONAL PACKAGE</strong><br>
                                <span style="font-size:20px;color:#707070;" class="kanit">สำหรับบุคคลทั่วไป</span>
                            </h2>
                            <hr style="width:100px;border:2px solid #f7941d" />
                        </div>
                    </center>
                    <BR><BR>
                    <div class="text_paragraph ">
                        </center>
                        <?php
                            // $db = new DB();
                            $category = "EOL PERSONAL PACKAGE";
                            $active = 1;
                            // $strSQL = "SELECT * ";
                            // $strSQL .= "       FROM tbl_order_product_new AS A";
                            // $strSQL .= "       WHERE A.category = '" . $category . "'";
                            // $strSQL .= "       AND A.is_active='1'";
                            // $db->ExecuteSQL($strSQL);
                            // $result = $db->arrayedResult;

                            $strSQL = "SELECT * FROM tb_order_product WHERE category = ? && is_active = ? ";
                            $stmt = $conn->prepare($strSQL);
                            $stmt->bind_param("si",$category,$active);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $rows = $result->num_rows;
                            // $data = $result->fetch_array();
                            // print_r($data);
                            // $j = 0;
                            // while($data = $result->fetch_assoc()) {
                            //     $temp_image[$j] = $data['product_image'];
                            //     $temp_name[$j] = $data['product_name'];
                            //     $temp_detail[$j] = $data['product_detail'];
                            //     $temp_cost[$j] =  $data['product_cost'];
                            //     $j++;
                            // }

                            while($data = $result->fetch_assoc()) {
                                
                                $path_img = "https://www.engtest.net/img/shop/products/" . $data['product_image'];
                                ?>
                        <div class="row" style="padding:5px 0px;">
                            <div class="col-xs-5">
                                <img src="<?= $path_img; ?>"
                                    style="width:100%; vertical-align: middle; border-radius: 10px;" />
                            </div>
                            <div class="col-xs-7" style="border:0px solid blue;">
                                <table class="item_table" border="0" style="width:100%;">
                                    <tr>
                                        <td style="width:50px !important;"><img
                                                src="https://www.engtest.net/img/shop/products/icon-card.png" /></td>
                                        <td style="width:100% !important;"><?= $data['product_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><img src="https://www.engtest.net/img/shop/products/icon-refill.png" /></td>
                                        <td><?= $data['product_detail']; ?><span style="color:red;">*</span></td>
                                    </tr>
                                    <tr>
                                        <td><img src="https://www.engtest.net/img/shop/products/icon-money.png" /></td>
                                        <td><?= number_format($data['product_cost'], 0) ?> Baht</td>
                                    </tr>
                                    <tr>
                                        <!--td colspan="2" style="text-align: right !important;">
                                                    <button class="btn kanit purchase_item add-to-cart" data-item-id="<?=$data['product_id'];?>">สั่งซื้อ</button>
                                                </td-->
                                        <td colspan="2" style="text-align: right !important;">
                                            <input type="button" button class="btn kanit purchase_item" value="สั่งซื้อ"
                                                onclick="Newbuy()" style="border-radius: 30px !important;">
                                            <script>
                                            function Newbuy() {
                                                window.open(
                                                    "https://www.engtest.net/forum/detail.php?type_id=02-02&&topic_id=4786"
                                                )
                                            }
                                            </script>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr style="width:100%;border-top:1px solid grey;">
                        <?php
                            }
                            $stmt->close();
                            ?>
                    </div>
                    <div style="font-size:20px;font-weight:bold;">
                        <ul style="padding-left:25px;">
                            <li><span style="color:red;">การนับวันใช้งาน</span> : จะนับจากการใช้งานจริงเท่านั้น
                                ถ้าผู้ใช้ไม่ได้ Log in เข้าระบบ จะไม่หักวันใช้งาน</li>
                            <li><span style="color:red;">Expire date</span> : ต้องใช้งานภายใน 6 เดือนหลังจาก Login
                                วันแรก</li>
                        </ul>
                    </div>
                    <BR>
                    <a href="http://localhost/engtest/eol_system/personal.php" style="text-decoration: none;">
                        <div class="link_shortcut">WHAT IS EOL PERSONAL?</div>
                    </a>
                    <div style="height:10px;"></div>
                    <!--<div class="link_shortcut" style="text-align: left;">การลงทะเบียนเป็นสมาชิกระบบ และการเติมวันใช้งาน</div>-->
                    <BR><BR>
                </div>
            </div>
        </div>
    </div>
    <?php footer(); ?>
    <script>
    $(document).ready(function() {

    });

    $(".add-to-cart").click(function() {
        var item_id = $(this).data('item-id');
        $.ajax({
            url: "add_to_cart.php",
            type: "POST",
            data: {
                method: "plus",
                item_id: item_id
            },
            success: function(data, textStatus, jqXHR) {
                $("#shopping_cart").html(data);
                //                        console.log(data);
            },
        });
    })
    </script>