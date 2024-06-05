<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PricesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['category_id' => '1', 'name' => 'germ1', 'amount' => '205',],
            ['category_id' => '1', 'name' => 'germ2', 'amount' => '275',],
            ['category_id' => '1', 'name' => 'vilaterm', 'amount' => '85',],
            ['category_id' => '1', 'name' => 'pena', 'amount' => '170',],
            ['category_id' => '1', 'name' => 'breakdown', 'amount' => '270',],
            ['category_id' => '1', 'name' => 'sctch_lenta', 'amount' => '205',],
            ['category_id' => '1', 'name' => 'prokleivanie_sctch_lenta1', 'amount' => '75',],
            ['category_id' => '1', 'name' => 'prokleivanie_sctch_lenta2', 'amount' => '135',],
            ['category_id' => '1', 'name' => 'snyatie_sctch_lenta1', 'amount' => '40',],
            ['category_id' => '1', 'name' => 'snyatie_sctch_lenta2', 'amount' => '70',],
            ['category_id' => '1', 'name' => 'primer', 'amount' => '55',],
            ['category_id' => '1', 'name' => 'drilling', 'amount' => '480',],
        ];

		foreach($data as $item){
			$this->db->table('prices')->insert($item);
		}
    }
}
