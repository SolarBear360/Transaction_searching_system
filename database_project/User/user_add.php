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
<!-- 新增使用者  -->
<body>
    <form method="POST" action="user_add.php">
        姓名 : <input type='text' name='user_name' required> <br>
        電話 : <input type='text' name='user_phone' required> <br>
        <button type="submit">新增</button>
    </form>

<?php 
    if(isset($_POST['user_name']) && isset($_POST['user_phone'])){
        $query = ("INSERT INTO users values(null,?,0,?)");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($_POST['user_name'],$_POST['user_phone']));
    }


?>
</body>
</html>