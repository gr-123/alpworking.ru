<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name'    => 'sealing', 'title' => 'Герметизация межпанельных швов',],
            ['name'    => 'window_cleaning', 'title' => 'Мойка окон',],
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO price (category, amount) VALUES(:category:, :amount:)', $data);

        // Using Query Builder
		foreach($data as $item){
			$this->db->table('categories')->insert($item);
		}
    }
}
