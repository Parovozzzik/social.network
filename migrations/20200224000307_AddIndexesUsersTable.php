<?php

use Phpmig\Migration\Migration;

class AddIndexesUsersTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $db = $this->get('db');
        $db->query(
            "CREATE INDEX email_index ON users (email);"
        );
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $db = $this->get('db');
        $db->query(
            "DROP INDEX email_index ON users;"
        );
    }
}
