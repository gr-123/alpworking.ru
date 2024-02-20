<?php

namespace App\Controllers\Admin;

use CodeIgniter\Images\Exceptions\ImageException;
use App\Controllers\BaseController;
use App\Models\Image;

// посмотреть что полезное
// https://codeigniter.com/user_guide/incoming/restful.html
// $routes->resource('photos');
// // Equivalent to the following:
// $routes->get('photos/new', 'Photos::new');
// $routes->post('photos', 'Photos::create');
// $routes->get('photos', 'Photos::index');
// $routes->get('photos/(:segment)', 'Photos::show/$1');
// $routes->get('photos/(:segment)/edit', 'Photos::edit/$1');
// $routes->put('photos/(:segment)', 'Photos::update/$1');
// $routes->patch('photos/(:segment)', 'Photos::update/$1');
// $routes->delete('photos/(:segment)', 'Photos::delete/$1');



// Узнайте, как загружать файлы в CodeIgniter 4, как отдельные файлы, 
// так и несколько файлов одновременно....
// https://learncodeigniter.net/codeigniter-tutorials/upload-files-in-codeigniter-4/

// «Работа с загруженными файлами» . https://codeigniter.com/user_guide/libraries/uploaded_files.html#uploaded-files-accessing-files

// Помощник по файловой системе https://codeigniter.com/user_guide/helpers/filesystem_helper.html


// # In VsCode create ... files, folders
// sudo chown -R $USER:www-data /var/www/alpworking.ru/public/images


// # Загрузить несколько изображений
// # https://programmingfields.com/upload-multiple-image-with-validation-in-codeigniter-4/
// 
// 1. создать миграцию для загрузки изображений
// php spark make:migration images --table
// 
// Вы можете проверить файл в папке "App\Database\Migrations"
// Здесь создадим схему для таблицы изображений. В функцию up() добавим несколько полей:
// 
// <?php

// // php spark make:migration <...> // Создать файл миграции
// // php spark migrate              // Запуск миграции
// // php spark db:table users       // И проверьте users таблицу

// namespace App\Database\Migrations;

// use CodeIgniter\Database\Migration;
// use CodeIgniter\Database\RawSql;

// class Images extends Migration
// {
//     public function up()
//     {
//         // Внимание!
//         // TIMESTAMP --> 'updated_at','updated_at' для PostgreSQL !
//         $fields = [
//             'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
//             'imagename' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
//             'updated_at' => ['type' => 'TIMESTAMP', 'null' => true,],
//             'updated_at' => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP'),],
//         ];
//         $this->forge->addField($fields);
//         $this->forge->addPrimaryKey('id');
//         $this->forge->createTable('images');
//     }

//     public function down()
//     {
//         $this->forge->dropTable('images');
//     }
// }
// 
// 2. Перенести схему в базу данных
// php spark migrate
// 
// 3. Создайте модель для загрузки изображения
// php spark make:model Image
// protected $allowedFields = ['imagename'];
// 
// 4. Создайте контроллер для загрузки изображения
// php spark make:controller Admin\\Image --suffix # ImageController
// 
// 5. Создайте представление для загрузки нескольких изображений 
// touch app/Views/admin/dashboard/upload.php
// 
// 6. маршруты (admin/)
// $routes->get('image/upload', [ImageController::class, 'index'], ['as' => 'admin.image.upload']);
// $routes->post('image/upload', [ImageController::class, 'uploadImage'], ['as' => 'admin.image.upload']);

// Работа с загруженными файлами
// https://codeigniter.com/user_guide/libraries/uploaded_files.html

class ImageController extends BaseController
{
    private $upload_view = "admin/dashboard/upload";                                     // каталог шаблона    для загрузки    файлов изображений
    private $upload_uri = "admin/image/upload";                                          // uri                для загрузки    файлов изображений
    // Каталог загрузки
    // Загруженные файлы хранятся в каталоге writable/uploads/
    private $upload_folder = WRITEPATH . "uploads";  //file_location                                                 // внутренний каталог для загрузки    файлов изображений
    private $public_240x180_thumbs_images_folder = FCPATH . "images/thumbnails/240x180"; // внешний каталог    для перемещения файлов изображений
    private $w_resize = 240;                                                             // длина              для превью      файлов изображений
    private $h_resize = 180;                                                             // высота             для превью      файлов изображений
    
    /**
     * Constructor
     */
    public function __construct()
    {
        helper(['form', 'url']);
    }

    /**
     * Return image upload view
     *
     * @return void
     */
    public function index()
    {
		$data = [
			'pageTitle' => "Upload",
		];

		return view($this->upload_view, $data);
    }

