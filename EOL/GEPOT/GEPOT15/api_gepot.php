<?php
include('../config/connection.php');
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $etest = 2;
    $tb_etest = "SELECT ETEST_ID FROM tb_etest WHERE IS_EST = ?";
    $stmt_etest = $conn->prepare($tb_etest);
    $stmt_etest->bind_param("i", $etest);
    $stmt_etest->execute();
    $result = $stmt_etest->get_result();
    $data_result = $result->fetch_array();
    $etest_id = $data_result[0];
    $stmt_etest->close();

    // $tb_etest_mapping = "SELECT * FROM tb_etest_mapping WHERE ETEST_ID = ?";
    // $stmt_etest_mapping = $conn->prepare($tb_etest_mapping);
    // $stmt_etest_mapping->bind_param("i", $etest_id);
    // $stmt_etest_mapping->execute();
    // $result_etest_map = $stmt_etest_mapping->get_result();
    // $quiz_num = $result_etest_map->num_rows;
    $question_text = array();
    //-------------------------//
    $count = 0;
    for ($k = 1; $k <= 4; $k++) {
        if ($k == 1) {
            $skill_id = 2;
        }
        if ($k == 2) {
            $skill_id = 1;
        }
        if ($k == 3) {
            $skill_id = 5;
        }
        if ($k == 4) {
            $skill_id = 4;
        }

        $msg = "SELECT A.QUESTIONS_ID,B.QUESTIONS_TEXT FROM tb_etest_mapping AS A,tb_questions AS B WHERE A.ETEST_ID = ? && A.QUESTIONS_ID=B.QUESTIONS_ID  && B.SKILL_ID= ? ORDER BY B.QUESTIONS_ID ASC";

        $stmt_map = $conn->prepare($msg);
        $stmt_map->bind_param("ii", $etest_id, $skill_id);
        $stmt_map->execute();
        $result_map = $stmt_map->get_result();
        $num = $result_map->num_rows;

        for ($i = 1; $i <= $num; $i++) {
            $data = $result_map->fetch_array();
            $id_quiz[$count] = $data['QUESTIONS_ID'];
            $quiz_text[$count] = $data['QUESTIONS_TEXT'];
            $count = $count + 1;
        }
        $stmt_map->close();

    }
    //--------------------------//

    for ($i = 0; $i < 100; $i++) {
        // $quiz = $result_etest_map->fetch_array();
        // $quiz_id = $quiz['QUESTIONS_ID'];
        // $msg_question = "SELECT QUESTIONS_TEXT FROM tb_questions WHERE QUESTIONS_ID = ?";
        // $stmt_question = $conn->prepare($msg_question);
        // $stmt_question->bind_param("s", $id_quiz[$i]);
        // $stmt_question->execute();
        // $result_question = $stmt_question->get_result();
        // $question = $result_question->fetch_array();
        $question_text['question'][$i] = trim($quiz_text[$i]);
        // $stmt_question->close();

        $msg_q_map = "SELECT GQUESTION_ID FROM tb_questions_mapping where QUESTIONS_ID = ?";

        $stmt_q_map = $conn->prepare($msg_q_map);
        $stmt_q_map->bind_param("s", $id_quiz[$i]);
        $stmt_q_map->execute();
        $result_q_map = $stmt_q_map->get_result();
        $qquestion_map = $result_q_map->fetch_array();
        $gquiz_id[$i] = $qquestion_map[0];
        $stmt_q_map->close();

        $smg_question = "SELECT GQUESTION_TYPE_ID,GQUESTION_TEXT FROM tb_questions_relate WHERE GQUESTION_ID = ?";
        $stmt_question_relate = $conn->prepare($smg_question);
        $stmt_question_relate->bind_param("s", $gquiz_id[$i]);
        $stmt_question_relate->execute();
        $result_question_relate = $stmt_question_relate->get_result();
        $question_relate = $result_question_relate->fetch_array();

        // if ($i > 0) {
        //     if ($gquiz_id[$i - 1] != $gquiz_id[$i]) {
        //         if (!$question_text['relate_text'][$i]) {
        //             $question_text['relate_text'][$i] = $question_relate['GQUESTION_TEXT'];
        //         }
        //     }
        // }
        // else {
        //     if (!$question_text['relate_text'][$i]) {
        //         $question_text['relate_text'][$i] = $question_relate['GQUESTION_TEXT'];
        //     }
        // }
        if ($gquiz_id[$i - 1] != $gquiz_id[$i]) {
            if (!$question_text['relate_text'][$i]) {
                $question_text['relate_text'][$i] = $question_relate['GQUESTION_TEXT'];
            }
        }
        $question_text['relate_type'][$i] = $question_relate['GQUESTION_TYPE_ID'];
        $stmt_question_relate->close();

        $msg_answer = "SELECT ANSWERS_TEXT,ANSWERS_CORRECT FROM tb_answers WHERE QUESTIONS_ID= ? ";
        $stmt_answer = $conn->prepare($msg_answer);
        $stmt_answer->bind_param("s", $id_quiz[$i]);
        $stmt_answer->execute();
        $result_answer = $stmt_answer->get_result();
        $answer_num = $result_answer->num_rows;

        for ($j = 0; $j < $answer_num; $j++) {
            $data_answer = $result_answer->fetch_array();
            $question_text['answer_text'][$i][$j] = trim($data_answer['ANSWERS_TEXT']);
            $question_text['answer_correct'][$i][$j] = trim($data_answer['ANSWERS_CORRECT']);
        }
        $stmt_answer->close();

    }
    echo json_encode($question_text);
    mysqli_close($conn);


}
elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
    echo 'This is POST';
}
else {
    http_response_code(405);
}
;

?>