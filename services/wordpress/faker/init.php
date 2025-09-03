<?php

require_once __DIR__ . "/vendor/autoload.php";

const ROOT = __DIR__;

global $faker_ja;
global $faker_en;

$faker_ja = Faker\Factory::create("ja_JP");
$faker_en = Faker\Factory::create("en_US");

// Core libraries (再利用可能)
require_once __DIR__ . "/lib/Core/TraitCallback.php";
require_once __DIR__ . "/lib/Core/TraitFaker.php";
require_once __DIR__ . "/lib/Core/ImageManager.php";
require_once __DIR__ . "/lib/Core/TaxonomyManager.php";
require_once __DIR__ . "/lib/Core/PostManager.php";

require_once __DIR__ . "/helpers.php";
