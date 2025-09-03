<?php

namespace WordPressStarter\Theme;

use Timber;

$context = Timber::context();

$timber_post = Timber::get_post();
$context["post"] = $timber_post;
render_timber_templates(["page-" . $timber_post->post_name . ".twig", "page.twig"], $context);
