<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name'    => 'sealing',],
            ['name'    => 'window_cleaning',],
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO price (category, amount) VALUES(:category:, :amount:)', $data);

        // Using Query Builder
		foreach($data as $item){
			$this->db->table('categories')->insert($item);
		}
    }
}
