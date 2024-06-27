<?php

namespace App\Controllers;

use App\Controllers\CategoryController;

class IndexController extends BaseController
{
    public function index(): string
    {
        $categoryController = new CategoryController();
        
        $data = [
            'categories' => $categoryController->getCategories(), // все категории
        ];

        return view('index', $data);
    }
}
