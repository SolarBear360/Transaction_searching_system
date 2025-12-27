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
<!-- 使用者儲值 !-->
<body>
    <div class="main-container">
    <form method="POST" action="user_add_money.php">
        ID : <input type='text' name='user_ID' required> <br>
        金額 : <input type='text' name='money' required> <br>
        <button type="submit">儲值</button>
    </form>
        <button onclick="window.location.href='../index.php'">返回</button>

<?php 
    //若輸入金額 > 0 則增加持有金額
    if(isset($_POST['user_ID']) && isset($_POST['money']) && $_POST['money'] > 0){
        try {
            $query = ("UPDATE users set money = money + ? WHERE user_ID = ?");
            $stmt = $conn->prepare(($query));
            $stmt->execute(array($_POST['money'],$_POST['user_ID']));
        } catch (Exception $e) {
            echo '<div class="error-message">錯誤訊息: ' . $e->getMessage() . '</div>';
        }
    }


?>
    </div>
</body>
</html>