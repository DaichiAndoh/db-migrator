<?php

namespace Database;

use mysqli;
use Helpers\Settings;

class MySQLWrapper extends mysqli{
    public function __construct(?string $hostname = '127.0.0.1', ?string $username = null, ?string $password = null, ?string $database = null, ?int $port = null, ?string $socket = null)
    {
        /*
            接続の失敗時にエラーを報告し、例外をスローする。
            データベース接続を初期化する前にこの設定を行う。
        */
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $username = $username??Settings::env('DATABASE_USER');
        $password = $password??Settings::env('DATABASE_USER_PASSWORD');
        $database = $database??Settings::env('DATABASE_NAME');

        parent::__construct($hostname, $username, $password, $database, $port, $socket);
    }

    // クエリが問い合わせられるデフォルトのデータベースを取得する
    public function getDatabaseName(): string{
        return $this->query("SELECT database() AS the_db")->fetch_row()[0];
    }
}
