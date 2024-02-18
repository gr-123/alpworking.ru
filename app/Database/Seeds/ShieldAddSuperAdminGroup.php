<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;        

class ShieldAddSuperAdminGroup extends Seeder
{
    public function run()
    {
        $data = [['user_id' => 1, 'group' => 'superadmin', 'created_at' => Time::now()],];
        $this->db->table('auth_groups_users')->insertBatch($data);
    }
}
