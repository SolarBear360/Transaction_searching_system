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
<!-- 刪除交易  -->
<body>
    <form method="POST" action="transaction_cancel.php">
        交易ID : <input type='text' name='transaction_ID' required> <br>
        <button type="submit">取消交易</button>
    </form>

<?php 
    if(isset($_POST['transaction_ID'])){
        $query = ("DELETE FROM transactions WHERE trans_ID = ?");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($_POST['transaction_ID']));

    }


?>
</body>
</html>