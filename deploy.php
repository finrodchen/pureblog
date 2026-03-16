<?php
// 1. 設定本地臨時伺服器跑起你的 PHP 專案
$port = 8080;
shell_exec("php -S localhost:$port > /dev/null 2>&1 &");
sleep(3); // 等待伺服器啟動

$dist = "dist";
if (!is_dir($dist)) mkdir($dist);

// 2. 定義你要抓取的頁面 (純靜態化版本)
// 注意：因為 Cloudflare Pages 是靜態的，搜尋功能和後台 (admin) 會失效
$pages = [
    '/' => 'index.html',
    '/404' => '404.html',
];

// 掃描 content/posts 下的檔案來生成文章列表 (這部分需要根據你的 logic 調整)
// 簡單示範：直接抓取首頁
foreach ($pages as $url => $filename) {
    $html = file_get_contents("http://localhost:$port" . $url);
    file_put_contents("$dist/$filename", $html);
    echo "Generated $filename\n";
}

// 3. 複製資產 (CSS/JS/Images)
shell_exec("cp -r assets $dist/");
shell_exec("cp -r content $dist/"); // 確保圖片等資源也能讀到

echo "Build Complete!";
