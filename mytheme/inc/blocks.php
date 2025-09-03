<?php

namespace WordPressStarter\Theme;

add_action("admin_enqueue_scripts", function () {
  $IS_VITE_RUNNING = check_vite_connection();
  global $pagenow;
  if (
    ($_ENV["IS_DEVELOPMENT"] || $IS_VITE_RUNNING) &&
    ($pagenow === "post.php" || $pagenow === "post-new.php")
  ) {
    echo '<script type="module" src="http://localhost:3000/@vite/client"></script>';
    echo '<script type="module" src="http://localhost:3000/source/index.ts"></script>';
  }
});

add_action("enqueue_block_editor_assets", function () {
  $manifest = file_get_contents(dirname(__DIR__) . "/build/.vite/manifest.json");

  if (!isset($manifest)) {
    return null;
  }

  $manifest = json_decode($manifest, true);
  $entry = $manifest["source/index.ts"];
  $build_path = get_template_directory_uri() . "/build/";

  foreach ($entry["css"] as $css) {
    wp_enqueue_style("block-editor-styles", $build_path . $css, [], "1.0", "all");
  }

  foreach (glob(dirname(__DIR__) . "/editor/{*.js}", GLOB_BRACE) as $file) {
    if (!is_file($file)) {
      continue;
    }

    $info = pathinfo($file);

    wp_register_script(
      "custom-{$info["filename"]}",
      get_template_directory_uri() . "/editor/{$info["basename"]}",
      ["wp-blocks", "wp-editor", "wp-components", "wp-i18n"]
    );
    register_block_type("custom/{$info["filename"]}", [
      "editor_script" => "custom-{$info["filename"]}",
    ]);
  }
});

add_action(
  "init",
  function () {
    foreach (glob(dirname(__DIR__) . "/blocks/*", GLOB_ONLYDIR) as $dir) {
      register_block_type($dir);
    }
  },
  5
);

add_filter(
  "allowed_block_types_all",
  function ($allowed_block_types, $block_editor_context) {
    $block_types = [
      "custom/paragraph",
    ];

    //		if ($block_editor_context->post->post_type == "post") {
    //
    //		}

    return $block_types;
  },
  10,
  2
);
