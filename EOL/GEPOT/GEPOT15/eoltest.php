<?php
ob_start();
session_start();
include('../config/connection.php');
include('./config/connection.php');
include('../inc/user_info.php');
// include('../inc/footer.php');

if ($_SESSION["x_member_id"] == '') {
    echo "<script type=\"text/javascript\">
                 window.location=\"http://localhost/engtest/\";
          </script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EOL System</title>
    <link rel='shortcut icon' type='image/x-icon' href='http://localhost/engtest/images/image2/neweol-logo.ico'>
    <!-- <script src='https://www.engtest.net/bootstrap/js/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-tools/1.2.7/jquery.tools.min.js'></script> -->
    <!-- <script defer type="text/javascript" src="https://www.engtest.net/js/pngfix.js"></script> -->
    <!-- <link href="http://localhost/engtest/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="https://www.engtest.net/bootstrap/css/tab.css"> -->
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/tabbar.css">
    <!-- <link href="https://www.engtest.net/css/testpage.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/mainpage.css">
    <link rel="stylesheet" href="http://localhost/engtest/bootstrap/css/eoltest.css">
    <style>
    .welcome {
        position: absolute;
        right: 35px;
        font-size: 2rem;
        font-weight: 600;
        font-family: fantasy;
        top: 28px;
    }

    .edit-profile {
        position: absolute;
        left: 140px;
        font-size: 1.5rem;
        font-weight: 600;
        font-family: fantasy;
        top: 48px;
    }

    .sub-member,
    .personal {
        position: absolute;
        left: 166px;
        font-size: 1.6rem;
        font-weight: 600;
        font-family: monospace;
        top: 390px;
    }
    </style>

</head>


<body>
    <!--------------------------main content --------------------------->
    <div id="container">
        <div id="header">
            <a href="../index.php"><img src="http://localhost/engtest/images/image2/logo/logo-02.png" width="270"
                    height="118" style="float:left;margin-left:20px; margin-top: 175px;" />
            </a>
            <!---- info user ----->
            <div id="info_user">
                <?php
$data = new info();
echo $data->loadinfo('test');
?>
                <div id="logoutPic">
                    <a href="http://localhost/engtest/inc/logout.php"><img
                            src="http://localhost/engtest/images/image2/eol system/button/logout-06.png"
                            style="margin-top:10px; margin-left:20px;" /></a>
                </div>
            </div>
        </div>
        <!------- main content--------->
        <div id="content">
            <div id="pic_border">
                <img src="http://localhost/engtest/images/image2/eol system/head-box-02.png" width="1024" />
            </div>

            <div id="content-div">

                <?php

if ($_SESSION["x_member_id"] != '') {
    include("eoloption.php");
}

?>
            </div>

            <div class='modal1' id='prompt1'>
                <h2> Rename Group</h2>
                <!-- input form. you can press enter too -->
                <form method="post" action='?section=business&&action=re_group'>
                    <input type="text" name="rename" id="rename"
                        style="width:220px; height:25px; border:1px solid #666; padding-left:5px;"><input type="text"
                        name="idrename" id="idrename" readonly style="border:none;color:#fff;" class="txt_rename">
                    <br><br>
                    <font id="txt_alert" style="color:red;display:none;"> ไม่สามารถเปลี่ยนชื่อ None Group ได้ </font>
                    <br>
                    <input type="submit" id="btn_rename" value="Save" class="btntest btn-save"
                        style="cursor:pointer;" />
                    <input type="button" value="Cancel" class="close btntest btn-cancel"
                        style="cursor:pointer;margin-left:10px;" />
                </form>
            </div>

            <div class='modal1' id='prompt2'>
                <h2> Edit Sub Account</h2>
                <!-- input form. you can press enter too -->
                <form method="post" action=''>
                    <b>New Username :</b> <input type="text" name="rename-subAcc" id="rename-subAcc"
                        style="width:195px; height:25px; border:1px solid #666;margin-left:16px;padding-left:5px;">
                    <input type="text" name="idre-sub" id="idre-sub" readonly style="border:none;color:#fff;width:70px;"
                        class="txt_rename"><br><br>
                    <b>New Password :</b><input type="password" name="pass" id="pass"
                        style="width:200px; height:25px; border:1px  solid #666;margin-left:22px;"><br><br>
                    <b>Re-New password :</b><input type="password" name="re-pass" id="re-pass"
                        style="width:200px; height:25px; border:1px  solid #666;"><br><br><br>
                    <div id="imgload" style="display:none; margin-top:10px; margin-left:130px;"> <img
                            src="http://localhost/engtest/images/image2/eol system/loading2.gif" /></div>
                    <div id="editerror" style="margin-top:-20px;float:right;height:30px;width:250px;"></div>
                    <input type="button" id="btn_rename" value="Save" class="btntest btn-save"
                        style="cursor:pointer;margin-left:130px;" onclick="edit_subAcc_Call()" />
                    <input type="button" value="Cancel" class="close btntest btn-cancel"
                        style="cursor:pointer;margin-left:30px;" />
                </form>
            </div>

        </div>
        <!-----------end main cotent------------>
    </div>

    <!------------------- footer -------------->
    <div>
        <!-- < include '../inc/footer-inner.php'; ?> -->
        <!-- < footer(); ?> -->
        <center style="margin-bottom:10px; margin-top:-3px;"><b>Copyright © 2022 By English Online Co.,Ltd. All rights
                reserved.</b>
        </center>
    </div>
    <script src='http://localhost/engtest/bootstrap/js/jquery.min.js'></script>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery-tools/1.2.7/jquery.tools.min.js'>
    </script>
    <script>
    const tabs = document.querySelectorAll('[data-tab-target]');
    const tabContents = document.querySelectorAll('[data-tab-content]')
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = document.querySelector(tab.dataset.tabTarget);
            tabContents.forEach(tabContent => {
                tabContent.classList.remove('active');
            })
            tabs.forEach(tab => {
                tab.classList.remove('active');
            })
            tab.classList.add('active');
            target.classList.add('active');
        })
    })
    </script>
    <script>
    $(document).ready(function() {
        var triggers = $('.modalInput').overlay({
            mask: {
                color: '#666',
                loadSpeed: 100,
                opacity: 0.7
            },

            closeOnClick: true,
            top: 100
        });
    });

    function rename() {
        var idname = $('#group_id').val();
        if (idname != 0) {
            var namegroup = $("#group_id :selected").text();
            var name = namegroup.split('[');
            $("#rename").val(name[0]);
            $("#idrename").val(idname);
            $("#btn_rename").removeAttr("disabled");
            $("#txt_alert").hide();
        } else {
            $("#btn_rename").attr("disabled", "disabled");
            $("#txt_alert").show();
        }
    }

    function alt1() {
        var id = $("#idre-sub").val();
        var name = $("#rename-subAcc").val();
        alert(name + id);
    }

    function edit_subAcc(Obj) {
        var id = Obj.id;
        //$(Obj).attr("data-user").val();
        $("#rename-subAcc").val($("#userdata_" + id).text());
        $("#idre-sub").val(id);
        $("#pass").val("")
        $("#re-pass").val("")
        $("#editerror").html("");
        //alert($("#idre-sub").val());
    }

    function clear() {
        $("#editerror").val("");
    }

    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
            vars[key] = value;
        });
        return vars;
    }



    function edit_subAcc_Call() {
        var idsub = $("#idre-sub").val();
        let page = getUrlVars()["page"];

        if (!page) {
            page = '1';
        }

        $.ajax({
            type: "POST",
            url: "edit_subAcc.php",
            data: {
                rename: $("#rename-subAcc").val(),
                newpass: $("#pass").val(),
                repass: $("#re-pass").val(),
                member: idsub
            },
            beforeSend: function() {
                $("#imgload").show();
            },
            complete: function() {
                $("#imgload").hide();
            },
            success: function(response) {
                $("#poduct_order").html(response);

                if (response == 'OK') {
                    window.location = "eoltest.php?section=business&&page=" + page;
                } else {
                    $("#editerror").html(response);
                }
                // cal_price();
            },
            error: function(error) {
                $("#editerror").html(error);
            }
        });
    }
    $(function() {
        $(window).bind("beforeunload", function(event) {

            var msg = "ยืนยันต้องการปิดหน้านี้ ?";
            $(window).bind("unload", function(event) {
                event.stopImmediatePropagation();

                $.ajax({
                    type: "POST",
                    url: "../inc/updatetimeout.php",
                    data: '',
                    success: function(response) {
                        if (response == 'OK') {
                            alert(msg);
                        }
                    },
                    async: false
                });
            });
            return;
        });
        $("a").click(function() {
            $(window).unbind("beforeunload");
        });
    });

    function changelistExam(obj) {
        var idinput = $(obj).attr('data-select');
        var level = $('#level' + idinput).val();
        var skill = $('#skill_id' + idinput).val();
        //alert(skill +'  '+level); 
        $.ajax({
            type: "POST",
            url: "addExamlist.php",
            data: {
                label: 'change',
                skill_id: skill,
                level_id: level
            },
            beforeSend: function() {
                $("#imgloading").show();
            },
            complete: function() {
                $("#imgloading").hide();
            },
            success: function(response) {
                $('#topic' + idinput).html(response);
            },
            error: function(error) {
                //$("#showpost").append('<p align="center"></p>');
            }
        });
    }

    function Input_Eng() {
        if (event.keyCode >= 3585) {
            event.returnValue = false;
        }
    }

    function checknum() {
        if (event.keyCode < 48 || event.keyCode > 57) {
            event.returnValue = false;
        }
    }

    function addNewExam() {
        var numquiz = 0;
        $('input[name="num[]"]').each(function() {
            numquiz += parseInt($(this).val());
        });
        if (numquiz < 30) {
            $.ajax({
                type: "POST",
                url: "addExamlist.php",
                data: {
                    label: 'newlist'
                },
                beforeSend: function() {
                    $("#imgloading").show();
                },
                complete: function() {
                    $("#imgloading").hide();
                },
                success: function(response) {
                    $('#tbcreate').append(response);
                },
                error: function(error) {
                    //$("#showpost").append('<p align="center"></p>');
                }
            });
        }
    }

    // function newexam() {
    //     var tr = $('<tr ><td><select name="skill_id" style="float:left;"class="selector">' +
    //         '<option value=1 > Reading Comprehension</option>' +
    //         '<option value=2 > Listening Comprehension</option>' +
    //         '<option value=3 > Semi - Speaking</option>' +
    //         '<option value=4 > Semi - Writing</option>' +
    //         '<option value=7 > Vocabulary </option>' +
    //         '<option value=5 > Grammar </option>' +
    //         '<option value=10 > Multiple Skills </option>' +
    //         '</select></td><td>' +
    //         '<select name="level1" style="float:left;" class="selector">' +
    //         '<option value=1 >Beginner</option>' +
    //         '<option value=2 >Lower Intermediate</option>' +
    //         '<option value=3 >Intermediate</option>' +
    //         '<option value=4 >Upper Intermediate</option>' +
    //         '<option value=5 >Advanced </option>' +
    //         '</select>' +
    //         '<select name="topic1" style="width:300px;margin-left:5px; margin-right:5px;" class="selector">' +
    //         ' <option value=1 >music</option>' +
    //         '<option value=2 >Lower Intermediate</option>' +
    //         '<option value=3 >Intermediate</option>' +
    //         '<option value=4 >Upper Intermediate</option>' +
    //         '<option value=5 >Advanced </option>' +
    //         '</select>จำนวน <input type="text" class="txtdetail" style="width:50px;"/>ข้อ<button class="btnremove_exam" onclick="javascript:Removetr(this);"></button></td>' +
    //         '</tr>');
    //     $('#tbcreate').append(tr);
    // }

    function Removetr(obj) {
        $(obj).parent().parent().remove();
    }

    /*$.ajax({
    type: "POST",
    url: "listproduct.php",
    data: {action:'listproduct',idcard:id},
    beforeSend: function() {
           // $("#imag_load").show();
    },
    complete: function() {
            //$("#imag_load").hide();
    },        
    success: function(response)
     { 
             $("#tbl_list_order").html('');		  
	        $("#tbl_list_order").html(response);
			 cal_price();
		   },
	error: function(error) {
			//$("#showpost").append('<p align="center"></p>');
     }
     });  */
    </script>
</body>

</html>