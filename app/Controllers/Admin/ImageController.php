<?php

namespace App\Controllers\Admin;

use CodeIgniter\Images\Exceptions\ImageException;
use App\Controllers\BaseController;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Files\UploadedFile;
use App\Models\Image;
use Throwable;

class ImageController extends BaseController
{
    private $upload_form = "admin/dashboard/upload";                                     // каталог шаблона    для загрузки
    private $upload_uri = "admin/image/upload";                                          // uri                для загрузки
    private $upload_folder = WRITEPATH . "uploads";  //file_location                                                 // каталог загрузки
    // превью изображений
    private $thumbs = FCPATH . "images/thumbnails"; // каталог
    private $w_thumb = 240; // ширина
    private $h_thumb = 180; // высота
    
    private $imageModel;

    // Вы можете определить массив вспомогательных файлов как свойство класса. 
    // Всякий раз при загрузке контроллера эти вспомогательные файлы будут автоматически 
    // загружаться в память, так что вы сможете использовать их методы в любом месте внутри контроллера:
    protected $helpers = ['url', 'form'];
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->imageModel = new Image;
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
        // $session->close();
        // точно так же, как функция PHP session_write_close()
        // очистить текущий сеанс (например, при выходе из системы)
        // $session->destroy();
        // точно так же, как функция PHP session_destroy()
        // Это должна быть последняя операция, связанная с сеансом, которую вы выполняете во время того же запроса. Все данные сеанса (включая флэш-данные и временные данные) будут безвозвратно уничтожены.
        //   Примечание
        //   Вам не обязательно вызывать этот метод из обычного кода. Очистите данные сеанса, а не уничтожайте его.
        // Удаление данных сеанса
        // unset($_SESSION['some_name']); // or multiple values: unset($_SESSION['some_name'],$_SESSION['another_name']);
        // или
        // $session->remove('some_name'); // или массив ключей: $array_items = ['username', 'email']; $session->remove($array_items);

		$data = [
			'pageTitle' => "Upload - Загрузка нескольких файлов",
            // 'all_images' => $this->imageModel->orderBy('created_at', 'asc')->findAll(),
            'errors' => []
		];

