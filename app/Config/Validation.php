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
    // Rules
    // --------------------------------------------------------------------

    // https://codeigniter.com/user_guide/libraries/validation.html#how-to-save-your-rules
    // Подробную информацию о форматировании массива см. в разделе «Настройка пользовательских сообщений об ошибках» .
    // https://codeigniter.com/user_guide/libraries/validation.html#validation-custom-errors
    
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
            'min_length' => 'Your password is too short. You want to get hacked?',
        ],
        'pass_confirm' => [
            'required' => '"pass_confirm" является обязательным - не заполнен.',
        ],
    ];

    // ------------------------------------------------------------------------
    // imageupload
    // ------------------------------------------------------------------------
    // Вы можете указать группу, которая будет использоваться при вызове run() метода:
    // $validation->run($data, 'imageupload');

    // 'imageupload' - группа правил
    public array $imageupload = [
        'images' => [
            'uploaded[images]',
            // 'max_size[images,2048]',
            // 'max_dims[images,1024,768]',
            'mime_in[images,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
            // ext_in[images,jpg,jpeg,png,gif,webp]
            'is_image[images]',
        ],
    ];

    // Сообщения ошибок проверки для правил группы - 'imageupload'
    public array $imageupload_errors = [
        'images' => [
            'max_dims' => '..превышение максимального "1024,768" размера загружаемого файла.',
        ],
    ];
    // ------------------------------------------------------------------------
}
