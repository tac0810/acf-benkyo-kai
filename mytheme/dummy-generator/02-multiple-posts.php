<?php
/**
 * 02. 複数記事の一括投稿
 * 
 * ループ処理を使って複数の投稿を効率的に作成する方法を学びます。
 * 実際のプロジェクトでテストデータを大量に作成する際に便利です。
 */

echo "📚 複数記事の一括投稿を開始します...\n\n";

// ========================================
// 1. 単純なループで複数投稿を作成
// ========================================
echo "1. ループで5件の投稿を作成\n";

$created_posts = [];  // 作成した投稿IDを保存

for ($i = 1; $i <= 5; $i++) {
    // Gutenbergブロック形式のコンテンツを動的に生成
    $content = '
<!-- wp:paragraph -->
<p>これは' . $i . '番目の記事です。ループ処理で自動生成されました。</p>
<!-- /wp:paragraph -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:paragraph -->
<p>記事番号: ' . $i . '/5</p>
<!-- /wp:paragraph -->
';
    
    $post_data = [
        'post_title'   => "サンプル記事 No.{$i}",
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'post',
        'post_name'    => "sample-post-{$i}",  // スラッグも動的に生成
    ];
    
    $post_id = wp_insert_post($post_data);
    
    if ($post_id && !is_wp_error($post_id)) {
        $created_posts[] = $post_id;
        echo "  ✅ 記事 {$i}/5 を作成 (ID: $post_id)\n";
    }
}

echo "作成した投稿ID: " . implode(', ', $created_posts) . "\n";

// ========================================
// 2. 配列データから複数投稿を作成
// ========================================
echo "\n2. 配列データから投稿を作成\n";

// 投稿データの配列（実際のプロジェクトではCSVやJSONから読み込むことも）
$posts_data = [
    [
        'title'   => 'WordPress入門',
        'content' => '<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">WordPressとは</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>WordPressの基本的な使い方を解説します。</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">詳しく見る</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->',
        'slug'    => 'wordpress-basics',
    ],
    [
        'title'   => 'ACFの活用方法',
        'content' => '<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph -->
<p>Advanced Custom Fieldsを使ったカスタマイズ方法を左カラムで説明。</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph -->
<p>右カラムには実装例を記載します。</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->',
        'slug'    => 'acf-usage',
    ],
    [
        'title'   => 'Gutenbergブロックエディタ',
        'content' => '<!-- wp:quote -->
<blockquote class="wp-block-quote">
<p>最新のブロックエディタの使い方を学びましょう。</p>
<cite>WordPress 公式ドキュメント</cite>
</blockquote>
<!-- /wp:quote -->

<!-- wp:paragraph -->
<p>ブロックエディタは直感的な操作が可能です。</p>
<!-- /wp:paragraph -->',
        'slug'    => 'gutenberg-editor',
    ],
];

foreach ($posts_data as $index => $data) {
    $post_id = wp_insert_post([
        'post_title'   => $data['title'],
        'post_content' => $data['content'],
        'post_name'    => $data['slug'],
        'post_status'  => 'publish',
        'post_type'    => 'post',
    ]);
    
    if ($post_id) {
        echo "  ✅ 「{$data['title']}」を作成 (ID: $post_id)\n";
    }
}

// ========================================
// 3. ランダムなコンテンツで投稿を生成
// ========================================
echo "\n3. ランダムコンテンツで投稿を生成\n";

// サンプルデータのプール
$titles = ['お知らせ', '新機能', 'アップデート', 'メンテナンス', 'イベント'];
$contents = [
    'この度、新しい機能がリリースされました。',
    'システムメンテナンスのお知らせです。',
    '期間限定のキャンペーンを実施中です。',
    'サービスの品質向上のため、アップデートを行いました。',
    '新しいイベントの開催が決定しました。',
];

for ($i = 1; $i <= 3; $i++) {
    // ランダムに選択
    $random_title = $titles[array_rand($titles)];
    $random_content = $contents[array_rand($contents)];
    $date = date('Y-m-d');
    
    $post_id = wp_insert_post([
        'post_title'   => "{$random_title} - {$date}",
        'post_content' => $random_content,
        'post_status'  => 'publish',
        'post_type'    => 'post',
    ]);
    
    if ($post_id) {
        echo "  ✅ ランダム投稿を作成: 「{$random_title}」 (ID: $post_id)\n";
    }
}

// ========================================
// 4. 階層構造を持つページの作成
// ========================================
echo "\n4. 親子関係を持つページを作成\n";

// 親ページを作成
$parent_id = wp_insert_post([
    'post_title'   => 'サービス案内',
    'post_content' => '弊社のサービス一覧です。',
    'post_status'  => 'publish',
    'post_type'    => 'page',  // ページタイプ
    'post_name'    => 'services',
]);

if ($parent_id) {
    echo "  ✅ 親ページを作成: 「サービス案内」 (ID: $parent_id)\n";
    
    // 子ページを作成
    $child_pages = ['Web制作', 'システム開発', 'コンサルティング'];
    
    foreach ($child_pages as $child_title) {
        $child_id = wp_insert_post([
            'post_title'   => $child_title,
            'post_content' => "{$child_title}の詳細ページです。",
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_parent'  => $parent_id,  // 親ページのIDを指定
        ]);
        
        if ($child_id) {
            echo "    └─ 子ページ: 「{$child_title}」 (ID: $child_id)\n";
        }
    }
}

// ========================================
// 5. 一括削除のためのクリーンアップ関数
// ========================================
echo "\n5. 作成した投稿を管理する方法\n";

// メタデータを使って管理
foreach ($created_posts as $post_id) {
    // カスタムメタデータを追加（後で一括削除する際の目印）
    update_post_meta($post_id, '_dummy_data', 'yes');
}

echo "  ℹ️ 作成した投稿に '_dummy_data' メタデータを追加しました\n";
echo "  ℹ️ 以下のコードで一括削除が可能です:\n";
echo "     \$query = new WP_Query(['meta_key' => '_dummy_data', 'posts_per_page' => -1]);\n";
echo "     foreach (\$query->posts as \$post) { wp_delete_post(\$post->ID, true); }\n";

// ========================================
// 学習ポイント
// ========================================
echo "\n" . str_repeat("=", 50) . "\n";
echo "💡 学習ポイント:\n";
echo "- forループやforeachで効率的に複数投稿を作成\n";
echo "- 配列データから動的に投稿を生成\n";
echo "- post_parentで親子関係（階層構造）を設定\n";
echo "- メタデータで投稿を管理・分類\n";
echo "- array_rand()でランダムなコンテンツを生成\n";
echo str_repeat("=", 50) . "\n";