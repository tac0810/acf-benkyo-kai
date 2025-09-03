# WordPress Starter v2 プロジェクト概要

## プロジェクトの目的
WordPress テーマ構築のための開発環境。Docker と Vite を利用したローカル開発環境が組み込まれており、Timber の採用によって Twig を利用したテンプレートの記述が可能。

## 技術スタック
- **CMS**: WordPress
- **テンプレートエンジン**: Timber/Twig
- **フロントエンドビルド**: Vite
- **スタイリング**: TailwindCSS, PostCSS
- **JavaScript**: Alpine.js
- **コンテナ**: Docker Compose
- **データベース**: MariaDB
- **開発言語**: PHP, JavaScript/TypeScript
- **パッケージマネージャー**: npm

## プロジェクト構造
```
wordpress-starter-v2/
├── mytheme/             # WordPressテーマ本体
│   ├── blocks/          # ACFブロック定義
│   ├── inc/             # PHP関数/機能
│   ├── views/           # Twigテンプレート
│   ├── assets/          # 静的アセット
│   └── editor/          # エディタ関連
├── services/            # Dockerサービス
│   └── wordpress/       
│       ├── faker/       # テストデータ生成システム
│       └── portal/      # データインポート/エクスポート
├── source/              # ソースファイル
├── scripts/             # 開発用スクリプト
└── tailwind/            # TailwindCSS設定
```

## 主要サービス
- **WordPress**: ポート8080でメインアプリケーション実行
- **MariaDB**: ポート3306でデータベース提供
- **smtp4dev**: ポート8025でメール開発環境提供