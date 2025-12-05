<!DOCTYPE html>
<html lang="zh-TW">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
<?php 
//------------------------------    用本地端的帳密
    $db_host = 'localhost';
    $username = 'root';
    $password = 'noisy';
    $db_name = 'transaction_system';
//------------------------------
    $conn = new mysqli($db_host, $username, $password, $db_name);
    if (!empty($conn->connect_error)) {
        die('資料庫連線錯誤:' . $conn->connect_error);
    }
?>
<!-- 使用者儲值 !-->
<body>
    <form method="POST" action="user_add_money.php">
        ID : <input type='text' name='user_ID' required> <br>
        金額 : <input type='text' name='money' required> <br>
        <button type="submit">儲值</button>
    </form>

<?php 
    //若輸入金額 > 0 則增加持有金額
    if(isset($_POST['user_ID']) && isset($_POST['money']) && $_POST['money'] > 0){
        $query = ("UPDATE users set money = money + ? WHERE user_ID = ?");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($_POST['money'],$_POST['user_ID']));
    }


?>
</body>
</html>