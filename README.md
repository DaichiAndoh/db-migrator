# db-migrator

![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)

## About

データベース（`MySQL`）のマイグレーション処理、シード処理を実行することができます。
`MySQL` を使用するプロジェクトにおけるデータベーススキーマ管理、開発用データ管理を効率化します。

## Usage

### set up

`.env.template` から `.env` を作成し、データベース情報を設定します。

```
$ cp .env.template .env
```

### command: code-gen

以下のコマンドで、マイグレーションファイルを生成します。
出力パスは `Database/Migrations/yyyy-mm-dd_[unix_timestamp]_[name].php` です。

```
$ php console code-gen migration --name [name]
```

以下のコマンドで、シードファイルを生成します。
また、`--name` の値は自由に設定できますが、名前末尾に `Seeder` がなければ、自動で付加されます。
出力パスは `Database/Seeds/[name].php` です。

```
$ php console code-gen seeder --name [name]
```

### command: migrate

マイグレーションを実行します。
`code-gen migration` によって生成されたマイグレーションファイルの `up` にマイグレーションロジック、`down` にロールバックロジックを記述し、以下で実行します。

```
$ php console migrate
```

なお、初回実行時は、DBにマイグレーション管理用のテーブルを作成する必要があるため、`--init(or -i)` オプションを指定する必要があります。
これにより、マイグレーション管理用テーブルが作成された上で、マイグレーションファイルで定義された処理が実行されます。

```
$ php console migrate --init
or
$ php console migrate -i
```

ロールバックには、`--rollback`（`-r`）オプションを使用します。

```
$ php console migrate --rollback
or
$ php console migrate -r
```

ロールバックオプションに続けて整数値を設定すると、その回数分ロールバックを実行します。

```
# 現在のバージョンから2回分ロールバックする
$ php console migrate -r 2
```

### command: seed

`code-gen seeder` によって生成されたシードファイルに、シードデータを記述し、以下で実行します。

```
$ php console seed
```

### command: state-migrate

`Database/state.php` の内容をデータベースに反映します。

```
$ php console state-migrate
```

## Development

`console` が入力に対応するコマンドラインプログラムを実行します。
コマンドラインプログラム関連のソースコードは `Commands` ディレクトリで管理されています。
このリポジトリのコアとなるロジックは `console` と `Commands` に多く含まれています。

`console` および `Commands` ディレクトリ配下のファイルについての簡単な説明は以下です。

- console
    - すべてのコマンドラインプログラムのエントリーポイントです。すべてのコマンドがロードし、指定されたプログラムを実行します。
- Commands/
    - registry.php
        - すべてのコマンドクラス名の配列を含んでいます。これはコマンドが登録されるレジストリとして機能し、consoleはここから読み取ります。ここに登録されていないコマンドは実行することができません。
    - Command.php
        - すべてのコマンドが持っているメソッドを定義するインターフェースです。
    - AbstractCommand.php
        - すべてのコマンドの基底となる抽象クラスです。
    - Argument.php
        - コマンドが使用できる引数を定義するビルダークラスです。
    - Programs
        - すべてのコマンドがこのフォルダ内に格納されています。これらはすべて Command インターフェースを実装し、AbstractCommand クラスを拡張する必要があります。
    - Programs/CodeGeneration.php
        - マイグレーションファイル、およびシードファイルを生成します。
    - Programs/Migrate.php
        - マイグレーションファイルをもとにマイグレーションやロールバックを実行します。
    - Programs/Seeder.php
        - シードファイルをもとにシード処理を実行します。
    - Programs/StateMigrate.php
        - 状態ベースのデータベース更新を実行します。
