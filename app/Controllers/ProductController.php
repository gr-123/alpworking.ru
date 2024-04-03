<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourcePresenter;

use CodeIgniter\Exceptions\PageNotFoundException;

use App\Entities\ProductEntity;
use App\Models\ProductModel;

class ProductController extends ResourcePresenter
{
    // ResourcePresenter   https://codeigniter.com/user_guide/incoming/restful.html#resourcepresenter
    protected $modelName = ProductModel::class;

    // Вы можете определить массив вспомогательных файлов как свойство класса. 
    // Всякий раз при загрузке контроллера эти вспомогательные файлы будут автоматически 
    // загружаться в память, так что вы сможете использовать их методы в любом месте внутри контроллера:
    protected $helpers = ['url', 'form'];

    private $target_dir = APPPATH . 'Views/products/';

    /**
     * Вывод списка
     * 
     * $routes->GET('products', [ProductController::class, 'index']);
     * 
     * @return ResponseInterface
     */
    public function index()
    {
        $paginations = $this->model->getPagination(4);
        $data = [
            'title' => 'Products archive',
            'products'  => $paginations['products'],
            'pager'  => $paginations['pager'],
        ];
        // echo "<pre>"; var_dump($data); die;

        if (!is_file($this->target_dir . 'index' . 'php')) {
            throw new PageNotFoundException($this->target_dir . 'index' . 'php');
        }

        return view('products/index', $data); // третий параметр очистить данные между вызовами

        // Api: 
        // return $this->respond($data);
        // curl -i -X GET http://alpworking.local/products
    }

    /**
     * GET products/show/(.*) \App\Controllers\ProductController::show/$1 
     * 
     * @param string $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        try {
            $data = [
                'title' => 'Show a products item',
                'item'  => $this->model->getProducts($id), // find($id)
            ];
            // echo "<pre>"; var_dump($data); die;
        } catch (\Throwable $t) {
            exit('<pre>' . $t->getMessage() . '<br>' . $t->getFile() . ', Line: ' . $t->getLine() . '<br><br>Trace:<br>' . $t->getTraceAsString());
        }

        if (!is_file($this->target_dir . 'show' . 'php')) {
            throw new PageNotFoundException($this->target_dir . 'show' . 'php');
        }

        // View\products\show.php
        return view('products/show', $data);

        // Api: 
        // if(! $data){ return $this->failNotFound(sprintf('product with id %d not found', $id)); }// вывод всегда только такой: 404 Not Found
        // return $this->respond($data);
        // curl -i -X GET http://alpworking.local/products/1
        // curl -i -X GET http://alpworking.local/products/show/1
    }

    /**
     * Отображение формы добавления
     * 
     * GET products/new \App\Controllers\ProductController::new   
     * 
     * @return mixed
     */
    public function new()
    {
        // Включить CSRF-фильтр 
        // для включения всех запросов POST: app/Config/Filters.php -> public $methods = ['post' => ['csrf'],];
        // Вы можете прочитать больше о защите CSRF в библиотеке безопасности https://codeigniter.com/user_guide/libraries/security.html

        if (!is_file($this->target_dir . 'create' . 'php')) {
            throw new PageNotFoundException($this->target_dir . 'create' . 'php');
        }

        // View\products\create.php
        return view('products/create', ['title' => 'Create a products item']);
    }

