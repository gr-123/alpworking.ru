<?php

namespace App\Controllers;

use App\Models\CategoriesModel;
use App\Models\SealingImagesModel;
use App\Entities\CategoriesEntity;
use App\Entities\SealingImagesEntity;

/*
    php spark make:model Categories --suffix --return entity
    php spark make:seeder categories --suffix
    php spark make:migration create_categories_table
    php spark migrate
    php spark db:seed CategoriesSeeder
 */

class CategoryController extends BaseController
{
    protected $helpers = ['url'];

    /**
     * С помощью этого кода вы можете выполнить два разных запроса. 
     * Вы можете получить все записи категорий или получить категорию по ее програмному названию. 
     * $category переменная не была экранирована перед выполнением запроса; Query Builder сделает это за вас.
     * 
     * @param false|string $slug
     *
     * @return array|CategoriesEntity|null
     */
    public function getCategories($category = false)
    {
        $categoryModel = model(CategoriesModel::class);
        if ($category === false) {
            return $categoryModel->findAll();
        }
        return $categoryModel->where(['name' => $category])->first();
    }

    public function sealing(): string
    {
        $sealingImagesModel = model(SealingImagesModel::class);

        $data = array();
        $data = [
            'title' => 'Герметизация м.п. швов',
            'categories' => $this->getCategories('sealing'),
            'images' => $sealingImagesModel->findAll(),
        ];
        
        return view('category/sealing/index', $data);
    }
    public function window_cleaning(): string
    {
        $data = array();
        $data = [
            'pageTitle' => 'Мойка окон',
            'categories' => $this->getCategories('window_cleaning'),
        ];

        return view('category/window_cleaning/index', $data);
    }
}
