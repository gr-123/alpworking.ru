<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Migration;

// чтобы предотвратить ошибки плагинa PHP Intelephense VS Code от ложных отчетов для $this->db->disable<enable>ForeignKeyChecks();
/**
 * @property BaseConnection $db
 */
class CreatePricesTable extends Migration
{

    public function up()
    {
        $fields = [
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'category_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'amount'      => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'created_at'  => ['type' => 'datetime', 'null' => true],
            'updated_at'  => ['type' => 'datetime', 'null' => true],
            'deleted_at'  => ['type' => 'datetime', 'null' => true],

            // use CodeIgniter\Database\RawSql;
            // 'created_at'  => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP'),],
            // Предупреждение
            // Когда вы используете RawSql, вы ДОЛЖНЫ экранировать данные вручную. Невыполнение этого требования может привести к SQL-инъекциям.
        ];

        // Если ваши таблицы содержат внешние ключи, миграция часто может вызывать проблемы при попытке удалить таблицы и столбцы. 
        // Чтобы временно обойти проверки внешнего ключа во время миграции, используйте методы 
        // DisableForeignKeyChecks() и EnableForeignKeyChecks() при подключении к базе данных.

        $this->db->disableForeignKeyChecks();

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('category_id', 'categories', 'id', '', 'CASCADE');
        $this->forge->createTable('prices');

        $this->db->enableForeignKeyChecks();

        // Добавление внешних ключей
        // https://codeigniter.com/user_guide/dbmgmt/forge.html#adding-foreign-keys

        // $forge->addForeignKey('users_id', 'users', 'id', 'CASCADE', 'CASCADE');
        // users_id – имя поля внешнего ключа.
        // users    – имя родительской таблицы.
        // id       – первичный ключ или уникальное имя поля родительской таблицы, которую необходимо связать.
        // CASCADE  – удалять соответствующие записи при выполнении запроса на удаление в родительской таблице.
        // CASCADE  – обновлять соответствующие записи при выполнении запроса на обновление в родительской таблице.

        // Если вы не хотите вносить какие-либо изменения в дочернюю таблицу, когда действие удаления/обновления 
        // выполняется в родительской таблице, удалите CASCADE при определении внешнего ключа.

        // addForeignKey ( $fieldName , $tableName , $tableField[, $onUpdate = '' , $onDelete = '' , $fkName = ''])
        //     Параметры:
        //         $fieldName ( string|string[])  – Имя ключевого поля или массива полей
        //         $tableName ( string)           – Имя родительской таблицы
        //         $tableField ( string|string[]) – Имя родительского поля таблицы или массива полей.
        //         $onUpdate ( string)            – Желаемое действие для «при обновлении»
        //         $onDelete ( string)            – Желаемое действие для «при удалении»
        //         $fkName ( string)              – Имя внешнего ключа. Это не работает с SQLite3
    }

    public function down()
    {
        // Produces: DROP TABLE IF EXISTS `prices`
        // $this->forge->dropTable('prices', true);

        $this->db->disableForeignKeyChecks();
        
        // Produces: DROP TABLE `prices` CASCADE
        $this->forge->dropTable('prices', false, true);

        $this->db->enableForeignKeyChecks();
    }
}
