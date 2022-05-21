<?php
include('inc/header.php');
include('inc/footer.php');
include('inc/info_user.php');
include('config/format_time.php');
// include('config/connection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>
    <div class="container shadow_side" style="width:1150px !important;background:#ffffff;margin-top:45px;">

        <?= callheader(); ?>
        <?php

function column_new()
{
    include('config/connection.php');

    $strSQL = "SELECT type_id,max(topic_create) AS last_update FROM tb_web_topic GROUP BY type_id";

    $stmt = $conn->prepare($strSQL);

    $stmt->execute();

    $result = $stmt->get_result();

    $rows = $result->num_rows;

    if ($rows >= 1) {
        for ($i = 1; $i <= $rows; $i++) {

            $data = $result->fetch_array();

            $type_id = $data["type_id"];

            $date_create = $data["last_update"];

            $dif = date_dif($date_create, date("Y-m-d"));

            if ($dif <= 7) {

                $new_topic[$type_id] = "show";

            }

        }

    }
    $stmt->close();
    mysqli_close($conn);
    return $new_topic;

}



function column_list($format)
{
    // include('config/format_time.php');
    include('config/connection.php');


    if ($format == "activity") {

        $num = "2";

        $type = "02-01";

        $active = "1";

        $strSQL = "SELECT * FROM tb_web_topic WHERE type_id=? && topic_active=? ORDER BY topic_id DESC limit ? ";

        $stmt = $conn->prepare($strSQL);

        $stmt->bind_param("sss", $type, $active, $num);

        $stmt->execute();

        $result = $stmt->get_result();

        $rows = $result->num_rows;

        if ($rows >= 1) {

            echo "<table style='width:100%;' cellpadding=0 cellspacing=0 border=0 >";

            for ($i = 1; $i <= $rows; $i++) {

                $data = $result->fetch_array();

                echo "<tr valign='top'>

                                    <td style='width:100px !important;'>

                                        <a class='over_a' href='https://www.engtest.net/forum/detail.php?type_id=$type&&topic_id=$data[topic_id]' target='_blank' title=\"$data[topic_name]\"  style=\"color:#333;\">

                                            <img class='activity_img' src='https://www.engtest.net/2010/user_images/$data[topic_image]?v=1' style='width:100px;height:80px; border-radius: 50%;'>

                                        </a>

                                    </td>

                                    <td class='kanit' style='font-size:16px;padding-left:10px;line-height:20px;'>

                                        <a class='over_a' href='https://www.engtest.net/forum/detail.php?type_id=$type&&topic_id=$data[topic_id]' target='_blank' title=\"$data[topic_name]\"  style=\"color:#333;\">

                                            $data[topic_name]

                                        </a>

                                    </td>

                                </tr>
                                <tr valign='top'>

                                    <td colspan='2' style='height:5px;'>

                                    </td>

                                </tr>";
            }
            echo "</table><br>";

            echo "<center><a href='http://localhost/engtest/forum/e-en.php?type_id=" . $type . "'><button class='btn' id='activity' style='color:#ffffff !important;background:#f7941d;'>All Gallery</button></a></center>";
        }
        $stmt->close();
    }

    if ($format == "news_events") {

        $num = "2";

        $type = "02-02";

        $active = "1";

        $strSQL = "SELECT * FROM tb_web_topic WHERE type_id=? && topic_active=? ORDER BY topic_id DESC limit ? ";

        $stmt = $conn->prepare($strSQL);

        $stmt->bind_param("sss", $type, $active, $num);

        $stmt->execute();

        $result = $stmt->get_result();

        $rows = $result->num_rows;

        if ($rows >= 1) {

            echo "<table style='width:100%;' cellpadding=0 cellspacing=0 border=0 >";

            for ($i = 1; $i < $rows; $i++) {

                $data = $result->fetch_array();

                echo "  <tr valign='top'>

                                        <td style='width:100px !important;'>

                                            <a class='over_a' href='forum/detail.php?type_id=$type&&topic_id=$data[topic_id]' target='_blank' title=\"$data[topic_name]\"  style=\"color:#333;\">

                                                <img class='news_events_img' src=\"https://www.engtest.net/2010/user_images/$data[topic_image]\" style='width:100px;height:80px; border-radius: 50%;'>

                                            </a>

                                        </td>

                                        <td class='kanit' style='font-size:16px;padding-left:10px;line-height:20px;'>

                                            <a class='over_a' href='forum/detail.php?type_id=$type&&topic_id=$data[topic_id]' target='_blank' title=\"$data[topic_name]\"  style=\"color:#333;\">

                                                $data[topic_name]

                                            </a>

                                        </td>

                                    </tr>
                                    <tr valign='top'>

                                        <td colspan='2' style='height:5px;'>

                                        </td>

                                    </tr>";

            }
            echo "</table><br>";

            echo "<center><a href=\"http://localhost/engtest/forum/e-en.php?type_id=" . $type . "\"><button class=\"btn\" id='news_events' style=\"color:#ffffff !important;background:#f7941d;\">All News & Events</button></a></center>";
        }
        $stmt->close();
    }

    if ($format == "eol_magazine_online_showcase") {

        $active = "1";

        $strSQL = "SELECT a.topic_id,a.topic_name,a.topic_headline,a.topic_detail,a.topic_image,a.type_id,a.topic_view,a.topic_create,a.topic_update,a.admin_id,b.nickname FROM tb_web_topic AS a LEFT JOIN tb_web_admin AS b ON (b.admin_id = a.admin_id) WHERE a.type_id NOT IN ('02-01','02-02','02-03','10-01','11-01','11-02','11-03','12-01','12-02','12-03','13-01','13-02','13-03','14-01','14-02','14-03','15-01','15-02','15-03','16-01','17-01','17-02','17-03') && a.topic_active=? ORDER BY a.topic_id DESC LIMIT 0,1";

        $stmt = $conn->prepare($strSQL);

        $stmt->bind_param("s", $active);

        $stmt->execute();

        $result = $stmt->get_result();

        $rows = $result->num_rows;

        if ($rows >= 1) {

            echo "<table style='width:100%;' cellpadding=0 cellspacing=0 border=0 >";

            for ($i = 1; $i <= $rows; $i++) {

                $data = $result->fetch_array();
                // print_r($data["type_id"]);

                // $type = $data[type_id];

                // $view = $data["topic_view"];

                // $url = "https://www.engtest.net/forum/detail.php?type_id=" . $data["type_id"] . "&&topic_id=" . $data["topic_id"];

                // $html = file_get_contents($url);

                // $doc = new DOMDocument();

                // @$doc->loadHTML($html);

                // $tags = $doc->getElementsByTagName('img');

                // $size_array = array();

                // foreach ($tags as $tag) {

                //     $size_array[getimagesize($tag->getAttribute('src'))] = $tag->getAttribute('src');

                // }

                // $max_size = max(array_keys($size_array)); // get max size from keys array

                // $max_file = $size_array[$max_size];
                $img = $data['topic_image'];

                // รูปแบบใหม่
                //--------------------------//

                $img_name = $data['nickname'];

                $img_path = "https://www.engtest.net/userfiles/image/$img_name";

                //--------------------------//



                $bigimg = "https://www.engtest.net/userfiles/BN-RA034_TINYTO_M_20161130144817(1).jpg";

                // echo $img;

                echo "<tr valign='top'>

                                    <td style='width:55% !important;'>

                                        <a class='over_a' href='forum/detail.php?type_id=$data[type_id]&&topic_id=$data[topic_id]' target='_blank' title=\"$data[topic_name]\"  style=\"color:#333;\">

                                            <img src=\"$bigimg\" style='width:100%; border-radius:15px;height:210px;'>

                                        </a>

                                    </td>

                                    <td class='kanit' style='width:45% !important;font-size:20px;padding:0px 15px;line-height:20px;'>

                                        <a class='over_a' href='forum/detail.php?type_id=$data[type_id]&&topic_id=$data[topic_id]' target='_blank' title=\"$data[topic_name]\"  style=\"color:#333;\">

                                            $data[topic_name]<BR><BR>

                                            <span class='text-grey' style='font-size:14px;'>$data[topic_headline]</span>

                                        </a><BR><BR><BR>

                                        <div class='text-grey' style='font-size:14px;'><i class='fa fa-calendar-check-o'></i> " . date("d M Y", strtotime($data["topic_update"])) . "</div>

                                        <div class='text-grey' style='font-size:14px;'><i class='fa fa-user-circle-o'></i> $data[nickname]</div>

                                        <div class='text-grey' style='font-size:14px;'><i class='fa fa-eye'></i> $data[topic_view] Views</div>

                                    </td>

                                </tr>
                                <tr valign='top'>

                                    <td colspan='2' style='height:5px;'>

                                    </td>

                                </tr>";
            }

            echo "</table>";
        }
        else {
            echo "NO Data!!!";
        }
        $stmt->close();
    }

    if ($format == "school") {
    # code...
    }

    // EOL ENGLISH ROOM
    if ($format == "everyday" || $format == "idiom" || $format == "scholarship" || $format == "uthai" || $format == "slangs" ||

    $format == "song" || $format == "x_movie" || $format == "impressive_quote" || $format == "x_sport" || $format == "english_from_news" || $format == "effective_writing" || $format == "easy_english" ||

    $format == "government" || $format == "weak" || $format == "education" || $format == "world" || $format == "sport" ||

    $format == "life" || $format == "health" || $format == "travel" || $format == "movie" || $format == "music" || $format == "communicative") {
        if ($format == "everyday") {

            $img_num = "1";

            $num = "1";

            $type = "03-01";

            $font = 'color:#333;';

        }
        if ($format == "idiom") {

            $img_num = "1";

            $num = "1";

            $type = "03-03";

        }
        if ($format == "scholarship") {

            $img_num = "1";

            $num = "1";

            $type = "03-02";

        }
        if ($format == "uthai") {

            $img_num = "1";

            $num = "1";

            $type = "03-04";

        }
        if ($format == "government") {

            $img_num = "1";

            $num = "1";

            $type = "04-01";

        }
        if ($format == "weak") {

            $img_num = "1";

            $num = "1";

            $type = "04-02";

        }
        if ($format == "education") {

            $img_num = "1";

            $num = "1";

            $type = "04-03";

        }
        if ($format == "world") {

            $img_num = "1";

            $num = "1";

            $type = "04-04";

        }
        if ($format == "sport") {

            $img_num = "1";

            $num = "1";

            $type = "04-05";

        }
        if ($format == "life") {

            $img_num = "1";

            $num = "1";

            $type = "05-01";

        }
        if ($format == "health") {

            $img_num = "1";

            $num = "1";

            $type = "05-02";

        }
        if ($format == "travel") {

            $img_num = "1";

            $num = "1";

            $type = "05-03";

        }
        if ($format == "movie") {

            $img_num = "1";

            $num = "1";

            $type = "05-04";

        }
        if ($format == "music") {

            $img_num = "1";

            $num = "1";

            $type = "05-05";

        }
        if ($format == "song") {

            $img_num = "1";

            $num = "1";

            $type = "03-07";

        }
        if ($format == "x_movie") {

            $img_num = "1";

            $num = "1";

            $type = "03-05";

        }
        if ($format == "impressive_quote") {

            $img_num = "1";

            $num = "1";

            $type = "03-08";

        }
        if ($format == "x_sport") {

            $img_num = "1";

            $num = "1";

            $type = "03-09";

            $font = 'color:#333;';

        }
        if ($format == "communicative") {

            $img_num = "1";

            $num = "1";

            $type = "03-15";

        }
        if ($format == "easy_english") {

            $img_num = "1";

            $num = "1";

            $type = "03-10";

        }
        if ($format == "effective_writing") {

            $img_num = "1";

            $num = "1";

            $type = "03-11";

        }
        if ($format == "english_from_news") {

            $img_num = "1";

            $num = "1";

            $type = "03-12";

            $font = 'color:#333;';

        }
        if ($format == "slangs") {

            $img_num = "1";

            $num = "1";

            $type = "03-13";

        }

        $strSQL = "SELECT * FROM tb_web_topic WHERE type_id=? && topic_active=?  order by topic_id DESC limit ? ";

        $active = '1';

        $stmt = $conn->prepare($strSQL);

        $stmt->bind_param("sss", $type, $active, $num);

        $stmt->execute();

        $result = $stmt->get_result();

        $rows = $result->num_rows;

        if ($rows >= 1) {

            for ($i = 1; $i <= $rows; $i++) {

                $data = $result->fetch_array();

                $date_now = date("Y-m-d");

                $date_create = $data["topic_create"];

                $dif = date_dif($date_create, $date_now);

                $arr_date = explode("-", $date_create);

                $msg_date = $arr_date[2] . "-" . $arr_date[1] . "-" . $arr_date[0];

                $msg_date = date("d M Y", strtotime($date_create));

                $view = $data["topic_view"];

                $topic_id = $data["topic_id"];

                $admin_id = $data["admin_id"];

                $strSQL = "SELECT * FROM tb_web_admin WHERE admin_id=?";

                $query = $conn->prepare($strSQL);

                $query->bind_param("s", $admin_id);

                $query->execute();

                $result = $query->get_result();

                $admin = $result->fetch_array();

                $admin_name = $admin["nickname"];

                $query->close();

                // ------------------------------ //

                echo "<table align=center width=100% cellpadding=0 cellspacing=0 border=0 >";

                if ($i <= $img_num) {

                    echo "
                                    <tr valign=top>

                                            <td>

                                            <i class=\"fa fa-gift text-red\"></i>

                                                <a class='over_a kanit text-blue' href='forum/detail.php?type_id=$type&&topic_id=$data[topic_id]' target='_blank' title=\"$data[topic_name]\" style=\"font-size:14px;$font\">

                                                    <b>$data[topic_name]</b>

                                                </a><br>

                                                <a class='over_a kanit text-black' href='forum/detail.php?type_id=$type&&topic_id=$data[topic_id]' target='_blank' title=\"$data[topic_name]\" style=\"font-size:12px;$font\">

                                                    <i class=\"fa fa-book\"></i>&nbsp;$data[topic_headline] <br>

                                                    <div class=\"row text-grey\" style=\"font-size:14x !important;border:0px solid blue;margin:0px;\">

                                                        <div class=\"col-xs-4 no-space\" style=\"font-size:12px !important;margin:0px;\"><i class=\"fa fa-calendar-check-o\"></i>&nbsp;$msg_date</div>

                                                        <div class=\"col-xs-4 no-space text-center\" style=\"font-size:12px !important;margin:0px;\"><i class=\"fa fa-id-card-o\"></i>&nbsp;$admin_name</div>

                                                        <div class=\"col-xs-4 no-space text-center\" style=\"font-size:12px !important;margin:0px;\"><i class=\"fa fa-eye\"></i>&nbsp;View&nbsp;" . number_format($view, 0) . "</div>    

                                                    </div>

                                                </a>

                                            </td>

                                    </tr>";
                }
                else {
                    echo "
                                    <tr valign=top >

                                        <td align=left><font size=2 face=tahoma color=black><b>&nbsp;&raquo;&nbsp;</b></font></td>

                                        <td align=left></td>

                                        <td width=100% align=left>
                                        
                                            <a class='over_a' href='forum/detail.php?type_id=$type&&topic_id=$data[topic_id]' target='_blank' title=\"$data[topic_name]\">
                                            
                                                <b>

                                                        $data[topic_name] - [ $view ]

                                                </b>
                                                
                                            </a><br>
                                            
                                        </td>

                                    </tr>";
                }
            }
        }
        else {
            echo "
                            <tr height=100 valign=middle>

                                <td align=center><font size=2 face=tahoma color=red><b> - Coming Soon - </b></font></td>
                                
                            </tr>";

        }
        echo "</table>";
        $stmt->close();
    }
    mysqli_close($conn);

}

