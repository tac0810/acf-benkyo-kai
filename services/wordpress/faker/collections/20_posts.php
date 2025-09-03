<?php

/**
 * Posts Collection with ACF Support
 * 投稿の生成とACFフィールドの自動設定
 */

global $faker_ja, $faker_en;

echo "Creating posts with ACF fields...\n";

// カテゴリーの作成
$categoryManager = new TaxonomyManager('category');
$categories = [
    ['slug' => 'news', 'title' => 'ニュース'],
    ['slug' => 'tech', 'title' => 'テクノロジー'],
    ['slug' => 'business', 'title' => 'ビジネス'],
    ['slug' => 'lifestyle', 'title' => 'ライフスタイル']
];
$categoryManager->bulkInsert($categories);
echo "  - " . count($categories) . " categories created\n";

// タグの作成
$tagManager = new TaxonomyManager('post_tag');
$tags = [];
for ($i = 1; $i <= 15; $i++) {
    $tags[] = [
        'slug' => $faker_en->slug(2),
        'title' => $faker_ja->word
    ];
}
$tagManager->bulkInsert($tags);
echo "  - " . count($tags) . " tags created\n";

// PostManagerの設定
$postManager = new PostManager('post');

// ACF更新用コールバック
$postManager->setCallback('insert.after', function($post_id, $item) use ($faker_ja, $faker_en) {
    
    // Gutenbergブロック形式のコンテンツを生成
    $gutenberg_content = '';
    
    // 段落ブロック
    $gutenberg_content .= '<!-- wp:paragraph -->' . "\n";
    $gutenberg_content .= '<p>' . $faker_ja->realText(200) . '</p>' . "\n";
    $gutenberg_content .= '<!-- /wp:paragraph -->' . "\n\n";
    
    // 見出しブロック (H2)
    $gutenberg_content .= '<!-- wp:heading {"level":2} -->' . "\n";
    $gutenberg_content .= '<h2 class="wp-block-heading">' . $faker_ja->realText(30) . '</h2>' . "\n";
    $gutenberg_content .= '<!-- /wp:heading -->' . "\n\n";
    
    // 段落ブロック
    $gutenberg_content .= '<!-- wp:paragraph -->' . "\n";
    $gutenberg_content .= '<p>' . $faker_ja->realText(150) . '</p>' . "\n";
    $gutenberg_content .= '<!-- /wp:paragraph -->' . "\n\n";
    
    // リストブロック
    $gutenberg_content .= '<!-- wp:list -->' . "\n";
    $gutenberg_content .= '<ul>' . "\n";
    for ($i = 0; $i < rand(3, 5); $i++) {
        $gutenberg_content .= '<!-- wp:list-item -->' . "\n";
        $gutenberg_content .= '<li>' . $faker_ja->realText(30) . '</li>' . "\n";
        $gutenberg_content .= '<!-- /wp:list-item -->' . "\n";
    }
    $gutenberg_content .= '</ul>' . "\n";
    $gutenberg_content .= '<!-- /wp:list -->' . "\n\n";
    
    // 引用ブロック
    $gutenberg_content .= '<!-- wp:quote -->' . "\n";
    $gutenberg_content .= '<blockquote class="wp-block-quote">' . "\n";
    $gutenberg_content .= '<p>' . $faker_ja->realText(100) . '</p>' . "\n";
    $gutenberg_content .= '<cite>' . $faker_ja->name . '</cite>' . "\n";
    $gutenberg_content .= '</blockquote>' . "\n";
    $gutenberg_content .= '<!-- /wp:quote -->' . "\n\n";
    
    // 見出しブロック (H3)
    $gutenberg_content .= '<!-- wp:heading {"level":3} -->' . "\n";
    $gutenberg_content .= '<h3 class="wp-block-heading">' . $faker_ja->realText(25) . '</h3>' . "\n";
    $gutenberg_content .= '<!-- /wp:heading -->' . "\n\n";
    
    // カラムブロック (2カラム)
    $gutenberg_content .= '<!-- wp:columns -->' . "\n";
    $gutenberg_content .= '<div class="wp-block-columns">' . "\n";
    
    // 左カラム
    $gutenberg_content .= '<!-- wp:column -->' . "\n";
    $gutenberg_content .= '<div class="wp-block-column">' . "\n";
    $gutenberg_content .= '<!-- wp:paragraph -->' . "\n";
    $gutenberg_content .= '<p>' . $faker_ja->realText(100) . '</p>' . "\n";
    $gutenberg_content .= '<!-- /wp:paragraph -->' . "\n";
    $gutenberg_content .= '</div>' . "\n";
    $gutenberg_content .= '<!-- /wp:column -->' . "\n";
    
    // 右カラム
    $gutenberg_content .= '<!-- wp:column -->' . "\n";
    $gutenberg_content .= '<div class="wp-block-column">' . "\n";
    $gutenberg_content .= '<!-- wp:paragraph -->' . "\n";
    $gutenberg_content .= '<p>' . $faker_ja->realText(100) . '</p>' . "\n";
    $gutenberg_content .= '<!-- /wp:paragraph -->' . "\n";
    $gutenberg_content .= '</div>' . "\n";
    $gutenberg_content .= '<!-- /wp:column -->' . "\n";
    
    $gutenberg_content .= '</div>' . "\n";
    $gutenberg_content .= '<!-- /wp:columns -->' . "\n\n";
    
    // テーブルブロック
    $gutenberg_content .= '<!-- wp:table -->' . "\n";
    $gutenberg_content .= '<figure class="wp-block-table"><table>' . "\n";
    $gutenberg_content .= '<thead>' . "\n";
    $gutenberg_content .= '<tr><th>項目</th><th>説明</th><th>値</th></tr>' . "\n";
    $gutenberg_content .= '</thead>' . "\n";
    $gutenberg_content .= '<tbody>' . "\n";
    for ($i = 0; $i < 3; $i++) {
        $gutenberg_content .= '<tr>';
        $gutenberg_content .= '<td>' . $faker_ja->word . '</td>';
        $gutenberg_content .= '<td>' . $faker_ja->realText(30) . '</td>';
        $gutenberg_content .= '<td>' . $faker_ja->numberBetween(100, 9999) . '</td>';
        $gutenberg_content .= '</tr>' . "\n";
    }
    $gutenberg_content .= '</tbody>' . "\n";
    $gutenberg_content .= '</table></figure>' . "\n";
    $gutenberg_content .= '<!-- /wp:table -->' . "\n\n";
    
    // セパレーターブロック
    $gutenberg_content .= '<!-- wp:separator -->' . "\n";
    $gutenberg_content .= '<hr class="wp-block-separator has-alpha-channel-opacity"/>' . "\n";
    $gutenberg_content .= '<!-- /wp:separator -->' . "\n\n";
    
    // 最後の段落ブロック
    $gutenberg_content .= '<!-- wp:paragraph -->' . "\n";
    $gutenberg_content .= '<p>' . $faker_ja->realText(120) . '</p>' . "\n";
    $gutenberg_content .= '<!-- /wp:paragraph -->' . "\n";
    
    // ボタンブロック
    $gutenberg_content .= '<!-- wp:buttons -->' . "\n";
    $gutenberg_content .= '<div class="wp-block-buttons">' . "\n";
    $gutenberg_content .= '<!-- wp:button -->' . "\n";
    $gutenberg_content .= '<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">詳細を見る</a></div>' . "\n";
    $gutenberg_content .= '<!-- /wp:button -->' . "\n";
    $gutenberg_content .= '</div>' . "\n";
    $gutenberg_content .= '<!-- /wp:buttons -->' . "\n";
    
    wp_update_post([
        'ID' => $post_id,
        'post_content' => $gutenberg_content
    ]);
    
    // カテゴリーの割り当て（ランダムに1-2個）
    $category_ids = get_terms([
        'taxonomy' => 'category',
        'fields' => 'ids',
        'hide_empty' => false
    ]);
    if (!empty($category_ids)) {
        $selected_categories = array_rand(array_flip($category_ids), rand(1, min(2, count($category_ids))));
        if (!is_array($selected_categories)) {
            $selected_categories = [$selected_categories];
        }
        wp_set_post_categories($post_id, $selected_categories);
    }
    
    // タグの割り当て（ランダムに2-5個）
    $tag_ids = get_terms([
        'taxonomy' => 'post_tag',
        'fields' => 'ids',
        'hide_empty' => false
    ]);
    if (!empty($tag_ids)) {
        $num_tags = rand(2, min(5, count($tag_ids)));
        $selected_tags = array_rand(array_flip($tag_ids), $num_tags);
        if (!is_array($selected_tags)) {
            $selected_tags = [$selected_tags];
        }
        wp_set_post_tags($post_id, $selected_tags);
    }
    
    // ACFフィールドが存在する場合の更新処理（group_68b85961899b4.json に基づく）
    if (function_exists('update_field')) {
        
        // テキストフィールド (field_68b859619448a)
        update_field('text', $faker_ja->realText(50), $post_id);
        
        // WYSIWYGエディタ (field_68b8597d9448c)
        $wysiwyg_content = '<h3>' . $faker_ja->realText(30) . '</h3>';
        $wysiwyg_content .= '<p>' . $faker_ja->realText(200) . '</p>';
        $wysiwyg_content .= '<ul>';
        for ($i = 0; $i < rand(3, 5); $i++) {
            $wysiwyg_content .= '<li>' . $faker_ja->realText(30) . '</li>';
        }
        $wysiwyg_content .= '</ul>';
        $wysiwyg_content .= '<p>' . $faker_ja->realText(150) . '</p>';
        update_field('wysiwyg', $wysiwyg_content, $post_id);
        
        // 日時フィールド (field_68b8598c9448d)
        $random_datetime = $faker_en->dateTimeBetween('-1 year', 'now')->format('d/m/Y g:i a');
        update_field('datetime', $random_datetime, $post_id);
        
        // グループフィールド (field_68b859b99448e)
        $group_data = [
            'text' => $faker_ja->realText(40)
        ];
        update_field('group', $group_data, $post_id);
        
        // リピーターフィールド (field_68b859dc94490)
        $repeater_data = [];
        $num_items = rand(3, 8);
        for ($i = 0; $i < $num_items; $i++) {
            $repeater_data[] = [
                'text' => $faker_ja->realText(30)
            ];
        }
        update_field('repeat', $repeater_data, $post_id);
        
        // フレキシブルコンテンツ (field_68b859fb94492)
        $flexible_data = [];
        $num_flexible = rand(2, 5);
        for ($i = 0; $i < $num_flexible; $i++) {
            // 現在は「文章」レイアウトのみ定義されている
            $flexible_data[] = [
                'acf_fc_layout' => 'paragraph',
                'text' => $faker_ja->realText(100)
            ];
        }
        update_field('flexible', $flexible_data, $post_id);
        
        // 画像フィールド (field_68b859709448b)
        // ImageManagerを使用してfixture画像をアップロード
        $imageManager = new ImageManager();
        $aspects = ['16x9', '4x3', '1x1', '3x4'];
        $sizes = ['large', 'medium', 'small'];
        
        // ランダムなアスペクト比とサイズで画像を取得
        $aspect = $aspects[array_rand($aspects)];
        $size = $sizes[array_rand($sizes)];
        
        $image_id = $imageManager->getFixtureByAspect($aspect, $size);
        if ($image_id) {
            update_field('image', $image_id, $post_id);
            
            // アイキャッチ画像としても設定
            set_post_thumbnail($post_id, $image_id);
            
            echo "      - Image uploaded: {$aspect} ({$size})\n";
        }
        
        echo "    - ACF fields updated (Post: Sample group)\n";
    }
    
    
    echo "  - Post created: {$item['title']} (ID: $post_id)\n";
});

// 投稿を生成
echo "\nGenerating posts...\n";
$postManager->bulkGenerate(20);

echo "✓ 20 posts with ACF fields created successfully\n";