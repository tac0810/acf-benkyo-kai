<?php

// グローバルFakerインスタンスを使用
global $faker_ja, $faker_en;

echo "Sample with new Core libraries\n";
echo $faker_ja->realText(random_int(30, 60)) . "\n\n";

// PostManagerの使用例
// $postManager = new PostManager('post');
// $postManager->bulkGenerate(5); // 5つのダミー投稿を生成

// TaxonomyManagerの使用例
// $taxManager = new TaxonomyManager('category');
// $taxManager->bulkInsert([
//     ['slug' => 'news', 'title' => 'ニュース'],
//     ['slug' => 'tech', 'title' => 'テクノロジー'],
// ]);

// TraitFakerのstatic関数使用例
// $text = TraitFaker::fake(['type' => TraitFaker::$TEXT, 'range' => [20, 50]]);
// $html = TraitFaker::fake(['type' => TraitFaker::$HTML]);
// $slug = TraitFaker::fake(['type' => TraitFaker::$SLUG]);

/*
  // ACF
  update_field('name', value, 'post_id' or 'option')

  // Term
 _wp("term create 'TAXONOMY_NAME' TITLE --slug='SLUG'");

  // Post
  $id = _wp(
    "post create --post_type=POST_TYPE --post_title='TITLE' --post_name='SLUG' --post_status=publish --porcelain"
  );
 */


