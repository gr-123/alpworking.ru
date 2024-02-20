<?php

// php spark make:migration <...> // Создать файл миграции
// php spark migrate              // Запуск миграции
// php spark db:table users       // И проверьте users таблицу

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Images extends Migration
{
    public function up()
    {
        $fields = [
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'imagename' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
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