    /**
     * Сохранение 
     * 
     * $routes->POST products/create ProductController::create  
     * $routes->POST products        ProductController::create  
     * 
     * @return mixed
     */
    public function create()
    {
        // Получить данные ( нет свойства 'slug', создается автоматически в Entity :: setSlug($title) из значения свойства 'title' )
        // $data = [
        //     'title'   => $this->request->getPost('title'),
        //     'name'    => $this->request->getPost('name'),
        //     'price'   => $this->request->getPost('price'),
        //     'content' => $this->request->getPost('content'),
        // ];
        $data = $this->request->getPost(['title', 'name', 'price', 'content']); // null, если значение не найдено

        // Подробнее о библиотеке Validation https://codeigniter.com/user_guide/libraries/validation.html
        // Проверка в модели: https://codeigniter.com/user_guide/models/model.html#in-model-validation
        // $rules = $model->getValidationRules(['except' => ['username']]);
        // $rules = $model->getValidationRules(['only' => ['city', 'state']]);
        $rules = $this->model->getValidationRules();
        
        // $rules = [
        //     // @TODO
        // ];
        // $data = $this->request->getPost(array_keys($rules));

        // Проверить данные
        if (!$this->validateData($data, $rules)) {
            // var_export($this->validator->getErrors()); die;
            // echo validation_list_errors(); // Вывод ошибок проверки в представлении

            $validate_errors = $this->validator->getErrors();
            // Если проверка не удалась возвращаем HTML-форму.
            return redirect()->back()->withInput()->with('errors', $validate_errors); // validation_show_error('field') для вывода ошибки поля формы
            // return redirect()->back()->withInput(); // validation_show_error('field') для вывода ошибки поля формы

            // Redirect:
            // https://codeigniter4.github.io/userguide/outgoing/response.html#redirect
            // Если вы не знаете код состояния HTTP для перенаправления:
            // https://developer.mozilla.org/en-US/docs/Web/HTTP/Redirections
        }


        // Важный
        // рекомендуем перейти на Строгие CodeIgniter\Validation\StrictRules правила.

        // Сохранение наборов правил проверки в файле конфигурации
        // https://codeigniter.com/user_guide/libraries/validation.html#saving-sets-of-validation-rules-to-the-config-file

        // Примечание
        // Проверка также может выполняться автоматически в модели, но иногда ее проще сделать в контроллере. Где решать вам.

        // Setting Validation Rules
        // https://www.codeigniter.org/user_guide/models/model.html#setting-validation-rules

        // временно, если пригодится
        // Для проверки post-данных из формы (н-р: регистрации пользователя):
        // $validation = \Config\Services::validation();
        // // Получить группу правил из конфигурации проверки:
        // $rules = $validation->getRuleGroup('imageupload');
        // $data = $this->request->getPost(array_keys($rules));
        //// $validation->reset(); // run()метод не сбрасывает состояние ошибки. будут возвращаться все предыдущие ошибки до тех пор, пока они не будут явно сброшены. 
        // if ($validation->run($data, 'imageupload')) {// Вы можете указать группу, которая будет использоваться при вызове run() метода
        //     $validatedData = $validation->getValidated();
        // }
        // if ($validation->hasError('username')) { echo $validation->getError('username'); }// проверить, существует ли ошибка для одного поля. Если ошибок нет, будет возвращена пустая строка.
        // $errors = $validation->getErrors();

        // The validation was successful.

        // Получаем проверенные данные
        $post = $this->validator->getValidated(); // getValidated: https://codeigniter.com/user_guide/libraries/validation.html#getting-validated-data

        $entity = new ProductEntity();
        $entity->fill($post); // поместить в класс массив пар ключ/значение и заполнить свойства класса
        // Или тоже:
        // $entity = new ProductEntity();        
        // $entity->title   = $post['title'];
        // $entity->name    = $post['name'];
        // $entity->price   = $post['price'];
        // $entity->slug => свойство 'slug' создается автоматически в Entity :: setSlug($title) из значения свойства 'title'
        // $entity->content = $post['content'];

        // echo "<pre>"; var_dump($post); var_dump($entity); die;

        // Сохранить данные ( только $allowedFields )
        if ($this->model->save($entity) === false) {
            $data = ['errors' => $this->model->errors()];
            // Перенаправляем обратно, сохраняя информацию об ошибках:
            return redirect()->back()->withInput()->with('errors', $data); // setFlashdata()
        }

        // ID созданоого элемента
        $inserted_id = $this->model->getInsertID();

        // 
        // Вернуться на страницу успеха
        // View\products\success.php
        // return view('products/success', ['title' => 'Create a products item']);
        // 
        // Перейти на страницу показа созданного элемента
        return redirect()->to("/products/show/$inserted_id")->withInput()->with('success', 'Success! Create a products item.'); // setFlashdata()

        // Api:
        // return $this->fail($this->model->errors());             //https://codeigniter.com/user_guide/outgoing/api_responses.html#fail
        // return $this->respondCreated($data, 'product created'); //https://codeigniter.com/user_guide/outgoing/api_responses.html#respondCreated
        // Когда используется опция -F , curl отправляет данные с использованием Content-Type multipart/form-data
        // curl -i -X POST -F 'title=titleProduct' -F 'name=Product1' -F 'price=123.00' -F 'slug=c2afjdhj-nation-yes3' -F 'content=hfgh hjhjd hjkkj uilkryr klhkffbfgh' http://alpworking.local/products
        // Другой способ сделать запрос POST — использовать параметр -d . Это заставляет curl отправлять данные с использованием Content-Type application/x-www-form-urlencoded Content-Type.
        // curl -i -X POST -d 'title=titleProduct' -d 'name=Product1' -d 'price=123.00' -d 'slug=c2afjdhj-nation-yes3' -d 'content=hfgh hjhjd hjkkj uilkryr klhkffbfgh' http://alpworking.local/products
        // Загрузка файлов
        // Чтобы отправить файл с помощью curl , просто добавьте символ @ перед местоположением файла. Файл может быть архивом, изображением, документом и т. Д.
        // curl -X POST -F 'image=@/home/user/Pictures/wallpaper.jpg' http://example.com/upload
    }

