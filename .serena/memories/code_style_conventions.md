# コードスタイル・規約

## PHP (WordPress/Timber)
- **命名規則**:
  - 関数: snake_case (WordPress標準)
  - クラス: PascalCase
  - 変数: $snake_case
- **インデント**: タブ（WordPress標準）
- **ファイル命名**: kebab-case.php
- **名前空間**: 使用していない（グローバル空間）

## JavaScript/TypeScript
- **命名規則**:
  - 変数・関数: camelCase
  - クラス・コンポーネント: PascalCase
  - 定数: UPPER_SNAKE_CASE
- **インデント**: スペース2文字
- **モジュール**: ES6モジュール使用
- **フレームワーク**: Alpine.js使用

## CSS/TailwindCSS
- **クラス命名**: BEM記法またはTailwindユーティリティクラス
- **インデント**: スペース2文字
- **PostCSS**: @importと入れ子記法サポート

## Twig テンプレート
- **変数**: {{ variable }}
- **制御構造**: {% if %}, {% for %}
- **コメント**: {# comment #}
- **継承**: {% extends "base.twig" %}

## フォーマッター設定
- **Prettier**: 
  - PHP、JavaScript、CSS、HTMLに対応
  - TailwindCSSプラグイン有効
  - CSS順序プラグイン有効
- **設定ファイル**: .prettierrc.json

## WordPress Faker（テストデータ生成）
- **Core libraries**: 再利用可能なクラス群
  - PostManager: 投稿管理
  - TaxonomyManager: タクソノミー管理
  - ImageManager: 画像管理
  - TraitFaker: データ生成ユーティリティ
  - TraitCallback: コールバック処理
- **collections/**: プロジェクト固有のデータ定義