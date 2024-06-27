<?php

// 
// ! namespace: --> 'Config' (app/Config/Routes.php)
// 
use CodeIgniter\Router\RouteCollection;
use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\UsersController;
use App\Controllers\Admin\ImageController;
use App\Controllers\Admin\CalculatorController;
use App\Controllers\Admin\SealingpriceController;
use App\Controllers\IndexController;
use App\Controllers\CategoryController;
use App\Controllers\Admin\WindowcleaningpriceController;
use App\Controllers\Home;

// https://codeigniter4.github.io/userguide/incoming/routing.html

//  CodeIgniter считывает свои правила маршрутизации сверху вниз и 
//  направляет запрос к первому соответствующему правилу

/**
 * @var RouteCollection $routes
 */

//  Любые маршруты, определенные в этом замыкании, доступны только из данной среды:
$routes->environment('development', static function ($routes) {

    // $routes->get('from', 'to', ['hostname' => 'accounts.example.com']); // В этом примере указанные хосты будут работать только в том случае, если домен 
    // точно соответствует account.example.com . Это не будет работать на основном сайте example.com .
    // $routes->get('from', 'to', ['subdomain' => 'media']); // $routes->get('from', 'to', ['subdomain' => '*']);

    $routes->get('builder', 'Tools\Builder::index');

    $routes->get('getinfo', static function () { // Эта функция будет выполнена, когда пользователь посетит этот URI. 
        // Это удобно для быстрого выполнения небольших задач или даже простого отображения простого представления:
        echo "<b>!!!<b/><pre>";
    });

    // Если вы просто хотите визуализировать представление, не имеющее никакой связанной с ним логики
    // view in /app/Views/pages/about.php
    $routes->view('about/(:segment)/(:segment)', 'pages/about'); // Within the view, you can access the segments with $segments[0] and $segments[1] respectively.
});

$routes->get('/', [IndexController::class, 'index']);
// Без 'use App\Controllers\Home;' == 'Config\Home', поскольку Routes.php имеет пространство имен 'Config'
// маршрутизатор добавит пространства имен по умолчанию 'App\Controllers' в начало контроллера, указанного в маршруте.

service('auth')->routes($routes);

// Вы можете проверить зарегистрированные маршруты в таблице маршрутизации, выполнив команду
// php spark routes
// php spark filter:check get /

