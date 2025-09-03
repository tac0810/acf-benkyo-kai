#!/bin/bash

script_dir=$(dirname "$0")

if [ ! -d "$script_dir/vendor" ]; then
    cd $script_dir && composer install
fi

wp eval-file "$script_dir/insert_fake_data.php" --allow-root