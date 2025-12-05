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
<!-- 新增交易  -->
<body>
    <form method="POST" action="transaction_create.php">
        買方ID : <input type='text' name='user_ID' required> <br>
        商品ID : <input type='text' name='item_ID' required> <br>
        訂單數量 : <input type='text' name='quantity' value=1 required> <br>
        <button type="submit">新增</button>
    </form>

<?php 
    if(isset($_POST['user_ID']) && isset($_POST['item_ID']) && $_POST['quantity'] > 0){
        $query = ("INSERT INTO transactions values(null,?,?,?)");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($_POST['user_ID'],$_POST['item_ID'],$_POST['quantity']));
    }


?>
</body>
</html>