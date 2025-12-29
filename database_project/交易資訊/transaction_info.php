<!DOCTYPE html>
<html lang="zh-TW">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../common.css">
    </head>
<?php 
    include_once '../db_conn.php';

    function query_result($stm){
        $transaction_ID = 0;
        $buyer_ID = 0;
        $item_ID = 0;
        $transaction_count = 0;
        $seller_ID = 0;
        $item_name = "";
        $item_price = 0;
        $item_remain = 0;
        $stm->bind_result($transaction_ID,$buyer_ID,$item_ID,$transaction_count,$item_ID,$seller_ID,$item_name,$item_price,$item_remain);
        echo "<table border='1'>
        <tr>
            <th>買家ID</th>
            <th>商品ID</th>
            <th>商品名稱</th>
            <th>商品數量</th>
            <th>總價</th>
            <th>訂單數量</th>
        </tr>
    ";
        while($stm->fetch()){
            echo "<tr>";
            echo "<td>".$buyer_ID."</td>";
            echo "<td>".$item_ID."</td>";
            echo "<td>".$item_name."</td>";
            echo "<td>".$item_remain."</td>";
            echo "<td>".$item_price."</td>";
            echo "<td>".$transaction_count."</td>";
            echo "</tr>";
        }
    }
    function user_name_query_result($stm){
        $buyer_name = "";
        $buyer_ID = 0;
        $transaction_count = 0;
        $item_name = "";
        $item_price = 0;
        $stm->bind_result($buyer_name,$buyer_ID,$item_name,$item_price,$transaction_count);

        echo "<table border='1'>
        <tr>
            <th>買家</th>
            <th>買家ID</th>
            <th>商品名稱</th>
            <th>價格</th>
            <th>訂單數量</th>
        </tr>
    ";
        while($stm->fetch()){
            echo "<tr>";
            echo "<td>".$buyer_name."</td>";
            echo "<td>".$buyer_ID."</td>";
            echo "<td>".$item_name."</td>";
            echo "<td>".$item_price."</td>";
            echo "<td>".$transaction_count."</td>";
            echo "</tr>";
        }
    }
?>
<!-- 查詢交易  -->
<body>
    <div class="main-container">
    <form method="POST" action="transaction_info.php">
        買方ID : <input type='text' name='buyer_ID'> <br>
        <button type="submit">查詢</button>
    </form>
    <form method="POST" action="transaction_info.php">
        使用者名稱 : <input type='text' name='user_name'> <br>
        <button type="submit">查詢</button>
    </form>
    <form method="POST" action="transaction_info.php">
        賣方ID : <input type='text' name='seller_ID'> <br>
        <button type="submit">查詢</button>
    </form>
    <form method="POST" action="transaction_info.php">
        商品 : <input type='text' name='item_name'> <br>
        <button type="submit">查詢</button>
    </form>
    <button onclick="window.location.href='../index.php'">返回</button>

<?php 
    try {
        if(isset($_POST['buyer_ID'])){
            // $query = ("SELECT * FROM transactions,items JOIN items ON items.item_ID = transactions.item_ID WHERE transactions.user_ID = ? ");
            $query = ("SELECT * FROM transactions, items WHERE items.item_ID = transactions.item_ID and transactions.user_ID = ? ");
            $stmt = $conn->prepare(($query));
            $stmt->execute(array($_POST['buyer_ID']));
            query_result(($stmt));
        }else if(isset($_POST['seller_ID'])){
            $query = ("SELECT * FROM transactions, items WHERE items.item_ID = transactions.item_ID and items.user_ID = ? ");
            $stmt = $conn->prepare(($query));
            $stmt->execute(array($_POST['seller_ID']));
            query_result(($stmt));
        }else if(isset($_POST['user_name'])){
            $query = ("call user_trans(?)");
            $stmt = $conn->prepare(($query));
            $stmt->execute(array($_POST['user_name']));
            user_name_query_result(($stmt));
        }else if(isset($_POST['item_name'])){
            $query = ("SELECT * FROM transactions, items WHERE items.item_ID = transactions.item_ID and items.item_name = ? ");
            $stmt = $conn->prepare(($query));
            $stmt->execute(array($_POST['item_name']));
            query_result(($stmt));
        }
    } catch (Exception $e) {
        echo '<div class="error-message">錯誤訊息: ' . $e->getMessage() . '</div>';
    }


?>
    </div>
</body>
</html>