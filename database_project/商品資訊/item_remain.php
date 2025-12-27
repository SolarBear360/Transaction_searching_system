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
    <form method="POST" action="item_remain.php">
        ID : <input type='text' name='item_ID' required> <br>
        <button type="submit">結算</button>
    </form>
    <button onclick="window.location.href='../index.php'">返回</button>

<?php 
    if(isset($_POST['item_ID'])){
        $query = ("SELECT items.item_ID, item_name, remain-COALESCE(sum(quantity),0) as remain_number   
                    FROM items LEFT OUTER JOIN transactions USING(item_ID)
                    WHERE items.item_ID = ? 
                    GROUP BY items.item_ID, items.user_ID, items.item_name, items.item_price, items.remain");
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
    </div>
</body>
</html>