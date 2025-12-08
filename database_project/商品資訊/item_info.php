<!DOCTYPE html>
<html lang="zh-TW">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
<?php 
    include_once '../db_conn.php';

    function query_result($stm){
        $item_ID = 0;
        $user_ID = 0;
        $name = "";
        $price = 0;
        $remain = 0;

        $stm->bind_result($item_ID,$user_ID,$name,$price,$remain);

        echo "<table border='1'>
        <tr>
            <th>商品ID</th>
            <th>賣方ID</th>
            <th>名稱</th>
            <th>售價</th>
            <th>數量</th>
        </tr>
    ";
        while($stm->fetch()){
            echo "<tr>";
            echo "<td>".$item_ID."</td>";
            echo "<td>".$user_ID."</td>";
            echo "<td>".$name."</td>";
            echo "<td>".$price."</td>";
            echo "<td>".$remain."</td>";
            echo "</tr>";
        }
    }
?>
<!-- 查詢商品資訊 !-->
<body>
    <form method="POST" action="item_info.php">
        商品名稱 : <input type='text' name='item_name'> <br>
        <button type="submit">查詢</button>
    </form>
    <form method="POST" action="item_info.php">
        商品ID : <input type='text' name='item_ID'> <br>
        <button type="submit">查詢</button>
    </form>
    <button onclick="window.location.href='../index.php'">返回</button>

<?php 
    if(isset($_POST['item_name'])){
        $query = ("SELECT * from item WHERE item_name = ?");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($_POST['item_name']));
        query_result($stmt);
    }else if(isset($_POST['item_ID'])){
        $query = ("SELECT * from item WHERE item_ID = ?");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($_POST['item_ID']));
        query_result($stmt);
    }


?>
</body>
</html>