<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriesModel;
use App\Models\PricesModel;

/** Create Controller: */
// php spark make:controller Admin\\Calculator --suffix

// DELETE 'table_name'...
// DELETE FROM "migrations" WHERE "id"=...

/** Create Migrations: */
// php spark make:migration create_categories_table
// php spark make:migration create_prices_table
// 
// Created: * CreateCategoriesTable.php, * CreatePricesTable.php

// php spark migrate:status

/** Create tables database: */
// php spark migrate

/** Create 2 Models and 2 Entities: */
// php spark make:model Categories --suffix --return entity
// php spark make:model Prices --suffix --return entity
// 
// Created and edit files:
// CategoriesModel.php,  Edit: $allowedFields = ['name',];
// PricesModel.php,      Edit: $allowedFields = ['category_id','name','amount',];
// CategoriesEntity.php, Edit: $attributes =    ['name'  => null];
// PricesEntity.php,     Edit: $attributes =    ['category_id'  => null, 'name'  => null, 'amount'  => null,];

/** Create Seeders: */
// php spark make:seeder categories --suffix // CategoriesSeeder.php
// php spark make:seeder prices --suffix     // PricesSeeder.php
// 
// Edit...

/** Insert data in tables database:*/
// 1.
// php spark db:seed CategoriesSeeder
// 2.
// php spark db:seed PricesSeeder

// php spark db:table categories --metadata
// php spark db:table categories --limit-rows 50 --limit-field-value 20 --desc
// php spark db:table prices     --metadata
// php spark db:table prices     --limit-rows 50 --limit-field-value 20 --desc


class CalculatorController extends BaseController
{

    /*
use CodeIgniter\API\ResponseTrait;
use ResponseTrait;
public function index(){
    $categoryModel = new CategoryModel();
    $data['categories'] = $categoryModel->findAll();
    return view('categories', $data);
}
public function getSubcategories(){
$subcategoryModel = new SubcategoryModel();
$subcategories = $subcategoryModel->where('category_id', $this->request->getVar('category_id'))->findAll();
return $this->respond($subcategories);
}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#category').change(function(){
                var category_id = $('#category').val();
                if(category_id != ''){
                    $.ajax({
                        url:"<?= base_url('category/getSubcategories'); ?>",                    method:"POST",
                    data:{category_id:category_id},
                    success:function(data){
                        $('#subcategory').html(data);
                    }
                });
            }
        });
    });
</script>
</head>
<body>
    <h1>Dynamic Dependent Dropdown - CodeIgniter 4</h1><div>
    <label>Category:</label>
    <select id="category">
        <option value="">Select Category</option>
        <?php foreach($categories as $category): ?>
            <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div>
    <label>Subcategory:</label>
    <select id="subcategory">
        <option value="">Select Subcategory</option>
    </select>
</div>
</body>
*/


    protected $helpers = ['url', 'form'];
    // protected $model = model(PriceModel::class);
    // protected $model = new PriceModel(); // \App\Models\PriceModel()

    public function index()
    {
        // $data['news'] = $model->getNews();

        $data['pageTitle'] = 'Calculator';
        return view('admin/calculator/index');
    }

