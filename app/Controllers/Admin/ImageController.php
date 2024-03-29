<?php

namespace App\Controllers\Admin;

use Throwable;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Images\Exceptions\ImageException;
use CodeIgniter\HTTP\Exceptions\HTTPException;

use CodeIgniter\HTTP\RedirectResponse;

use App\Controllers\BaseController;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Files\UploadedFile;
use App\Models\Image;



// 2015 Simple Image Gallery CRUD with CodeIgniter 3 https://the-amazing-php.blogspot.com/2015/05/codeigniter-image-gallery-crud.html



// \alpfreelance - swarm\app\application\upload\FileController.php
// C:\Users\n1\OneDrive\PHP\CI\5. Images upload.s

class ImageController extends BaseController
{
    private $imagesDir = 'assets/images';            // каталог загрузки изображений
    private $thumbsDir = 'assets/images/thumbnails'; // каталог превью изображений

    private $w_thumb = 240; // ширина превью
    private $h_thumb = 180; // высота

    private $upload_form = 'admin/upload/upload_form';       // форма загрузки
    private $success_upload = 'admin/upload/success_upload'; // вывод успешной загрузки файлов

    private $uploaded_bool = true;  // обязательно ли загружать файлы
    private $thumbs_bool = true;    // обязательно ли создавать уменьшенные копии изображений

