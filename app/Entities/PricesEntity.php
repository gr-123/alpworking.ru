<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PricesEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
    protected $attributes = [
        'category_id'  => null,
        'name'  => null,
        'amount'  => null,
    ];
}
