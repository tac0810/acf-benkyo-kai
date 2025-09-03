<?php

/**
 * 汎用的なデータ生成トレイト
 * 
 * プロジェクトに依存しない再利用可能なfake関数を提供
 */
trait TraitFaker
{
	static $TEXT = "text";
	static $HTML = "html";
	static $SLUG = "slug";
	static $IMAGE = "image";

	static function fake($props)
	{
		$faker = Faker\Factory::create($props["locale"] ?? "ja_JP");

		if ($props["type"] === self::$TEXT) {
			$range = $props["range"] ?? [10, 12];
			return $faker->realText(random_int($range[0], $range[1]));
		}

		if ($props["type"] === self::$HTML) {
			return self::getFakeHTML();
		}

		if ($props["type"] === self::$SLUG) {
			return $faker->slug();
		}

		if ($props["type"] === self::$IMAGE) {
			return self::getFakeImage($props);
		}
	}

	/**
	 * フィクスチャー画像を取得
	 */
	static function getFakeImage($props)
	{
		static $imageManager = null;
		if (!$imageManager) {
			$imageManager = new ImageManager();
		}
		
		$aspect = $props['aspect'] ?? '16x9';
		$size = $props['size'] ?? null;
		
		return $imageManager->getFixtureByAspect($aspect, $size);
	}

	/**
	 * 汎用的なサンプルHTML
	 * プロジェクトに依存しない基本的なHTML構造
	 */
	static function getFakeHTML()
	{
		return <<<EOC

    <h1>Sample Content</h1>
    <p>
        This is a sample paragraph. You can edit this text with the WYSIWYG editor.
        <strong>Bold text</strong>, <em>italic text</em>, <u>underlined text</u>.
    </p>

    <h2>Links and Images</h2>
    <p>
        This is a <a href="https://example.com" target="_blank">sample link</a>.<br>
        Below is a sample image.
    </p>
    <img src="https://via.placeholder.com/600x200.png?text=Sample+Image" alt="Sample image">

    <h2>Lists</h2>
    <ul>
        <li>Bullet list item 1</li>
        <li>Bullet list item 2</li>
        <li>Bullet list item 3</li>
    </ul>
    <ol>
        <li>Numbered list item 1</li>
        <li>Numbered list item 2</li>
        <li>Numbered list item 3</li>
    </ol>

    <h2>Table</h2>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Product A</td>
                <td>Sample description A</td>
                <td>$10.00</td>
            </tr>
            <tr>
                <td>Product B</td>
                <td>Sample description B</td>
                <td>$20.00</td>
            </tr>
        </tbody>
    </table>

    <h2>Quote</h2>
    <blockquote>
        "This is a sample quote. You can test block quotes with the WYSIWYG editor."
    </blockquote>

    <h2>Button</h2>
    <p>
        <button onclick="alert('Button clicked!')">Click me</button>
    </p>
EOC;
	}
}