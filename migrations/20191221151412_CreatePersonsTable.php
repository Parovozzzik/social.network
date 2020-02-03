<?php

use Phpmig\Migration\Migration;

/**
 * Class CreatePersonsTable
 */
class CreatePersonsTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {$db = $this->get('db');
        $db->query(
            "CREATE TABLE IF NOT EXISTS persons (
                person_id INT(11) AUTO_INCREMENT PRIMARY KEY COMMENT 'Id of person.',
                user_id INT(11) NOT NULL COMMENT 'Id of user.',
                first_name VARCHAR(64) NOT NULL COMMENT 'First name.',
                last_name VARCHAR(64) NOT NULL COMMENT 'Last name.',
                date_birth DATE NOT NULL COMMENT 'Date bitrh of person.',
                gender ENUM('male','female') DEFAULT NULL COMMENT 'Gender',
                deleted TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Status of deletion user.',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date of creation user',
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date of updating user',
                
                CONSTRAINT fk_persons_user_id FOREIGN KEY (user_id) REFERENCES users (user_id)
            ) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT 'Persons';"
        );

    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $db = $this->get('db');
        $db->query(
            "DROP TABLE IF EXISTS persons"
        );
    }
}