// 
// Примечание
// Параметры, передаваемые во внешнюю group() (например, пространство имен и фильтр), не объединяются с параметрами внутренней group().
// 
// $routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'group:admin,superadmin'], static function($routes){
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'group:superadmin'], static function ($routes) {
    // 
    // Вы можете настроить, куда будет перенаправляться пользователь при входе в систему, с помощью метода loginRedirect() конфигурационного файла app/Config/Auth.php
    // Например: администраторы на /admin, а все остальные группы на /
    // return $this->getUrl(auth()->user()->inGroup('admin') ? '/admin' : setting('Auth.redirects')['login']); // ... auth()->user()->can('admin.access')
    // 
    $routes->get('/', [AdminController::class, 'index'], ['as' => 'admin.home']);
    $routes->get('profile', [AdminController::class, 'profile'], ['as' => 'admin.profile']);
    $routes->get('manager', [AdminController::class, 'manager'], ['as' => 'admin.manager']);
    $routes->get('calculator', [AdminController::class, 'calculator'], ['as' => 'admin.calculator']);
    $routes->get('prices', [AdminController::class, 'prices'], ['as' => 'admin.prices']);

    // Upload
    $routes->get('image/upload', [ImageController::class, 'index'], ['as' => 'admin.image.upload']);
    // $routes->post('image/upload', [ImageController::class, 'index'], ['as' => 'admin.image.upload']);
    $routes->post('image/upload', [ImageController::class, 'uploadImage'], ['as' => 'admin.image.upload']);
    $routes->post('image/delete', [ImageController::class, 'delete'], ['as' => 'admin.image.delete']);

    // Calculator
    $routes->get('calculator/sealing', [CalculatorController::class, 'sealing'], ['as' => 'admin.calculator.sealing']);
    $routes->post('calculator/sealing', [CalculatorController::class, 'sealing']);
    // 
    // $routes->post('calculator/subtract', [CalculatorController::class, 'subtract'], ['as' => 'admin.calculator.subtract']);
    // $routes->post('calculator/multiply', [CalculatorController::class, 'multiply'], ['as' => 'admin.calculator.multiply']);
    // $routes->post('calculator/divide', [CalculatorController::class, 'divide'], ['as' => 'admin.calculator.divide']);

    // Prices
    $routes->get('prices/sealing', [SealingpriceController::class, 'index'], ['as' => 'admin.prices.sealing']);
    $routes->get('prices/sealing/update', [SealingpriceController::class, 'update']);
    $routes->post('prices/sealing/update', [SealingpriceController::class, 'update']);
    // $routes->get('prices/window_cleaning', [WindowcleaningpriceController::class, 'index'], ['as' => 'admin.prices.window_cleaning']);

    // $routes->post('adduser', 'AdminController::adduser'); // /admin/adduser // $this->request->getPost()
    // $routes->match(["get", "post"], 'namemethod', 'AdminController::namemethod');

    // Обратите внимание, что параметры (filter), переданные во внешнюю группу(), не объединяются с параметрами внутренней группы().
    // $routes->group(
    //     '',
    //     ['filter' => ['group:admin,superadmin', 'permission:users.manage']],
    //     static function ($routes) {
    //         $routes->resource('users');
    //     }
    // );

    // Примечание
    // https://codeigniter.com/user_guide/incoming/routing.html#multiple-filters
    // Если вы установили для маршрута более одного фильтра, вам необходимо включить несколько 
    // фильтров (установить свойство $multipleFilters true в app/Config/Feature.php). 
    // Важный! 
    // Эта функция отключена по умолчанию. Потому что это нарушает обратную совместимость.

    // $routes->group('users', ['namespace' => 'App\Controllers\Admin', 'filter' => 'permission:admin.access'], function ($routes) {}
    $routes->group('users', ['namespace' => 'App\Controllers\Admin'], function ($routes) { // admin/users/
        $routes->get('/', [UsersController::class, 'index']); //, ['as' => 'admin.user.home']
        // $routes->get('list', 'UsersController::list');
        // $routes->delete('users/delete/(:segment)', 'UsersController::delete', ['filter' => 'admin-auth:dual,noreturn']); // ['dual', 'noreturn'] in $arguments filter’s before() and after()
    });
});

// $routes->resource('products', ['controller' => 'ProductController', 'websafe' => 1]);
// GET    | products               | »   \App\Controllers\Products::index    
// GET    | products/new           | »   \App\Controllers\Products::new      
// GET    | products/(.*)/edit     | »   \App\Controllers\Products::edit/$1  
// GET    | products/(.*)          | »   \App\Controllers\Products::show/$1  
// POST   | products               | »   \App\Controllers\Products::create   
// PATCH  | products/(.*)          | »   \App\Controllers\Products::update/$1
// PUT    | products/(.*)          | »   \App\Controllers\Products::update/$1
// DELETE | products/(.*)          | »   \App\Controllers\Products::delete/$1
    
$routes->presenter('products', ['controller' => 'ProductController', 'websafe' => 1]);
// GET    | products               | »   \App\Controllers\ProductController::index    
// GET    | products/show/(.*)     | »   \App\Controllers\ProductController::show/$1  
// GET    | products/new           | »   \App\Controllers\ProductController::new      
// GET    | products/edit/(.*)     | »   \App\Controllers\ProductController::edit/$1  
// GET    | products/remove/(.*)   | »   \App\Controllers\ProductController::remove/$1
// GET    | products/(.*)          | »   \App\Controllers\ProductController::show/$1  
// POST   | products/create        | »   \App\Controllers\ProductController::create   
// POST   | products/update/(.*)   | »   \App\Controllers\ProductController::update/$1
// POST   | products/delete/(.*)   | »   \App\Controllers\ProductController::delete/$1
// POST   | products               | »   \App\Controllers\ProductController::create

// The route is defined as:
$routes->get('users/(:num)/gallery/(:num)', 'Galleries::showUserGallery/$1/$2', ['as' => 'user_gallery']);
// <a href="<?= url_to('user_gallery', 15, 12) вопр.>">View Gallery</a> Result: 'http://example.com/users/15/gallery/12'

// Category
$routes->get('category/sealing', [CategoryController::class, 'sealing'], ['as' => 'category.sealing']);
$routes->get('category/window_cleaning', [CategoryController::class, 'window_cleaning'], ['as' => 'category.window_cleaning']);
