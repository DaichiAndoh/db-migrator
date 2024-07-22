<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateLikeTable1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加
        return [
            "CREATE TABLE post_likes (
                user_id BIGINT,
                post_id INT,
                PRIMARY KEY (user_id, post_id),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
            )",
            "CREATE TABLE comment_likes (
                user_id BIGINT,
                comment_id INT,
                PRIMARY KEY (user_id, comment_id),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加
        return [
            "DROP TABLE post_likes",
            "DROP TABLE comment_likes"
        ];
    }
}
