<?php
function footer_sitemap($title_name)
{
    $_footer['home']['title'] = "Home";
    $_footer['about']['title'] = "เกี่ยวกับเรา";
    $_footer['eol-system']['title'] = "EOL System";
    $_footer['product']['title'] = "สินค้าและบริการ";
    $_footer['eol-columns']['title'] = "EOL Columns";
    $_footer['standard-test']['title'] = "Standard Test";
    $_footer['contact']['title'] = "ติดต่อเรา";

    $_footer['home']['list'][] = array('name' => 'เข้าสู่เว็บไซต์', 'url' => 'https://www.engtest.net/index.php');
    // $_footer['home']['list'][] = array('name' => 'สมัครสมาชิก', 'url' => 'https://www.engtest.net/register.php');
    // $_footer['home']['list'][] = array('name' => 'ลืมรหัสผ่าน', 'url' => 'https://www.engtest.net/forgot_pwd/setpass.php');
    $_footer['about']['list'][] = array('name' => 'เกี่ยวกับ EOL', 'url' => 'https://www.engtest.net/info/about_eol.php');
    $_footer['about']['list'][] = array('name' => 'ความปลอดภัยของเว็บไซต์', 'url' => 'https://www.engtest.net/info/safe.php');
    $_footer['about']['list'][] = array('name' => 'กว่าจะเป็น EOL', 'url' => 'https://www.engtest.net/info/eol.php');
    $_footer['eol-system']['list'][] = array('name' => 'What is EOL', 'url' => 'https://www.engtest.net/eol_system/whatiseol.php');
    $_footer['eol-system']['list'][] = array('name' => 'Personal', 'url' => 'https://www.engtest.net/eol_system/personal.php');
    $_footer['eol-system']['list'][] = array('name' => 'Intelligence', 'url' => 'https://www.engtest.net/eol_system/Intelligence.php');
    $_footer['eol-system']['list'][] = array('name' => 'CORPORATE', 'url' => 'https://www.engtest.net/eol_system/corporate.php');
    $_footer['eol-system']['list'][] = array('name' => '1 Year Course', 'url' => 'https://www.engtest.net/eol_system/oneyear.php');
    $_footer['eol-system']['list'][] = array('name' => 'GEPOT', 'url' => 'https://www.engtest.net/eol_system/gepot.php');
    $_footer['product']['list'][] = array('name' => 'สั่งซื้อสินค้า', 'url' => 'https://www.engtest.net/shop/product_personal.php');
    // $_footer['product']['list'][] = array('name' => 'วิธีการสั่งซื้อ', 'url' => 'https://www.engtest.net/product-and-service/howbuy.php');
    $_footer['product']['list'][] = array('name' => 'การชำระเงิน', 'url' => 'https://www.engtest.net/forum/detail.php?type_id=02-02&&topic_id=4786');
    $_footer['product']['list'][] = array('name' => 'นโยบายการเปลี่ยนสินค้า', 'url' => 'https://www.engtest.net/shop/policy-change-product.php');
    $_footer['product']['list'][] = array('name' => 'การรับประกันสินค้า', 'url' => 'https://www.engtest.net/shop/warranty.php');
    $_footer['eol-columns']['list'][] = array('name' => 'Everyday English', 'url' => 'https://www.engtest.net/forum/e-en.php?type_id=03-01');
    // $_footer['eol-columns']['list'][] = array('name' => 'Hello ASEAN', 'url' => 'https://www.engtest.net/forum/e-en.php?type_id=03-02');
    $_footer['eol-columns']['list'][] = array('name' => 'English for Kids', 'url' => 'https://www.engtest.net/forum/e-en.php?type_id=03-10');
    $_footer['eol-columns']['list'][] = array('name' => 'English for You', 'url' => 'https://www.engtest.net/forum/e-en.php?type_id=03-11');
    $_footer['eol-columns']['list'][] = array('name' => 'Proverbs / Slang / Idioms', 'url' => 'https://www.engtest.net/forum/e-en.php?type_id=03-03');
    $_footer['eol-columns']['list'][] = array('name' => 'Communicative English', 'url' => 'https://www.engtest.net/forum/e-en.php?type_id=03-15');
    $_footer['eol-columns']['list'][] = array('name' => 'Impressive Quotes', 'url' => 'https://www.engtest.net/forum/e-en.php?type_id=03-08');
    $_footer['eol-columns']['list'][] = array('name' => 'Songs for Soul', 'url' => 'https://www.engtest.net/forum/e-en.php?type_id=03-07');
    $_footer['eol-columns']['list'][] = array('name' => 'Trendy Movies', 'url' => 'https://www.engtest.net/forum/e-en.php?type_id=03-05');
    $_footer['standard-test']['list'][] = array('name' => 'Admission', 'url' => 'https://www.engtest.net/stdtest/admission.php');
    $_footer['standard-test']['list'][] = array('name' => 'CU-TEP', 'url' => 'https://www.engtest.net/stdtest/cu-tep.php');
    $_footer['standard-test']['list'][] = array('name' => 'TU-GET', 'url' => 'https://www.engtest.net/stdtest/tu-get.php');
    $_footer['standard-test']['list'][] = array('name' => 'TOEFL', 'url' => 'https://www.engtest.net/stdtest/toefl.php');
    $_footer['standard-test']['list'][] = array('name' => 'TOEIC', 'url' => 'https://www.engtest.net/stdtest/toeic.php');
    $_footer['standard-test']['list'][] = array('name' => 'IELTS', 'url' => 'https://www.engtest.net/stdtest/ielts.php');
    $_footer['contact']['list'][] = array('name' => 'ติดต่อเรา', 'url' => 'https://www.engtest.net/contact/contact.php');
    $_footer['contact']['list'][] = array('name' => 'ร่วมงานกับเรา', 'url' => 'https://www.engtest.net/contact/work.php');

    echo "<span><b>" . $_footer[$title_name]['title'] . "</b></span>";
    echo "<ul class='site_map' style=''>";
    for ($i = 0; $i < count($_footer[$title_name]['list']); $i++) {
        echo "   <li><a class=\"over_a text-white font-tahoma font-small column-footer\" href=\"" . $_footer[$title_name]['list'][$i]['url'] . "\">" . $_footer[$title_name]['list'][$i]['name'] . "</a></li>";
    }
    echo "</ul>";
}
?>

