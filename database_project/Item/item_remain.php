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
<!-- 計算使用者購買所有訂單後金額 !-->
<body>
    <form method="POST" action="item_remain.php">
        ID : <input type='text' name='item_ID' required> <br>
        <button type="submit">結算</button>
    </form>

<?php 
    if(isset($_POST['item_ID'])){
        $query = ("SELECT item.item_ID, item_name, remain-sum(quantity) 
                    FROM item, transactions WHERE item.item_ID = transactions.item_ID and item.item_ID = ? 
                    GROUP BY item.item_ID, item.user_ID, item.item_name, item.item_price, item.remain");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($_POST['item_ID']));
        $stmt->bind_result($ID,$name,$remain);

        echo "<table border=1><tr>
            <th>ID</th>
            <th>商品</th>
            <th>剩餘</th>
        </tr>";
        while($stmt->fetch()){
            echo "<tr>
                <td>$ID</td>
                <td>$name</td>
                <td>$remain</td>
            </tr>";
        }

    }


?>
</body>
</html>