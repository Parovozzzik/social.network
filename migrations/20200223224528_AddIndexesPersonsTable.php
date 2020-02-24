<?php

use Phpmig\Migration\Migration;

class AddIndexesPersonsTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $db = $this->get('db');
        $db->query(
            "CREATE INDEX first_name_index ON persons (first_name);
            CREATE INDEX last_name_index ON persons (last_name);
            CREATE INDEX first_last_name_index ON persons (first_name, last_name);"
        );
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $db = $this->get('db');
        $db->query(
            "DROP INDEX first_name_index ON persons;
            DROP INDEX last_name_index ON persons;
            DROP INDEX first_last_name_index ON persons;"
        );
    }
}
