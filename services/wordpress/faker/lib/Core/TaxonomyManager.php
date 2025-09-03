<?php

class TaxonomyManager
{
	use TraitCallback, TraitFaker;

	static function getAllTermIDs($taxonomy)
	{
		return get_terms([
			"taxonomy" => $taxonomy,
			"hide_empty" => false,
			"fields" => "ids",
		]);
	}

	private $taxonomy;

	function __construct($taxonomy)
	{
		$this->taxonomy = $taxonomy;
	}

	function deleteBySlug($slug)
	{
		$term = get_term_by("slug", $slug, $this->taxonomy);

		if (!$term) {
			return;
		}

		wp_delete_term($term->term_id, $this->taxonomy);
	}

	function insert($slug, $title)
	{
		$term_data = wp_insert_term($title, $this->taxonomy, [
			"slug" => $slug,
			"parent" => 0,
		]);

		$this->callCallback("insert.after", $term_data);
	}

	function bulkInsert($terms)
	{
		foreach ($terms as $term) {
			$this->deleteBySlug($term["slug"]);
			$this->insert($term["slug"], $term["title"]);
		}
	}
}