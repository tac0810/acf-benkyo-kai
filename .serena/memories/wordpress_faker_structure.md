# WordPress Faker サービス構造

## 概要
WordPress開発環境用のテストデータ生成システム。再利用可能なCoreライブラリとプロジェクト固有のcollectionsで構成。

## ディレクトリ構造
```
services/wordpress/faker/
├── init.php                 # 初期化ファイル（Faker設定、ライブラリ読み込み）
├── insert_fake_data.php     # データ挿入実行スクリプト
├── delete_data.php          # データ削除スクリプト
├── entry.sh                 # エントリーポイント
├── helpers.php              # ヘルパー関数（_wp関数など）
├── composer.json            # Faker PHPライブラリ依存定義
├── lib/Core/                # 再利用可能なコアライブラリ
│   ├── TraitCallback.php    # コールバック処理トレイト
│   ├── TraitFaker.php       # データ生成ユーティリティ
│   ├── ImageManager.php     # 画像管理クラス
│   ├── TaxonomyManager.php  # タクソノミー管理クラス
│   └── PostManager.php      # 投稿管理クラス
└── collections/             # プロジェクト固有のデータ定義
    ├── 00_sample.php        # サンプルコレクション
    └── 01_place.php         # 場所データコレクション

## Core ライブラリの特徴

### TraitFaker
- 汎用的なデータ生成機能を提供
- TEXT、HTML、SLUG、IMAGEタイプのデータ生成
- プロジェクトに依存しない再利用可能な実装

### PostManager
- WordPress投稿の一括生成・管理
- 階層構造（親子関係）のサポート
- スラッグベースの削除機能
- コールバック機構による拡張性

### TaxonomyManager
- カテゴリ・タグなどのタクソノミー管理
- 階層構造のサポート
- 一括挿入・削除機能

### ImageManager
- フィクスチャー画像の管理
- アスペクト比別の画像取得
- メディアライブラリへの登録

## 実行方法
```bash
# Dockerコンテナ内で実行
npm run setup:faker

# または直接実行
docker exec -it [container_id] php /var/www/html/faker/insert_fake_data.php
```

## カスタマイズポイント
1. collections/に新しいPHPファイルを追加してプロジェクト固有のデータを定義
2. Core ライブラリは変更せず、継承やトレイトで拡張
3. helpers.phpに共通ヘルパー関数を追加