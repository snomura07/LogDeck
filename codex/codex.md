# LogDeck 開発仕様書

## 概要

LogDeck は複数システムから送信されるログを一元管理するためのWebアプリケーションである。

各システムはHTTP API経由でログを投稿し、管理画面からログの閲覧・検索・絞り込みを行う。

本システムはローカルネットワーク内での利用を前提とし、認証機能は実装しない。

---

# システム名称

**LogDeck**

---

# 動作環境

* Jetson Nano Developer Kit
* Docker Compose によるコンテナ運用
* ストレージはJetson本体に接続されたUSBメモリ等の外部記憶媒体を利用
* 永続データはDocker Volumeを通じて外部記憶媒体へ保存する

---

# システム構成

* App（Laravel）
* Database（MySQL）
* Web Server（Apache HTTP Server）
* Frontend（Bootstrap）

```text
+--------------------+
| Client System A    |
+--------------------+
          |
          | HTTP POST
          v
+--------------------+
|                    |
|      LogDeck       |
|                    |
+--------------------+
          |
          v
+--------------------+
|      MySQL         |
+--------------------+
```

---

# 使用技術

## Backend

* Laravel 12以上
* PHP最新版安定版

## Frontend

* Bootstrap 5
* Bootstrap Icons
* JavaScript（Vanilla JS）

## Database

* MySQL 8系

## Web Server

* Apache HTTP Server

## Container

* Docker
* Docker Compose

---

# コンセプト

* シンプル
* 軽量
* LAN内利用前提
* ログイン不要
* APIトークン不要
* システム登録時に発行される専用APIパスでシステムを識別

---

# 機能一覧

## 1. システム管理

### システム登録

管理画面からシステムを登録する。

登録項目

* システム名
* 説明（任意）

登録時に以下を自動生成する。

* APIパス識別子

例

```text
system_name : CameraSystem

generated_path : abcd1234efgh5678
```

投稿API

```text
POST /api/logs/abcd1234efgh5678
```

---

### システム一覧

表示項目

* システム名
* 説明
* APIパス
* 登録日時
* 総ログ件数

---

## 2. ログ投稿API

### エンドポイント

```http
POST /api/logs/{path}
```

例

```http
POST /api/logs/abcd1234efgh5678
```

---

### リクエスト

```json
{
  "level": "INFO",
  "message": "起動しました。"
}
```

---

### level

許可値

```text
INFO
WARN
ERROR
```

将来的な拡張を考慮し、実装は文字列ベースとする。

---

### レスポンス

成功

```json
{
  "result": "ok"
}
```

失敗

```json
{
  "result": "error",
  "message": "system not found"
}
```

---

## 3. ログ閲覧

### ログ一覧画面

表示項目

| 項目    | 内容              |
| ----- | --------------- |
| 日時    | 受信日時            |
| システム  | 登録システム名         |
| 種別    | INFO/WARN/ERROR |
| メッセージ | ログ本文            |

表示例

```text
[2026/06/20 14:14][INFO ] 起動しました
[2026/06/20 14:15][WARN ] プロセス起動中です
[2026/06/20 14:16][ERROR] システムエラー
```

---

### 検索機能

以下で絞り込み可能

* システム
* ログレベル
* 開始日時
* 終了日時
* メッセージ全文検索

---

### ソート

* 日時昇順
* 日時降順

デフォルトは日時降順

---

# UI要件

## デザイン方針

モダンな管理画面を目指す。

Bootstrap標準デザインをベースに以下を適用する。

* ダークモード対応
* カードUI
* Bootstrap Icons利用
* レスポンシブ対応

参考イメージ

```text
+--------------------------------------+
| LogDeck                              |
+--------------------------------------+

+------------+------------------------+
| Systems    | Logs                   |
+------------+------------------------+

+--------------------------------------+
| Search Filter                        |
+--------------------------------------+

+--------------------------------------+
| Log Table                            |
+--------------------------------------+
```

---

# データベース設計

## systems

| カラム         | 型                   |
| ----------- | ------------------- |
| id          | BIGINT              |
| name        | VARCHAR(255)        |
| description | TEXT NULL           |
| api_path    | VARCHAR(255) UNIQUE |
| created_at  | TIMESTAMP           |
| updated_at  | TIMESTAMP           |

---

## logs

| カラム         | 型           |
| ----------- | ----------- |
| id          | BIGINT      |
| system_id   | BIGINT      |
| level       | VARCHAR(32) |
| message     | TEXT        |
| received_at | DATETIME    |
| created_at  | TIMESTAMP   |
| updated_at  | TIMESTAMP   |

---

# 非機能要件

* Laravel標準機能を優先利用する
* Eloquent ORMを利用する
* REST APIとして実装する
* CSRF対象外としてAPIを実装する
* Docker Composeで起動可能にする
* コンテナ再起動後もデータが保持されること
* USBストレージへの永続化を考慮する
* ソースコードは保守しやすい構成とする

---

# 今回実装対象外

以下は将来拡張とし、今回は実装しない。

* ユーザー認証
* APIトークン認証
* アラート通知
* メール送信
* WebSocketリアルタイム更新
* CSVエクスポート
* ログ自動削除
* ログファイル出力
* Grafana等との連携

---

# 成果物

以下を作成すること。

* Laravelプロジェクト
* Docker Compose構成
* Dockerfile
* Apache設定
* Migration
* Seeder
* Model
* Controller
* API実装
* Blade画面
* Bootstrap UI
* README

起動後にブラウザから利用可能な状態まで実装すること。
