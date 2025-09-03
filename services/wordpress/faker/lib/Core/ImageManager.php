<?php

class ImageManager
{
	/**
	 * フィクスチャー画像のベースディレクトリ
	 */
	private string $fixtureBasePath;

	public function __construct()
	{
		$this->fixtureBasePath = dirname(dirname(__DIR__)) . "/assets/fixtures";
	}

	/**
	 * アスペクト比とサイズに基づいて画像を取得
	 *
	 * @param string $aspect アスペクト比 (16x9, 4x3, 1x1, 3x4)
	 * @param string|null $size サイズ指定 (large, medium, small) or null for any
	 * @return int アタッチメントID（0の場合は失敗）
	 */
	public function getFixtureByAspect(string $aspect = "16x9", ?string $size = null): int
	{
		// 利用可能な画像を検索
		$pattern = $this->fixtureBasePath . "/fixture_{$aspect}_*.jpg";
		$files = glob($pattern);

		if (empty($files)) {
			// 指定されたアスペクト比の画像がない場合は、任意の画像を返す
			$files = glob($this->fixtureBasePath . "/fixture_*.jpg");
		}

		if (empty($files)) {
			return 0;
		}

		// サイズで絞り込み
		if ($size) {
			$filtered = $this->filterBySize($files, $aspect, $size);
			if (!empty($filtered)) {
				$files = $filtered;
			}
		}

		// ランダムに1つ選択
		$selectedFile = $files[array_rand($files)];
		$filename = basename($selectedFile);

		// メディアライブラリを検索
		$existingId = $this->findImageInLibrary($filename);
		if ($existingId) {
			return $existingId;
		}

		// なければアップロード
		return $this->uploadImage($selectedFile);
	}

	/**
	 * サイズで画像をフィルタリング
	 *
	 * @param array $files
	 * @param string $aspect
	 * @param string $size
	 * @return array
	 */
	private function filterBySize(array $files, string $aspect, string $size): array
	{
		$sizeRanges = [
			"16x9" => [
				"large" => 1000, // 幅1000px以上
				"medium" => 600, // 幅600-999px
				"small" => 0, // 幅600px未満
			],
			"4x3" => [
				"large" => 800,
				"medium" => 500,
				"small" => 0,
			],
			"1x1" => [
				"large" => 600,
				"medium" => 400,
				"small" => 0,
			],
			"3x4" => [
				"large" => 600,
				"medium" => 400,
				"small" => 0,
			],
		];

		$filtered = [];
		$minWidth = $sizeRanges[$aspect][$size] ?? 0;
		$maxWidth =
			$size === "large"
				? PHP_INT_MAX
				: ($size === "medium"
					? $sizeRanges[$aspect]["large"] - 1
					: $sizeRanges[$aspect]["medium"] - 1);

		foreach ($files as $file) {
			// ファイル名から幅を抽出 (fixture_16x9_800x450.jpg → 800)
			if (preg_match("/fixture_\d+x\d+_(\d+)x\d+/", basename($file), $matches)) {
				$width = (int) $matches[1];
				if ($width >= $minWidth && $width <= $maxWidth) {
					$filtered[] = $file;
				}
			}
		}

		return $filtered;
	}

	/**
	 * メディアライブラリから画像を検索
	 *
	 * @param string $filename
	 * @return int アタッチメントID（見つからない場合は0）
	 */
	private function findImageInLibrary(string $filename): int
	{
		$args = [
			"post_type" => "attachment",
			"post_status" => "inherit",
			"posts_per_page" => 1,
			"meta_query" => [
				[
					"key" => "_wp_attached_file",
					"value" => $filename,
					"compare" => "LIKE",
				],
			],
		];

		$attachments = get_posts($args);

		if (!empty($attachments)) {
			return $attachments[0]->ID;
		}

		return 0;
	}

	/**
	 * 画像をアップロード
	 *
	 * @param string $imagePath
	 * @return int アタッチメントID（失敗時は0）
	 */
	private function uploadImage(string $imagePath): int
	{
		$uploadDir = wp_upload_dir();
		$filename = basename($imagePath);
		$uploadFile = $uploadDir["path"] . "/" . wp_unique_filename($uploadDir["path"], $filename);

		if (!copy($imagePath, $uploadFile)) {
			return 0;
		}

		$fileType = wp_check_filetype($filename);

		$attachment = [
			"guid" => $uploadDir["url"] . "/" . basename($uploadFile),
			"post_mime_type" => $fileType["type"],
			"post_title" => preg_replace('/\.[^.]+$/', "", $filename),
			"post_content" => "",
			"post_status" => "inherit",
		];

		$attachmentId = wp_insert_attachment($attachment, $uploadFile);

		if (!is_wp_error($attachmentId)) {
			require_once ABSPATH . "wp-admin/includes/image.php";
			$attachmentData = wp_generate_attachment_metadata($attachmentId, $uploadFile);
			wp_update_attachment_metadata($attachmentId, $attachmentData);
			return $attachmentId;
		}

		return 0;
	}

	/**
	 * 旧メソッド（後方互換性のため）
	 */
	public function getRandomFixtureImage(string $category): int
	{
		// カテゴリは無視して、ランダムなアスペクト比で返す
		$aspects = ["16x9", "4x3", "1x1", "3x4"];
		$aspect = $aspects[array_rand($aspects)];
		return $this->getFixtureByAspect($aspect);
	}
}