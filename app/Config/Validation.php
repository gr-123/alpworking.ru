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
    
    public array $signup = [
        'username'     => 'required|max_length[30]',
        // 'password'     => 'required|max_length[255]',
        // 'pass_confirm' => 'required|max_length[255]|matches[password]',
        // 'email'        => 'required|max_length[254]|valid_email',
    ];

    public array $signup_errors = [
        'username' => [
            'required' => 'You must choose a username.',
        ],
        // 'email' => [
        //     'valid_email' => 'Please check the Email field. It does not appear to be valid.',
        // ],
    ];

    // public array $signup = [
    //     'username' => [
    //         'rules'  => 'required|max_length[30]',
    //         'errors' => [
    //             'required' => 'You must choose a Username.',
    //         ],
    //     ],
    //     'email' => [
    //         'rules'  => 'required|max_length[254]|valid_email',
    //         'errors' => [
    //             'valid_email' => 'Please check the Email field. It does not appear to be valid.',
    //         ],
    //     ],
    // ];
}
