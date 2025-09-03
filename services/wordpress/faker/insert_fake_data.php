<?php

require_once __DIR__ . "/init.php";
require_once __DIR__ . "/delete_data.php";

//_wp('help');

//update_field('option--home--statement', "bar", 'option');

foreach (glob(__DIR__ . "/collections/*.php", GLOB_BRACE) as $file) {
  try {
    $basename = basename($file);
    echo "Start to insert from $basename\n";
    require_once $file;
    echo "\n";
    echo "Complete $basename\n";
  } catch (Exception $exception) {
    echo "$exception\n";
  }
}
