$ 環境

PHP version 8.1.23

Laravel version 10.23

MySql version 8.034

Docker

# 処理

## 制御方法

ControllerからServiceをインスタンス化し、メソッドを呼び出す

Serviceから返ってきた整形されたデータをフロントに渡す

処理の流れ

1.ユーザーが View からリクエストを送る

2.Controlle rがリクエストを受け取り、適切なServiceにわたす

3.Service が処理を行い、必要に応じてRepositoryにわたす

4.Repository がDB通信やAPI通信を行い、結果をServiceに返す

5.Service が結果をもとに処理を行い、Controllerに返す

6.Controller からViewにレスポンスを返す

# コマンド

## シンボリックリンクの作成(画像)

php artisan storage:link

## キャッシュクリア

php artisan cache:clear

## 全キャッシュクリア

php artisan optimize:clear

## .env反映

php artisan config:cache

## マイグレーション作成

php artisan make:migration create_diaries_table

## マイグレーション実行

php artisan migrate

## テーブル作り直し

php artisan migrate:reset

## FormRequest作成

php artisan make:request DiariesRequest

## モデル作成

php artisan make:model Diaries

## コントローラ作成

php artisan make:controller Diaries

## サービスプロバイター作成

php artisan make:provider UtilServiceProvider

## ファクトリの作成

php artisan make:factory UserFactory --model=User

# composer

## アップデート

composer update

composer update --no-dev

## クラスのオートロード

composer dump-autoload

## Laravelインストール

composer create-project laravel/laravel --prefer-dist XXX

## フォームファザード

composer require "laravelcollective/html"

## Intelephenseが正確なオートコンプリートを提供できるように補助するヘルパーファイルを作成するライブラリ

composer require --dev barryvdh/laravel-ide-helper

php artisan ide-helper:generate

## メール

composer require swiftmailer/swiftmailer

php artisan make:mail SendMail

## Command

php artisan make:command UserCountCommand

## Comman実行

php artisan app:user-count-command

# PHPUnit

## テスト実行

./vendor/bin/phpunit

./vendor/bin/phpunit tests/Feature/ExampleTest.php

phpunit.xmlに下記設定追記が必要

```c
<env name="DB_CONNECTION" value=""/>
<env name="DB_HOST" value=""/>
<env name="DB_DATABASE" value=""/>
<env name="DB_USERNAME" value=""/>
<env name="DB_PASSWORD" value=""/>
```

php artisan test

php artisan test --env=testing

phpunit.xmlの下記設定はコメントアウトがよさそう

※ Laravel10ではうまくtestingのファイルをよんでくれなかった

```c
<env name="DB_CONNECTION" value=""/>
<env name="DB_DATABASE" value=":memory:"/>
```
