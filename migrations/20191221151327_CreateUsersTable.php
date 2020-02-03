<?php

use Phpmig\Migration\Migration;

/**
 * Class CreateUsersTable
 */
class CreateUsersTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $db = $this->get('db');
        $db->query(
            "CREATE TABLE IF NOT EXISTS users (
                user_id INT(11) AUTO_INCREMENT PRIMARY KEY COMMENT 'Id of user.',
                email VARCHAR(64) NOT NULL COMMENT 'Email address of user.',
                password VARCHAR(255) NOT NULL COMMENT 'Password.',
                deleted TINYINT NOT NULL DEFAULT 0 COMMENT 'Status of deletion user.',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date of creation user',
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date of updating user'
            ) ENGINE=INNODB  DEFAULT CHARSET=utf8 COMMENT 'Users';"
        );
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $db = $this->get('db');
        $db->query(
            "DROP TABLE IF EXISTS users"
        );
    }
}
