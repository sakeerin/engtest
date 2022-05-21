<?php
    $host = 'localhost';
    $user = 'root';
    $pwd = '';
    $dbname = 'engtest_online';

    // $dsn = 'mysql:host='. $host .';dbname='.$dbname;

    try {
        $dbcon = new PDO("mysql:host=$host;dbname=$dbname",$user,$pwd);
        $dbcon->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        // echo "Connect to database successful";
    } catch (PDOException $e) {
        echo "Faild to connect to database";
    }
    // $pdo = new PDO($dsn, $user, $pwd);
    // $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

    // $type_id = '03-03';
    // $topic_id = '4804';
    // $active = '1';
    
    // $sql = "SELECT * FROM tb_web_type ,tb_web_topic,tb_web_admin WHERE tb_web_type.type_id=:type_id AND tb_web_topic.topic_id=:topic_id AND tb_web_topic.topic_active=:active ";

    // $sql = 'SELECT * FROM tb_web_topic';

    // $stmt = $dbcon->prepare($sql);
    // $stmt->bindParam(':type_id',$type_id,PDO::PARAM_STR);
    // $stmt->bindParam(':topic_id',$topic_id,PDO::PARAM_STR);
    // $stmt->bindParam(':active',$active,PDO::PARAM_STR);
    // $stmt->execute();
    // $result = $stmt->fetch();
    // var_dump($result);
    

    // $stmt->execute();
    // $result = $stmt->fetchAll();
    // var_dump($result);
    

    // echo "Hello";

    

    
    
?>