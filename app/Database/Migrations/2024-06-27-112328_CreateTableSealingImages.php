<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

// php spark make:migration create_table_sealing_images
// php spark migrate:status
// php spark migrate

class CreateTableSealingImages extends Migration
{
    public function up()
    {
        $fields = [
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'caption'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'  => ['type' => 'datetime', 'null' => true],
            'updated_at'  => ['type' => 'datetime', 'null' => true],
            'deleted_at'  => ['type' => 'datetime', 'null' => true],
        ];
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('sealing_images'); // ('tablename', true); // создаст таблицу, только если не существует
    }

    public function down()
    {
        $this->forge->dropTable('sealing_images');
    }
}
