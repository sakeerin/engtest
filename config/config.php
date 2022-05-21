<?php
    function config()
    {
        
			$sql["host_connect"] 	= "localhost";

			$sql["user_connect"] 	= "root";

			$sql["pass_connect"] 	= "";

			$sql["db_name"]		= "engtest_online";

			//-----------------------------------------------------------------------------------------//

			$sql["tb_card"] = "tbl_user_pass";

			$sql["tb_card_type"] = "tbl_user_pass_type";

			$sql["tb_card_time"] = "tbl_user_pass_time";

			$sql["tb_member"] = "tbl_member";

			$sql["tb_result"] = "tbl_test_result";

			$sql["tb_result_detail"] = "tbl_result_detail";

			$sql["tb_order_list"] = "tbl_order_list";

			$sql["tb_order_detail"] = "tbl_order_detail";

			$sql["tb_order_event"] = "tbl_order_event";

			$sql["tb_order_event_detail"] = "tbl_order_event_detail";

			$sql["tb_register"] = "tbl_order_register";

			$sql["tb_product"] = "tbl_order_product";

			$sql["tb_order_admin"] = "tbl_order_admin";

			$sql["tb_agent"] = "tbl_order_agent";

			$sql["tb_card_time"] = "tbl_user_pass_time";

			$sql["tb_question"] = "tbl_questions";

			$sql["tb_answer"] = "tbl_answers";

			$sql["tb_skill"] = "tbl_item_skill";

			$sql["tb_sskill"] = "tbl_item_sskill";

			$sql["tb_reason"] = "tbl_item_detail";

			$sql["tb_relate_data"] = "tbl_gquestion";

			$sql["tb_quiz_map"] = "tbl_questions_mapping";

			$sql["tb_section"] = "tbl_test";

			$sql["tb_level"] = "tbl_item_level";

			$sql["tb_admin"] = "tbl_admin";

			$sql["tb_etest"] = "tbl_etest";

			$sql["tb_etest_detail"] = "tbl_etest_mapping";

			$sql["tb_card_etest"] = "tbl_card_etest";

			$sql["tb_free_etest_mem"] = "tbl_free_etest_member";

			$sql["tb_description"] = "tbl_description";

			$sql["tb_quiz_comment"] = "tbl_quiz_comment";

			$sql["tb_e_switch"] = "tbl_e_switch";

			$sql["tb_sell_member"]="tbl_sell_member";

			$sql["tb_sell_order"]="tbl_sell_order";

			$sql["tb_x_quiz"] = "tbl_x_quiz";

			$sql["tb_x_relate"] = "tbl_x_relate";

			$sql["tb_x_quiz_relate"] = "tbl_x_quiz_relate";

			$sql["tb_x_ans_select"] = "tbl_x_ans_select";

			$sql["tb_x_ans_text"] = "tbl_x_ans_text";

			$sql["tb_x_faq1year"] = "tbl_x_faq1year";

			$sql["tb_x_faq_ans1year"] = "tbl_x_faq_ans1year";

			$sql["tb_x_log_member"] = "tb_x_log_member";

			$sql["tbl_x_log_member_1year"] = "tb_x_log_member_1year";

			$sql["tbl_eventest"] = "tbl_eventest";



			$sql["tb_x_member"] = "tb_x_member";

			$sql["tb_x_general"] = "tbl_x_member_general";

			$sql["tb_x_general_login"] = "tbl_x_general_login";

			$sql["tb_x_general_time"] = "tbl_x_general_time";

			$sql["tb_x_log_member_general"] = "tbl_x_log_member_general";

			$sql["tb_w_result_general"] = "tbl_w_result_general";

			$sql["tb_w_result_general_detail"] = "tbl_w_result_general_detail";

			$sql["tb_x_member_1year"] = "tb_x_member_1year";

			$sql["tb_x_member_time"] = "tb_x_member_time";

			$sql["tb_x_member_amount"] = "tb_x_member_amount";

			$sql["tb_x_member_sub"] = "tb_x_member_sub";

			$sql["tb_x_member_etest"] = "tbl_x_member_etest";

			$sql["tb_x_member_type"] = "tb_x_member_type";

			$sql["tb_x_card"] = "tbl_x_card";

			$sql["tb_x_card_type"] = "tbl_x_card_type";

			$sql["tb_x_section"] = "tbl_x_section";

			$sql["tb_x_part"] = "tbl_x_part";

			$sql["tb_x_level"] = "tbl_x_level";

			$sql["tb_x_result"] = "tbl_x_result";

			$sql["tb_x_result_detail"] = "tbl_x_result_detail";

			$sql["tb_x_result_detail_text"] = "tbl_x_result_detail_text";

			$sql["tb_x_result_detail_select"] = "tbl_x_result_detail_select";

			$sql["tb_x_result_detail_group"] = "tbl_x_result_detail_group";

			$sql["tb_w_result"] = "tbl_w_result";

			$sql["tb_w_result_detail"] = "tbl_w_result_detail";

			$sql["tb_x_1year_week51"] = "tbl_x_1year_week51";

			$sql["tb_x_login"] = "tb_x_login";

			$sql["tb_x_member_total"] = "tb_x_member_total";

			$sql["tb_x_member_refill"] = "tbl_x_member_refill";

			$sql["tb_x_member_spacial"] = "tb_x_member_spacial";

			

			$sql["tb_webboard_forum"] = "tbl_webboard_forum";

			$sql["tb_webboard_topic"] = "tbl_webboard_topic";

			$sql["tb_webboard_reply"] = "tbl_webboard_reply";

			$sql["tb_webboard_message"] = "tbl_webboard_message";

			$sql["tb_webboard_block"] = "tbl_webboard_block";

			$sql["tb_webboard_admin"] = "tbl_webboard_admin";

			$sql["tb_webboard_ban"] = "tbl_webboard_ban";

			$sql["tb_webboard_report_topic"] = "tbl_webboard_report_topic";

			$sql["tb_webboard_report_reply"] = "tbl_webboard_report_reply";

			$sql["tb_webboard_online"] = "tbl_webboard_online";

			// ------------------------ //
			$sql["tb_topic"] = "tb_web_topic";

			$sql["tb_admin"] = "tb_web_admin";

			// ------------------------ //
			// $sql[tb_log_eoltest] = "tbl_log_eoltest";

			// $sql[tb_log_eventest] = "tbl_log_eventest";

			// $sql[tb_w_result_gepot] = "tbl_w_result_gepot";

			// //-----------------------------------------------------------------------------------------//
			// $sql[tb_t_member] = "tbl_test_member";

			return $sql;

    }

    function web_config()
	{

			$sql["host_connect"] 	= "localhost";

			$sql["user_connect"] 	= "engtest_old";

			$sql["pass_connect"] 	= "sTEZY1UM";

			$sql["db_name"] 		= "engtest_old";

			//-----------------------------------------------------------------------------------------//

			$sql["tb_admin"] = "tb_web_admin";

			$sql["tb_permission"] = "tb_web_permission";

			$sql["tb_type"] = "tb_web_type";

			$sql["tb_topic"] = "tb_web_topic";

			$sql["tb_reply"] = "tb_web_reply";

			$sql["tb_webboard_member"] = "tb_web_webboard_member";

			$sql["tb_feedback"] = "tb_web_feedback";

			$sql["tb_school"] = "tb_web_school";

			$sql["tb_face_contest"] = "tb_face_contest";

			$sql["tb_web_useronline"] = "tb_web_useronline";

			$sql["tb_comment"] = "tb_web_comment";

			$sql["tb_google"] = "tb_web_google";

			$sql["tb_game_type"] = "tb_web_game_type";

			$sql["tb_game_hang_man"] = "tb_web_game_hang_man";

			$sql["tb_chatroom"] = "tb_web_chatroom";

			$sql["tb_game_fantasy_class"] = "tb_web_game_fantasy_class";

			$sql["tb_game_fantasy_player"] = "tb_web_game_fantasy_player";

			$sql["tb_game_fantasy_monster"] = "tb_web_game_fantasy_monster";

			$sql["tb_game_fantasy_enemy"] = "tb_web_game_fantasy_enemy";

			//-----------------------------------------------------------------------------------------//

			return $sql;

	}
    function connect($sql)
	{

		$host_connect = $sql["host_connect"];

		$user_connect = $sql["user_connect"];

		$pass_connect = $sql["pass_connect"];

		$db_connect = $sql["db_name"];

        $connect = mysqli_connect($host_connect, $user_connect, $pass_connect,$db_connect) or die("Connect failed");

		// mysqli_query("SET character_set_results=utf8");

		// mysqli_query("SET character_set_client=utf8");

		// mysqli_query("SET character_set_connection=utf8");

		return $connect;			

	}

    // function insert()
    // {
    //     $input = "INSERT INTO $table SET $value";

	// 	$result= mysqli_query($input);

	// 	return $result;
    // }

    // function delete($table,$where)
	// {

	// 	$input ="delete from $table $where";

	// 	$result = mysqli_query($input);

	// }
    // function update($table,$value,$where)
	// {

	// 	$input = "UPDATE $table SET $value $where";

	// 	$result = mysqli_query($input);

	// 	return $result;

	// }

    // function select($table,$where)
	// {

	// 	$input = "select * from $table $where";

	// 	$result = mysqli_query($input);

	// 	return $result;

	// }

	// function date_dif($date_in,$date_out)
	// {

	// 	$format = "-";

	// 	$array_date_in = explode($format,$date_in);

	// 	$array_date_out = explode($format,$date_out);

	// 	$date_in = gregoriantojd($array_date_in[1], $array_date_in[2], $array_date_in[0]);

	// 	$date_out = gregoriantojd($array_date_out[1], $array_date_out[2], $array_date_out[0]);

	// 	$total = $date_out - $date_in;

	// 	return $total;

	// }

?>