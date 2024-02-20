<?php

// php spark make:controller Admin\\Admin --suffix # namespace App\Controllers\Admin; class AdminController extends BaseController

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
// use CodeIgniter\Shield\Entities\User;
// use CodeIgniter\Shield\Models\UserModel;

class AdminController extends BaseController
{

    // ci4-admin посмотреть примеры view
    // https://github.com/bvrignaud/ci4-admin/tree/master/src/Views

    public function index()
    {
        // echo "AdminController<pre>";
        // echo \CodeIgniter\CodeIgniter::CI_VERSION;
        // echo "PHP is working!\n"; echo phpinfo();

        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider(); // use CodeIgniter\Shield\Entities\User;
        // php spark db:table users // id = 1
        $user = $users->findById(1);

        $entity = array();
        $entity['groups']= $user->getGroups();
        $entity['permissions']= $user->getPermissions();
        
		$data = [
			'pageTitle' => "Home",
			'entity' => $entity
		];

		return view('admin/dashboard/home', $data);
    }

    public function profile()
    {
		$data['pageTitle']='Profile';
		return view('admin/dashboard/profile', $data);
    }

    public function upload()
    {
		$data['pageTitle']='Upload';
		return view('admin/dashboard/upload', $data);
    }
    
    // войти в систему, используя свой адрес электронной почты и пароль
    public function loginAttempt()
    {
        // Многие методы аутентификации возвращают класс CodeIgniter\Shield\Result:
        // 
        // isOK()        // Возвращает логическое значение, указывающее, была ли проверка успешной или нет.
        // reason()        // Возвращает сообщение, которое может быть отображено пользователю в случае неудачной проверки.
        // extraInfo()        // Может возвращать пользовательский бит информации. Они будут подробно описаны в описаниях методов ниже.

        // Аутентификатор сеанса
        // https://shield.codeigniter.com/references/authentication/session/

        $credentials = [
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password')
        ];
        
        // check()
        // Если вы хотите проверить учетные данные пользователя, не входя в систему
        // $validCreds = auth()->check($credentials); // Возвращенный экземпляр Result

        // attempt()
        $result = auth()->attempt($credentials); // Возвращенный объект Response

        // Вход в систему фиксируется и записывается в таблицу 'auth_logins', независимо от результата.
        
        // Если попытка не удалась, запускается событие неудачного входа в систему с массивом учетных данных в качестве единственного параметра
        if (! $result->isOK()) {
            return redirect()->back()->with('error', $result->reason());
        }

        // В случае успешного завершения attempt() пользователь входит в систему.
        if ($result->isOK()) {
            $user = $result->extraInfo(); // данные пользователя

            // Если $allowRemembering true в Auth файле конфигурации, вы можете указать аутентификатору сеанса 
            // установить безопасный файл cookie «запомнить меня».
            // $loginAttempt = auth()->remember()->attempt($credentials);

            // Активация пользователя
            // Пользователи автоматически активируются в рамках EmailActivatorдействия. Их можно активировать вручную с помощью activate()метода сущности User.
            // $user->activate();        

            // Проверка статуса активации
            if ($user->isActivated()) {
                //
            }

            // Деактивация пользователя
            // Пользователей можно деактивировать вручную с помощью deactivate()метода объекта User.
            // $user->deactivate();            
        }

        // logout()
        // Вы можете вызвать logout()метод, чтобы выйти из текущего сеанса пользователя. Это приведет к уничтожению и восстановлению текущего сеанса, очистке всех текущих токенов «запомнить меня» для этого пользователя и запуску события logout.
        // auth()->logout();

        // forget()
        // Этот forget метод удалит все токены «запомнить меня» для текущего пользователя, чтобы они не были запомнены при следующем посещении сайта.
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

    // Codeigniter 4 — Shield: Каков рабочий процесс создания новых пользователей?
    // https://stackoverflow.com/questions/76270968/codeigniter-4-shield-what-is-the-workflow-for-creating-new-users

    // Codeigniter 4 Shield: как выдать токен доступа
    // https://stackoverflow.com/questions/75503513/codeigniter-4-shield-how-to-issue-an-access-token
}
