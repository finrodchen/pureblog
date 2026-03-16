<?php
// deploy.php
$dist = "dist";
if (!is_dir($dist)) mkdir($dist, 0777, true);

// 簡單的頁面渲染範例
// 實際上你可以根據 pureblog 的邏輯遍歷 content/posts 目錄
$pages = [
    'index.php' => 'index.html',
    '404.php'   => '404.html'
];

foreach ($pages as $source => $target) {
    if (file_exists($source)) {
        ob_start();
        include $source;
        $html = ob_get_clean();
        file_put_contents("$dist/$target", $html);
        echo "Successfully built $target\n";
    }
}

// 複製靜態資源
if (is_dir('assets')) {
    shell_exec("cp -r assets $dist/");
}
if (is_dir('content')) {
    shell_exec("cp -r content $dist/");
}
