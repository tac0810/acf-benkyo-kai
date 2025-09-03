<?php

class PostManager
{
	use TraitCallback, TraitFaker;

	static function hasChildren($item)
	{
		return !empty($item["children"]) && is_array($item["children"]);
	}

	public $post_type;

	function __construct($post_type)
	{
		$this->post_type = $post_type;
	}

	function deleteBySlug($slug)
	{
		$post = get_page_by_path($slug);
		if (!$post) {
			return;
		}

		wp_delete_post($post->ID, true);
	}

	function deleteAllGeneratedItems()
	{
		$all_posts = get_posts([
			"post_type" => $this->post_type,
			"post_status" => "any",
			"numberposts" => -1,
			"fields" => "ids",
		]);

		foreach ($all_posts as $post_id) {
			$title = get_the_title($post_id);
			if (preg_match("/^\d+\s+Bulked:\s+/", $title)) {
				wp_delete_post($post_id, true);
			}
		}
	}

	function insert($item, $parent_id = 0)
	{
		$post_id = wp_insert_post([
			"post_name" => $item["slug"],
			"post_title" => $item["title"],
			"post_status" => "publish",
			"post_type" => $this->post_type,
			"post_author" => 1,
			"post_parent" => $parent_id,
		]);

		$this->callCallback("insert.after", $post_id, $item);

		return $post_id;
	}

	function bulkGenerate($amount = 20)
	{
		$result = [];

		$this->deleteAllGeneratedItems();
		foreach (range(0, $amount - 1) as $i) {
			$result[] = $this->insert([
				"slug" => self::fake([
					"type" => self::$SLUG,
				]),
				"title" =>
					"$i Bulked: " .
					self::fake([
						"type" => self::$TEXT,
						"range" => [10, 100],
					]),
			]);
		}

		return $result;
	}

	function bulkInsert($items)
	{
		$result = [];

		foreach ($items as $item) {
			$this->deleteBySlug($item["slug"]);
			$post_id = $this->insert($item);

			$item["post_id"] = $post_id;

			if ($this->post_type === "page" && self::hasChildren($item)) {
				$children_result = [];
				foreach ($item["children"] as $child) {
					$this->deleteBySlug($child["slug"]);
					$child_post_id = $this->insert($child, $post_id);

					$child["post_id"] = $child_post_id;

					$children_result[] = $child;
				}

				$item["children"] = $children_result;
			}

			$result[] = $item;
		}

		return $result;
	}
}