<?php

$faker = Faker\Factory::create("ja_JP");

echo "this is sample\n";
echo $faker->realText(random_int(30, 60));

/*

  // ACF
  update_field('name', value, 'post_id' or 'option')

  // Term
 _wp("term create 'TAXONOMY_NAME' TITLE --slug='SLUG'");

  // Post
  $id = _wp(
    "post create --post_type=POST_TYPE --post_title='TITLE' --post_name='SLUG' --post_status=publish --porcelain"
  );

 * */


