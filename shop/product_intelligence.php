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

    .item_table td {
        padding: 8px;
        font-size: 26px;
        font-weight: bold;

    }

    /* .purchase_item {
        font-size: 20px;
        background: #f7941d;
        color: #ffffff;
        border: 1px solid #f7941d;
        width: 150px;
    }

    .purchase_item:hover {
        background: #ef5f2d;
        color: #ffffff;

    } */

    .link_shortcut {
        background: #f5f5f5;
        color: #525252;
        font-size: 24px;
        text-align: center;
        font-weight: bold;
        padding: 5px 10px;
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
                            <a href="http://localhost/engtest/shop/product_personal.php">
                                <img src="https://www.engtest.net/img/shop/tab-menu-product/personal-package.jpg"></a>

                            <a href="#">
                                <img
                                    src="https://www.engtest.net/img/shop/tab-menu-product/Over-Intelligence-Package.jpg"></a>

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
                            <h2><strong>EOL Intelligence Package</strong><br>
                                <span style="font-size:20px;color:#707070;" class="kanit">สำหรับบุคคลทั่วไป</span>
                            </h2>
                            <hr style="width:100px;border:2px solid #f7941d" />
                        </div>
                    </center>
                    <BR><BR>
                    <div class="text_paragraph ">
                        <center>
                            <?php

$topic_name = "EOL Intelligence Package";
$type_id = '02-02';
$active = 1;
$strSQL = "SELECT * FROM tb_web_topic WHERE topic_name = ? && type_id = ? && topic_active = ? ORDER BY topic_id DESC limit 1";
$stmt = $conn->prepare($strSQL);
$stmt->bind_param("ssi", $topic_id, $type_id, $active);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_array();
if ($data) {
    echo "
                                <table align=center width=95% cellpadding=0 cellspacing=0 border=0>
                                    <tr height=30>
                                        <td>&nbsp;&nbsp;</td>
                                        <td width=100% align=left>
                                            " . $data['topic_detail'] . "
                                        </td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr height=30>
                                        <td colspan=2></td>
                                    </tr>
                                </table>	";
}
$stmt->close();
?>
                        </center>
                        <BR><BR>
                    </div>
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