		return view($this->upload_form, $data);
    }
    
    /**
     * Upload Image
     *
     * @return void
     */
    public function uploadImage()
    {
        // Учебное пособие по проверке формы: https://codeigniter.com/user_guide/libraries/validation.html#form-validation-tutorial

        // В предыдущих версиях вам нужно было использовать if (strtolower($this->request->getMethod()) !== 'post')
        if (! $this->request->is('post')) { // начиная с версии 4.3.0
            return view($this->upload_form);
        }

        // Важный
        // Традиционные правила существуют только для обратной совместимости. CodeIgniter\Validation
        // Не используйте их в новых проектах. Даже если вы уже их используете, мы 
        // рекомендуем перейти на Строгие правила. CodeIgniter\Validation\StrictRules

/*
 * The data to test:
 * ['contacts' => [
 *         'name' => 'Joe Smith',
 *         'friends' => [
 *             [
 *                 'name' => 'Fred Flinstone',
 *             ],
 *             [
 *                 'name' => 'Wilma',
 *             ],]]]
 */
// Joe Smith
// $validation->setRules([
//     'contacts.name' => 'required|max_length[60]',
// ]);
// Вы можете использовать *подстановочный знак для соответствия любому уровню массива:
// // Fred Flintsone & Wilma
// $validation->setRules([
//     'contacts.friends.*.name' => 'required|max_length[60]',
// ]);

        // Сохранение наборов правил проверки в файле конфигурации
        // https://codeigniter.com/user_guide/libraries/validation.html#saving-sets-of-validation-rules-to-the-config-file

        $rules = [
            'username' => 'required|max_length[30]|min_length[1]',
        ];

        $data = $this->request->getPost(array_keys($rules));
        // $data = $this->request->getPost(['title', 'body']);

        if (! $this->validateData($data, $rules)) { // validateData():
            // false - по умолчанию возвращает false (логическое значение false)
            // true -  только в том случае, если ваши правила были успешно применены и ни одно из них не привело к сбою

            return view($this->upload_form, [
                'errors' => $this->validator->getErrors(),
            ]);
        }

        // найти для validateData
        // 
        // class Validation extends BaseConfig 
        // public array $signup = [...
        // Вы можете указать группу, которая будет использоваться при вызове run()метода:
        // $validation->run($data, 'signup');
        // if ($validation->run($data)) {
        //     $validatedData = $validation->getValidated();
        //     // $validatedData = [
        //     //     'username' => 'john',
        //     //     'password' => 'BPi-$Swu7U5lm$dX',
        //     // ];
        // }
        // все сообщения об ошибках для полей с ошибками
        // $errors = $validation->getErrors();


        // getValidated() можно использовать начиная с версии 4.4.0.
        // Этот метод возвращает массив только из тех элементов, которые были проверены правилами проверки.
        $validData = $this->validator->getValidated(); // Фактически проверенные данные
        // Получает проверенные данные.
        // $post = $this->validator->getValidated();
        // $model = model(NewsModel::class);
        // $model->save([
        //     'title' => $post['title'],
        //     'slug'  => url_title($post['title'], '-', true),
        //     'body'  => $post['body'],
        // ]);


		$data = [
            'errors' => []
		];
        // <p>Try it again!</p>
        // <h3>Your form was successfully submitted!</h3>
        return view($this->upload_form, $data);




        // $_FILES У этого массива есть некоторые серьезные недостатки при работе с несколькими файлами, загруженными 
        // одновременно, а также потенциальные недостатки безопасности, о которых многие разработчики не знают. CodeIgniter 
        // помогает в обеих этих ситуациях, стандартизируя использование файлов с помощью общего интерфейса.

        // getFiles() вернет массив файлов, представленный экземплярами CodeIgniter\HTTP\Files\UploadedFile

        // <input type="file" name="my-form[details][avatar]">
        // ['my-form' => ['details' => ['avatar' => // UploadedFile instance],],] // возвращаемый массив файлов
        // $file = $this->request->getFile('my-form.details.avatar'); // получить экземпляр файла:

        // В некоторых случаях вы можете указать массив файлов для загрузки:
        // Upload an avatar: <input type="file" name="my-form[details][avatars][]">
        // Upload an avatar: <input type="file" name="my-form[details][avatars][]">        
        // ['my-form' => ['details' => ['avatar' => [0 => // UploadedFile instance, 1 => // UploadedFile instance, ],],],] // возвращаемый массив файлов

        // Возможно, вам будет проще использовать getFileMultiple(), чтобы получить массив загруженных файлов с одинаковым именем:
        // $files = $this->request->getFileMultiple('images');

        // Примечание
        // Использование getFiles() более целесообразно.



// <input type="file" name="images[]" multiple>
if ($imagefile = $this->request->getFiles()) {

    // if (isset($_FILES[$field])) { echo '<pre>';print_r($_FILES);echo '</pre>'; }
    // $number_of_files = sizeof($_FILES['images']['tmp_name']);// количество загруженных изображений;

//     foreach ($imagefile['images'] as $img) {
//         if ($img->isValid() && ! $img->hasMoved()) {
//             $newName = $img->getRandomName();
//             $img->move(WRITEPATH . 'uploads', $newName);
//         }
//     }
}


// try {
//     //
// } catch (Throwable $e) {
//     $e->getMessage();
//     return;
// }

// if (! $file->isValid()) {
//     throw new RuntimeException($file->getErrorString().'('.$file->getError().')');
// }
// <input type="file" name="multiple_files[]" id="multiple_files" readonly="true" multiple/>
// <input type="submit" name="files_upload" value="Upload Files"/>
// if($this->request->getPost('files_upload')) {
//     if($files = $this->request->getFileMultiple('multiple_files'))	{
//         $errors = array();
//         foreach($files as $file) {
//           if ($file->isValid() && ! $file->hasMoved()) {
//                $newName = $file->getRandomName();
//                $file->move(WRITEPATH . 'uploads', $newName);
//           } else {
//               array_push($errors, $file->getErrorString() . '(' . $file->getError() . ')');
//           }
//         }
        
//         if(empty($errors)) {
//             echo view('files_upload', ['success' => 'All Files Uploaded Successfully']);
//         } else {
//             echo view('files_upload', ['errors' => $errors]);
//         }
//     } else {
//         echo view('files_upload', ['error' => 'Select at least one file for upload']);
//     }
// } else {
//     echo view('files_upload');
// }

// echo 'My files: ' . implode(PHP_EOL, $files->get());//use CodeIgniter\Files\FileCollection;
// echo 'I have ' . count($files) . ' files!';


// Получив экземпляр UploadedFile, вы можете получить информацию о файле безопасными способами, а также переместить файл в новое место.
// Проверка файла
// Проверить, что файл действительно был загружен по HTTP без ошибок, можно, вызвав метод isValid():
// if (! $file->isValid()) {
//     throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
// }

// $name = $file->getName();               // исходное имя файла, предоставленное клиентом
// $originalName = $file->getClientName(); // исходное имя загруженного файла, отправленное клиентом, даже если файл был перемещен
// $tempfile = $file->getTempName();       // полный путь к временному файлу, созданному во время загрузки
// $ext = $file->getClientExtension();     // исходное расширение файла на основе имени загруженного файла
                                            // Предупреждение
                                            // Это НЕ надежный источник. Вместо этого используйте надежную версию guessExtension().
// $type = $file->getClientMimeType();     // MIME-тип файла, предоставленный клиентом. Это НЕ доверенное значение. Вместо этого используйте getMimeType()
// $clientPath = $file->getClientPath();   // относительный путь к загруженному файлу, когда клиент загрузил файлы через загрузку каталога.

// $newName = $file->getRandomName();
// $file->move(WRITEPATH . 'uploads', $newName); // с новым именем файла
// $file->move(WRITEPATH . 'uploads', null, true); // перезаписать существующий файл

// После удаления файла временный файл удаляется
// проверить, был ли файл уже перемещен с помощью hasMoved()
// if ($file->isValid() && ! $file->hasMoved()) {
//     $file->move($path);
// }

// Store Files
// Каждый файл можно переместить в новое место с помощью store()метода
// По умолчанию файлы загрузки сохраняются в каталоге, доступном для записи/загрузках. Будет создана папка ГГГГММДД и случайное имя файла. Возвращает путь к файлу:
// <input type="file" name="userfile">
// $path = $this->request->getFile('userfile')->store();
// Вы можете указать каталог для перемещения файла в качестве первого параметра. Новое имя файла, передав его в качестве второго параметра:
// $path = $this->request->getFile('userfile')->store('head_img/', 'user_name.jpg');
// Перемещение загруженного файла может завершиться неудачей HTTPException



// Правила загрузки файлов
// При проверке загруженных файлов необходимо использовать правила, специально созданные для проверки файлов.
// Для проверки файлов можно использовать только правила, перечисленные в таблице ниже.
// Поскольку значение HTML-поля для загрузки файла не существует и хранится в глобальном 
// масштабе $_FILES, имя поля ввода необходимо будет использовать дважды. Один раз, чтобы 
// указать имя поля, как и для любого другого правила, но снова в качестве первого 
// параметра всех правил, связанных с загрузкой файлов:
// https://codeigniter.com/user_guide/libraries/validation.html#rules-for-file-uploads

// <input type="file" name="userfile" size="20">
$validationRule = [
    'userfile' => [
        'label' => 'Image File',
        'rules' => [
            'uploaded[userfile]',
            'max_size[userfile,2048]',
            'max_dims[userfile,1024,768]',
            'mime_in[userfile,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
            // ext_in[userfile,jpg,jpeg,png,gif,webp]
            'is_image[userfile]',
        ],
    ],
];
if (! $this->validate($validationRule)) {
    $data = ['errors' => $this->validator->getErrors()];
    return view($this->upload_form, $data);
}
$img = $this->request->getFile('userfile');
if (! $img->hasMoved()) {
    // Каталог загрузки
    // Загруженные файлы хранятся в каталоге writable/uploads/
    $filepath = WRITEPATH . 'uploads/' . $img->store();
    $data = ['uploaded_fileinfo' => new File($filepath)];
    return view('admin/upload/upload_success', $data);
}
$data = ['errors' => 'The file has already been moved.'];
return view($this->upload_form, $data);


// Примечание
// Проверка также может выполняться автоматически в модели, но иногда ее проще сделать в контроллере. Где решать вам.

// Setting Validation Rules
// https://www.codeigniter.org/user_guide/models/model.html#setting-validation-rules

        // fileimages validation
        // ext_in[file,jpg,jpeg,docx,pdf] ?
        
        // 'max_height' => "768", // 'max_width' => "1024" //min_width,min_height
        $validated = $this->validate([ 

            //Важный
            // Этот метод существует только для обратной совместимости. Не используйте его в новых проектах. Даже если вы уже используете его, мы рекомендуем вам использовать этот validateData()метод.

            'fileimages' => [
                'uploaded[fileimages]',
                'mime_in[fileimages,image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[fileimages,4096]',
                'errors' => [
                    'uploaded[fileimages]' => 'Please select an fileimages.'
                ]
            ],
        ]);
        // Новое в версии 4.2.0. https://codeigniter.com/user_guide/incoming/controllers.html#this-validatedata
        // $this->validateData()
        // только для проверки данных POST 
        //
        // Метод принимает (1) массив данных для проверки, (2) массив правил, (3) необязательный массив пользовательских сообщений об ошибках для отображения, если элементы недействительны, (4) необязательную группу базы данных для использования.
        // Документы библиотеки проверки https://codeigniter.com/user_guide/libraries/validation.html
        // содержат подробную информацию о форматах правил и массивов сообщений, а также доступных правилах:
        // $data = [
        //     'id'   => $id,
        //     'name' => $this->request->getPost('name'),
        // ];

        // $rule = [
        //     'id'   => 'integer',
        //     'name' => 'required|max_length[255]',
        // ];

        // if (! $this->validateData($data, $rule)) {
        //     return view('store/product', [
        //         'errors' => $this->validator->getErrors(),
        //     ]);
        // }

        // ...

        // Предупреждение
        // Вместо validate()используйте validateData()

        // if (! $this->validate([
        //     'email' => "required|is_unique[users.email,id,{$userID}]",
        //     'name'  => 'required|alpha_numeric_spaces',
        // ])) {
        //     // The validation failed.
        //     return view('users/update', [
        //         'errors' => $this->validator->getErrors(),
        //     ]);
        // }

        // // The validation was successful.

        // // Get the validated data.
        // $validData = $this->validator->getValidated(); // Примечание
        // Метод $this->validator->getValidated() можно использовать начиная с версии 4.4.0.
        // https://codeigniter.com/user_guide/libraries/validation.html#validation-getting-validated-data

        // // ...

        $session = \Config\Services::session();

        if (!$validated) {
            return view($this->upload_form, [
                'validation' => $this->validator
            ]);
        }

        // Имена файлов из формы HTML
        $files = $this->request->getFileMultiple('fileimages');

        $filePreviewName = [];

        foreach($files as $file) {
            if($file->isValid() && !$file->hasMoved()) {

                // https://codeigniter4.github.io/userguide/helpers/filesystem_helper.html
                // 
                // get_file_info//name, size, date, readable, writeable, executable and fileperms.
                // symbolic_permissions  // -rw-r--r--
                // octal_permissions // 644

                // SplFileInfo:
                // echo $file->getBasename();
                // echo $file->getMTime();                // Get last modified time
                // echo $file->getRealPath();
                // echo $file->getPerms();                // Get the file permissions
                // $newName = $file->getRandomName();     // Generates something like: 1465965676_385e33f741.jpg
                // $size = $file->getSize(); // 256901
                // $bytes     = $file->getSizeByUnit(); // 256901
                // $kilobytes = $file->getSizeByUnit('kb'); // 250.880
                // $megabytes = $file->getSizeByUnit('mb'); // 0.245
                // echo $file->getMimeType(); // image/png
                // echo $file->guessExtension(); // Returns 'jpg' (WITHOUT the period)


                // $name = $file->getName(); ?
                // $ext = $file->getClientExtension(); ?

                $newName = $file->getRandomName();

                // CodeIgniter’s Image Manipulation class
                // https://codeigniter.com/user_guide/libraries/images.html
                // 
                $image = \Config\Services::image(); // инициализируется в вашем контроллере путем вызова класса Services
                try {
                    $image->withFile($file)
                        ->resize($this->w_thumb, $this->h_thumb, true, 'height')
                        ->save($this->thumbs . '/' . '_' . $newName, 10);
                        // Методы обработки возвращают экземпляр класса
                        // В случае неудачи они выдадут сообщение CodeIgniter\Images\ImageException, содержащее сообщение об ошибке
                } catch (ImageException $e) {
                    echo $e->getMessage();
                }                

// $files = new FileCollection//use CodeIgniter\Files\FileCollection;
// echo 'Moving ' . $file->getBasename() . ', ' . $file->getSizeByUnit('mb');

                $file->move($this->upload_folder, $newName);

                // log_message("info", $newName . " saved to public upload folder");

                // https://codeigniter.com/user_guide/libraries/files.html#moving-files
                // Метод move() возвращает новый экземпляр File для перемещенного файла, поэтому вам 
                // необходимо зафиксировать результат, если полученное местоположение необходимо:
                // $file = $file->move(WRITEPATH . 'uploads');

                $data = [
                    'imagename' =>  $newName,
                    // 'filename' => $file->getClientName(),
                    //     'filepath' => 'uploads/' . $newName,
                    //     'type' => $file->getClientExtension()
					// 'type'  => $file->getClientMimeType(),
					// 'path' => 'uploads/' . $file->getClientName()
// type varchar(255) NOT NULL COMMENT 'file type',
//  `type` varchar(10) NOT NULL,
//  `path` varchar(120) DEFAULT NULL,
                ];

                $result = $this->imageModel->save($data);
                if (!$result) {
                    
        // $newdata = ['username' => 'johndoe', 'email' => 'johndoe@some-site.com', 'logged_in' => true,];
        // $session->set($newdata); // или по одному значению за раз: $session->set('some_name', 'some_value');
        // $session->push('hobbies', ['sport' => 'tennis']); // добавить в массив новое значение

        // Flashdata: 
        // доступны только для следующего запроса, а затем автоматически удаляются
        // метод getFlashdata(): если вы хотите быть уверены, что читаете «флэш-данные» (а не какие-либо другие)
        // $session->getFlashdata('item'); // null, если элемент не найден
        // $session->getFlashdata(); // массив со всеми флэш-данными

                    $session->setFlashdata('failed', 'Failed! image not uploaded.');
                    // https://codeigniter.com/user_guide/outgoing/response.html
                    return redirect()->to(site_url($this->upload_uri))->withInput()->with('previewImage', $newName);
                    // return redirect()->back()->with('error', 'Choose files to upload.'); ?


                    // PHP ничего не разделяет между запросами. Поэтому при перенаправлении в случае сбоя проверки в перенаправленном запросе не будет ошибок проверки, поскольку проверка выполнялась в предыдущем запросе.
                    // В этом случае вам нужно использовать вспомогательную функцию формы validation_errors()и validation_list_errors(). validation_show_error()Эти функции проверяют ошибки проверки, хранящиеся в сеансе.
                    // Чтобы сохранить ошибки проверки в сеансе, вам необходимо использовать withInput() with redirect():
                    // // In Controller.
                    // if (! $this->validateData($data, $rules)) {
                    //     return redirect()->back()->withInput();
                    // }


                    // if ($is_file_error) { if ($file_data) {
                    //         $file = './upload/' . $file_data['file_name'];
                    //         if (file_exists($file)) {unlink($file);}
                    //         $thumb = $thumb_path . $file_data['file_name'];
                    //         if ($thumb) {unlink($thumb);}
                    //         ...
                }

                // $session->setFlashdata('message', 'Uploaded successfully one file image!');// 'filename', $file->getName());'extension', $file->getClientExtension());
                array_push($filePreviewName, $newName);
            }           
        }

        $session->setFlashdata('success', 'Success! image uploaded.');
        
        return redirect()->to(site_url($this->upload_uri))->withInput()->with('previewImage', $filePreviewName);
        // return redirect()->back()->with('success', $filesUploaded . ' File/s uploaded successfully.'); ?
    }
}