<?php
function footer()
{
?>
<style>
#Certificate-banners img {
    width: 95%;
    padding: 5px;
}

.column-footer:hover {
    color: black !important;
}

.admin-manage:hover {
    color: black !important;
}
</style>
<footer class="footer"
    style="padding-top:20px;padding-bottom:30px;background: #f7941d;z-index: 100;width:100% !important;min-width:1150px !important;">
    <div class="container" style="width:1150px">
        <div class="row">
            <div class="col-xs-6 text-white prompt">
                Copyright © 2022 By English Online Co.,Ltd. All rights reserved.
            </div>
            <div class="col-xs-6 text-white text-right prompt">
                <a href="https://www.engtest.net/mainoffice.php?section=admin" class="over_a text-white admin-manage"><i
                        class='fa fa-graduation-cap'></i> Academics</a> |
                <a href="https://www.engtest.net/mainoffice.php?section=office&&status=login_form"
                    class="over_a  text-white admin-manage"><i class='fa fa-user-circle-o'></i> Webmaster /
                    Columnists</a>

            </div>
        </div>
    </div>
    <hr style="height:5px;background:#f7b048;border:0px;" />
    <div class="container kanit" style="width:1150px">
        <div class="row row-eq-height ">
            <div class="col-xs-3" style="border:0px solid blue;">
                <div style="border:0px solid #FFF;padding:5px;background:#F9B562;">
                    <div class="kanit" style="font-size:20px;color:#fff;">&nbsp;ติดต่อสอบถามข้อมูล</div>
                    <div class="kanit" style="font-size:30px;font-weight:bold;text-align: center;color:#fff; "><i
                            class='fa fa-phone'></i> 02-1708725-6</div>
                </div><BR>
                <div style="border:0px solid #FFF;padding:5px;background:#F9B562;">
                    <script
                        src="https://www.trustmarkthai.com/callbackData/initialize.js?t=f912768c67-31-4-4d78c96ecdb76f089760a23951ddf1ca36"
                        id="dbd-init">
                    </script>
                    <div id="Certificate-banners"></div>
                    <div class="font-tahoma" style="text-align: center;font-size:12px;">
                        ผู้ประกอบการพาณิชย์อิเล็คทรอนิกส์<BR>เลขที่ 0105548060561</div>
                </div>
            </div>
            <div class="col-xs-9" style="border:0px solid blue;">
                <div class="row row-eq-height">
                    <div class="col-xs-3">
                        <?= footer_sitemap('home'); ?>
                        <?= footer_sitemap('about'); ?>
                        <?= footer_sitemap('contact'); ?>
                    </div>
                    <div class="col-xs-3">
                        <?= footer_sitemap('eol-system'); ?>
                        <?= footer_sitemap('product'); ?>
                    </div>
                    <div class="col-xs-3">
                        <?= footer_sitemap('standard-test'); ?>
                    </div>
                    <div class="col-xs-3">
                        <?= footer_sitemap('eol-columns'); ?>
                        <BR>
                        <!-- Statistic -->
                        <!-- <img src="https://c39.statcounter.com/3475811/0/7dba0666/0/" alt="hit counter script" border="0"
                            class="statcounter" /> -->
                        <script>
                        (function(i, s, o, g, r, a, m) {
                            i["GoogleAnalyticsObject"] = r;
                            i[r] = i[r] || function() {
                                (i[r].q = i[r].q || []).push(arguments)
                            }, i[r].l = 1 * new Date();
                            a = s.createElement(o),
                                m = s.getElementsByTagName(o)[0];
                            a.async = 1;
                            a.src = g;
                            m.parentNode.insertBefore(a, m)
                        })(window, document, "script", "//www.google-analytics.com/analytics.js", "ga");

                        ga("create", "UA-108448865-1", "engtest.net");
                        ga("send", "pageview");
                        </script>
                    </div>
                </div>
            </div>
        </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<script src="http://localhost/engtest/bootstrap/js/bootstrap.min.js"></script>
<script>
// $(document).ready(function() {
//     $.ajax({
//         url: "../shop/add_to_cart.php",
//         type: "POST",
//         data: {
//             method: "view"
//         },
//         success: function(data, textStatus, jqXHR) {
//             $("#shopping_cart").html(data);
//         },
//     });
// });
</script>

<?php
}
?>