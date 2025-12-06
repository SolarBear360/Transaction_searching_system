<?php
// 定義菜單結構
$menu_items = [
    'User' => [
        'add' => 'user_add.php',
        'money' => 'user_money.php',
        'add_money' => 'user_add_money.php',
        'info' => 'user_info.php',
    ],
    'Transaction' => [
        'create' => 'transaction_create.php',
        'cancel' => 'transaction_cancel.php',
        'info' => 'transaction_info.php',
    ],
    'Item' => [
        'add' => 'item_add.php',
        'remain' => 'item_remain.php',
        'edit' => 'item_edit.php',
        'info' => 'item_info.php',
    ]
];
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>交易查詢系統</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: grey;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        /* 修正盒模型，讓寬度計算包含 padding */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        .main-container {
            width: 350px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .logo-container {
            position: absolute;
            top: 0;
            left: 0;
            padding: 20px;
            height: 40px;
            z-index: 10; /* 確保 Logo 在最上層 */
        }

        .nav-container {
            padding: 20px;
        }

        #layer1 h2, #layer2 h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .category-button, .back-button,.sub-category-button {
            display: block;
            width: 100%;
            padding: 15px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            background-color: #5d80d1;
            color: white;
            font-size: 1em;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s;
            text-decoration: none; /* 移除 a 標籤的底線 */
        }
        .category-button:hover, #submenu-list li a:hover {
            background-color: #4a69bd;
        }

        .back-button {
            background-color: #6c757d;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background-color: #5a6268;
        }

        #submenu-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        /* #submenu-list li a 的樣式已合併到 .category-button */



    </style>
</head>
<body>

    <div class="logo-container">
        <!-- 這是您放 Logo 的地方。請將 src 替換成您的 Logo 圖片路徑 -->
        <img src="src/logo.png" alt="Logo" style="height: 300%;">
    </div>
    <div class="main-container">
        <div class="nav-container">
            <!-- Layer 1: 主選單 -->
            <div id="layer1">
                <h2>系統菜單</h2>
                <?php foreach (array_keys($menu_items) as $category): ?>
                    <button class="category-button" data-category="<?php echo htmlspecialchars($category); ?>">
                        <?php echo htmlspecialchars($category); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Layer 2: 子選單 (預設隱藏) -->
            <div id="layer2" style="display: none;">
                <h2 id="submenu-title"></h2>
                <ul id="submenu-list"></ul>
                <button class="back-button">← 返回</button>
            </div>
        </div>
    </div>
    
    <script>
        // 從 PHP 獲取菜單資料並轉換為 JavaScript 物件
        const menuItems = <?php echo json_encode($menu_items); ?>;

        const layer1 = document.getElementById('layer1');
        const layer2 = document.getElementById('layer2');
        const submenuTitle = document.getElementById('submenu-title');
        const submenuList = document.getElementById('submenu-list');
        const backButton = document.querySelector('.back-button');

        // 為所有主分類按鈕添加點擊事件
        document.querySelectorAll('.category-button').forEach(button => {
            button.addEventListener('click', () => {
                const category = button.dataset.category;
                const subItems = menuItems[category];

                // 設定子選單標題
                submenuTitle.textContent = category;
                
                // 清空舊的子選單項目並產生新的
                submenuList.innerHTML = '';
                for (const [name, url] of Object.entries(subItems)) {
                    const listItem = document.createElement('li');
                    listItem.innerHTML = `<a class="category-button" href="${category}/${url}">${name}</a>`;
                    submenuList.appendChild(listItem);
                }

                // 切換顯示畫面
                layer1.style.display = 'none';
                layer2.style.display = 'block';
            });
        });

        // 為返回按鈕添加點擊事件
        backButton.addEventListener('click', () => {
            layer1.style.display = 'block';
            layer2.style.display = 'none';
        });
    </script>

</body>
</html>