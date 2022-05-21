<?php
function getmedia($id)
{
    //echo $id;
    include('../config/connection.php');

    // $table = "tb_questions_mapping";
    // $where = " where QUESTIONS_ID='$id' ";
    // $relate_query = mysql_query("SELECT * FROM $table $where");
    // $is_relate = mysql_num_rows($relate_query);

    $strSQL = "SELECT * FROM tb_questions_mapping  WHERE QUESTIONS_ID = ?";
    $stmt = $conn->prepare($strSQL);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $is_relate = $result->num_rows;

    if ($is_relate == 1) {
        // $relate_data = mysql_fetch_array($relate_query);
        $relate_data = $result->fetch_array();
        $relate_id = $relate_data['GQUESTION_ID'];

        // $table = "tbl_gquestion";
        // $where = " where GQUESTION_ID='$relate_id' ";
        // $relate_query = mysql_query("SELECT * FROM $table $where");
        // $relate_data = mysql_fetch_array($relate_query);
        // $relate_type = $relate_data[GQUESTION_TYPE_ID];
        // $relate_text = $relate_data[GQUESTION_TEXT];

        $SQL = "SELECT * FROM tb_gquestion WHERE GQUESTION_ID = ? ";
        $query = $conn->prepare($SQL);
        $query->bind_param("s", $relate_id);
        $query->execute();
        $result_data = $query->get_result();
        // $is_relate = $result->num_rows;
        $relate_data = $result_data->fetch_array();
        $relate_type = $relate_data['GQUESTION_TYPE_ID'];
        $relate_text = $relate_data['GQUESTION_TEXT'];
        $query->close();

        if ($relate_type == 1) {
            $msg_relate = $relate_text;
        }
        if ($relate_type == 3) {
            if (is_mobile()) {
                $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $relate_text);
                $relate_text = str_replace(".flv", ".mp3", $relate_text);
                $msg_relate = "	<div align=center>
									<br>
		    							<audio controls='controls' preload='none'> 
                                             <source src='https://www.engtest.net/files/sound/" . $relate_text . "'>  
                                        </audio>
									<br>;
								</div> ";
            }
            else {
                $relate_text = str_replace("/home/engtest/domains/engtest.net/public_html/files/sound/", "", $relate_text);
                $relate_text = str_replace(".flv", ".mp3", $relate_text);
                $msg_relate = '<audio id="audio" controls="controls" > <source src="http://www.engtest.net/files/sound/' . $relate_text . '"></audio>';
            }
        }
        if ($relate_type == 2) {
            $msg_relate = str_replace("/home/engtest/domains/engtest.net/public_html/", "", "../" . $relate_text);
            $msg_relate = "<div align=center><img src='$msg_relate' border=0 width=300></div>";
        }
    }
    $stmt->close();
    return $msg_relate;
}
?>