?>

        <!-- Slide -->
        <div class="row">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <a href="https://www.engtest.net/forum/detail.php?type_id=02-03&&topic_id=4796">
                            <img src="https://www.engtest.net/event/TEOC6/Banner-TEOC6.jpg" alt="" style="width:100%;">
                            <div class="carousel-caption">
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="https://www.engtest.net/eol_system/personal.php">
                            <img src="https://www.engtest.net/event/Personal/Personal pack.jpg" alt=""
                                style="width:100%;">
                            <div class="carousel-caption">
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="../forum/detail.php?type_id=02-02&&topic_id=4763">
                            <img src="https://www.engtest.net/event/1yearscourse/Banner Oneyears_V1.jpg" alt=""
                                style="width:100%;">
                            <div class="carousel-caption">
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="../forum/detail.php?type_id=02-02&&topic_id=4626">
                            <img src="https://www.engtest.net/image2/Home/Slide/banner-gps-index.jpg" alt=""
                                style="width:100%;">
                            <div class="carousel-caption">
                            </div>
                        </a>
                    </div>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <!-- end slide -->


        <div class="row row-eq-height">
            <!-- ซ้าย -->
            <div class="col-xs-8">
                <!-- what is eol -->
                <div class="row row-eq-height">
                    <div class="col-xs-12">
                        <div class="title_section">
                            <i class="fa fa-gift"></i> WHAT IS EOL SYSTEM / EOL ENGTEST.NET
                        </div>

                        <div class="content_section kanit" style="border-radius:15px;">
                            <div class="text-grey"
                                style="padding:10px;background:#fde7cf;text-align: center;font-size:20px; border-radius:15px;">
                                <a href="https://www.engtest.net/eol_system/personal.php">
                                    <img src="https://www.engtest.net/New EOL/image/English Clinic for Thais.png"
                                        style="width:100%;max-height:400px;border:0px solid grey;">
                                </a>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>

                <!-- GALLERY NEWS & EVENTS -->
                <div class="row row-eq-height">
                    <div class="col-xs-6">
                        <div class="title_section">
                            <i class="fa fa-image"></i> GALLERY
                        </div>

                        <div class="content_section kanit" style="border-radius:15px;">
                            <!-- content -->
                            <?= column_list('activity'); ?>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="title_section">
                            <i class="fa fa-newspaper-o"></i> NEWS & EVENTS
                        </div>

                        <div class="content_section kanit" style="border-radius:15px;">
                            <!-- content -->
                            <?= column_list('news_events'); ?>
                        </div>
                    </div>
                </div>
                <!-- end gallery -->

                <!-- EOL MAGAZINE ONLINE SHOWCASE -->
                <div class="row row-eq-height">
                    <div class="col-xs-12">
                        <div class="title_section">
                            <i class="fa fa-book"></i> EOL MAGAZINE ONLINE SHOWCASE
                        </div>
                        <div class="content_section kanit" style="border-radius:15px; height:250px;">
                            <!-- content -->
                            <?= column_list('eol_magazine_online_showcase'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ขวา -->
            <div class="col-xs-4">
                <!-- ผู้สนับสนุนหลัก -->
                <div class="row row-eq-height">
                    <div class="col-xs-12">
                        <div class="title_section">
                            <i class="fa fa-thumbs-o-up"></i> ผู้สนับสนุนหลัก
                        </div>
                        <div class="content_section" style="border-radius:15px;height:220px;">
                            <a title="What is EOL System ?" tag="needless" target="_TEST" a
                                href="https://www.engtest.net/eol_system/personal.php">

                                <img src="https://www.engtest.net/image2/what is eol.png"
                                    style="width:100%;max-height:190px;border:0px solid grey; border-radius:15px;">
                            </a>
                        </div>
                    </div>
                </div>
                <!-- VDO -->
                <div class="row row-eq-height">
                    <div class="col-xs-12">
                        <div class="title_section">
                            <i class="fa fa-video-camera"></i> EOL Presentation
                        </div>
                        <div class="content_section" style="border-radius:15px;">
                            <!-- content -->
                            <iframe width="100%" height="160" src="https://www.youtube.com/embed/JvmBZu3Rh9M"
                                frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
                <!-- QR Code -->
                <div class="row row-eq-height">
                    <div class="col-xs-12">
                        <div class="title_section">
                            <i class="fa fa-qrcode"></i> QR Payment EOL
                        </div>
                        <div class="content_section" style="border-radius:15px;text-align:center;height:280px;">
                            <!-- content -->
                            <a title="QR Payment" tag="needless" target="_blank" a
                                href="https://www.engtest.net/event/QR Payment/QR Payment.jpg">

                                <img src="https://www.engtest.net/event/QR Payment/QR Payment.jpg"
                                    style="max-width:220px;height:250px;border:0px solid grey; border-radius:15px;">
                            </a><br>
                        </div>
                    </div>
                </div>
                <div class="row row-eq-height">
                    <div class="col-xs-12">
                        <div class="title_section">
                            <i class="fa fa-youtube"></i> EOL CHANNEL
                        </div>
                        <div class="content_section" style="border-radius:15px;">
                            <!-- content -->
                            <iframe width="100%" height="180" src="https://www.youtube.com/embed/9v4mRiVZNK8"
                                frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  -->
        <div class="row row-eq-height" style="padding-top:10px;">
            <div class="col-xs-4">
                <div class="title_3_menu" style="background:grey;border-radius:15px;"><i class="fa fa-list-alt"></i>
                    รายชื่อลูกค้าที่ใช้บริการ EOL</div>
            </div>
            <div class="col-xs-4">
                <div class="title_3_menu" style="background:grey;border-radius:15px;"><i class="fa fa-comments-o"></i>
                    ความคิดเห็นของผู้ใช้บริการ EOL</div>
            </div>
            <div class="col-xs-4">
                <div class="title_3_menu" style="background:grey;border-radius:15px;"><i class="fa fa-briefcase"></i>
                    ติดต่อลงโฆษณากับเรา</div>
            </div>
        </div>

        <!-- EOL Column -->
        <div class="row row-eq-height">
            <div class="col-xs-12">
                <div class="title_section">
                    <i class="fa fa-th"></i>&nbsp;EOL ENGLISH ROOM
                </div>
            </div>
        </div>
        <?php
$new_topic = column_new();
?>


        <!-- แถวที่ 1 -->
        <div class="row row-eq-height">
            <div class="col-xs-4 row-eq-height">
                <div class="content_section" style="text-align:center;padding:0px; border-radius:15px;">
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-01" class="over_a">
                        <div style="position:absolute;top:135px;left:158px;">
                            <div class="icon_circle">
                                <i class="fa fa-calendar-check-o"
                                    style="font-size:30px;padding:16px 0px;color:#ffffff;">
                                </i>
                            </div>
                        </div>
                        <?=($new_topic['03-01']) ? '<div style="position:absolute;top:5px;left:16px;"><img src="https://www.engtest.net/img/icon_new.gif" /></div>' : ''; ?>
                    </a>
                    <div>
                        <a href="http://localhost/engtest/forum/e-en.php?type_id=03-01" class="over_a"><img
                                src="https://www.engtest.net/images/index/column1.jpg"
                                style="width:99.5%;height:160px; margin-top:1px; border-radius:15px;">
                        </a>
                    </div>
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-01" class="over_a">
                        <div class="title_english_room">Everyday English</div>
                    </a>
                    <hr style="width:80%;border-top:1px solid #f7941d;margin:5px auto;">
                    <div style="padding:10px;">
                        <!-- content -->
                        <?= column_list('everyday'); ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-4 row-eq-height">
                <div class="content_section" style="text-align:center;padding:0px; border-radius:15px;">
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-12" class="over_a">
                        <div style="position:absolute;top:135px;left:158px;">
                            <div class="icon_circle">
                                <i class="fa fa-newspaper-o" style="font-size:30px;padding:19px 0px;color:#ffffff;"></i>
                            </div>
                        </div>
                        <?=($new_topic['03-12']) ? '<div style="position:absolute;top:5px;left:16px;"><img src="img/icon_new.gif" /></div>' : ''; ?>
                    </a>
                    <div>
                        <a href="http://localhost/engtest/forum/e-en.php?type_id=03-12" class="over_a">
                            <img src="https://www.engtest.net/images/index/column2.jpg"
                                style="width:99.5%;height:160px; margin-top:1px; border-radius:15px;">
                        </a>
                    </div>
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-12" class="over_a">
                        <div class="title_english_room">English from News</div>
                    </a>

                    <hr style="width:80%;border-top:1px solid #f7941d;margin:5px auto;">
                    <div style="padding:10px;">
                        <!-- content -->
                        <?= column_list('english_from_news'); ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-4 row-eq-height">
                <div class="content_section" style="text-align:center;padding:0px;border-radius:15px;">
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-10" class="over_a">
                        <div style="position:absolute;top:135px;left:158px;">
                            <div class="icon_circle">
                                <i class="fa fa-child" style="font-size:30px;padding:16px 0px;color:#ffffff;"></i>
                            </div>
                        </div>

                        <?=($new_topic['03-10']) ? '<div style="position:absolute;top:5px;left:16px;"><img src="img/icon_new.gif" /></div>' : ''; ?>

                    </a>
                    <div>
                        <a href="http://localhost/engtest/forum/e-en.php?type_id=03-10" class="over_a">
                            <img src="https://www.engtest.net/images/index/column3.jpg"
                                style="width:99.5%;height:160px; margin-top:1px; border-radius:15px;">
                        </a>
                    </div>
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-10" class="over_a">
                        <div class="title_english_room">Easy English</div>
                    </a>

                    <hr style="width:80%;border-top:1px solid #f7941d;margin:5px auto;">
                    <div style="padding:10px;">
                        <!-- content -->
                        <?= column_list('easy_english'); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- แถวที่ 2 -->
        <div class="row row-eq-height" style="padding-top:20px;">
            <div class="col-xs-4 row-eq-height">
                <div class="content_section" style="text-align:center;padding:0px; border-radius:15px;">
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-11" class="over_a">
                        <div style="position:absolute;top:135px;left:158px;">
                            <div class="icon_circle">
                                <i class="fa fa-heart" style="font-size:30px;padding:18px 0px;color:#ffffff;"></i>
                            </div>
                        </div>

                        <?=($new_topic['03-11']) ? '<div style="position:absolute;top:5px;left:16px;"><img src="img/icon_new.gif" /></div>' : ''; ?>

                    </a>
                    <div>
                        <a href="https://www.engtest.net/forum/e-en.php?type_id=03-11" class="over_a">
                            <img src="https://www.engtest.net/images/index/column4.jpg"
                                style="width:99.5%;height:160px; margin-top:1px; border-radius:15px;">
                        </a>
                    </div>
                    <a href="https://www.engtest.net/forum/e-en.php?type_id=03-11" class="over_a">
                        <div class="title_english_room">Comprehensive Listening</div>
                    </a>
                    <hr style="width:80%;border-top:1px solid #f7941d;margin:5px auto;">
                    <div style="padding:10px;">
                        <!-- content -->
                        <?= column_list('effective_writing'); ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-4 row-eq-height">
                <div class="content_section" style="text-align:center;padding:0px; border-radius:15px;">
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-03" class="over_a">
                        <div style="position:absolute;top:135px;left:158px;">
                            <div class="icon_circle">
                                <i class="fa fa-text-width" style="font-size:30px;padding:17px 0px;color:#ffffff;"></i>
                            </div>
                        </div>

                        <?=($new_topic['03-03']) ? '<div style="position:absolute;top:5px;left:16px;"><img src="img/icon_new.gif" /></div>' : ''; ?>

                    </a>
                    <div>
                        <a href="https://www.engtest.net/forum/e-en.php?type_id=03-03" class="over_a">
                            <img src="https://www.engtest.net/images/index/column5.jpg"
                                style="width:99.5%;height:160px; margin-top:1px; border-radius:15px;">
                        </a>
                    </div>
                    <a href="https://www.engtest.net/forum/e-en.php?type_id=03-03" class="over_a">
                        <div class="title_english_room">Proverbs / Slang / Idioms</div>
                    </a>
                    <hr style="width:80%;border-top:1px solid #f7941d;margin:5px auto;">
                    <div style="padding:10px;">
                        <!-- content -->
                        <?= column_list('idiom'); ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-4 row-eq-height">
                <div class="content_section" style="text-align:center;padding:0px; border-radius:15px;">
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-15" class="over_a">
                        <div style="position:absolute;top:135px;left:158px;">
                            <div class="icon_circle"><i class="fa fa-comments"
                                    style="font-size:30px;padding:17px 0px;color:#ffffff;"></i>
                            </div>
                        </div>

                        <?=($new_topic['03-15']) ? '<div style="position:absolute;top:5px;left:16px;"><img src="img/icon_new.gif" /></div>' : ''; ?>

                    </a>
                    <div>
                        <a href="https://www.engtest.net/forum/e-en.php?type_id=03-15" class="over_a"><img
                                src="https://www.engtest.net/images/index/column6.jpg"
                                style="width:99.5%;height:160px; margin-top:1px; border-radius:15px;">
                        </a>
                    </div>
                    <a href="https://www.engtest.net/forum/e-en.php?type_id=03-15" class="over_a">
                        <div class="title_english_room">Communicative English</div>
                    </a>
                    <hr style="width:80%;border-top:1px solid #f7941d;margin:5px auto;">
                    <div style="padding:10px;">
                        <!-- content -->
                        <?= column_list('communicative'); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- แถวที่ 3 -->
        <div class="row row-eq-height" style="padding-top:20px; padding-bottom:20px;">
            <div class="col-xs-4 row-eq-height">
                <div class="content_section" style="text-align:center;padding:0px; border-radius:15px;">
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-08" class="over_a">
                        <div style="position:absolute;top:135px;left:158px;">
                            <div class="icon_circle">
                                <i class="fa fa-briefcase" style="font-size:30px;padding:15px 0px;color:#ffffff;"></i>
                            </div>
                        </div>

                        <?=($new_topic['03-08']) ? '<div style="position:absolute;top:5px;left:16px;"><img src="img/icon_new.gif" /></div>' : ''; ?>

                    </a>
                    <div>
                        <a href="https://www.engtest.net/forum/e-en.php?type_id=03-08" class="over_a">
                            <img src="https://www.engtest.net/images/index/column7.jpg"
                                style="width:99.5%;height:160px; margin-top:1px; border-radius:15px;">
                        </a>
                    </div>
                    <a href="https://www.engtest.net/forum/e-en.php?type_id=03-08" class="over_a">
                        <div class="title_english_room">Impressive Quote</div>
                    </a>
                    <hr style="width:80%;border-top:1px solid #f7941d;margin:5px auto;">
                    <div style="padding:10px;">
                        <!-- content -->
                        <?= column_list('impressive_quote'); ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-4 row-eq-height">
                <div class="content_section" style="text-align:center;padding:0px; border-radius:15px;">
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-07" class="over_a">
                        <div style="position:absolute;top:135px;left:158px;">
                            <div class="icon_circle">
                                <i class="fa fa-music" style="font-size:30px;padding:15px 0px;color:#ffffff;"></i>
                            </div>
                        </div>

                        <?=($new_topic['03-07']) ? '<div style="position:absolute;top:5px;left:16px;"><img src="img/icon_new.gif" /></div>' : ''; ?>

                    </a>
                    <div>
                        <a href="https://www.engtest.net/forum/e-en.php?type_id=03-07" class="over_a">
                            <img src="https://www.engtest.net/images/index/column8.jpg"
                                style="width:99.5%;height:160px; margin-top:1px; border-radius:15px;">
                        </a>
                    </div>
                    <a href="https://www.engtest.net/forum/e-en.php?type_id=03-07" class="over_a">
                        <div class="title_english_room">Song of Souls</div>
                    </a>
                    <hr style="width:80%;border-top:1px solid #f7941d;margin:5px auto;">
                    <div style="padding:10px;">
                        <!-- content -->
                        <?= column_list('song'); ?>
                    </div>
                </div>
            </div>

            <div class="col-xs-4 row-eq-height">
                <div class="content_section" style="text-align:center;padding:0px; border-radius:15px;">
                    <a href="http://localhost/engtest/forum/e-en.php?type_id=03-05" class="over_a">
                        <div style="position:absolute;top:135px;left:158px;">
                            <div class="icon_circle">
                                <i class="fa fa-film" style="font-size:30px;padding:15px 0px;color:#ffffff;"></i>
                            </div>
                        </div>

                        <?=($new_topic['03-05']) ? '<div style="position:absolute;top:5px;left:16px;"><img src="img/icon_new.gif" /></div>' : ''; ?>

                    </a>
                    <div>
                        <a href="https://www.engtest.net/forum/e-en.php?type_id=03-05" class="over_a">
                            <img src="https://www.engtest.net/images/index/column9.jpg"
                                style="width:99.5%;height:160px; margin-top:1px; border-radius:15px;">
                        </a>
                    </div>
                    <a href="https://www.engtest.net/forum/e-en.php?type_id=03-05" class="over_a">
                        <div class="title_english_room">Trendy Movie</div>
                    </a>
                    <hr style="width:80%;border-top:1px solid #f7941d;margin:5px auto;">
                    <div style="padding:10px;">
                        <!-- content -->
                        <?= column_list('x_movie'); ?>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="bodyfooter">
        <?php footer(); ?>
    </div>

</body>

</html>