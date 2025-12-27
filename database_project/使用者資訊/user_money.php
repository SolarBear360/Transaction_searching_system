<!DOCTYPE html>
<html lang="zh-TW">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../common.css">
    </head>
<?php 
    include_once '../db_conn.php';
?>
<!-- 計算使用者購買所有訂單後金額 !-->
<body>
    <div class="main-container">
    <form method="POST" action="user_money.php">
        ID : <input type='text' name='user_ID' required> <br>
        <button type="submit">結算</button>
    </form>
    <button onclick="window.location.href='../index.php'">返回</button>
<?php 
    if(isset($_POST['user_ID'])){
        $query = ("SELECT user_name, money-COALESCE(sum(item_price*quantity),0) as remain_money
                    FROM (users LEFT OUTER JOIN transactions USING(user_ID))LEFT OUTER JOIN items USING(item_ID)
                    GROUP BY users.user_ID, users.user_name, users.money, users.phone
                    HAVING users.user_ID = ? ");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($_POST['user_ID']));
        $stmt->bind_result($name,$remain_money);

        echo "<table border=1><tr>
            <th>姓名</th>
            <th>剩餘</th>
        </tr>";
        while($stmt->fetch()){
            echo "<tr>
                <td>$name</td>
                <td>$remain_money</td>
            </tr>";
        }

    }


?>
    </div>
</body>
</html>