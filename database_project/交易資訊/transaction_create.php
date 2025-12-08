<!DOCTYPE html>
<html lang="zh-TW">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- The style for the back button has been removed as it's no longer needed. -->

    </head>
<?php 
    include_once '../db_conn.php';
?>
<!-- 新增交易  -->
<body>
    <form method="POST" action="transaction_create.php">
        買方ID : <input type='text' name='user_ID' required> <br>
        商品ID : <input type='text' name='item_ID' required> <br>
        訂單數量 : <input type='text' name='quantity' value=1 required> <br>
        <button type="submit">新增</button>
    </form>
    <button onclick="window.location.href='../index.php'">返回</button>
<?php 
    if(isset($_POST['user_ID']) && isset($_POST['item_ID']) && $_POST['quantity'] > 0){
        $query = ("INSERT INTO transactions values(null,?,?,?)");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($_POST['user_ID'],$_POST['item_ID'],$_POST['quantity']));
    }


?>
</body>
</html>