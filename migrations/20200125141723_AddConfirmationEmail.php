<?php

use Phpmig\Migration\Migration;

/**
 * Class AddConfirmationEmail
 */
class AddConfirmationEmail extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $db = $this->get('db');
        $db->query(
            "ALTER TABLE users 
                ADD COLUMN email_confirmed_at TIMESTAMP DEFAULT NULL COMMENT 'Date of confirmation email' AFTER password,
                ADD COLUMN email_confirm_code VARCHAR(64) DEFAULT NULL COMMENT 'Code for confirmation email.' AFTER password,
                ADD COLUMN email_confirm TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Status of confirmation email.' AFTER password;"
        );
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $db = $this->get('db');
        $db->query(
            "ALTER TABLE users 
                DROP COLUMN email_confirm,
                DROP COLUMN email_confirm_code,
                DROP COLUMN email_confirmed_at;"
        );
    }
}
