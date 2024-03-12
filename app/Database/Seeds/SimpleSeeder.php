<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SimpleSeeder extends Seeder
{
    // php spark db:seed TestSeeder
    // php spark make:seeder user --suffix // app/Database/Seeds/UserSeeder.php
    // php spark make:seeder MySeeder --namespace Acme\\Blog // app/Blog/Database/Seeds/MySeeder.php (Если Acme\Blog сопоставлен с каталогом app/Blog)

    public function run()
    {
        // вызывать другие отдельные файлы сеялки
        $this->call('UserSeeder');
        $this->call('My\Database\Seeds\CountrySeeder');
        $this->call('JobSeeder');



        // Вы можете получить копию основной сеялки через класс конфигурации базы данных:
        $seeder = \Config\Database::seeder();
        $seeder->call('TestSeeder');



        $data = [
            'username' => 'darth',
            'email'    => 'darth@theempire.com',
        ];

        // Simple Queries
        $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

        // Using Query Builder
        $this->db->table('users')->insert($data);
    }
}