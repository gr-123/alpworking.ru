<?php

namespace App\Controllers\Admin;

use Throwable;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Images\Exceptions\ImageException;

use App\Controllers\BaseController;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Files\UploadedFile;
use App\Models\Image;



// 2015 Simple Image Gallery CRUD with CodeIgniter 3 https://the-amazing-php.blogspot.com/2015/05/codeigniter-image-gallery-crud.html
// ResourcePresenter   https://codeigniter.com/user_guide/incoming/restful.html#resourcepresenter
// Using CodeIgniter’s Model   https://codeigniter.com/user_guide/models/model.html
// return redirect()->to('admin/home'); // URI (относительно baseURL)   https://codeigniter.com/user_guide/outgoing/response.html#redirect
// return redirect()->route('user_gallery'); // Go to a named route. "user_gallery" is the route name, not a URI path. ( обратная маршрутизация )
// return redirect()->back()->withInput();// Keep the old input values upon redirect so they can be used by the `old()` function.
// return redirect()->back()->with('foo', 'message');// Set a flash message.
// return redirect()->to('admin/home', 301);// Redirect to a URI path relative to baseURL with status code 301.
// return redirect()->route('user_gallery', [], 308);// Redirect to a route with status code 308.
// return redirect()->back(302);// Redirect back with status code 302.
// 303 используется для запросов POST/PUT/DELETE, а 307 — для всех остальных запросов. «Перенаправления в HTTP»: https://developer.mozilla.org/en-US/docs/Web/HTTP/Redirections



                    // use CodeIgniter\Files\File;
                    // use CodeIgniter\Images\Exceptions\ImageException;
                    // class Image extends File
                        // /**
                        //  * Makes a copy of itself to the new location. If no filename is provided
                        //  * it will use the existing filename.
                        //  *
                        //  * @param string      $targetPath The directory to store the file in
                        //  * @param string|null $targetName The new name of the copied file.
                        //  * @param int         $perms      File permissions to be applied after copy.
                        //  */
                        // public function copy(string $targetPath, ?string $targetName = null, int $perms = 0644): bool
                        // {
                        //     $targetPath = rtrim($targetPath, '/ ') . '/';

                        //     $targetName ??= $this->getFilename();

                        //     if (empty($targetName)) {
                        //         throw ImageException::forInvalidFile($targetName);
                        //     }

                        //     if (! is_dir($targetPath)) {
                        //         mkdir($targetPath, 0755, true);
                        //     }

                        //     if (! copy($this->getPathname(), "{$targetPath}{$targetName}")) {
                        //         throw ImageException::forCopyError($targetPath);
                        //     }

                        //     chmod("{$targetPath}/{$targetName}", $perms);

                        //     return true;
                        // }
                        
                        // \alpfreelance - swarm\app\application\upload\FileController.php
                        // C:\Users\n1\OneDrive\PHP\CI\5. Images upload.s

class ImageController extends BaseController
{
    private $upload_form = "admin/upload/upload_form";       // шаблон <filename>.php
    private $success_upload = "admin/upload/success_upload";       // шаблон успешной загрузки файлов
    private $large = "assets/images/";     // каталог загрузки изображений
    // превью изображений
    private $thumbs = "assets/images/thumbnails/"; // каталог превью
    private $w_thumb = 240;                                // ширина
    private $h_thumb = 180;                                // высота
    
    private $imageModel;                                   // Image Model

    // Вы можете определить массив вспомогательных файлов как свойство класса. 
    // Всякий раз при загрузке контроллера эти вспомогательные файлы будут автоматически 
    // загружаться в память, так что вы сможете использовать их методы в любом месте внутри контроллера:
    protected $helpers = ['url', 'form'];
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // разделе «Использование модели CodeIgniter»
        // https://codeigniter.com/user_guide/models/model.html

