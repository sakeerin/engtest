<?php
session_start();
main_test();
function main_test()
{
    // echo "This is main test or cost test";
    echo "
        <div id='test' style='position:absolute;margin-top:115px;margin-left:40px;z-index:100;'>
            <a href='?section=business&&action=academic'>
                <img class='img_hover' src='https://www.engtest.net/image2/eol system/test-evaluation-new.png' width='219' height='213' />
            </a>
        </div>

        <div id='report' style='position:absolute;margin-top:110px;margin-left:330px;z-index:100;'>
            <a href='?section=business&&action=report'>
                <img class='img_hover' src='https://www.engtest.net/image2/eol system/report-new.png' width='219' height='213 />
            </a>
        </div>
        
        <div id='lesson' style='position:absolute;margin-top:165px;margin-left:400px;z-index:100;'>
            <a href='../lessons/elearning.php'>
                <img class='img_hover' src='https://www.engtest.net/image2/eol system/lessons-new.png' width='219' height='213' />
            </a>
        </div>";
    if ($_SESSION["coporate"] == true) {
        echo " <div id='coporate' style='position:absolute;margin-top:580px;left:0px;margin-left:330px;z-index:100;'><a href='http://localhost/engtest/corporate/ecop.php'><img class='img_hover' src='https://www.engtest.net/image2/eol system/ecop/corporate-icon-new.png' width='219' height='213' /></a></div>";
    }

    echo "
        <div id='standardtest' style='position:absolute;margin-top:580px;left:0px;margin-left:40px;z-index:100;'>
            <a href='standardtest.php'>
                <img class='img_hover' src='https://www.engtest.net/image2/eol system/standart-test-new.png' width='219' height='213' />
            </a>
        </div>
		
        <div id='back_to_home' style='position:absolute;margin-top:870px; margin-left:120px;'>
            <a href='http://localhost/engtest/index.php'>
				<img src='https://www.engtest.net/image2/eol system/button/back to home-10.png' border=0>
           </a>
        </div>
    	<img src='https://www.engtest.net/image2/eol system/bg-resize.jpg' width='100%' height='1074' style='border-radius:10px;'/>";
}
?>