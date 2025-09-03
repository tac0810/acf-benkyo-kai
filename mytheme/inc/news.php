<?php

namespace WordPressStarter\Theme;

add_action("init", function () {
  register_post_type(THEME_NAME . "_news", [
    "label" => "お知らせ",
    "public" => true,
    "supports" => ["title", "editor", "thumbnail"],
    "has_archive" => true,
    "show_in_rest" => true,
    "rewrite" => ["slug" => "news"],
  ]);

  register_taxonomy(
    THEME_NAME . "_news_category",
    [THEME_NAME . "_news"],
    [
      "label" => "カテゴリー",
      "hierarchical" => true,
      "show_in_rest" => true,
      "rewrite" => ["slug" => "news/category"],
    ]
  );

  add_rewrite_rule(
    'news/category/([^/]+)/?$',
    sprintf('index.php?post_type=%s_news&%s_news_category=$matches[1]', THEME_NAME, THEME_NAME),
    "top"
  );
});

add_action("pre_get_posts", function ($query) {
  if (is_admin() || !$query->is_main_query()) {
    return;
  }

  if (is_post_type_archive(THEME_NAME . "_news") || is_tax(THEME_NAME . "_news_category")) {
    $query->set("posts_per_page", 12);
  }
});
