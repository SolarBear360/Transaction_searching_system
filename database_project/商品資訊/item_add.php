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
<!-- 新增商品  -->
<body>
    <div class="main-container">
    <form method="POST" action="item_add.php">
        出售者ID : <input type='text' name='user_ID' required> <br>
        商品名稱 : <input type='text' name='item_name' required> <br>
        商品價格 : <input type='text' name='item_price' required> <br>
        商品數量 : <input type='text' name='item_remain' required> <br>
        <button type="submit">新增</button>
    </form>
    <button onclick="window.location.href='../index.php'">返回</button>

<?php 
    if(isset($_POST['user_ID']) && isset($_POST['item_name']) && isset($_POST['item_price']) && isset($_POST['item_remain'])){
        try {
            $query = ("INSERT INTO items values(null,?,?,?,?)");
            $stmt = $conn->prepare(($query));
            $stmt->execute(array($_POST['user_ID'],$_POST['item_name'],$_POST['item_price'],$_POST['item_remain']));
            echo $stmt->error;
        } catch (Exception $e) {
            echo '<div class="error-message">錯誤訊息: ' . $e->getMessage() . '</div>';
        }
    }


?>
    </div>
</body>
</html>