    /**
     * Upload Image
     *
     * @return void
     */
    public function uploadImage()
    {
        // Настройки сеанса
        // 
        // app/Config/Session.php file:
        // driver        FileHandler //  DatabaseHandler,MemcachedHandler,RedisHandler,ArrayHandler (https://codeigniter.com/user_guide/libraries/sessions.html#filehandler-driver-the-default)
        // cookieName    ci_session
        // expiration    7200 (2 hours)
        // savePath      null      - зависит от используемого драйвера (важная вещь, которую вам следует знать, — это убедиться, что вы не используете общедоступный или общий каталог для хранения файлов сеанса. Убедитесь, что только у вас есть доступ к содержимому выбранного вами каталога savePath)
        // matchIP       false     - Следует ли проверять IP-адрес пользователя при чтении файла cookie сеанса. Обратите внимание, что некоторые интернет-провайдеры динамически меняют IP-адрес, поэтому, если вам нужен сеанс без срока действия, вы, скорее всего, установите для этого параметра значение false.
        // timeToUpdate  300       - Этот параметр определяет, как часто класс сеанса будет перегенерировать себя и создавать новый идентификатор сеанса. Установка значения 0 отключит регенерацию идентификатора сеанса.
        // regenerateDestroy false - Уничтожать ли данные сеанса, связанные со старым идентификатором сеанса, при автоматическом восстановлении идентификатора сеанса. Если установлено значение false, данные позже будут удалены сборщиком мусора.
        // 
        // файл cookie сеанса использует следующие значения конфигурации в вашем файле app/Config/Cookie.php :
        // domain        ''    - Домен, для которого применим сеанс
        // path          /     - Путь, к которому применим сеанс
        // secure        false - Создавать ли файл cookie сеанса только для зашифрованных (HTTPS) соединений.
        // sameSite      Lax   - Настройка SameSite для файла cookie сеанса.













        $session = \Config\Services::session();

        // $newdata = ['username'  => 'johndoe', 'email'     => 'johndoe@some-site.com', 'logged_in' => true,];
        // $session->set($newdata); // или по одному значению за раз: $session->set('some_name', 'some_value');
        // $session->push('hobbies', ['sport' => 'tennis']); // добавить в массив новое значение

        // Удаление данных сеанса
        // unset($_SESSION['some_name']); // or multiple values: unset($_SESSION['some_name'],$_SESSION['another_name']);
        // или
        // $session->remove('some_name'); // или массив ключей: $array_items = ['username', 'email']; $session->remove($array_items);

        // Flashdata:
        // доступны только для следующего запроса, а затем автоматически удаляются
        // $_SESSION['item'] = 'value';
        // $session->markAsFlashdata('item'); // пометить существующий элемент как «flashdata»: // $session->markAsFlashdata(['item', 'item2']); // несколько элементов
        // $session->setFlashdata('item', 'value'); // альтернативно
        // сохранить переменную flashdata с помощью дополнительного запроса
        // $session->keepFlashdata('item'); // $session->keepFlashdata(['item1', 'item2', 'item3']);
        // метод getFlashdata(): если вы хотите быть уверены, что читаете «флэш-данные» (а не какие-либо другие)
        // $session->getFlashdata('item'); // null, если элемент не найден
        //$session->getFlashdata(); // массив со всеми флэш-данными

        // закрыть текущий сеанс вручную после того, как он вам больше не понадобится
        // $session->close();
        // точно так же, как функция PHP session_write_close()

        // очистить текущий сеанс (например, при выходе из системы)
        // $session->destroy();
        // точно так же, как функция PHP session_destroy()
        // Это должна быть последняя операция, связанная с сеансом, которую вы выполняете во время того же запроса. Все данные сеанса (включая флэш-данные и временные данные) будут безвозвратно уничтожены.
        //   Примечание
        //   Вам не обязательно вызывать этот метод из обычного кода. Очистите данные сеанса, а не уничтожайте его.



        // fileimages validation
        // ext_in[file,jpg,jpeg,docx,pdf] ?
        $validated = $this->validate([
            'fileimages' => [
                'uploaded[fileimages]',
                'mime_in[fileimages,image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[fileimages,4096]',
                'errors' => [
                    'uploaded[fileimages]' => 'Please select an fileimages.'
                ]
            ],
        ]);

        if (!$validated) {
            return view($this->upload_view, [
                'validation' => $this->validator
            ]);
        }

        // Имена файлов из формы HTML
        $files = $this->request->getFileMultiple('fileimages');

        $filePreviewName = [];

        foreach($files as $filePath) {
            if($filePath->isValid() && !$filePath->hasMoved()) {

                // $name = $filePath->getName(); ?
                // $ext = $filePath->getClientExtension(); ?

                $newName = $filePath->getRandomName();

                $image = \Config\Services::image();

                try {
                    $image->withFile($filePath)
                        ->resize($this->w_resize, $this->h_resize, true, 'height')
                        ->save($this->public_240x180_thumbs_images_folder . '/' . '_' . $newName);
                } catch (ImageException $e) {
                    echo $e->getMessage();
                }

                $filePath->move($this->upload_folder, $newName); // WRITEPATH . 'uploads' // public/uploads/ ?

                $nameData = [
                    'imagename' =>  $newName,
                ];

                $imageModel = new Image;
                $result = $imageModel->save($nameData);

                if (!$result) {
                    $session->setFlashdata('failed', 'Failed! image not uploaded.');
                    return redirect()->to(site_url($this->upload_uri))->withInput()->with('previewImage', $newName);
                }

                // $session->setFlashdata('message', 'Uploaded successfully one file image!');
                // $session->setFlashdata('filename', $filePath->getName());
                // $session->setFlashdata('extension', $filePath->getClientExtension());
                array_push($filePreviewName, $newName);
            }           
        }

        $session->setFlashdata('success', 'Success! image uploaded.');
        
        return redirect()->to(site_url($this->upload_uri))->withInput()->with('previewImage', $filePreviewName);    
    }
}