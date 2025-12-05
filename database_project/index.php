<?php
// 1. 定義菜單結構
// 使用 PHP 陣列來定義菜單的層次和相應的檔案名。
$menu_items = [
    'User' => [
        'add'       => 'user_add.php',
        'money'     => 'user_money.php',
        'add_money' => 'user_add_money.php',
        'info'      => 'user_info.php', // 遵循您的命名範例
    ],
    'Transaction' => [
        'create' => 'transaction_create.php',
        'cancel' => 'transaction_cancel.php',
        'info'   => 'transaction_info.php',
    ],
    'Item' => [
        'add'    => 'item_add.php',
        'remain' => 'item_remain.php',
        'edit'   => 'item_edit.php',
        'info'   => 'item_info.php',
    ]
];

/**
 * 2. 遞歸函數：用於生成菜單的 HTML 結構
 * @param array $items 菜單項目陣列 (包含父目錄和子目錄)
 * @return string 生成的 HTML 結構
 */
function generate_menu_html(array $items): string {
    $html = '<ul>';
    
    foreach ($items as $parent_name => $children) {
        // 頂層目錄
        $html .= '<li onclick="toggleMenu(this)">' . htmlspecialchars($parent_name);
        
        // 如果 $children 是一個陣列，表示它有子目錄
        if (is_array($children)) {
            $html .= '<ul>';
            foreach ($children as $child_name => $file_name) {
                // 子目錄 (可點擊跳轉)
                $html .= '<li>';
                // 使用 <a> 標籤，href 屬性指向相應的 PHP 檔案
                $html .= '<a href="'.htmlspecialchars($parent_name.'/'). htmlspecialchars($file_name) . '">';
                $html .= htmlspecialchars($child_name);
                $html .= '</a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        
        $html .= '</li>';
    }
    
    $html .= '</ul>';
    return $html;
}

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>交易查詢系統</title>
    <style>
        .menu-container {
            font-family: Arial, sans-serif;
            width: 300px;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .menu-container ul {
            list-style: none;
            padding-left: 20px;
            margin: 0;
        }

        .menu-container > ul > li {
            font-weight: bold;
            margin-top: 5px;
            cursor: pointer;
        }
        
        .menu-container > ul > li::before {
            content: '► ';
            display: inline-block;
            margin-right: 5px;
            transition: transform 0.2s;
        }

        /* 調整子目錄樣式，讓 <a> 標籤看起來更自然 */
        .menu-container li a {
            font-weight: normal;
            display: block; /* 讓整個區域可點擊 */
            padding: 2px 0;
            text-decoration: none; /* 移除下劃線 */
            color: #333; /* 連結顏色 */
        }
        
        .menu-container li a:hover {
            background-color: #eee;
        }

        .menu-container li ul {
            display: none; 
        }

        .menu-container .open > li::before {
             content: '▼ ';
        }
    </style>
</head>
<body>

    <div class="menu-container">
        <h2>系統菜單</h2>
        <?php 
            // 3. 呼叫函數，將生成的 HTML 輸出到頁面
            echo generate_menu_html($menu_items); 
        ?>
    </div>
    
    <script>
        function toggleMenu(element) {
            const submenu = element.querySelector('ul');
            
            if (submenu) {
                // 找到所有同級的主菜單項
                const allSiblings = element.parentNode.children;
                
                // 點擊當前項時，折疊其他所有已展開的主菜單項 (可選：讓每次只展開一項)
                for (let i = 0; i < allSiblings.length; i++) {
                    const sibling = allSiblings[i];
                    if (sibling !== element && sibling.classList.contains('open')) {
                         const otherSubmenu = sibling.querySelector('ul');
                         if (otherSubmenu) {
                            otherSubmenu.style.display = 'none';
                            sibling.classList.remove('open');
                         }
                    }
                }
                
                // 展開/折疊當前菜單
                if (submenu.style.display === 'block') {
                    submenu.style.display = 'none';
                    element.classList.remove('open');
                } else {
                    submenu.style.display = 'block';
                    element.classList.add('open');
                }
            }
        }
    </script>

</body>
</html>