<!DOCTYPE html>
<html lang="zh-TW">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
<?php 
    include_once '../db_conn.php';
?>
<!-- 刪除交易  -->
<body>
    <form method="POST" action="transaction_cancel.php">
        交易ID : <input type='text' name='transaction_ID' required> <br>
        <button type="submit">取消交易</button>
    </form>
    <button onclick="window.location.href='../index.php'">返回</button>

<?php 
    if(isset($_POST['transaction_ID'])){
        $query = ("DELETE FROM transactions WHERE trans_ID = ?");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($_POST['transaction_ID']));

    }


?>
</body>
</html>