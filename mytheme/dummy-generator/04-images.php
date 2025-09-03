<?php
/**
 * 04. 画像の設定とメディアライブラリ
 * 
 * アイキャッチ画像の設定、メディアライブラリへのアップロード、
 * 画像の管理方法を学びます。
 */

echo "🖼️ 画像の設定を開始します...\n\n";

// 必要なファイルをインクルード
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

// ========================================
// 1. サンプル画像を生成してアップロード
// ========================================
echo "1. サンプル画像を生成\n";

$uploaded_images = [];
$upload_dir = wp_upload_dir();

// GDライブラリが利用可能か確認
if (!function_exists('imagecreatetruecolor')) {
    echo "  ⚠️ GDライブラリが利用できません。画像処理をスキップします。\n";
    return;
}

// GDライブラリで3つの画像を生成
for ($i = 1; $i <= 3; $i++) {
    $width = 800;
    $height = 600;
    $image = imagecreatetruecolor($width, $height);
    
    // ランダムな背景色
    $bg_color = imagecolorallocate($image, rand(100, 200), rand(100, 200), rand(100, 200));
    imagefill($image, 0, 0, $bg_color);
    
    // テキストを追加
    $text_color = imagecolorallocate($image, 255, 255, 255);
    imagestring($image, 5, 350, 290, "Sample {$i}", $text_color);
    
    // 画像を保存
    $filename = "sample-{$i}.png";
    $filepath = $upload_dir['path'] . '/' . $filename;
    imagepng($image, $filepath);
    imagedestroy($image);
    
    // WordPressに登録
    $attachment = [
        'guid'           => $upload_dir['url'] . '/' . $filename,
        'post_mime_type' => 'image/png',
        'post_title'     => "サンプル画像{$i}",
        'post_status'    => 'inherit'
    ];
    
    $attach_id = wp_insert_attachment($attachment, $filepath);
    if ($attach_id) {
        $attach_data = wp_generate_attachment_metadata($attach_id, $filepath);
        wp_update_attachment_metadata($attach_id, $attach_data);
        $uploaded_images[] = $attach_id;
        echo "  ✅ 画像{$i}を生成 (ID: $attach_id)\n";
    }
}

// ========================================
// 2. 画像を使った投稿を作成
// ========================================
echo "\n2. 画像付き投稿を作成\n";

// 画像が生成されているか確認
if (count($uploaded_images) < 3) {
    echo "  ⚠️ 画像の生成に失敗したため、投稿作成をスキップします\n";
    return;
}

// 画像URLを取得
$image_url_1 = wp_get_attachment_url($uploaded_images[0]);
$image_url_2 = wp_get_attachment_url($uploaded_images[1]);
$image_url_3 = wp_get_attachment_url($uploaded_images[2]);

// Gutenbergブロックで画像を含む投稿
$content = '
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">画像の活用方法</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>WordPressでは画像を様々な方法で活用できます。</p>
<!-- /wp:paragraph -->

<!-- wp:image {"id":' . $uploaded_images[0] . ',"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="' . $image_url_1 . '" alt="メインビジュアル" class="wp-image-' . $uploaded_images[0] . '"/><figcaption>アイキャッチ画像として設定</figcaption></figure>
<!-- /wp:image -->

<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:image {"id":' . $uploaded_images[1] . ',"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img src="' . $image_url_2 . '" alt="サンプル画像1" class="wp-image-' . $uploaded_images[1] . '"/><figcaption>カラム内の画像1</figcaption></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:image {"id":' . $uploaded_images[2] . ',"sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img src="' . $image_url_3 . '" alt="サンプル画像2" class="wp-image-' . $uploaded_images[2] . '"/><figcaption>カラム内の画像2</figcaption></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">画像の設定ポイント</h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<!-- wp:list-item -->
<li>アイキャッチ画像: set_post_thumbnail()で設定</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>本文内の画像: Gutenbergブロックで挿入</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>メタデータ: Altテキストやキャプションを設定</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
';

$post_id = wp_insert_post([
    'post_title'   => '画像活用の完全ガイド',
    'post_content' => $content,
    'post_status'  => 'publish',
    'post_type'    => 'post',
]);

if ($post_id) {
    // アイキャッチ画像を設定
    set_post_thumbnail($post_id, $uploaded_images[0]);
    echo "  ✅ 投稿を作成してアイキャッチ画像を設定 (ID: $post_id)\n";
    
    // 画像のメタデータを設定
    update_post_meta($uploaded_images[0], '_wp_attachment_image_alt', 'メインビジュアル');
    
    // カテゴリーも設定
    $cat_id = wp_create_category('チュートリアル');
    if ($cat_id) {
        wp_set_post_categories($post_id, [$cat_id]);
    }
    
    // タグも設定
    wp_set_post_tags($post_id, '画像,WordPress,メディア');
    
    echo "  ✅ カテゴリーとタグも設定完了\n";
}

// ========================================
// 学習ポイント
// ========================================
echo "\n" . str_repeat("=", 50) . "\n";
echo "💡 学習ポイント:\n";
echo "- imagecreatetruecolor()でPHP画像生成\n";
echo "- wp_insert_attachment()でメディア登録\n";
echo "- set_post_thumbnail()でアイキャッチ設定\n";
echo "- Gutenbergブロックでの画像配置\n";
echo "- wp_get_attachment_image()で画像HTML生成\n";
echo str_repeat("=", 50) . "\n";