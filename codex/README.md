# LogDeck

LogDeck は LAN 内の複数システムからログを受け取り、一元管理する Laravel ベースの Web アプリケーションです。

## 構成

- アプリ本体: `codex/`
- Docker 関連: `Docker/`
- Web: Apache
- App: PHP 8.2 + Laravel 12
- DB: MySQL 8

## 実装済み機能

- システム登録画面
- システム一覧画面
- ログ投稿 API `POST /api/logs/{path}`
- ログ一覧画面
- システム、レベル、日時、メッセージによる絞り込み
- 日時昇順、日時降順ソート
- ダークモード対応の Bootstrap UI
- Seeder によるサンプルデータ投入

## ディレクトリ

```text
LogDeck/
├── Docker/
│   ├── apache/
│   └── php/
└── codex/
    ├── app/
    ├── config/
    ├── database/
    ├── public/
    ├── resources/
    └── routes/
```

## 起動手順

1. `cp codex/.env.example codex/.env`
2. `docker compose -f Docker/docker-compose.yml build`
3. `docker compose -f Docker/docker-compose.yml up -d`
4. `docker compose -f Docker/docker-compose.yml exec app composer install`
5. `docker compose -f Docker/docker-compose.yml exec app php artisan key:generate`
6. `docker compose -f Docker/docker-compose.yml exec app php artisan migrate --seed`

ブラウザ: `http://localhost:8080`

## API 例

```http
POST /api/logs/abcd1234efgh5678
Content-Type: application/json

{
  "level": "INFO",
  "message": "起動しました。"
}
```

成功時:

```json
{
  "result": "ok"
}
```

失敗時:

```json
{
  "result": "error",
  "message": "system not found"
}
```

## 補足

- ホストに `php` と `composer` が無くても、Docker コンテナ内の Composer と PHP で起動できます。
- `app` コンテナのエントリポイントで `storage/` と `bootstrap/cache/` の書き込み権限を自動調整します。