    /**
     * Вывод формы для редактирования
     * 
     * $routes->GET products/edit/(.*) ProductController::edit/$1
     * 
     * @param mixed $id
     * 
     * @return mixed
     */
    public function edit($id = null)
    {
        if (empty($id || $id == null)) {
            return redirect()->to('products')->withInput()->with('errors', 'Возможна ошибка.');
        }

        try {
            $data = [
                'title' => 'Edit a products item',
                // Проверим существование объекта продукта в базе данных
                // Если не найдено, перенаправляем обратно на страницу редактирования
                'product'  => $this->model->getProducts($id), // ->find($id) // $model->where('id', $id)->first($id);
            ];

            if (!is_file($this->target_dir . 'edit' . 'php')) {
                throw new PageNotFoundException($this->target_dir . 'edit' . 'php');
            }

            // echo "<pre>"; var_dump($data); die;
            return view('products/edit', $data); // View\products\edit.php

        } catch (\Throwable $t) {
            // exit('<pre>' . $t->getMessage() . '<br>' . $t->getFile() . ', Line: ' . $t->getLine() . '<br><br>Trace:<br>' . $t->getTraceAsString());

            return redirect()->back()->withInput()->with('errors', sprintf('Ошибка данных с идентификатором "%d". Message: "' . $t->getMessage() . '", File: "' . $t->getFile() . '", Line: "' . $t->getLine() . '"', $id));
        }
    }

