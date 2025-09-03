# WordPress ダミーデータ生成ツール

ACF勉強会用のシンプルなダミーデータ生成ツールです。

## 使い方

### 全てのサンプルを実行

```bash
docker exec wordpress-1 wp eval-file /var/www/html/wp-content/themes/mytheme/dummy-generator/generate.php --allow-root
```

### 個別のサンプルを実行

```bash
# シンプルな投稿作成
docker exec wordpress-1 wp eval-file /var/www/html/wp-content/themes/mytheme/dummy-generator/01-simple-post.php --allow-root

# ACFフィールド更新
docker exec wordpress-1 wp eval-file /var/www/html/wp-content/themes/mytheme/dummy-generator/02-acf-update.php --allow-root

# Gutenbergブロックコンテンツ作成
docker exec wordpress-1 wp eval-file /var/www/html/wp-content/themes/mytheme/dummy-generator/03-gutenberg-content.php --allow-root
```

## ファイル構成

- `generate.php` - エントリーポイント
- `01-simple-post.php` - シンプルな投稿作成のサンプル
- `02-acf-update.php` - ACFフィールド更新のサンプル
- `03-gutenberg-content.php` - Gutenbergブロックコンテンツ作成のサンプル

## カスタマイズ

各ファイルはシンプルな実装例となっています。
勉強会の内容に応じて、自由に編集してご利用ください。