<?php

namespace WordPressStarter\Theme;

use Timber;
use Twig;

Timber\Timber::init();

Timber::$dirname = ["views"];

add_filter("timber/twig", function ($twig) {
  $twig->addFunction(
    new Twig\TwigFunction("get_rel_uri", function ($url) {
      return get_rel_uri($url);
    })
  );

  $twig->addFunction(
    new Twig\TwigFunction("get_current_url", function () {
      return get_current_url();
    })
  );

  $twig->addFunction(
    new Twig\TwigFunction("is_current", function ($path) {
      return is_current($path);
    })
  );

  $twig->addFunction(
    new Twig\TwigFunction("get_field", function ($selector, $id) {
      return get_field($selector, $id);
    })
  );

  $twig->addFunction(
    new Twig\TwigFunction("assets_path", function ($path) {
      return get_template_directory_uri() . "/assets/" . $path;
    })
  );

  $twig->addFunction(
    new Twig\TwigFunction("debug", function ($value) {
      return debug($value);
    })
  );

  $twig->addFunction(
    new Twig\TwigFunction("build_assets", function () {
      $manifest = file_get_contents(dirname(__DIR__) . "/build/.vite/manifest.json");

      if (!isset($manifest)) {
        return null;
      }

      $manifest = json_decode($manifest, true);
      $entry = $manifest["source/index.ts"];
      $build_path = get_template_directory_uri() . "/build/";

      $html = "<!-- production build -->";
      $html .= sprintf('<script type="module" src="%s"></script>', $build_path . $entry["file"]);
      $html .= "\n";

      foreach ($entry["dynamicImports"] as $dynamicImport) {
        $import = $manifest[$dynamicImport];
        $html .= sprintf('<script type="module" src="%s"></script>', $build_path . $import["file"]);
      }

      foreach ($entry["css"] as $css) {
        $html .= sprintf('<link rel="stylesheet" href="%s" />', $build_path . $css);
      }

      return $html;
    })
  );

  $twig->addFunction(
    new Twig\TwigFunction("sprite", function ($context, $id, $attr = "") {
      $sprite_path = sprintf("/build/sprites/%s.svg", $context);

      $sprite = simplexml_load_string(file_get_contents(dirname(__DIR__) . $sprite_path));

      $default_attr = [];

      foreach ($sprite->symbol as $symbol) {
        $symbol_attr = $symbol->attributes();

        if ($id === (string) $symbol_attr->id) {
          $viewBox = (string) $symbol_attr->viewBox;
          list($min_x, $min_y, $width, $height) = array_map("floatval", explode(" ", $viewBox));
          $default_attr["width"] = $width - $min_x;
          $default_attr["height"] = $height - $min_y;

          break;
        }
      }

      if (!(isset($default_attr["width"]) && isset($default_attr["height"]))) {
        return false;
      }

      $attr = wp_parse_args($attr, $default_attr);
      $attr = array_map("esc_attr", $attr);
      $html = "<svg";

      foreach ($attr as $name => $value) {
        $html .= " $name=" . '"' . $value . '"';
      }

      $html .= ">";

      $use_href = get_template_directory_uri() . $sprite_path . "#" . $id;
      $html .= '<use href="' . $use_href . '" />';

      $html .= "</svg>";

      return $html;
    })
  );

  $twig->addFilter(
    new Twig\TwigFilter( 'parse_heading_tags', 'get_heading_tags' )
  );

  $twig->addFilter(
    new Twig\TwigFilter( 'add_ids_to_heading_tags', 'add_ids_to_heading_tags' )
  );

  return $twig;
});

add_filter("timber/context", function ($context) {
  $context["IS_DEVELOPMENT"] = $_ENV["IS_DEVELOPMENT"];
  $context["IS_VITE_RUNNING"] = check_vite_connection();

  $context["navigation"] = [
    "home" => home_url(),
    "main" => [
      "about" => [
        "label" => "私たちについて",
        "link" => get_permalink(get_page_by_path("about")),
      ],
      "news" => [
        "label" => [
          "en" => "News",
          "ja" => "お知らせ",
        ],
        "link" => get_post_type_archive_link("news"),
      ],
      "contact" => [
        "label" => [
          "en" => "Contact",
          "ja" => "お問いわせ",
        ],
        "link" => get_permalink(get_page_by_path("contact")),
      ],
    ],
    "sub" => [
      "privacy" => [
        "label" => [
          "en" => "Privacy Policy",
          "ja" => "プライバシーポリシー",
        ],
        "link" => get_permalink(get_page_by_path("privacy-policy")),
      ],
    ],
  ];

  return $context;
});
