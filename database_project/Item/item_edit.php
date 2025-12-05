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


    if(isset($_POST['search_item_ID']) || isset($_POST['editting'])){
        if(isset($_POST['search_item_ID'])){
            $show_item_ID = $_POST['search_item_ID'];
        }else{
            $show_item_ID = $_POST['item_ID'];
        }

        $query = ("SELECT * from item WHERE item_ID = ?");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($show_item_ID));
        $user_ID = 0;
        $name = "";
        $price = 0;
        $remain = 0;

        $stmt->bind_result($show_item_ID,$user_ID,$name,$price,$remain);
        while($stmt->fetch());
    }else{
        $show_item_ID = "";
        $user_ID = "";
        $name = "";
        $price = "";
        $remain = "";
    }
?>
<!-- 修改商品  -->
<body>

    <form method="POST" action="item_edit.php">
        商品ID : <input type='text' name='search_item_ID' value=<?php echo  $show_item_ID;?>> <br>
        <button type="submit">查詢</button>
    </form>
    <form method="POST" action="item_edit.php">
        <input type='hidden' name='editting'> <br>
        商品ID : <input type='text' name='item_ID' value=<?php echo  $show_item_ID;?> required> <br>
        出售者ID : <input type='text' name='user_ID' value=<?php echo  $user_ID;?> disabled> <br>
        商品名稱 : <input type='text' name='item_name' value=<?php echo  $name;?> required> <br>
        商品價格 : <input type='text' name='item_price' value=<?php echo  $price;?> required> <br>
        商品數量 : <input type='text' name='item_remain' value=<?php echo  $remain;?> required> <br>
        <button type="submit">修改</button>
    </form>

<?php 
    if(isset($_POST['editting'])){
        $query = ("UPDATE item SET item_name = ?, item_price = ?, remain = ? WHERE item_ID = ?");
        $stmt = $conn->prepare(($query));
        $stmt->execute(array($_POST['item_name'],$_POST['item_price'],$_POST['item_remain'],$_POST['item_ID']));
        echo $stmt->error;
    }


?>
</body>
</html>