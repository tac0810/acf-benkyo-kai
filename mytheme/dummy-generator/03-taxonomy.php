<?php
/**
 * 03. タクソノミー（カテゴリー・タグ）の設定
 * 
 * カテゴリーやタグ、カスタムタクソノミーの作成と
 * 投稿への紐付け方法を学びます。
 */

echo "🏷️ タクソノミーの設定を開始します...\n\n";

// ========================================
// 1. カテゴリーの作成と割り当て
// ========================================
echo "1. カテゴリーを作成して投稿に割り当て\n";

// カテゴリーを作成
$categories_to_create = [
    'お知らせ' => 'news',
    '技術情報' => 'tech',
    'イベント' => 'events',
];

$category_ids = [];

foreach ($categories_to_create as $name => $slug) {
    // カテゴリーが既に存在するか確認
    $term = get_term_by('slug', $slug, 'category');
    
    if (!$term) {
        // 新規作成
        $result = wp_insert_term(
            $name,      // カテゴリー名
            'category', // タクソノミー名
            [
                'slug' => $slug,
                'description' => "{$name}に関する投稿",
            ]
        );
        
        if (!is_wp_error($result)) {
            $category_ids[$name] = $result['term_id'];
            echo "  ✅ カテゴリー「{$name}」を作成 (ID: {$result['term_id']})\n";
        }
    } else {
        $category_ids[$name] = $term->term_id;
        echo "  ℹ️ カテゴリー「{$name}」は既に存在 (ID: {$term->term_id})\n";
    }
}

// 投稿を作成してカテゴリーを割り当て
$post_content = '
<!-- wp:paragraph -->
<p>この投稿には複数のカテゴリーが設定されています。</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">カテゴリーの活用方法</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<!-- wp:list-item -->
<li>記事の分類に使用</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>アーカイブページの自動生成</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>関連記事の表示に活用</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
';

$post_id = wp_insert_post([
    'post_title'   => 'カテゴリー設定のサンプル投稿',
    'post_content' => $post_content,
    'post_status'  => 'publish',
    'post_type'    => 'post',
]);

if ($post_id) {
    // カテゴリーを投稿に割り当て（複数可）
    wp_set_post_categories($post_id, [
        $category_ids['お知らせ'],
        $category_ids['技術情報'],
    ]);
    echo "  ✅ 投稿にカテゴリーを割り当てました (投稿ID: $post_id)\n";
}

// ========================================
// 2. タグの作成と割り当て
// ========================================
echo "\n2. タグを作成して投稿に割り当て\n";

$tags_to_create = ['WordPress', 'PHP', 'プラグイン開発', '初心者向け'];
$tag_ids = [];

foreach ($tags_to_create as $tag_name) {
    $result = wp_insert_term(
        $tag_name,  // タグ名
        'post_tag'  // タクソノミー名
    );
    
    if (!is_wp_error($result)) {
        $tag_ids[] = $result['term_id'];
        echo "  ✅ タグ「{$tag_name}」を作成 (ID: {$result['term_id']})\n";
    } else {
        // 既に存在する場合
        $term = get_term_by('name', $tag_name, 'post_tag');
        if ($term) {
            $tag_ids[] = $term->term_id;
            echo "  ℹ️ タグ「{$tag_name}」は既に存在\n";
        }
    }
}

// 投稿にタグを割り当て
if ($post_id && !empty($tag_ids)) {
    wp_set_post_tags($post_id, $tag_ids);
    echo "  ✅ 投稿にタグを割り当てました\n";
}

// ========================================
// 3. 階層構造を持つカテゴリー
// ========================================
echo "\n3. 親子関係のあるカテゴリーを作成\n";

// 親カテゴリーを作成
$parent_result = wp_insert_term(
    'プログラミング',
    'category',
    ['slug' => 'programming']
);

if (!is_wp_error($parent_result)) {
    $parent_id = $parent_result['term_id'];
    echo "  ✅ 親カテゴリー「プログラミング」を作成 (ID: $parent_id)\n";
    
    // 子カテゴリーを作成
    $child_categories = ['PHP', 'JavaScript', 'Python'];
    
    foreach ($child_categories as $child_name) {
        $child_result = wp_insert_term(
            $child_name,
            'category',
            [
                'parent' => $parent_id,  // 親カテゴリーのID
                'slug' => strtolower($child_name),
            ]
        );
        
        if (!is_wp_error($child_result)) {
            echo "    └─ 子カテゴリー「{$child_name}」を作成\n";
        }
    }
}

