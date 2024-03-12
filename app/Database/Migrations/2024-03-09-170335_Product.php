<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Product extends Migration
{
    // CREATE DATABASE <name_db>;
    // DROP TABLE IF EXISTS <name_table>;
    // CREATE TABLE <name_table> ...
    // -----------------------------------------------------------------------------
    // Миграция базы данных: https://codeigniter.com/user_guide/dbmgmt/migration.html
    // php spark make:migration product            // Создать файл миграции <class> [options]
    // // php spark make:scaffold product --suffix // { Controller.php,Model.php,Migration.php,Seeder.php }
    // php spark migrate:status
    // php spark migrate              // Запуск миграции

    // INSERT INTO <name_table> VALUES ...
    // -----------------------------------------------------------------------------
    // php spark make:seeder product --suffix // Создать файл для внесения данных в базу данных
    // php spark db:seed ProductSeeder        // Запуск
    // 
    // $seeder = \Config\Database::seeder();
    // $seeder->call('ProductSeeder');
    // 
    // php spark db:table products --limit-rows 50 --limit-field-value 20 --desc // И проверьте таблицу
    // php spark db:table products --metadata
    // 
    // $db = \Config\Database::connect();
    // $insertQuery = "INSERT INTO table_name (column1, column2, ...) VALUES (value1, value2, value3, ...)";
    // $db->query($insertQuery);
    // $insertQuery = "INSERT INTO table_name (column1, column2, ...) VALUES (?, ?, ?, ...)";
    // $db->query($insertQuery, [value1, value2, value3, ...]);
    // $insertQuery = "INSERT INTO table_name (column1, column2, ...) VALUES (:val1: , :val2: , :val3: , ...)";
    // $db->query($insertQuery, ["val1" => value1, "val2" => value2, "val3" => value3, ...]);


    // https://github.com/codeigniter4/shield/blob/e48f15d658262956d0beea8019e07bd5caeae276/src/Database/Migrations/2020-12-28-223112_create_auth_tables.php#L27
    // https://stackoverflow.com/questions/75329452/what-are-the-preferred-mysql-column-data-types-for-codeigniter-4s-created-at-u

    public function up()
        {
        // 
        // Добавление внешних ключей: https://codeigniter4.github.io/userguide/dbmgmt/forge.html#adding-foreign-keys
        // Foreign Keys
        // --------------------------------------------------------------------
        // https://codeigniter.com/user_guide/dbmgmt/migration.html#foreign-keys
        // Если ваши таблицы содержат внешние ключи, миграция часто может вызывать проблемы при попытке удалить таблицы и столбцы. Чтобы временно обойти проверки внешнего ключа во время миграции, используйте методы DisableForeignKeyChecks() и EnableForeignKeyChecks() при подключении к базе данных.
        // 
        // $this->db->disableForeignKeyChecks();
        // 

        // Products Table
        $fields = [
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            // 'code'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'price'       => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => false, 'default' => 0.00,],
            // 'amount'      => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => false],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'content'     => ['type' => 'TEXT', 'null' => true],
            // 'description' => ['type' => 'TEXT', 'null' => true],
            // 'picture'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            // 'status'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			// // 'status' => ['type' => 'ENUM', 'constraint' => ['publish', 'pending', 'draft'], 'default' => 'pending',],
            // 'active'      => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'created_at'  => ['type' => 'datetime', 'null' => true],
            'updated_at'  => ['type' => 'datetime', 'null' => true],
            'deleted_at'  => ['type' => 'datetime', 'null' => true],
        ];
        $this->forge->addField($fields);

        $this->forge->addPrimaryKey('id');
        // $this->forge->addUniqueKey('code');
        $this->forge->addUniqueKey('slug');

        $this->forge->createTable('products'); // ('tablename', true); // создаст таблицу, только если не существует
        // 
        // $this->db->enableForeignKeyChecks();
        // 
    }

    public function down()
    {
        $this->forge->dropTable('products');
        // $forge->dropTable('table_name', true);        // Produces: DROP TABLE IF EXISTS `table_name`
        // $forge->dropTable('table_name', false, true); // Produces: DROP TABLE `table_name` CASCADE
    }
}
