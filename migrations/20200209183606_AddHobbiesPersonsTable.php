<?php

use Phpmig\Migration\Migration;

class AddHobbiesPersonsTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $db = $this->get('db');
        $db->query(
            "ALTER TABLE persons 
                ADD COLUMN hobbies TEXT DEFAULT NULL COMMENT 'Hobbies and interests' AFTER gender;"
        );
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $db = $this->get('db');
        $db->query(
            "ALTER TABLE persons 
                DROP COLUMN hobbies;"
        );
    }
}