    /**
     * Сохранение обновления
     * 
     * $routes->POST products/update/(.*) ProductController::update/$1
     * 
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        // post value from 'hidden' Form field
        // $hidden_id = $this->request->getPost(['id']); // null, если значение не найдено

        // Проверка существование объекта продукта в базе данных уже была проведена в методе 'edit', см. выше

        // Получить данные ( нет свойства 'slug', создается автоматически в Entity :: setSlug($title) из значения свойства 'title' )
        // $data = [
        //     'title'   => $this->request->getPost('title'),
        //     'name'    => $this->request->getPost('name'),
        //     'price'   => $this->request->getPost('price'),
        //     'content' => $this->request->getPost('content'),
        // ];
        $data = $this->request->getPost(['title', 'name', 'price', 'content']); // null, если значение не найдено

        // Подробнее о библиотеке Validation https://codeigniter.com/user_guide/libraries/validation.html
        // Проверка в модели: https://codeigniter.com/user_guide/models/model.html#in-model-validation
        // $rules = $model->getValidationRules(['except' => ['username']]);
        // $rules = $model->getValidationRules(['only' => ['city', 'state']]);
        $rules = $this->model->getValidationRules();
        
        // $rules = [
        //     // @TODO
        // ];
        // $data = $this->request->getPost(array_keys($rules));

        // Проверить данные
        if (!$this->validateData($data, $rules)) {
            // var_export($this->validator->getErrors()); die;
            // echo validation_list_errors(); // Вывод ошибок проверки в представлении

            $validate_errors = $this->validator->getErrors();
            // Если проверка не удалась возвращаем HTML-форму.
            return redirect()->back()->withInput()->with('errors', $validate_errors); // validation_show_error('field') для вывода ошибки поля формы
            // return redirect()->back()->withInput(); // validation_show_error('field') для вывода ошибки поля формы

            // Redirect:
            // https://codeigniter4.github.io/userguide/outgoing/response.html#redirect
            // Если вы не знаете код состояния HTTP для перенаправления:
            // https://developer.mozilla.org/en-US/docs/Web/HTTP/Redirections
        }


        // Важный
        // рекомендуем перейти на Строгие CodeIgniter\Validation\StrictRules правила.

        // Сохранение наборов правил проверки в файле конфигурации
        // https://codeigniter.com/user_guide/libraries/validation.html#saving-sets-of-validation-rules-to-the-config-file

        // Примечание
        // Проверка также может выполняться автоматически в модели, но иногда ее проще сделать в контроллере. Где решать вам.

        // Setting Validation Rules
        // https://www.codeigniter.org/user_guide/models/model.html#setting-validation-rules

        // временно, если пригодится
        // Для проверки post-данных из формы (н-р: регистрации пользователя):
        // $validation = \Config\Services::validation();
        // // Получить группу правил из конфигурации проверки:
        // $rules = $validation->getRuleGroup('imageupload');
        // $data = $this->request->getPost(array_keys($rules));
        //// $validation->reset(); // run()метод не сбрасывает состояние ошибки. будут возвращаться все предыдущие ошибки до тех пор, пока они не будут явно сброшены. 
        // if ($validation->run($data, 'imageupload')) {// Вы можете указать группу, которая будет использоваться при вызове run() метода
        //     $validatedData = $validation->getValidated();
        // }
        // if ($validation->hasError('username')) { echo $validation->getError('username'); }// проверить, существует ли ошибка для одного поля. Если ошибок нет, будет возвращена пустая строка.
        // $errors = $validation->getErrors();

        // The validation was successful.

        // Получаем проверенные данные
        $post = $this->validator->getValidated(); // getValidated: https://codeigniter.com/user_guide/libraries/validation.html#getting-validated-data

        $entity = new ProductEntity();
        $entity->fill($post);        // поместить в класс массив пар ключ/значение и заполнить свойства класса
        // Или тоже:
        // $entity = new ProductEntity();        
        // $entity->title   = $post['title'];
        // $entity->name    = $post['name'];
        // $entity->price   = $post['price'];
        // $entity->slug => свойство 'slug' создается автоматически в Entity :: setSlug($title) из значения свойства 'title'
        // $entity->content = $post['content'];

        // echo "<pre>"; var_dump($post); var_dump($entity); die;

        // Сохранить данные
        try { // if ($model->save($data) === false)
            // Сохранить данные
            $this->model->save($entity); // только поля из $allowedFields
            // save() автоматически обрабатывает вставку или обновление, когда найден ключ, соответствующий первичному            
        } catch (\Throwable $t) {
            // exit('<pre>' . $t->getMessage() . '<br>' . $t->getFile() . ', Line: ' . $t->getLine() . '<br><br>Trace:<br>' . $t->getTraceAsString());

            $model_errors = $this->model->errors();
            $model_errors[] = 'Ошибки сохранения в базе данных: ' . $t->getMessage();
            // $model_errors['message'] = 'Ошибки сохранения в базе данных: ' . $t->getMessage();
            return redirect()->back()->withInput()->with('errors', $model_errors); // setFlashdata()
        }

        // ID обновленного элемента
        $inserted_id = $this->model->getInsertID();

        // Вывести страницу показа представления этого, но теперь уже обновленного элемента
        return redirect()->to("/products/show/$inserted_id")->withInput()->with('success', 'Success! Update a products item.'); // setFlashdata()

        // PUT-запрос – запись обновления
        // Для обновления любого поля вам необходимо использовать Request Type: PUT
        // 
        // var_dump($this->request->getMethod());die;
        // Получение необработанных данных (PUT, PATCH, DELETE)                   https://codeigniter.com/user_guide/incoming/incomingrequest.html#retrieving-raw-data-put-patch-delete
        // getRawInput(), так и getPost() в чем разница и где использовать каждый https://codeigniter.com/user_guide/incoming/incomingrequest.html?highlight=getrawinput
        // $request->is('put');
        // $json = $request->getJSON(); // https://codeigniter.com/user_guide/incoming/incomingrequest.html#getting-json-data
        // 
        // View:
        // <form action="" method="post">
        //     <input type="hidden" name="_method" value="PUT">
        // </form>
        // Только когда $routes->'resource'; иначе метод getRawInputVar() возвращает пустой php://input массив
        // curl -i -X PUT -d 'title=titleProduct' -d 'name=Product1' -d 'price=123.00' -d 'slug=c2afjdhj-nation-yes0' -d 'content=hfgh hjhjd hjkkj uilkryr klhkffbfgh' http://alpworking.local/products/update/40
        // 
        // Api:
        // $data = $this->request->getRawInput();                       // получить содержимое php://input в виде необработанного потока
        // var_dump($this->request->getRawInputVar(['title', 'name'])); // Вы также можете использовать getRawInputVar()
        // var_dump($data); die;
        // $data['id'] = $id;
        // if (!$this->model->save($data)) {
        //     return $this->fail($this->model->errors());
        // }
        // return $this->respond($data, 200, 'Data Updated');
    }

    /**
     * Представить представление для удаления определенного объекта, либо для возможности выбора нескольких.
     * 
     * GET products/remove/(.*) ProductController::remove/$1
     *
     * @param mixed $id Если 'id' === 'list' тогда загружаем страницу со всеми объектами и формой выбора нескольких объектов для удаления
     *
     * @return mixed
     */
    public function remove($id = null)
    {
        // Если не задан индетификатор, тогда открываем страницу списка для выбора многих строк (элементов) и последующего удаления
        if ($id === 'list') {
            // такая же пагинация, как и в методе 'index'
            $paginations = $this->model->getPagination(4);
            $data = [
                'title' => 'Выбор элементов для удаления',
                'products'  => $paginations['products'],
                'pager'  => $paginations['pager'],
            ];

            if (!is_file($this->target_dir . 'removelist' . 'php')) {
                throw new PageNotFoundException($this->target_dir . 'removelist' . 'php');
            }

            // View\products\removelist.php
            return view('products/removelist', $data);
        }

        if (!is_file($this->target_dir . 'remove' . 'php')) {
            throw new PageNotFoundException($this->target_dir . 'remove' . 'php');
        }

        return view('products/remove', ['id' => $id]);
    }

