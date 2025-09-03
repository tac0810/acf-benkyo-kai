<?php
/**
 * 01. 基本的な投稿作成
 * 
 * WordPressでプログラム的に投稿を作成する基本的な方法を学びます。
 * wp_insert_post()関数を使用して、タイトル、本文、その他の属性を持つ投稿を作成します。
 */

echo "📝 基本的な投稿作成を開始します...\n\n";

// ========================================
// 1. シンプルな投稿を作成
// ========================================
echo "1. シンプルな投稿を作成\n";

$post_data = [
    'post_title'    => 'プログラムで作成した投稿',
    'post_content'  => 'これはwp_insert_post()関数を使って作成した投稿です。',
    'post_status'   => 'publish',  // publish, draft, pending, private
    'post_type'     => 'post',      // post, page, カスタム投稿タイプ
    'post_author'   => 1,           // ユーザーID
];

$post_id = wp_insert_post($post_data);

if ($post_id && !is_wp_error($post_id)) {
    echo "✅ 投稿を作成しました (ID: $post_id)\n";
} else {
    echo "❌ 投稿の作成に失敗しました\n";
}

// ========================================
// 2. より詳細な設定を持つ投稿
// ========================================
echo "\n2. 詳細設定付きの投稿を作成\n";

// Gutenbergブロック形式のコンテンツ
$gutenberg_content = '
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">見出しレベル2</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>これは詳細な設定を持つ投稿の例です。Gutenbergブロックエディタ形式で作成されています。</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<!-- wp:list-item -->
<li>リスト項目1</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>リスト項目2</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>リスト項目3</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>投稿には様々な属性を設定できます。</p>
<!-- /wp:paragraph -->
';

$detailed_post = [
    'post_title'    => '詳細設定付きの投稿サンプル',
    'post_content'  => $gutenberg_content,
    'post_excerpt'  => 'これは投稿の抜粋（excerpt）です。一覧ページなどで使用されます。',
    'post_status'   => 'publish',
    'post_type'     => 'post',
    'post_author'   => 1,
    'comment_status' => 'open',     // open, closed
    'ping_status'   => 'closed',    // open, closed
    'post_name'     => 'detailed-sample-post',  // スラッグ（URL）
    'menu_order'    => 0,
];

$post_id2 = wp_insert_post($detailed_post);

if ($post_id2 && !is_wp_error($post_id2)) {
    echo "✅ 詳細設定付き投稿を作成しました (ID: $post_id2)\n";
    echo "   URL: " . get_permalink($post_id2) . "\n";
}

// ========================================
// 3. 下書き状態の投稿を作成
// ========================================
echo "\n3. 下書き（draft）投稿を作成\n";

$draft_post = [
    'post_title'    => '下書き投稿のサンプル',
    'post_content'  => 'この投稿は下書き状態で保存されます。',
    'post_status'   => 'draft',  // 下書き状態
    'post_type'     => 'post',
];

$post_id3 = wp_insert_post($draft_post);

if ($post_id3) {
    echo "✅ 下書き投稿を作成しました (ID: $post_id3)\n";
    echo "   ステータス: draft（管理画面でのみ表示）\n";
}

// ========================================
// 学習ポイント
// ========================================
echo "\n" . str_repeat("=", 50) . "\n";
echo "💡 学習ポイント:\n";
echo "- wp_insert_post()で投稿を作成\n";
echo "- post_statusで公開状態を制御（publish/draft/private）\n";
echo "- post_typeで投稿タイプを指定（post/page/カスタム）\n";
echo "- post_nameでスラッグ（URL）を設定\n";
echo "- 戻り値は投稿ID（エラーの場合はWP_Errorオブジェクト）\n";
echo str_repeat("=", 50) . "\n";