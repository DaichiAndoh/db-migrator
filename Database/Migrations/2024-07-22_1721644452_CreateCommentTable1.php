<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateCommentTable1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加
        return [
            "CREATE TABLE comments (
                id INT PRIMARY KEY AUTO_INCREMENT,
                comment_text VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                user_id BIGINT,
                post_id INT,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加
        return [
            "DROP TABLE comments"
        ];
    }
}