    /**
     * Обработка удаления одного или нескольких объектов
     * 
     * POST products/delete/(.*) ProductController::delete/$1
     * 
     * @param mixed $id Если 'id' === 'checkbox' тогда удаляются один или несколько выбранных объектов
     * 
     * @return mixed
     */
    public function delete($id = null)
    {
        // dd($this->request); var_dump($id);die;

        // массив для сохранения значений 'id' всех удаляемых объектов
        $id_data = array();

        // if (empty($id || $id == null)) { // бесполезно, все равно (в связи с маршрутами 'prezenter' все запросы перенаправляются на 'show' метод контроллера)
        //     return redirect()->to('products')->withInput()->with('errors', 'Возможна ошибка.');
        // }

        // Получение выбранных чекбоксов из формы (см. app/Views/products/index.php )
        // для удаления сразу нескольких объектов
        if ($id === 'checkbox') {
            $items = $this->request->getPost('id_items'); // null, если значение не найдено

            // Если ничего не выбрано из выведенного списка элементов на странице app/Views/products/removelist.php
            if (empty($items)) {
                return redirect()->back()->withInput()->with('errors', 'Ошибка. Выберите элементы.');
            }

            // добавим в массив значения 'id' всех удаляемых объектов
            foreach ($items as $item) {
                $id_data[] = $item;
            }
        } else {
            $id_data[] = $id;
        }

        // Удаление:
        // через перечисление массива в цикле:
        // foreach ($id_data as $id_item) {
        //     if (! $this->model->find($id_item)) {
        //         return redirect()->back()->withInput()->with('errors', "Sorry! Данные с идентификатором '$id' не найдены или уже удалены.");
        //     }
        //     if (!$this->model->delete($id_item)) {
        //         return redirect()->back()->withInput()->with('errors', "Sorry, product '$id_item' not deleted.");
        //     }
        // }
        // Или одной строкой, без предварительного поиска:
        try {
            $this->model->delete($id_data);
        } catch (\Throwable $t) {
            // exit('<pre>' . $t->getMessage() . '<br>' . $t->getFile() . ', Line: ' . $t->getLine() . '<br><br>Trace:<br>' . $t->getTraceAsString());

            session()->setFlashdata('errors', $this->model->errors());
            return redirect()->back()->withInput()->with('errors', $t->getMessage() . ', Ошибки удаления: ' . implode(", ", $this->model->errors())); // setFlashdata()
        }



        // stringify_attributes ( $attributes[, $js] 
        //  - $attributes ( mixed) – строка, массив пар ключ-значение или объект 
        //  - $js ( boolean) – true, если значения не нуждаются в кавычках (стиль Javascript)
        // Возврат: Строка, содержащая пары ключ/значение атрибута, разделенные запятыми. Тип возврата: string

        return redirect()->to('/products')->withInput()->with('success', "Deleted: '" . implode("', '", $id_data) . "'");

        // Api:
        // Request Type: DELETE
        // 
        // $data = $this->model->find($id);
        // if ($data) {
        //     $response = $this->model->delete($id); // if ($this->model->db->affectedRows() === 0) {
        //     if ($response) {
        //         return $this->respond($data);
        //         // $response = [
        //         //     'status'   => 200,
        //         //     'error'    => null,
        //         //     'messages' => [
        //         //         'success' => 'Employee successfully deleted'
        //         //     ]
        //         // ];
        //         // return $this->respondDeleted($response); // return $this->respondDeleted(['id' => $id], 'product deleted');
        //     }
        //     return $this->fail('Sorry! not deleted');
        // }
        // return $this->failNotFound(sprintf('Sorry! data with id %d not found or already deleted', $id));
        // 
        // curl -i -X DELETE http://alpworking.local/products/1
    }
}
