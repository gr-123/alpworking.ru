<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
	// https://onlinewebtutorblog.com/codeigniter-4-multi-auth-user-role-wise-login/
    // public function __construct()
    // {
    //     if (session()->get('role') != "admin") {
    //         echo 'Access denied';
    //         exit;
    //     }
    // }

    public function index()
    {
        // echo "AdminController<pre>";
        // echo \CodeIgniter\CodeIgniter::CI_VERSION;
        // echo "PHP is working!\n"; echo phpinfo();
        // auth_helper Помощник по аутентификации https://codeigniter4.github.io/shield/authentication/#auth-helper
        // echo auth()->user()->username; // namespace CodeIgniter\Shield\Entities; class User extends Entity
        // echo auth()->user()->getEmail(); // shield/src/Entities/User.php
        // echo auth()->user()->created_at->toDateTimeString();
        // 
        // print_r(['данные пользователя, вошедшего в систему:' => auth()->user()->toRawArray()]);

		$data['pageTitle']='Home';
		return view('admin/dashboard/home', $data);
    }

    public function profile()
    {
		$data['pageTitle']='Profile';
		return view('admin/dashboard/profile', $data);
    }

    // все пользователи с их группой
    // https://github.com/codeigniter4/shield/discussions/956
    public function listAllUsers()
    {
        // Это простой пример, конечно, вам нужно немного больше знаний. 
        // Возможно, вам придется расширить модель https://codeigniter4.github.io/shield/customization/user_provider/
        // или даже CodeIgniter\Shield\Entities\User. 
        // Или используйте объединение таблиц https://codeigniter.com/user_guide/database/query_builder.html?highlight=join#id16
        $users = auth()->getProvider();

        // table 
        $table = new \CodeIgniter\View\Table();
        $table->setHeading(['username', 'Groups']);

        foreach ($users->findAll() as $user) {
            $groups =  implode(",", $user->getGroups());
            $table->addRow([$user->username,$groups]);
            echo $table->generate();
        }

        // У Shield есть команда для вывода списка пользователей: php spark shield:user --help
        // list: https://github.com/codeigniter4/shield/blob/fb4142bd32ea42059062be8508cc2925c52c0c93/src/Commands/User.php#L515
    }

    public function editFieldTable()
    {
        //Изменение поля в таблице
        // https://codeigniter4.github.io/CodeIgniter4/dbmgmt/forge.html#modifying-a-field-in-a-table
    }
    
    public function editTable()
    {
        // вопрос: как я могу сохранить значения пола , имени , фамилии и... в базе данных помимо адреса электронной почты, имени пользователя и пароля на странице регистрации.
        // Ответ Выполните следующие действия:
        // 1. Добавьте файл представления (используйте настройку представлений)
        // <!-- Gender-->
        // <div class="mb-4">
        // <select id="gender" class="form-control" name="gender" placeholder="<?= lang('Auth.gender') вопр.>>
        // <option value="male">Male</option>
        // <option value="female">Female</option>
        // <option value="bisexual">Bisexual</option>
        // </select>
        // </div>
        // <!-- First Name-->
        // <div class="mb-4">
        // <input type="text" class="form-control" name="first_name" inputmode="text" autocomplete="first_name" placeholder="<?= lang('Auth.first_name') вопр.>" value="<?= old('first_name') вопр.>" required />
        // </div>
        // <!-- Last Name-->
        // <div class="mb-4">
        // <input type="text" class="form-control" name="last_name" inputmode="text" autocomplete="last_name" placeholder="<?= lang('Auth.last_name') вопр.>" value="<?= old('last_name') вопр.>" required />
        // </div>

        // 2. в файл app/Config/Auth.phpдобавить:
        // public array $personalFields = ['gender','first_name', 'last_name'];

        // 3. в файл app\Config\Validation.phpдобавить:
        //--------------------------------------------------------------------
        // Rules
        //--------------------------------------------------------------------
        // public $registration = [
        //     'username'         => [
        //             'required',
        //             'max_length[30]',
        //             'min_length[3]',
        //             'regex_match[/\A[a-zA-Z0-9\.]+\z/]',
        //             'is_unique[users.username]',
        //         ],
        //     'email'            => 'required|max_length[254]|valid_email|is_unique[auth_identities.secret]',
        //     'gender' => 'in_list[male,female,bisexual]',
        //     'first_name' => 'required|alpha|min_length[3]|max_length[10]',
        //     'last_name' => 'required|alpha|min_length[3]|max_length[15]',
        //     'password'         => 'required|strong_password',
        //     'password_confirm' => 'required|matches[password]',
        // ];
        
        // Сделайте то же самое для других полей.
        // Правильно ли я понял ваш вопрос и был ли ответ полным?
        // да, это работа. спасибо
    }
  
    public function addUser()
	{
		if($this->request->getPost()){
			//.. post submit code
		}
		// .. code here
	}
}
