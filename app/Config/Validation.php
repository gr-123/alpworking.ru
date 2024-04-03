<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules - группы правил
    // --------------------------------------------------------------------

    // https://codeigniter.com/user_guide/libraries/validation.html#how-to-save-your-rules
    // Подробную информацию о форматировании массива см. в разделе «Настройка пользовательских сообщений об ошибках» .
    // https://codeigniter.com/user_guide/libraries/validation.html#validation-custom-errors
    
    // ------------------------------------------------------------------------
    // 'signup'
    // ------------------------------------------------------------------------
    public array $signup = [
        'username'     => 'required|max_length[30]',
        'email'        => 'required|max_length[254]|valid_email',
        'password'     => 'required|max_length[255]',
        'pass_confirm' => 'required|max_length[255]|matches[password]',
    ];

    // собственные сообщения об ошибках (По умолчанию сообщения об ошибках извлекаются из языковых строк в файле system/Language/en/Validation.php , где каждое правило имеет запись)
    // Они будут автоматически использоваться для любых ошибок при использовании этой группы
    public array $signup_errors = [
        'username' => [
            'required' => 'You must choose a username.',
        ],
        'email' => [
            'valid_email' => 'Please check the Email field. It does not appear to be valid.',
        ],
        'password' => [
            'required' => '"password" является обязательным - не заполнен.',
            // 'min_length' => 'Ваш пароль слишком короткий. Предоставленное значение ({value}) для {field} должно содержать не менее {param} символов.', // Предупреждение
            // Если вы получаете сообщения об ошибках с помощью getErrors()или getError(), сообщения не экранируются HTML. 
            // Если вы используете данные пользовательского ввода, например ({value}), для создания сообщения об ошибке, 
            // они могут содержать теги HTML. Если вы не экранируете сообщения перед их отображением, возможны XSS-атаки.

        ],
        'pass_confirm' => [
            'required' => '"pass_confirm" является обязательным - не заполнен.',
        ],
    ];
    // << 'signup'
    // ------------------------------------------------------------------------

    // ------------------------------------------------------------------------
    // 'imageupload'
    // ------------------------------------------------------------------------
    // $validation->run($data, 'imageupload');
    // 
    // Rules:
    public array $imageupload = [
        'images' => [
            'uploaded[images]',
            'is_image[images]',
            'mime_in[images,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
            'ext_in[images,jpg,jpeg,gif,png,webp]',
            // 'max_size[images,4096]', 
            // 'max_dims[images,1024,768]', 
            // 
            // max_size - Ошибка, если размер загруженного файла, указанного в параметре, превышает второй параметр в килобайтах (КБ). Или, если файл больше разрешенного максимального размера, указанного в upload_max_filesize директиве файла конфигурации php.ini.
            // max_dims - Ошибка, если максимальная ширина и высота загруженного изображения превышают указанные значения. Первый параметр — это имя поля. Второе — ширина, третье — высота. Также произойдет сбой, если файл не может быть определен как изображение.
        ],
    ];
    // 
    // Messages:
    public array $imageupload_errors = [ // Пользовательские сообщения ошибок проверки
        'images' => [
            'uploaded' => 'Необходимо выбрать файлы для загрузки.',
            'max_dims' => '..превышение максимального "1024,768" размера загружаемого файла.',
        ],
    ];
    // << 'imageupload'
    // ------------------------------------------------------------------------
}
