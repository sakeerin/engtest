<?php 
if(!$_GET["fname"]){
  $fname = "";
}
if(!$_GET["lname"]){
  $lname = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example that shows off a responsive product landing page.">

    <title>GET Certificate - Report</title>
</head>

<body>
    <center>
        <img src="https://www.engtest.net/gepot/Main Banner GEPOT.jpg" width="40%" />
        <form action="<?php $_PHP_SELF ?>" method="get" name="form1" class="pure-form pure-form-stacked">
            <table width="361" border="0">
                <tr>
                    <td colspan="4" align="center"><label for="Report3">
                            <font color="#FF9900" size="5"><strong>GET Certificate - Report</strong></font>
                        </label></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>Name Title</td>
                    <td>:</td>
                    <td colspan="2">
                        <select name="first">
                            <option value="dekch" name="dekch"
                                <?php if($_GET['first'] == 'dekch') { echo "selected"; } ?>>
                                ด.ช.</option>
                            <option value="dekyn" name="dekyn"
                                <?php if($_GET['first'] == 'dekyn') { echo "selected"; } ?>>
                                ด.ญ.</option>
                            <option value="nine" name="nine" <?php if($_GET['first'] == 'nine') { echo "selected"; } ?>>
                                นาย</option>
                            <option value="nang" name="nang" <?php if($_GET['first'] == 'nang') { echo "selected"; } ?>>
                                นาง
                            </option>
                            <option value="nangs" name="nangs"
                                <?php if($_GET['first'] == 'nangs') { echo "selected"; } ?>>
                                น.ส.</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="85">Name</td>
                    <td width="14">:</td>
                    <td colspan="2"><input name="fname" type="text" maxlength="50"
                            value="<?php if($_GET['fname'] != '') { echo $_GET['fname']; } ?>"
                            placeholder="กรุณากรอกชื่อ..." required /></td>
                </tr>
                <tr>
                    <td><label for="lname">Lastname</label></td>
                    <td>:</td>
                    <td colspan="2"><input name="lname" type="text" maxlength="50"
                            value="<?php if($_GET['lname'] != '') { echo $_GET['lname']; } ?>"
                            placeholder="กรุณากรอกนามสกุล..." required /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td width="122"><input type="submit" name="Submit" value="Submit"
                            class="pure-button pure-button-primary" /></td>
                    <td width="177"><input type="button" name="Reset" value="Reset"
                            class="pure-button pure-button-primary"
                            onclick="window.location='http://localhost/engtest/EOL/get_certificate_gepot_th.php';" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                </tr>
            </table>
        </form>
        <?php 
    if($_GET["Submit"]){
        if ($_GET["first"] == "dekch") {
            $first = "ด.ช.";
        }
        else if ($_GET["first"] == "dekyn") {
            $first = "ด.ญ.";
        }
        else if ($_GET["first"] == "nine") {
            $first = "นาย";
        }
        else if ($_GET["first"] == "nang") {
            $first = "นาง";
        }
        else {
            $first = "น.ส.";
        }
        if($_GET["fname"]){
            $fname = $_GET["fname"];
        }
        if($_GET["lname"]){
            $lname = $_GET["lname"];
        }
        $file = $fname." ".$lname.".pdf";

        result($first,$fname,$lname,$file);
    }
	
	function result($first,$fname,$lname,$file) 
	{
        ini_set("display_errors", "1");
        error_reporting(E_ALL);
		require("fpdf/fpdf.php");

		define('FPDF_FONTPATH','font/');
		
		$pdf = new FPDF('L','mm','A4');
		$pdf->AddPage();
		$pdf->SetXY(0,0); 
		$pdf->Image('../EOL/GEPOT/GEPOT15/Certificate GEPOT15 Thai.jpg','0','0','-150','-150');
		$pdf->AddFont('cordia','B','cordiab.php');
		$pdf->SetFont('cordia','B',26);
		$pdf->SetY(71);
		$pdf->Cell(280,65,iconv('UTF-8','TIS-620',$first." ".$fname." ".$lname),0,1,"C");
        $pdf->SetFont('cordia','B',22);
        $pdf->SetY(83);
		$pdf->Output("Report/".$file,"F");
		
		$print = "<a href='http://localhost/engtest/EOL/Report/$file' target=_blank class='pure-menu-link'>Download Certificate</a>";
       
		if ($_GET['fname'] != "" && $_GET['lname'] != "") {
			echo $print;
		}else{
            echo " <font size=2 face=tahoma color=red>Please fill out all fields.</font> ";
        }
    }
?>
    </center>
</body>

</html>