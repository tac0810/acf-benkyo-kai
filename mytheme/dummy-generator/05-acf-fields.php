<?php
/**
 * 05. ACFフィールドの更新
 * 
 * Advanced Custom Fieldsのさまざまなフィールドタイプの
 * データ設定方法を学びます。
 */

echo "🔧 ACFフィールドの更新を開始します...\n\n";

// ACFが有効か確認
if (!function_exists('update_field')) {
    echo "❌ ACFプラグインが有効化されていません。\n";
    echo "   管理画面からAdvanced Custom Fieldsを有効化してください。\n";
    return;
}

// ========================================
// 1. すべてのACFフィールドタイプを含む投稿を作成
// ========================================
echo "1. ACFフィールドを持つ投稿を作成\n";

// Gutenbergコンテンツ
$content = '
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">ACFフィールドの活用例</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>このページでは、Advanced Custom Fieldsの各フィールドタイプの使用方法を解説します。</p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%">
<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">基本フィールド</h4>
<!-- /wp:heading -->
<!-- wp:list -->
<ul>
<!-- wp:list-item -->
<li>テキスト</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>テキストエリア</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>日時</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%">
<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">構造フィールド</h4>
<!-- /wp:heading -->
<!-- wp:list -->
<ul>
<!-- wp:list-item -->
<li>グループ</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>リピーター</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>フレキシブル</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%">
<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">メディア</h4>
<!-- /wp:heading -->
<!-- wp:list -->
<ul>
<!-- wp:list-item -->
<li>画像</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>ギャラリー</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:paragraph -->
<p>以下のACFフィールドがこの投稿に設定されています。管理画面で確認してください。</p>
<!-- /wp:paragraph -->
';

$post_id = wp_insert_post([
    'post_title'   => 'ACF完全ガイド - すべてのフィールドタイプ',
    'post_content' => $content,
    'post_status'  => 'publish',
    'post_type'    => 'post',
]);

if (!$post_id) {
    echo "❌ 投稿の作成に失敗しました\n";
    return;
}

echo "  ✅ 投稿を作成 (ID: $post_id)\n";

// ========================================
// 2. ACFフィールドを設定
// ========================================
echo "\n2. ACFフィールドを更新\n";

// 基本フィールド
update_field('text', 'これはテキストフィールドの値です', $post_id);
echo "  ✅ テキストフィールド\n";

// WYSIWYGフィールド
$wysiwyg_content = '<h3>リッチテキストエディタ</h3>';
$wysiwyg_content .= '<p><strong>太字</strong>や<em>斜体</em>などの装飾が可能です。</p>';
$wysiwyg_content .= '<ul><li>リスト項目1</li><li>リスト項目2</li></ul>';
update_field('wysiwyg', $wysiwyg_content, $post_id);
echo "  ✅ WYSIWYGフィールド\n";

// 日時フィールド
update_field('datetime', date('d/m/Y g:i a'), $post_id);
echo "  ✅ 日時フィールド\n";

// グループフィールド
$group_data = [
    'text' => 'グループ内のテキスト値',
];
update_field('group', $group_data, $post_id);
echo "  ✅ グループフィールド\n";

// リピーターフィールド（5行）
$repeater_data = [];
for ($i = 1; $i <= 5; $i++) {
    $repeater_data[] = [
        'text' => "リピーター行 {$i} のテキスト",
    ];
}
update_field('repeat', $repeater_data, $post_id);
echo "  ✅ リピーターフィールド (5行)\n";

// フレキシブルコンテンツ
$flexible_content = [
    [
        'acf_fc_layout' => 'paragraph',
        'text' => '1つ目の段落レイアウト',
    ],
    [
        'acf_fc_layout' => 'paragraph',
        'text' => '2つ目の段落レイアウト',
    ],
    [
        'acf_fc_layout' => 'paragraph',
        'text' => '3つ目の段落レイアウト',
    ],
];
update_field('flexible', $flexible_content, $post_id);
echo "  ✅ フレキシブルコンテンツ (3レイアウト)\n";

// 画像フィールド（メディアライブラリから取得）
$attachments = get_posts([
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

if (!empty($attachments)) {
    update_field('image', $attachments[0]->ID, $post_id);
    echo "  ✅ 画像フィールド\n";
}

// カテゴリーとタグも設定
$cat_id = wp_create_category('ACFチュートリアル');
if ($cat_id) {
    wp_set_post_categories($post_id, [$cat_id]);
}
wp_set_post_tags($post_id, 'ACF,カスタムフィールド,WordPress');
echo "  ✅ カテゴリーとタグ\n";

// ========================================
// 3. 設定値を確認
// ========================================
echo "\n3. 設定したフィールド値を確認\n";

$text_value = get_field('text', $post_id);
echo "  ℹ️ テキスト: " . ($text_value ?: '未設定') . "\n";

$repeat_value = get_field('repeat', $post_id);
if ($repeat_value) {
    echo "  ℹ️ リピーター行数: " . count($repeat_value) . "\n";
}

$flexible_value = get_field('flexible', $post_id);
if ($flexible_value) {
    echo "  ℹ️ フレキシブルレイアウト数: " . count($flexible_value) . "\n";
}

echo "\n  📌 投稿URL: " . get_permalink($post_id) . "\n";
echo "  📌 編集URL: " . admin_url("post.php?post={$post_id}&action=edit") . "\n";

// ========================================
// 学習ポイント
// ========================================
echo "\n" . str_repeat("=", 50) . "\n";
echo "💡 学習ポイント:\n";
echo "- update_field()でACFフィールドを更新\n";
echo "- get_field()でフィールド値を取得\n";
echo "- リピーターは配列の配列として扱う\n";
echo "- フレキシブルコンテンツはacf_fc_layoutを指定\n";
echo "- グループフィールドは連想配列で渡す\n";
echo str_repeat("=", 50) . "\n";