// ========================================
// 4. タクソノミーを使った投稿の検索
// ========================================
echo "\n4. タクソノミーで投稿を検索\n";

// カテゴリーで投稿を検索
$query = new WP_Query([
    'category_name' => 'news',  // カテゴリースラッグ
    'posts_per_page' => 5,
]);

echo "  ℹ️ カテゴリー「お知らせ」の投稿数: {$query->found_posts}\n";

// タグで投稿を検索
$tag_query = new WP_Query([
    'tag' => 'wordpress',  // タグスラッグ
    'posts_per_page' => 5,
]);

echo "  ℹ️ タグ「WordPress」の投稿数: {$tag_query->found_posts}\n";

// ========================================
// 5. 複数投稿に一括でタクソノミーを設定
// ========================================
echo "\n5. 複数投稿に一括でタクソノミーを設定\n";

// サンプル投稿を3つ作成
$sample_posts = [];
for ($i = 1; $i <= 3; $i++) {
    // Gutenbergブロック形式のコンテンツを生成
    $test_content = '
<!-- wp:paragraph -->
<p>タクソノミーの一括設定テストです。投稿番号: ' . $i . '</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">タクソノミーの重要性</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>カテゴリーとタグを適切に設定することで、コンテンツの整理と検索性が向上します。</p>
<!-- /wp:paragraph -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:paragraph -->
<p>投稿 No.' . $i . ' - タクソノミー自動設定のデモンストレーション</p>
<!-- /wp:paragraph -->
';
    
    $pid = wp_insert_post([
        'post_title'   => "タクソノミーテスト投稿 {$i}",
        'post_content' => $test_content,
        'post_status'  => 'publish',
        'post_type'    => 'post',
    ]);
    
    if ($pid) {
        $sample_posts[] = $pid;
        
        // 各投稿に異なるカテゴリーとタグを設定
        if ($i == 1) {
            wp_set_post_categories($pid, [$category_ids['お知らせ']]);
            wp_set_post_tags($pid, 'WordPress, 初心者向け');
        } elseif ($i == 2) {
            wp_set_post_categories($pid, [$category_ids['技術情報']]);
            wp_set_post_tags($pid, 'PHP, プラグイン開発');
        } else {
            wp_set_post_categories($pid, [$category_ids['イベント']]);
            wp_set_post_tags($pid, 'WordPress');
        }
        
        echo "  ✅ 投稿 {$i} にタクソノミーを設定 (ID: $pid)\n";
    }
}

// ========================================
// 6. タクソノミーの情報取得
// ========================================
echo "\n6. 投稿のタクソノミー情報を取得\n";

if (!empty($sample_posts)) {
    $check_post_id = $sample_posts[0];
    
    // カテゴリーを取得
    $categories = wp_get_post_categories($check_post_id, ['fields' => 'all']);
    echo "  投稿ID {$check_post_id} のカテゴリー:\n";
    foreach ($categories as $cat) {
        echo "    - {$cat->name} (slug: {$cat->slug})\n";
    }
    
    // タグを取得
    $tags = wp_get_post_tags($check_post_id);
    echo "  投稿ID {$check_post_id} のタグ:\n";
    foreach ($tags as $tag) {
        echo "    - {$tag->name}\n";
    }
}

// ========================================
// 学習ポイント
// ========================================
echo "\n" . str_repeat("=", 50) . "\n";
echo "💡 学習ポイント:\n";
echo "- wp_insert_term()でカテゴリー・タグを作成\n";
echo "- wp_set_post_categories()でカテゴリーを割り当て\n";
echo "- wp_set_post_tags()でタグを割り当て\n";
echo "- parentパラメータで階層構造を作成\n";
echo "- WP_Queryでタクソノミーベースの検索\n";
echo "- get_term_by()で既存のタームを確認\n";
echo str_repeat("=", 50) . "\n";