    // Действие сложения.
    // get|post
    public function add()
    {
        // foreach ($_POST as $element) { if (is_numeric($element)) { echo var_export($element, true) . " число", PHP_EOL; } else {echo var_export($element, true) . " НЕ число", PHP_EOL; } }

        // Пример работы с оператором нулевого слияния       
        // $action = $_POST['action'] ?? 'default';
        // Пример выше аналогичен этому выражению с if/else
        // if (isset($_POST['action'])) { $action = $_POST['action']; } else { $action = 'default'; }

        // обычно вы можете сделать что-то вроде этого:
        // $something = $_POST['foo'] ?? null;

        // С помощью встроенных методов CodeIgniter вы можете просто сделать это:
        // $something = $request->getPost('foo');
        // возвращают значение null, если элемент не существует
        // позволяет удобно использовать данные без необходимости предварительно проверять, существует ли элемент

        // Определение типа запроса
        // Если не post-запрос, тогда открываем страницу калькулятора
        if (!$this->request->is('post')) {
            return view('admin/calculator/add');
        }

        $model = model(PricesModel::class);
        // все позиции прайса в базе данных для категории "Герметизация м.п. швов"
        // $price = $model->where(['category_id' => '1'])->findAll();

        // Post-запрос. Вычисляем данные запроса.
        $post_data = $this->request->getPost();
        // $this->request->getPost('value'); // null, если элемент не существует

        // echo '<pre>', 'post_data: '; var_dump($post_data);

        // Стоимость работ (без стоимости матрериалов)
        $data['ans'] = 0;

        // себестоимость одного п.м. материала
        foreach ($post_data as $item) {
            switch ($item) {
                case "vilaterm": // вилатерм
                    $val = $model->where(['category_id' => '1', 'name' => 'vilaterm'])->first();
                    $data['ans'] = intval($data['ans']) + $val->amount; // арифметическое действие калькулятора
                    break;
                case "pena": // монтажная пена
                    $val = $model->where(['category_id' => '1', 'name' => 'pena'])->first();
                    $data['ans'] = intval($data['ans']) + $val->amount; // арифметическое действие калькулятора
                    break;
                case "breakdown": // разбивка межпанельного шва
                    $val = $model->where(['category_id' => '1', 'name' => 'breakdown'])->first();
                    $data['ans'] = intval($data['ans']) + $val->amount; // арифметическое действие калькулятора
                    break;
                case "sctch_lenta": // скотч лента
                    $val = $model->where(['category_id' => '1', 'name' => 'sctch_lenta'])->first();
                    $data['ans'] = intval($data['ans']) + $val->amount; // арифметическое действие калькулятора
                    break;
                case "primer": // грунтовка
                    $val = $model->where(['category_id' => '1', 'name' => 'primer'])->first();
                    $data['ans'] = intval($data['ans']) + $val->amount; // арифметическое действие калькулятора
                    break;
                case "sverlenie":
                    $val = $model->where(['category_id' => '1', 'name' => 'sverlenie'])->first();
                    $data['ans'] = intval($data['ans']) + $val->amount; // арифметическое действие калькулятора
                    break;
                case "germ1": // 1-комп.герметик
                    $val = $model->where(['category_id' => '1', 'name' => 'germ1'])->first();
                    $data['ans'] = intval($data['ans']) * $val->amount; // арифметическое действие калькулятора
                    break;
                case "germ2": // 2-комп.герметик
                    $val = $model->where(['category_id' => '1', 'name' => 'germ2'])->first();
                    $data['ans'] = intval($data['ans']) + $val->amount; // арифметическое действие калькулятора
                    break;
                    //     case "breakdown": // С разбивкой швов
                    //         break;
                    //     case "drilling": // Через сверление отверстий
                    //         break;
            }
        }

        // сколько всего пог.метров
        $total_meters = $this->request->getPost('total_meters');

        // is_numeric
        // is_numeric — Проверяет, содержит ли переменная число или числовую строку
        // строка считается числовой, если её можно интерпретировать как целое (int) число или как число с плавающей точкой (float).

        if (is_numeric($total_meters)) {
            // Если int равно float, тогда приравниваем к int-значению.
            $total_meters = (intval($total_meters) == floatval($total_meters)) ? intval($total_meters) : floatval($total_meters);
        } else {
            // если поле формы пустое (не заполнено), преобразуем в int-значение (для последующего арифметического действия в калькуляторе).
            $total_meters = intval($total_meters);
        }

        // echo '<pre>', 'ans: '; var_dump($data['ans']);
        // echo '<pre>', 'total_meters: '; var_dump($total_meters);
        // die;

        // Если количество п.м. не указано, приравниваем к 1 п.м.
        if ($total_meters == 0) {
            $data['ans'] = 1 * $data['ans']; // итого за 1 п.м.            
        } else {
            // иначе количество метров умножаем на стоимость работ за 1 п.м.
            $data['ans'] = $total_meters * $data['ans']; // арифметическое действие калькулятора
        }

        // $data['ans'] // итоговая стоимость работ (без учета стоим. материалов)

        return view('admin/calculator/add', $data);
    }

    protected function calculate($num1, $num2, $num3)
    {
        $data = array();

        $data['c'] = $num1 / 50;
        $data['b'] = $num2 / 12;
        $data['s'] = $num3 / 5;
        $data['p'] = $data['c'] + $data['b'] - $data['s'];

        return $data;
    }

    // вычитание
    public function subtract()
    {
        if (isset($_POST['subtract'])) {
            $ans = $_POST['number1'] - $_POST['number2'];
            $data = array(
                'number1' => $_POST['number1'],
                'number2' => $_POST['number2'],
                'ans' => $ans,
            );
        } else {
            $data = array(
                'number1' => '0',
                'number2' => '0',
                'ans' => '0',
            );
        }
        return view('admin/calculator/subtract', $data);
    }
    // умножение
    public function multiply()
    {
        if (isset($_POST['multiply'])) {
            $ans = $_POST['number1'] * $_POST['number2'];
            $data = array(
                'number1' => $_POST['number1'],
                'number2' => $_POST['number2'],
                'ans' => $ans,
            );
        } else {
            $data = array(
                'number1' => '0',
                'number2' => '0',
                'ans' => '0',
            );
        }
        return view('admin/calculator/multiply', $data);
    }
    // разделение
    public function divide()
    {
        // Операция деления («/») возвращает число с плавающей точкой, кроме случая, когда оба значения — целые числа (или строки, которые преобразуются в целые числа), которые делятся нацело, тогда возвращается целое значение. Для целочисленного деления вызывают функцию intdiv()
        // intdiv — Делит два числа без остатка
        // 
        // 
        // 
        if (isset($_POST['divide'])) {
            $ans = $_POST['number1'] / $_POST['number2'];
            $data = array(
                'number1' => $_POST['number1'],
                'number2' => $_POST['number2'],
                'ans' => $ans,
            );
        } else {
            $data = array(
                'number1' => '0',
                'number2' => '0',
                'ans' => '0',
            );
        }
        return view('admin/calculator/divide', $data);
    }
}