        $this->imageModel = new Image;
        // Вы можете получить правила проверки модели, обратившись к ее validationRules свойству:
        // $rules = $model->validationRules;
        // // Вы также можете получить только подмножество этих правил
        // // get the rules for all but the "username" field
        // $rules = $model->getValidationRules(['except' => ['username']]);
        // // get the rules for only the "city" and "state" fields
        // $rules = $model->getValidationRules(['only' => ['city', 'state']]);
    }

    /**
     * Return image upload view
     *
     * @return void
     */
    public function index()
    {
        // $data = array();          
        // if($this->session->userdata('success_msg')){ $data['success_msg'] = $this->session->userdata('success_msg'); $this->session->unset_userdata('success_msg'); } 
        // if($this->session->userdata('error_msg')){ $data['error_msg'] = $this->session->userdata('error_msg'); $this->session->unset_userdata('error_msg'); }
        // 
        // закрыть текущий сеанс вручную после того, как он вам больше не понадобится
        // session()->close();
        // точно так же, как функция PHP session_write_close()
        // очистить текущий сеанс (например, при выходе из системы)
        // session()->destroy();
        // точно так же, как функция PHP session_destroy()
        // Это должна быть последняя операция, связанная с сеансом, которую вы выполняете во время того же запроса. Все данные сеанса (включая флэш-данные и временные данные) будут безвозвратно уничтожены.
        //   Примечание
        //   Вам не обязательно вызывать этот метод из обычного кода. Очистите данные сеанса, а не уничтожайте его.
        // Удаление данных сеанса
        // unset($_SESSION['some_name']); // or multiple values: unset($_SESSION['some_name'],$_SESSION['another_name']);
        // или
        // session()->remove('some_name'); // или массив ключей: $array_items = ['username', 'email']; session()->remove($array_items);
        
        // Краткое руководство по базе данных
        // --------------------------------------------------------------------
        // https://codeigniter.com/user_guide/database/examples.html
        // $query = $db->query('SELECT * FROM my_table');//$db = \Config\Database::connect();
        // $query = $this->imageModel->query('SELECT * FROM my_table');

        // https://codeigniter.com/user_guide/outgoing/table.html
        // $table = new \CodeIgniter\View\Table($template);
        // echo $table->generate($query);

		$data = [
			'pageTitle' => "Upload - Загрузка нескольких файлов",
            // 'images' => $this->imageModel->orderBy('created_at', 'asc')->findAll(),
            // 'images' => $this->imageModel->orderBy('id', 'DESC')->findAll(),
            'errors' => []
		];

        if (! is_file(APPPATH . 'Views/' . $this->upload_form . '.php')) {
        // if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            throw new PageNotFoundException($this->upload_form);
        }

		return view($this->upload_form, $data);
        // return view('blog_view', $data, ['saveData' => false]); // чтобы функция view() по умолчанию очищала данные между вызовами
    }
    
    /**
     * Upload Image
     *
     * @return void
     */
    public function uploadImage()
    {
        // echo '<pre>';print_r($this->request->getPost());echo '</pre>';
        // echo '<pre>';print_r($this->request->getFileMultiple('images'));echo '</pre>';
        // echo '<pre>';print_r($this->request->getFiles());echo '</pre>';
        // echo '<pre>';print_r($this->request->getFile('images.0'));echo '</pre>'; //  <input type="file" name="images[]">

        // --------------------------------------------------------------------

        // Проверяем необходимый тип запроса (post).
        // 
        // В предыдущих версиях вам нужно было использовать if (strtolower($this->request->getMethod()) !== 'post')
        if (! $this->request->is('post')) { // начиная с версии 4.3.0
            log_message("info", "Ошибка приема POST данных! Несанкционированный вход по GET-запросу.");
            return view($this->upload_form);
        }
        
        // Проверяем наличие поля 'name' в post-запросе.
        // 
        // form_button: type="submit" name="images_upload"
        // POST: array( [images_upload] => Upload Images )
        if(! $this->request->getPost('images_upload')) {
            log_message("info", "Ошибка приема POST данных! Нет необходимого значения.");
            return view($this->upload_form);
        }
        
        // Важный
        // Традиционные правила существуют только для обратной совместимости. CodeIgniter\Validation
        // Не используйте их в новых проектах. Даже если вы уже их используете, мы 
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
        
        // 
        // Валидация файлов в соответствии с правилами проверки группы 'imageupload' в файле конфигурации app/Config/Validation.php
        // 
        if (! $this->validateData([], 'imageupload')) { // true -  только в том случае, если ваши правила были успешно применены и ни одно из них не привело к сбою
            $data = ['errors' => $this->validator->getErrors()];// Получение всех ошибок. Если ошибок нет, будет возвращен пустой массив.
            return view($this->upload_form, $data);
            // PHP ничего не разделяет между запросами. Поэтому при перенаправлении в случае сбоя проверки в перенаправленном запросе не будет ошибок проверки, поскольку проверка выполнялась в предыдущем запросе.
            // В этом случае вам нужно использовать вспомогательную функцию формы validation_errors()и validation_list_errors(). validation_show_error()Эти функции проверяют ошибки проверки, хранящиеся в сеансе.
            // Чтобы сохранить ошибки проверки в сеансе, вам необходимо использовать withInput() with redirect(): if (! $this->validateData($data, $rules)) { return redirect()->back()->withInput(); }
            // return redirect()->back()->withInput();
        }

        // 
        // Сохраняем все загруженные файлы в массив:
        // 
        // getFiles():
        //  - Возвращает массив всех файлов, загруженных по этому запросу. Каждый файл представлен экземпляром UploadedFile.
        //  - <input type="file" name="images[]" multiple="multiple">
        if (! $files = $this->request->getFiles()) { 
            return view($this->upload_form, ['errors' => 'Select at least one file for upload']);
        }
        
        // для имен файлов, сохраненных в каталоге загрузки 
        $save_images = array();
        // $save_images = array(
        //     'id' => [],
        //     'name' => [],
        // );

        foreach ($files['images'] as $file) { // echo '<pre>';print_r($files['images']);echo '</pre>';
            
            // Получив экземпляр UploadedFile, вы можете получить информацию о файле безопасными способами, а также переместить файл в новое место.
            // Проверка файла
            // Проверить, что файл действительно был загружен по HTTP без ошибок, можно, вызвав метод isValid():
            if (! $file->isValid()) {
                throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
            }
            
            // Здесь непонятно: После удаления файла временный файл удаляется. Вы можете проверить, был ли уже перемещен файл, с помощью метода hasMoved(), который 
            // возвращает логическое значение:
            if ($file->hasMoved()) { 
                return view($this->upload_form, ['errors' => "Ошибка. Данный файл '$file' уже был перемещен." . $file->getErrorString() . '(' . $file->getError() . ')']);
            }

            // https://codeigniter4.github.io/userguide/helpers/filesystem_helper.html
            // 
            // get_file_info                            // name, size, date, readable, writeable, executable and fileperms.
            // symbolic_permissions                     // -rw-r--r--
            // octal_permissions                        // 644

            // SplFileInfo:
            // echo $file->getBasename();
            // echo $file->getRealPath();
            // echo $file->getMTime();                  // Get last modified time
            // echo $file->getPerms();                  // Get the file permissions
            // echo $file->getMimeType();               // image/png
            // echo $file->guessExtension();            // Returns 'jpg' (WITHOUT the period)
            // $newName   = $file->getRandomName();     // Generates something like: 1465965676_385e33f741.jpg
            // $size      = $file->getSize();           // 256901
            // $bytes     = $file->getSizeByUnit();     // 256901
            // $kilobytes = $file->getSizeByUnit('kb'); // 250.880
            // $megabytes = $file->getSizeByUnit('mb'); // 0.245

            // $name         = $file->getName();            // исходное имя файла, предоставленное клиентом
            // $originalName = $file->getClientName();      // исходное имя загруженного файла, отправленное клиентом, даже если файл был перемещен
            // $tempfile     = $file->getTempName();        // полный путь к временному файлу, созданному во время загрузки
            // $ext          = $file->getClientExtension(); // исходное расширение файла на основе имени загруженного файла
                                                            // Предупреждение
                                                            // Это НЕ надежный источник. Вместо этого используйте надежную версию guessExtension().
            // $type         = $file->getClientMimeType();  // MIME-тип файла, предоставленный клиентом. Это НЕ доверенное значение. Вместо этого используйте getMimeType()
            // $clientPath   = $file->getClientPath();      // относительный путь к загруженному файлу, когда клиент загрузил файлы через загрузку каталога.
            
            $newName = $file->getRandomName();
            $filePath = $file->getClientPath();
            $fileType = $file->getMimeType();
            
            // https://codeigniter.com/user_guide/libraries/images.html
            $image = \Config\Services::image();
            try {
                // Методы обработки возвращают экземпляр класса
                $image->withFile($file)
                    ->resize($this->w_thumb, $this->h_thumb, true, 'height')
                    ->save(FCPATH . $this->thumbs . $newName, 10);
                    // ->save($uploadedImages . $newName, 10);
            } catch (ImageException $e) {// CodeIgniter\Images\ImageException
                echo "Image->resize():<br>" . $e->getMessage();

                // helper 'filesystem':
                // $directory = WRITEPATH . 'uploads/qwe/';
                // echo "<pre>";
                // print_r(directory_map(FCPATH . 'assets/images/', 0, true)); //карта каталога                 
                // echo octal_permissions(fileperms('assets/images')), symbolic_permissions(fileperms('assets/images')); // 750 drwxr-x---
                // echo set_realpath('./');  // /var/www/alpworking.ru/public/
                // print_r(get_filenames(WRITEPATH . 'uploads/'));            //массив, содержащий имена всех файлов
                // print_r(get_dir_file_info (WRITEPATH . 'uploads/', false));//массив, содержащий имена имена файлов, размер файла, даты и разрешения
                // print_r(get_file_info  (WRITEPATH . 'uploads/', false));   //атрибуты имени , пути , размера и даты изменения для файла

                // Созд.папку,затем удалить
                // if (!file_exists($directory)) { mkdir($directory, 0755); }
                // if (! write_file($directory . 'file.php', 'Some file data')) { echo 'Unable to write the file'; } else { echo 'File written!'; }
                // Рекурсивно копирует файлы и каталоги исходного каталога в целевой каталог
                // try {
                //     directory_mirror($directory, WRITEPATH . 'uploads'); // поведение перезаписи с помощью третьего параметра
                // } catch (\Throwable $e) {
                //     echo 'Failed to export uploads!';
                // }

                // delete_files($directory, true, false, 1); // delete all files/folders
                // rmdir($directory);                        // delete folder
            } 

            // 
            // Перемещаем файл в каталог загрузки:
            // 
            // $file->move($this->large, $newName, true); // true - перезаписать существующий файл            
            // https://codeigniter.com/user_guide/libraries/files.html#moving-files
            // Метод move() возвращает новый экземпляр File для перемещенного файла, поэтому вам 
            // необходимо зафиксировать результат, если полученное местоположение необходимо:
            try {
                $file = $file->move(FCPATH . $this->large, $newName, true); // true - перезаписать существующий файл
            } catch (Throwable $e) {
                $e->getMessage();
                return;
            }

            log_message("info", $newName . " saved (move) to public upload folder. \n" . $file . " saved \$file");

            // Возможно также перемещение файлов методом store():
            // Store Files
            // Каждый файл можно переместить в новое место с помощью store() метода
            // По умолчанию файлы загрузки сохраняются в каталоге , доступном для записи/загрузках . Будет создана папка ГГГГММДД и случайное имя файла . Возвращает путь к файлу:
            // <input type="file" name="userfile">
            // $path = $this->request->getFile('userfile')->store();
            // Вы можете указать каталог для перемещения файла в качестве первого параметра. Новое имя файла, передав его в качестве второго параметра:
            // $path = $this->request->getFile('userfile')->store('head_img/', 'user_name.jpg');
            // Перемещение загруженного файла может завершиться неудачей HTTPExceptionв следующих случаях:
            // - файл уже перемещен
            // - файл не был успешно загружен
            // - операция перемещения файла завершается сбоем (например, неправильные разрешения)

            // $filepath = WRITEPATH . 'uploads/' . $file->store();
            // $data = ['uploaded_fileinfo' => new File($filepath)];
            // return view('upload_success', $data);
            
            $data = [
                'name' =>  $newName,
                'path' =>  $filePath,
                'type' =>  $fileType,
            ];

            // 
            // Сохраняем данные файла в базе данных:
            // 
            $result = $this->imageModel->save($data);
            $inserted_id = $this->imageModel->getInsertID();
            
            if (!$result) {      
                session()->setFlashdata('errors', 'Errors! image not save.');
                // Перенаправляем обратно, сохраняя информацию об ошибках:
                return redirect()->back()->with('errors', 'tempmsg: Choose files to upload.');
                // https://codeigniter.com/user_guide/outgoing/response.html
                // return redirect()->to(site_url($this->upload_uri))->withInput()->with('previewImage', $newName);
                // return redirect()->to(site_url($this->upload_uri))->withInput();

                // todo:
                // if ($is_file_error) { if ($file_data) { $file = './upload/' . $file_data['file_name']; if (file_exists($file)) {
                    // unlink($file);} $thumb = $thumb_path . $file_data['file_name']; if ($thumb) {
                        // unlink($thumb);} ...
            }
            
            session()->setFlashdata('message', 'Uploaded successfully one file image!');
            log_message("info", $newName . " saved \$file in database.");
            
            // Сохраняем в ассоциативный массив для дальнейшего вывода превью при показе страницы
            array_push($save_images, ['id' => $inserted_id, 'name' => $newName]);
        }        

        session()->setFlashdata('success', 'Success! image uploaded.');
		$data = [
            'images' => $save_images,
            'thumbs' => $this->thumbs,
            'success' => "Фотографии загружены! All Files Uploaded Successfully<p>Try it again!</p><h3>Your form was successfully submitted!</h3>"
		];

        $save_images = []; // очищаем названия сохраненных файлов
        
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
        $save = $this->imageModel->update($id,$data);
        return redirect()->to( base_url('public/index.php/users') );
    }

    public function delete($id = null)
    {
        $this->imageModel->where('id', $id)->delete();
        // $data['user'] = $this->imageModel->where('id', $id)->delete();
        // return redirect()->to( base_url('public/index.php/users') );
        return redirect()->back()->with('success', $id . ' File/s deleted successfully.');
    }
}