<!DOCTYPE html>
<html lang="zh-TW">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../common.css">
    </head>
<?php 
    include_once '../db_conn.php';

    function query_result($stm){  //輸出成html表格
        $ID = 0;
        $name = "";
        $money = 0;
        $phone = "";
        $stm->bind_result($ID,$name,$money,$phone);
        echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>姓名</th>
            <th>金額</th>
            <th>電話</th>
        </tr>
    ";
        while($stm->fetch()){
            echo "<tr>";
            echo "<td>".$ID."</td>";
            echo "<td>".$name."</td>";
            echo "<td>".$money."</td>";
            echo "<td>".$phone."</td>";
            echo "</tr>";
        }
    }
?>
<!-- 查詢使用者資訊 !-->
<body>
    <div class="main-container">
    <form method="POST" action="user_info.php">
        姓名 : <input type='text' name='user_name'> <br>
        <button type="submit">查詢</button>
    </form>
    <form method="POST" action="user_info.php">
        ID : <input type='text' name='user_ID'> <br>
        <button type="submit">查詢</button>
    </form>
    <button onclick="window.location.href='../index.php'">返回</button>
<?php 


    try {
        if(isset($_POST['user_name'])){
            $query = ("SELECT * from users WHERE user_name = ?");
            $stmt = $conn->prepare(($query));
            $stmt->execute(array($_POST['user_name']));
            query_result(($stmt));
        }else if(isset($_POST['user_ID'])){
            $query = ("SELECT * from users WHERE user_ID = ?");
            $stmt = $conn->prepare(($query));
            $stmt->execute(array($_POST['user_ID']));
            query_result(($stmt));
        }
        
    } catch (Exception $e) {
        echo '<div class="error-message">錯誤訊息: ' . $e->getMessage() . '</div>';
    }



?>
    </div>
</body>
</html>