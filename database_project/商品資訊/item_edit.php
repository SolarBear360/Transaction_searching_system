<!DOCTYPE html>
<html lang="zh-TW">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../common.css">
    </head>
<?php 
    include_once '../db_conn.php';

    $top_error_msg = "";
    
    try {
        if(isset($_POST['editting'])){
            $query = ("UPDATE items SET item_name = ?, item_price = ?, remain = ? WHERE item_ID = ?");
            $stmt = $conn->prepare(($query));
            $stmt->execute(array($_POST['item_name'],$_POST['item_price'],$_POST['item_remain'],$_POST['item_ID']));
        }
        if(isset($_POST['search_item_ID']) || isset($_POST['editting'])){
            if(isset($_POST['search_item_ID'])){
                $show_item_ID = $_POST['search_item_ID'];
            }else{
                $show_item_ID = $_POST['item_ID'];
            }

            $query = ("SELECT * from items WHERE item_ID = ?");
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
    } catch (Exception $e) {
        $top_error_msg = $e->getMessage();
    }
?>
<!-- 修改商品  -->
<body>
    <div class="main-container">
    <?php if(!empty($top_error_msg)) echo '<div class="error-message">錯誤訊息: ' . $top_error_msg . '</div>'; ?>
    <form method="POST" action="item_edit.php">
        商品ID : <input type='text' name='search_item_ID' value=<?php echo  $show_item_ID;?>> <br>
        <button type="submit">查詢</button>
    </form>
    <form method="POST" action="item_edit.php">
        <input type='hidden' name='editting'> <br>
        商品ID : <input type='text' name='item_ID' required value=<?php echo  $show_item_ID;?>> <br>
        出售者ID : <input type='text' name='user_ID' disabled value=<?php echo  $user_ID;?>> <br>
        商品名稱 : <input type='text' name='item_name' required value=<?php echo  $name;?>> <br>
        商品價格 : <input type='text' name='item_price' required value=<?php echo  $price;?>> <br>
        商品數量 : <input type='text' name='item_remain' required value=<?php echo  $remain;?>> <br>
        <button type="submit">修改</button>
    </form>
    <button onclick="window.location.href='../index.php'">返回</button>
    </div>
</body>
</html>