<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\ProductEntity;

// Вместо написания операций с базой данных прямо в контроллере запросы следует размещать в модели, 
// чтобы их можно было легко повторно использовать позже. Модели — это место, где вы извлекаете, вставляете 
// и обновляете информацию в своей базе данных или других хранилищах данных. Они предоставляют доступ к 
// вашим данным. Подробнее об этом можно прочитать в разделе «Использование модели CodeIgniter» .
// https://codeigniter.com/user_guide/models/model.html

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;


    /**
     *  $returnType as entity class  in RESTful API might not work in CodeIgniter 4.0.2.
     *  You can define as "object" at CodeIgniter 4.0.2 for RESTful API usage.
     *
     * $returnType как класс сущности в RESTful API может не работать в CodeIgniter 4.0.2.
     * Вы можете определить как «объект» в CodeIgniter 4.0.2 для использования RESTful API.
     * 
     *       protected $returnType      = 'object';
     *
     */

    // класс Entity как $returnType. Это гарантирует, что все методы модели, которые возвращают строки из базы 
    // данных, будут возвращать экземпляры нашего класса Entity вместо объекта или массива, как обычно
    protected $returnType       = ProductEntity::class;
    // protected $returnType       = 'array';

    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        // 'code',
        'title',
        'name',
        'price',
        'slug',
        'content',
        // 'description',
        // 'amount',
        // 'status',
        // 'active',
    ];

    protected bool $allowEmptyInserts = false;

    // https://www.codeigniter.org/user_guide/models/model.html#usetimestamps
    // Это логическое значение определяет, будет ли текущая дата автоматически добавляться ко всем вставкам и обновлениям. 
    // Если это правда, будет установлено текущее время в формате, указанном $dateFormat. Для этого необходимо, чтобы в 
    // таблице были столбцы с именами «create_at», «update_at» и «deleted_at» соответствующего типа данных.
    // Dates
    protected $useTimestamps = true;
    // protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    // protected $validationRules      = [
    //     // 'code' => 'required|alpha_numeric|exact_length[5]|is_unique[products.code,id,{id}]',
    //     'name' => 'required|alpha_numeric_space|min_length[3]|max_length[255]|is_unique[products.name,id,{id}]',
    //     // 'amount' => 'required',
    // ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getProducts($id = false)
    {
        // https://codeigniter.com/user_guide/database/query_builder.html

        if ($id === false) {
            return $this->findAll();
            // return $this->orderBy('id', 'DESC')->findAll();
        }

        try {           
            return $this->find($id);
            // return $this->where(['id' => $id])->first();
            // return $this->getWhere(['id' => $id])->getResult();
        } catch (\Throwable $t) {
            throw new \Exception("Cannot find the product item: '$id' "); // Exception implements Throwable
        }

    }

    // Из модели в CodeIgniter 4 мы можем разбить на страницы существующий запрос, который мы используем в текущей таблице, определенной в $tableсвойстве, например, в модели, как показано ниже:
    // public function getPaginatedProductData(string $keyword = ''): array
    // {
    //     if ($keyword)
    //     {
    //         $this->builder()
    //              ->groupStart()
    //                  ->like('product_code', $keyword)
    //                  ->orLike('product_name', $keyword)
    //              ->groupEnd();
    //     }
 
    //     return [
    //         'products'  => $this->paginate(),
    //         'pager'     => $this->pager,
    //     ];
    // }
    // Это для строк с разбивкой на страницы в одной таблице, а как насчет соединения SQL? Мы можем! Например, у нас есть вариант использования, чтобы получить продукт и цену из следующего табличного соотношения:
    // table 'product' id(bigint(20)unsignet),code(varchar(5)),name(varchar(255))
    // table 'price' id(bigint(20)unsignet),product_id(bigint(20)unsignet),price(decimal(10,0)),data(date)
    // который можно получить с помощью join:
    // SELECT
    // `product`.`*`, 
    // `price`.`price` 
    //     FROM
    //         `product` 
    //     JOIN
    //         `price` 
    //     ON
    //         `product`.`id` = `price`.`product_id` 
    //     WHERE
    //        `price`.`date` = DATE_FORMAT(NOW(),'%Y-%m-%d');
    // Если нам нужно представление объекта с классом сущности, мы можем создать для этого сущность:
    // <?php namespace App\Entities; 
    // use CodeIgniter\Entity;     
    // class ProductWithPrice extends Entity    {
    //     protected $attributes = [
    //         'id'           => null,
    //         'product_code' => null,
    //         'product_name' => null,
    //         'price'        => null,
    //     ];
    // }
    // Теперь в модели мы можем запросить соединение, а затем разбить на страницы:
    // <?php namespace App\Models; 
    // use App\Entities\ProductWithPrice;
    // use CodeIgniter\Model;     
    // class ProductModel extends Model    {           // ...
    //     public function getPaginatedProductWithPriceData()        {
    //         $this->builder()
    //              ->select(["{$this->table}.*", 'price.price'])
    //              ->join('price', "{$this->table}.id = price.product_id")
    //              ->where("price.date = DATE_FORMAT(NOW(),'%Y-%m-%d')");
     
    //         return [
    //             'productWithPrices'  => $this->asObject(ProductWithPrice::class)->paginate(),
    //             'pager'              => $this->pager,
    //         ];
    //     }
    //     // ...
    // }
    // теперь paginate() функция будет разбивать на страницы соединение запроса с объектной сущностью для строки результата.









}
