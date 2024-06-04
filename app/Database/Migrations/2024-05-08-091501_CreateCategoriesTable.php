<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        $fields = [
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'  => ['type' => 'datetime', 'null' => true],
            'updated_at'  => ['type' => 'datetime', 'null' => true],
            'deleted_at'  => ['type' => 'datetime', 'null' => true],

            // use CodeIgniter\Database\RawSql;
            // 'created_at'  => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP'),],
            // Предупреждение
            // Когда вы используете RawSql, вы ДОЛЖНЫ экранировать данные вручную. Невыполнение этого требования может привести к SQL-инъекциям.
        ];
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('categories');
    }

    public function down()
    {
        // Produces: DROP TABLE IF EXISTS `categories`
        // $this->forge->dropTable('categories', true);

        // Produces: DROP TABLE `categories` CASCADE
        $this->forge->dropTable('categories', false, true);
    }
}
