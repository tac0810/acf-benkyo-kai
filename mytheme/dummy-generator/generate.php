<?php
/**
 * ダミーデータ生成 エントリーポイント
 * 
 * このファイルを実行することで、WordPress環境にダミーデータを生成します。
 * 
 * 実行方法:
 * docker exec wordpress-1 wp eval-file /var/www/html/wp-content/themes/mytheme/dummy-generator/generate.php --allow-root
 */

// WP-CLIまたは管理画面から実行されていることを確認
if (!defined('WP_CLI') && !is_admin()) {
    die('このスクリプトはWP-CLIまたは管理画面から実行してください。');
}

echo "==============================================\n";
echo " WordPress ダミーデータ生成ツール\n";
echo " ACF勉強会用サンプル\n";
echo "==============================================\n\n";

echo "ダミーデータ生成を開始します...\n\n";

// 個別のスクリプトを順番に実行
$scripts = [
    '01-basic-post.php',
    '02-multiple-posts.php',
    '03-taxonomy.php',
    '04-images.php',
    '05-acf-fields.php'
];

foreach ($scripts as $script) {
    $script_path = __DIR__ . '/' . $script;
    if (file_exists($script_path)) {
        echo "\n--- {$script} を実行中 ---\n";
        include $script_path;
    } else {
        echo "⚠️ {$script} が見つかりません\n";
    }
}

echo "\n✅ ダミーデータ生成が完了しました！\n";