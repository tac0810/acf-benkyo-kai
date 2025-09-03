# 推奨コマンド一覧

## 初期セットアップ
```bash
npm run setup:init    # .envファイルを作成（テーマ名とACF Proライセンスキー設定）
```

## 開発環境
```bash
docker compose up --build  # WordPress/DB/メールサーバー起動
npm run dev               # Vite開発サーバー起動（ホットリロード有効）
```

## ビルド
```bash
npm run build            # 本番用ビルド（mytheme/buildに出力）
```

## データ管理
```bash
npm run setup:import     # データインポート
npm run setup:export     # データエクスポート
npm run setup:faker      # テストデータ生成
```

## コード整形
```bash
npm run format           # Prettierでコードフォーマット
```

## ブロック作成
```bash
npx scaffdog generate block  # 新規ACFブロック生成（対話形式）
```

## アクセス情報
- WordPress管理画面: http://localhost:8080/wp-admin/
  - ユーザー名: admin
  - パスワード: password
- メール確認画面: http://localhost:8025/

## システムコマンド（Darwin/macOS）
```bash
git status              # Git状態確認
git diff                # 変更差分確認
ls -la                  # ファイル一覧（隠しファイル含む）
grep -r "pattern" .     # パターン検索
find . -name "*.php"    # ファイル検索
```