# wordpress-starter

WordPress テーマ構築のための開発環境です。[docker](https://www.docker.com/ja-jp/) と [vite](https://ja.vitejs.dev/) を利用したローカル開発環境が組み込まれています。[Timber](https://upstatement.com/timber/) の採用によって、[Twig](https://twig.symfony.com/) を利用したテンプレートの記述ができるようになっています。

## 導入

要求環境:

- [Docker クライアント](https://hub.docker.com/editions/community/docker-ce-desktop-mac/) または [podman](https://podman.io/)
- Node.js 16以上

`.env` の作成:

```bash
npm run setup:init
```

テーマ名と[ACF Pro](https://www.advancedcustomfields.com/pro/) の[ライセンスキー](https://www.advancedcustomfields.com/resources/how-to-activate/)を入力します。

開発環境の起動:

WordPressの起動

```bash
docker compose up --build
```

viteの起動

```bash
npm run dev
```

### ダッシュボードへのアクセス

wp-env の起動後に次の URL を開いてください。

http://localhost:8888/wp-admin/

- ユーザー名: `admin`
- パスワード: `password`

## 本番用ビルド

次のコマンドを実行すると、ビルド済みのファイルが `source/mytheme/build` ディレクトリに出力されます。

```bash
npm run build
```

## ブロックの作成の仕方

```bash
npx scaffdog generate block
```

対話に沿って生成してください。

- name
  - ブロックの slug を入れてください
- title
  - エディタ側で表示する名前を入れてください。日本語でも OK です
- description
  - エディタ側で表示する詳細文を書いてください
- icon
  - エディタ側で表示するアイコンを書いてください
  - [このサイト](https://developer.wordpress.org/resource/dashicons/)から選んください
  - `dashicons-` というプレフィクスはのぞいて指定してください eg. `dashicons-menu-alt3` なら `menu-alt3`
- category
  - エディタ側で表示するカテゴリを指定してください。
  - text
  - media
  - design
  - widgets
  - theme
  - embed
  - デフォルトは `text`

### 作成したブロックの登録の仕方

デフォルトでは全てのブロックが登録されているため、案件に応じて調整してください。

1. `source/mytheme/inc/blocks.php` を こちらのマニュアルを参考にセットアップしてください
2. ブロックの name は前項の `ブロックの作成の仕方` の name に入力した値に `acf/` プレフィクスをつけたものを指定してください。eg. `heading` → `acf/heading`
3. 管理画面の ACF から必要なフォームを指定してください。

## お問い合わせフォームセットアップ

[Docs](./source/mytheme/inc/formApp/README.md)

## 関連リソース

- [wordpress-starter](https://github.com/yuheiy/wordpress-starter) 
- [Timber Docs for v1 – Timber Documentation](https://timber.github.io/docs/): Timber の公式ドキュメント
- [The Timber Starter Theme](https://github.com/timber/starter-theme): Timber の公式スターターテーマ
- [Twig - The flexible, fast, and secure PHP template engine](https://twig.symfony.com/): Twig の公式ドキュメント