    private $imageModel;                                     // Image Model
    protected $helpers = ['url', 'form'];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->imageModel = new Image; // https://codeigniter.com/user_guide/models/model.html
    }

    /**
     * Return image upload view
     *
     * @return void
     */
    public function index(): string
    {
        $data = [
            'pageTitle' => 'Upload - Загрузка нескольких файлов',
            'errors' => [],
        ];

        if (!is_file(APPPATH . 'Views/' . $this->upload_form . '.php')) {
            throw new PageNotFoundException($this->upload_form);
        }

        return view($this->upload_form, $data);
    }

    /**
     * 
     * Работа с загруженными файлами
     * https://codeigniter.com/user_guide/libraries/uploaded_files.html
     * 
     * Upload Image
     * 
     * 
     */
    public function uploadImage(): RedirectResponse | string
    {
        //  найти все файлы конфигурации, загруженные PHP:
        // var_dump(php_ini_loaded_file(), php_ini_scanned_files());

        // d(ini_get('upload_max_filesize'), ini_get('post_max_size'), ini_get('memory_limit'));
        // dd($this->request->getFiles(), $this->request->getPost());
        // dd($_FILES, $_POST);
        // 
        // echo '<pre>';print_r($this->request->getPost());echo '</pre>';  // array ( 'images_upload' )
        // echo '<pre>';print_r($this->request->getFiles());echo '</pre>'; // array ( 'images' => array ( 0 => \UploadedFile ( name,path,size,hasMoved,error, ...
        // // echo '<pre>';print_r($this->request->getFileMultiple('images'));echo '</pre>'; 
        // // echo '<pre>';print_r($this->request->getFile('images.0'));echo '</pre>'; //  <input type='file' name='images[]'>
        // die;
        // 

        if (!is_file(APPPATH . 'Views/' . $this->upload_form . '.php')) {
            throw new PageNotFoundException($this->upload_form);
        }

        // 
        // Проверяем необходимый тип запроса (post).
        // 
        // В предыдущих версиях вам нужно было использовать if (strtolower($this->request->getMethod()) !== 'post')
        if (!$this->request->is('post')) { // начиная с версии 4.3.0
            log_message('info', 'Ошибка приема POST данных! Несанкционированный вход по GET-запросу.');
            $data = ['errors' => 'Ошибка приема POST данных! Несанкционированный вход по GET-запросу.'];
            return view($this->upload_form, $data);
        }

        // 
        // Проверяем наличие поля 'name' в post-запросе.
        // 
        if (!$this->request->getPost('images_upload')) { // <button name='images_upload' type='submit' />
            log_message('info', 'Ошибка приема POST данных! Нет необходимого значения.');
            $data = ['errors' => 'Ошибка приема POST данных! Нет необходимого значения.'];
            return view($this->upload_form, $data);
        }

        // 
        // Валидация в соответствии файла конфигурации app/Config/Validation.php, группа 'imageupload'
        // 
        if (!$this->validateData([], 'imageupload')) { // true -  только в том случае, если ваши правила были успешно применены и ни одно из них не привело к сбою
            $data = ['errors' => $this->validator->getErrors()]; // Если ошибок нет, будет возвращен пустой массив.
            log_message('info', 'Ошибка проверки файлов: ' . implode(', ', $data['errors']));
            return view($this->upload_form, $data);
        }

        // 
        // The validation was successful.
        // 

        // 
        // Список загруженных файлов.
        // 
        $uploadFiles = array();

        // 
        // Список сохраненных файлов
        // 
        $saveFiles = array();

        // 
        // Получаем загруженные файлы
        // 
        $uploadFiles = $this->request->getFiles(); // UploadedFile object
        //   <input type='file' name='images[]' multiple='multiple' />
        //   ['images' => [0 => UploadedFile::class -> { name,path,size,hasMoved,error,... }
        // 
        // Примечание
        // Экземпляр UploadedFile соответствует $_FILES. Даже если пользователь просто нажмет кнопку отправки и не загрузит файл, 
        // экземпляр все равно будет существовать. Вы можете проверить, что файл действительно был загружен, с помощью 
        // метода isValid() в UploadedFile. См. Проверка файла. https://codeigniter4.github.io/userguide/libraries/uploaded_files.html#verify-a-file
        // 

        // 
        // Необязательный блок (все проверяется и без этого, в rules-правилах для загрузки файлов, где 'uploaded' приравнивается к 'requred' атрибуту поля формы загрузки.)
        // -->>
        // --------------------------------------------------------------------
        // // Проверяем соответствие названию input поля в массиве файлов.
        // $name_input = 'images'; // название html input поля формы для загрузки файлов
        // // ключ первого ('images') массива загруженных файлов из формы (php функция 'array_key_first' возвращает первый ключ в массиве)
        // $first_key = array_key_first($uploadFiles); // ['images'][]
        // if ($first_key !== $name_input) { // если не совпадает
        //     log_message('info', 'Ошибка input name.');
        //     $data = ['errors' => 'Ошибка input name.']; 
        //     return view($this->upload_form, $data);
        // }
        // // значение первого массива с ключом 'images'
        // $first_value = $uploadFiles[$first_key]; // ['images'][0]( Object \UploadedFile -> { свойства класса })
        // // ключ второго (индексного) массива (php функция 'array_key_first' возвращает первый ключ в массиве)
        // $second_key = array_key_first($first_value); // 0
        // // значение свойства объекта \UploadedFile поля 'name' в первом индексном массиве массива 'images' загруженных файлов
        // $name_splfileinfo = $first_value[$second_key]->getName(); // название файла, либо пустая строка ""        
        // // Если в правилах проверки файлов есть 'uploaded' тогда необходимо выбрать файл(ы) в форме загрузки
        // // и если не выбрано, тогда поле 'name' будет пустой строкой, вероятно.
        // if ($name_splfileinfo === "" && $this->uploaded_bool == true) { // если пустая строка в свойстве объекта \UploadedFile и условие обязательной загрузки файла(ов)
        //     // тогда открываем снова форму с полем для загрузки
        //     log_message('info', 'Ошибка, выберите файл(ы).');
        //     $data = ['errors' => 'Ошибка, выберите файл(ы).']; 
        //     return view($this->upload_form, $data);
        // }
        // <<--
        // --------------------------------------------------------------------


        // 
        // Перебираем все загруженные из формы файлы
        // 
        foreach ($uploadFiles['images'] as $file) {

            // Здесь непонятно что значит 'уже перемещен' и куда. В док-ции читаем: 
            // После удаления файла временный файл удаляется. Вы можете проверить, был ли уже перемещен файл, с помощью метода hasMoved(), который 
            // возвращает логическое значение:
            if ($file->hasMoved()) {
                // $data = ['errors' => 'Ошибка. Данный файл "$file" уже был перемещен.' . $file->getErrorString() . '(' . $file->getError() . ')'];
                // return view($this->upload_form, $data);
                throw HTTPException::forAlreadyMoved();
            }

            // 
            // Проверка ошибок загрузки файла
            // 
            if (!$file->isValid()) { //, что действительно был загружен по HTTP без ошибок
                // throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
                // С помощью этого метода можно обнаружить следующие ошибки:
                //  - Файл превышает вашу upload_max_filesize директиву ini.
                //  - Файл превышает лимит загрузки, определенный в вашей форме.
                //  - Файл был загружен лишь частично.
                //  - Ни один файл не был загружен.
                //  - Не удалось записать файл на диск.
                //  - Не удалось загрузить файл: отсутствует временный каталог.
                //  - Загрузка файла была остановлена ​​расширением PHP.
                throw HTTPException::forInvalidFile();
            }

            /*
            https://codeigniter4.github.io/userguide/helpers/filesystem_helper.html
            
            get_file_info                            // name, size, date, readable, writeable, executable and fileperms.
            symbolic_permissions                     // -rw-r--r--
            octal_permissions                        // 644
            echo            $file->getPerms();           // Get the file permissions
            SplFileInfo:
            echo            $file->getBasename();
            echo            $file->getRealPath();
            echo            $file->getMTime();           // Get last modified time
            echo            $file->guessExtension();     // Returns 'jpg' (WITHOUT the period)
            $size         = $file->getSize();            // 256901
            $bytes        = $file->getSizeByUnit();      // 256901
            $kilobytes    = $file->getSizeByUnit('kb');  // 250.880
            $megabytes    = $file->getSizeByUnit('mb');  // 0.245
            $name         = $file->getName();            // исходное имя файла, предоставленное клиентом. Обычно это имя файла, отправленное клиентом, и ему не следует доверять. Если файл был перемещен, будет возвращено окончательное имя перемещенного файла
            $clientPath   = $file->getClientPath();      // путь к файлу относительно каталога, когда клиент загрузил файлы через загрузку каталога
            $tempfile     = $file->getTempName();        // полный путь к временному файлу, созданному во время загрузки
            $ext          = $file->getClientExtension(); // исходное расширение файла на основе имени загруженного файла
            Предупреждение
            Это НЕ надежный источник. Вместо этого используйте надежную версию guessExtension().
            $type         = $file->getClientMimeType();  // MIME-тип файла, предоставленный клиентом. Это НЕ доверенное значение. Вместо этого используйте getMimeType()
            helper 'filesystem':
            echo '<pre>';
            print_r(directory_map(FCPATH . 'assets/images/', 0, true)); //карта каталога                 
            echo octal_permissions(fileperms('assets/images')), symbolic_permissions(fileperms('assets/images')); 
                                                                       // 750 drwxr-x---
            echo set_realpath('./');                                   // /var/www/alpworking.ru/public/
            print_r(get_filenames(WRITEPATH . 'uploads/'));            //массив, содержащий имена всех файлов
            print_r(get_dir_file_info (WRITEPATH . 'uploads/', false));//массив, содержащий имена имена файлов, размер файла, даты и разрешения
            print_r(get_file_info  (WRITEPATH . 'uploads/', false));   //атрибуты имени , пути , размера и даты изменения для файла

            Созд.папку,затем удалить
            $directory = WRITEPATH . 'uploads/qwe/';
            if (!file_exists($directory)) { mkdir($directory, 0755); }
            if (! write_file($directory . 'file.php', 'Some file data')) { echo 'Unable to write the file'; } else { echo 'File written!'; }
            Рекурсивно копирует файлы и каталоги исходного каталога в целевой каталог
            try {
                directory_mirror($directory, WRITEPATH . 'uploads'); // поведение перезаписи с помощью третьего параметра
            } catch (\Throwable $e) {
                echo 'Failed to export uploads!';
            }
            delete_files($directory, true, false, 1); // delete all files/folders
            rmdir($directory);                        // delete folder
            */

            // Новое имя загруженному файлу
            $randomName = $file->getRandomName();

            // Заполняем возвращаемый массив
            array_push($saveFiles, [
                'id' => '1',
                'name' => $randomName,
                'path' =>  $file->getClientName(), // исходное имя загруженного файла, отправленное клиентом, даже если файл был перемещен
                'type' =>  $file->getMimeType(),
            ]);

            // 
            // Создание превью миниатюр изображений (до перемещения файла)
            // 
            if ($this->thumbs_bool == true) {
                $image = \Config\Services::image(); // https://codeigniter.com/user_guide/libraries/images.html
                try {
                    $image->withFile($file)
                        ->resize($this->w_thumb, $this->h_thumb, true, 'height')
                        ->save(FCPATH . $this->thumbsDir . '/' . $randomName, 10);
                } catch (ImageException $e) {
                    throw new ImageException($e->getMessage());
                }
            }

            // 
            // Перемещаем загруженный файл в новое место. https://codeigniter.com/user_guide/libraries/files.html#moving-files
            //          
            try {
                $file->move(FCPATH . $this->imagesDir, $randomName, true); // , true - Перезапись существующего файла

                // $file->store(FCPATH . $this->imagesDir, $randomName);
                // $uploaded_fileinfo => new File(WRITEPATH . 'uploads/' . $file->store())]); // будет создана папка ГГГГММДД и случайное имя файла
            } catch (HTTPException $e) {
                // Перемещение загруженного файла может завершиться неудачей из-за HTTPException в нескольких случаях:
                //   -  файл уже перемещен
                //   -  файл не был успешно загружен
                //   -  операция перемещения файла завершается сбоем (например, неправильные разрешения)
                $data = ['errors' => $e->getMessage()];
                return view($this->upload_form, $data);
            }
        }

        // session()->setFlashdata('success', 'Success! image uploaded.');
        $data = [
            'files' => $saveFiles,
            'thumbsDir' => $this->thumbsDir,
            'success' => 'Фотографии загружены! All Files Uploaded Successfully<p>Try it again!</p><h3>Your form was successfully submitted!</h3>'
        ];

        $saveFiles = []; // очищаем названия сохраненных файлов

        if (!is_file(APPPATH . 'Views/' . $this->success_upload . '.php')) {
            throw new PageNotFoundException($this->success_upload);
        }

        // return redirect()->to(site_url($this->upload_uri))->withInput()->with('previewImage', $filePreviewName);
        // return redirect()->back()->with('success', $filesUploaded . ' File/s uploaded successfully.'); ?
        return view($this->success_upload, $data);
    }

    public function edit($id = null)
    {
        $data['user'] = $this->imageModel->where('id', $id)->first();
        return view('admin/image/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $data = [
            'name' => $this->request->getVar('name'),
            'email'  => $this->request->getVar('email'),
        ];
        $save = $this->imageModel->update($id, $data);
        return redirect()->to(base_url('public/index.php/users'));
    }

    public function delete($id = null)
    {
        $this->imageModel->where('id', $id)->delete();
        // $data['user'] = $this->imageModel->where('id', $id)->delete();
        // return redirect()->to( base_url('public/index.php/users') );
        return redirect()->back()->with('success', $id . ' File/s deleted successfully.');
    }


    // https://stackoverflow.com/questions/73558358/how-to-display-uploaded-file-from-writable-uploads-in-codeigniter-4
    public function showFile()
    {
        helper("filesystem");
        $path = WRITEPATH . 'uploads/';
        $filename = 'logo-at.png';

        $fullpath = $path . $filename;
        $file = new \CodeIgniter\Files\File($fullpath, true);
        $binary = readfile($fullpath);
        return $this->response
            ->setHeader('Content-Type', $file->getMimeType())
            ->setHeader('Content-disposition', 'inline; filename="' . $file->getBasename() . '"')
            ->setStatusCode(200)
            ->setBody($binary);
    }
}
