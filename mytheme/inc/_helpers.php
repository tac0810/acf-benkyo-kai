<?php

function get_rel_uri($current_uri)
{
  $current_uri = Timber\URLHelper::get_rel_url($current_uri, true);
  $current_uri = Timber\URLHelper::unpreslashit($current_uri);
  return Timber\URLHelper::remove_trailing_slash($current_uri);
}

function get_current_url()
{
  $current_url = Timber\URLHelper::get_current_url();
  return get_rel_uri($current_url);
}

function is_current($path)
{
  $current_url = get_current_url();
  return strpos($current_url, $path) === 0;
}

function add_ids_to_heading_tags($html) {
  $doc = new DOMDocument();
  // HTMLをロードする前にエラーを抑制
  libxml_use_internal_errors(true);
  $doc->loadHTML('<?xml encoding="utf-8" ?>'. $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
  libxml_clear_errors();

  $tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
  $idCounter = 1;

  foreach ($tags as $tag) {
    $elements = $doc->getElementsByTagName($tag);
    foreach ($elements as $element) {
      $element->setAttribute('id', 'heading-' . $idCounter);
      $idCounter++;
    }
  }

  return $doc->saveHTML();
}

function get_heading_tags($html) {
  $matches = [];
  // 正規表現を使ってhタグをマッチングする
  preg_match_all('/<(h[1-6])([^>]*)>(.*?)<\/\1>/', $html, $matches, PREG_SET_ORDER);

  $hTags = [];
  foreach ($matches as $match) {
    $tag = $match[1];
    $attributesString = $match[2];
    $content = $match[3];

    // 属性をパースする
    $attributes = [];
    preg_match_all('/(\w+)=["\']([^"\']*)["\']/', $attributesString, $attrMatches, PREG_SET_ORDER);
    foreach ($attrMatches as $attr) {
      $attributes[$attr[1]] = $attr[2];
    }

    // 結果を配列に格納する
    $hTags[] = [
      'tag' => $tag,
      'content' => $content,
      'attributes' => $attributes
    ];
  }

  return $hTags;
}

function debug($obj, $label = "")
{
  $label = "[Debug] : {$label}";
  $label .= " in ";
  $traces = debug_backtrace();
  $count = 0;
  foreach ($traces as $trace) {
    if (isset($trace["file"], $trace["line"]) && __FILE__ != $trace["file"]) {
      $label .= $trace["file"] . " (" . $trace["line"] . ")";
      if (++$count >= 5) {
        break;
      } else {
        $label .= "<br />";
      }
    }
  }
  echo '<div style="font:11px/1.2 Lucida Grande, Verdana, Geneva, Sans-serif; margin: 1em 0; padding: 0.5em; background:#e9e9e9; border:1px solid #D0D0D0;">';
  if (strlen($label)) {
    echo "<strong>" . $label . "</strong>";
  }
  echo '<pre style="display: block; background:#F4F4F4; border:1px solid #D0D0D0; color: #002166; margin:0.5em 0; padding:1em;">';
  if (is_bool($obj)) {
    echo (bool) $obj ? "true" : "false";
  } elseif (is_array($obj) || is_object($obj)) {
    print_r($obj);
  } else {
    echo $obj;
  }
  echo "</pre>";
  echo "</div>";
}

function render_timber_templates($templates, $context)
{
  $IS_DEVELOPMENT = $context["IS_DEVELOPMENT"];
  $render = Timber::compile($templates, $context);

  if (!isset($_SERVER["HTTP_HOST"]) || (!is_admin() && $IS_DEVELOPMENT)) {
    $hostname = $_SERVER["HTTP_HOST"];
    if ($IS_DEVELOPMENT && str_contains($hostname, "localhost")) {
      $hostname = parse_url($hostname, PHP_URL_HOST);
    }
    if (strpos($hostname, ":") !== false) {
      list($hostname, $port) = explode(":", $hostname, 2);
    }
    echo str_replace("localhost", $hostname, $render);
  } else {
    echo $render;
  }
}

function check_vite_connection()
{
  if (!$_ENV["IS_DEVELOPMENT"]) {
    return false;
  }

  $host = "host.docker.internal";
  $port = 3000;
  $connection = @fsockopen($host, $port, $errno, $errstr, 5); // 5秒のタイムアウト

  if ($connection) {
    fclose($connection);
    return true;
  } else {
    return false;
  }
}

function simple_logger($var, $prefix = "", $suffix = "\n")
{
  error_log(
    $prefix . print_r($var, true) . $suffix,
    3,
    get_template_directory() . "/my-errors.log"
  );
}

function logger($var)
{
  if (!$_ENV["IS_DEVELOPMENT"]) {
    return false;
  }
  $traces = debug_backtrace();
  $count = 0;
  $label = "";
  foreach ($traces as $trace) {
    if (isset($trace["file"], $trace["line"]) && __FILE__ != $trace["file"]) {
      $label .= $trace["file"] . " (" . $trace["line"] . ")";
      if (++$count >= 3) {
        break;
      } else {
        $label .= "\n";
      }
    }
  }

  simple_logger($var, "----------\n$label\n");
}
