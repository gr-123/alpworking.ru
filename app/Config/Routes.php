<?php

// 
// ! namespace: --> 'Config' (app/Config/Routes.php)
// 
use CodeIgniter\Router\RouteCollection;
use App\Controllers\Admin\AdminController;
// use App\Controllers\Admin\UsersController;
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

$routes->get('/', [Home::class, 'index']);
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
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('/', [AdminController::class, 'index'], ['as' => 'admin.home']);
    $routes->get('profile', [AdminController::class, 'profile'], ['as' => 'admin.profile']);
    // $routes->post('adduser', 'AdminController::adduser'); // /admin/adduser // $this->request->getPost()
    // $routes->match(["get", "post"], 'namemethod', 'AdminController::namemethod');
    
	// $routes->group('users', ['namespace' => 'App\Controllers\Admin', 'filter' => 'permission:admin.access'], function ($routes) {}
	$routes->group('users', ['namespace' => 'App\Controllers\Admin'], function ($routes) { // admin/users/
        // $routes->get('/', 'UsersController::index');//, ['as' => 'admin.user.home']
        // $routes->get('list', 'UsersController::list');
        // $routes->delete('users/delete/(:segment)', 'UsersController::delete', ['filter' => 'admin-auth:dual,noreturn']); // ['dual', 'noreturn'] in $arguments filter’s before() and after()
	});
});

// The route is defined as:
$routes->get('users/(:num)/gallery/(:num)', 'Galleries::showUserGallery/$1/$2', ['as' => 'user_gallery']); 
// <a href="<?= url_to('user_gallery', 15, 12) вопр.>">View Gallery</a> Result: 'http://example.com/users/15/gallery/12'

