<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Images extends Migration
{
    public function up()
    {
        $fields = [
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'image_name' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'image_path' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'image_type' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true,],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP'),],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('images');
    }

    public function down()
    {
        $this->forge->dropTable('images');
    }
}
