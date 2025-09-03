<?php

/**
 * Pages Collection
 * 階層構造を持つ固定ページの生成
 */

global $faker_ja;

echo "Creating pages with hierarchy...\n";

$pageManager = new PostManager('page');

// 階層構造を持つページデータ
$pages = [
    [
        'slug' => 'about',
        'title' => '会社概要',
        'children' => [
            ['slug' => 'about/company', 'title' => '会社情報'],
            ['slug' => 'about/history', 'title' => '沿革'],
            ['slug' => 'about/team', 'title' => 'チーム']
        ]
    ],
    [
        'slug' => 'services',
        'title' => 'サービス',
        'children' => [
            ['slug' => 'services/web-development', 'title' => 'Web開発'],
            ['slug' => 'services/consulting', 'title' => 'コンサルティング'],
            ['slug' => 'services/support', 'title' => 'サポート']
        ]
    ],
    [
        'slug' => 'contact',
        'title' => 'お問い合わせ'
    ],
    [
        'slug' => 'privacy',
        'title' => 'プライバシーポリシー'
    ],
    [
        'slug' => 'terms',
        'title' => '利用規約'
    ]
];

// ページコンテンツ追加用のコールバック
$pageManager->setCallback('insert.after', function($post_id, $item) use ($faker_ja) {
    // Gutenbergブロック形式のページコンテンツを生成
    $gutenberg_content = '';
    
    // ヒーローセクション（カバーブロック）
    $gutenberg_content .= '<!-- wp:cover {"dimRatio":50,"overlayColor":"black","isDark":false} -->' . "\n";
    $gutenberg_content .= '<div class="wp-block-cover is-light">' . "\n";
    $gutenberg_content .= '<span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim"></span>' . "\n";
    $gutenberg_content .= '<div class="wp-block-cover__inner-container">' . "\n";
    $gutenberg_content .= '<!-- wp:heading {"textAlign":"center","level":1} -->' . "\n";
    $gutenberg_content .= '<h1 class="wp-block-heading has-text-align-center">' . $item['title'] . '</h1>' . "\n";
    $gutenberg_content .= '<!-- /wp:heading -->' . "\n";
    $gutenberg_content .= '<!-- wp:paragraph {"align":"center"} -->' . "\n";
    $gutenberg_content .= '<p class="has-text-align-center">' . $faker_ja->realText(50) . '</p>' . "\n";
    $gutenberg_content .= '<!-- /wp:paragraph -->' . "\n";
    $gutenberg_content .= '</div>' . "\n";
    $gutenberg_content .= '</div>' . "\n";
    $gutenberg_content .= '<!-- /wp:cover -->' . "\n\n";
    
    // 段落ブロック
    $gutenberg_content .= '<!-- wp:paragraph -->' . "\n";
    $gutenberg_content .= '<p>' . $faker_ja->realText(200) . '</p>' . "\n";
    $gutenberg_content .= '<!-- /wp:paragraph -->' . "\n\n";
    
    // グループブロック（背景色付き）
    $gutenberg_content .= '<!-- wp:group {"backgroundColor":"light-gray","layout":{"type":"constrained"}} -->' . "\n";
    $gutenberg_content .= '<div class="wp-block-group has-light-gray-background-color has-background">' . "\n";
    
    $gutenberg_content .= '<!-- wp:heading {"level":2} -->' . "\n";
    $gutenberg_content .= '<h2 class="wp-block-heading">' . $faker_ja->realText(30) . '</h2>' . "\n";
    $gutenberg_content .= '<!-- /wp:heading -->' . "\n";
    
    $gutenberg_content .= '<!-- wp:paragraph -->' . "\n";
    $gutenberg_content .= '<p>' . $faker_ja->realText(150) . '</p>' . "\n";
    $gutenberg_content .= '<!-- /wp:paragraph -->' . "\n";
    
    $gutenberg_content .= '</div>' . "\n";
    $gutenberg_content .= '<!-- /wp:group -->' . "\n\n";
    
    // カラムブロック（3カラム）
    $gutenberg_content .= '<!-- wp:columns -->' . "\n";
    $gutenberg_content .= '<div class="wp-block-columns">' . "\n";
    
    for ($i = 0; $i < 3; $i++) {
        $gutenberg_content .= '<!-- wp:column -->' . "\n";
        $gutenberg_content .= '<div class="wp-block-column">' . "\n";
        
        $gutenberg_content .= '<!-- wp:heading {"level":3} -->' . "\n";
        $gutenberg_content .= '<h3 class="wp-block-heading">' . $faker_ja->realText(20) . '</h3>' . "\n";
        $gutenberg_content .= '<!-- /wp:heading -->' . "\n";
        
        $gutenberg_content .= '<!-- wp:paragraph -->' . "\n";
        $gutenberg_content .= '<p>' . $faker_ja->realText(80) . '</p>' . "\n";
        $gutenberg_content .= '<!-- /wp:paragraph -->' . "\n";
        
        $gutenberg_content .= '</div>' . "\n";
        $gutenberg_content .= '<!-- /wp:column -->' . "\n";
    }
    
    $gutenberg_content .= '</div>' . "\n";
    $gutenberg_content .= '<!-- /wp:columns -->' . "\n\n";
    
    // スペーサーブロック
    $gutenberg_content .= '<!-- wp:spacer {"height":"50px"} -->' . "\n";
    $gutenberg_content .= '<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>' . "\n";
    $gutenberg_content .= '<!-- /wp:spacer -->' . "\n\n";
    
    // メディアとテキストブロック
    $gutenberg_content .= '<!-- wp:media-text {"mediaPosition":"right"} -->' . "\n";
    $gutenberg_content .= '<div class="wp-block-media-text has-media-on-the-right is-stacked-on-mobile">' . "\n";
    $gutenberg_content .= '<div class="wp-block-media-text__content">' . "\n";
    
    $gutenberg_content .= '<!-- wp:heading {"level":3} -->' . "\n";
    $gutenberg_content .= '<h3 class="wp-block-heading">' . $faker_ja->realText(25) . '</h3>' . "\n";
    $gutenberg_content .= '<!-- /wp:heading -->' . "\n";
    
    $gutenberg_content .= '<!-- wp:paragraph -->' . "\n";
    $gutenberg_content .= '<p>' . $faker_ja->realText(120) . '</p>' . "\n";
    $gutenberg_content .= '<!-- /wp:paragraph -->' . "\n";
    
    $gutenberg_content .= '</div>' . "\n";
    $gutenberg_content .= '<figure class="wp-block-media-text__media"></figure>' . "\n";
    $gutenberg_content .= '</div>' . "\n";
    $gutenberg_content .= '<!-- /wp:media-text -->' . "\n\n";
    
    // 最終段落
    $gutenberg_content .= '<!-- wp:paragraph -->' . "\n";
    $gutenberg_content .= '<p>' . $faker_ja->realText(180) . '</p>' . "\n";
    $gutenberg_content .= '<!-- /wp:paragraph -->' . "\n";
    
    wp_update_post([
        'ID' => $post_id,
        'post_content' => $gutenberg_content
    ]);
    
    echo "  - Page created: {$item['title']} (ID: $post_id)\n";
});

// ページを一括作成
$result = $pageManager->bulkInsert($pages);

echo "✓ " . count($result) . " pages created successfully\n";