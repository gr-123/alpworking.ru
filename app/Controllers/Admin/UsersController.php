<?php

// php spark make:controller Admin\\Users --suffix --restful # namespace App\Controllers\Admin; class UsersController extends ResourceController

namespace App\Controllers\Admin;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Entities\User;

// Управление пользователями
// --------------------------------------------------------------------
// 
// https://shield.codeigniter.com/user_management/managing_users/
// 

class UsersController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function index()
    {
        echo "UserController<pre>";
    }

    /**
     * Return the properties of a resource object
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider(); // use CodeIgniter\Shield\Entities\User;

        // php spark db:table users // id = 1
        $user = $users->findById(1);

		$data = [
			'pageTitle' => "...",
			'groups' => $user->getGroups(),
			'permissions' => $user->getPermissions(),
		];

		return view('...', $data);
    }

    public function showUser()
    {
        // получить текущего пользователя:
        // $user = auth()->user()->toRawArray();

        // auth_helper Помощник по аутентификации https://codeigniter4.github.io/shield/authentication/#auth-helper
        // echo auth()->user()->username; // namespace CodeIgniter\Shield\Entities; class User extends Entity
        // echo auth()->user()->getEmail(); // shield/src/Entities/User.php
        // echo auth()->user()->created_at->toDateTimeString();
        // 
        // print_r(['данные пользователя, вошедшего в систему:' => auth()->user()->toRawArray()]);



        // Аутентификатор по умолчанию $defaultAuthenticator = 'session';
        // Shield: auth_helper предоставляет auth()функцию,

        
        // Вы можете определить, вошел ли пользователь в систему в данный момент, с помощью метода loggedIn().
        if (auth()->loggedIn()) {
            // $this->listAllUsers();
            // echo auth()->id(); // or user_id();        // get the current user's id
        }
        // проверить, заблокирован ли пользователь
        // https://shield.codeigniter.com/user_management/banning_users/
        // if ($user->isBanned()) {
        //     //...
        // }


        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider(); // use CodeIgniter\Shield\Entities\User;
    }

    // все пользователи с их группой
    // https://github.com/codeigniter4/shield/discussions/956
    public function listAllUsers()
    {

        // Это простой пример, конечно, вам нужно немного больше знаний. 
        // Возможно, вам придется расширить модель https://codeigniter4.github.io/shield/customization/user_provider/
        // или даже CodeIgniter\Shield\Entities\User. 
        // Или используйте объединение таблиц https://codeigniter.com/user_guide/database/query_builder.html?highlight=join#id16

        
        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider(); // use CodeIgniter\Shield\Entities\User;

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

    /**
     * Return a new resource object, with default properties
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return ResponseInterface
     */
    public function create()
    {
        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider(); // use CodeIgniter\Shield\Entities\User;
        $user = new User([
            'username' => 'foo-bar',
            'email'    => 'foo.bar@example.com',
            'password' => 'secret plain text password',
        ]);
        $users->save($user);
        
        // Чтобы получить полный объект пользователя с идентификатором, нам нужно получить из базы данных
        $user = $users->findById($users->getInsertID());

        // Add to default group
        $users->addToDefaultGroup($user);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        // //
		// if($this->request->getPost()){
		// 	//.. post submit code
		// }
        
        // $user->removeGroup('user', 'admin', 'beta');
        // $user->addGroup('superadmin');

        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider(); // use CodeIgniter\Shield\Entities\User;
        // // Редактирование пользователя
        // $user->fill([
        //     'username' => 'JoeSmith111',
        //     'email' => 'joe.smith@example.com',
        //     'password' => 'secret123'
        // ]);
        // $users->save($user);
    }
    
    public function permissionsUser($user){

        // Позволяет проверить, разрешено ли пользователю выполнять определенное действие, группу или действия. 
        // Строки разрешений должны передаваться в качестве аргументов. Возвращает логическое значение true/ false
        // Если указано несколько разрешений, возвращается true, если какое-либо из них есть у пользователя.
        // 
        //  Сначала проверит прямые разрешения пользователя ( разрешения на уровне пользователя ), а затем 
        // проверит все разрешения групп пользователя ( разрешения на уровне группы )
        if ($user->can('users.create', 'users.edit')) {
            //
        }

        // inGroup()
        // Проверяет, входит ли пользователь в одну из переданных групп. Возвращает логическое значение true/ false.
        if (! $user->inGroup('superadmin', 'admin')) {
            //
        }

        // hasPermission()
        // Проверяет, есть ли у пользователя разрешения, установленные непосредственно для него 
        // самого. При этом игнорируются любые группы, частью которых они являются.
        // Примечание
        // Этот метод проверяет только разрешения на уровне пользователя и не проверяет 
        // разрешения на уровне группы. Если вы хотите проверить, может ли пользователь 
        // что-то сделать, используйте вместо этого метод $user->can().

        if (! $user->hasPermission('users.create')) {
            //
        }

        
        
        // Edit Permissions User:
        // --------------------------------------------------------------------
        
        // addPermission()
        // Добавляет пользователю одно или несколько разрешений уровня пользователя. 
        // Если разрешение не существует, CodeIgniter\Shield\Authorization\AuthorizationException выдается .
        $user->addPermission('users.create', 'users.edit');
        
        // removePermission()
        // Удаляет одно или несколько разрешений уровня пользователя. 
        // Если разрешение не существует, CodeIgniter\Shield\Authorization\AuthorizationException выдается .
        $user->removePermission('users.delete');
        
        // syncPermissions()
        // Обновляет разрешения пользователя на уровне пользователя , чтобы включать только разрешения из заданного списка. Все существующие разрешения для этого пользователя, которого нет в этом списке, будут удалены.
        $user->syncPermissions('admin.access', 'beta.access');
        
        // getPermissions()
        // Возвращает все разрешения уровня пользователя, которые этот пользователь назначил им непосредственно.
        $user->getPermissions();
    }

    public function editGroupsUser($user)
    {
        // addGroup()
        // Добавляет одну или несколько групп пользователю. Если группа не существует, 
        // создается исключение CodeIgniter\Shield\Authorization\AuthorizationException is thrown.
        $user->addGroup('admin', 'beta');
        
        // removeGroup()
        // Удаляет одну или несколько групп у пользователя. Если группа не существует, 
        // создается исключение CodeIgniter\Shield\Authorization\AuthorizationException is thrown.
        $user->removeGroup('admin', 'beta');
        
        // syncGroups()
        // Обновляет группы пользователя, чтобы включать только группы из заданного списка. Любые 
        // существующие группы этого пользователя, которых нет в этом списке, будут удалены.
        $user->syncGroups('admin', 'beta');
        
        // getGroups()
        // Возвращает все группы пользователя
        $user->getGroups();
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }

    public function deleteUser()
    {
        // Удаление пользователей
        // Данные пользователя могут быть распределены по нескольким различным таблицам, поэтому вас может беспокоить вопрос о том, как удалить все данные пользователя из системы. Это обрабатывается автоматически на уровне базы данных для всей информации, о которой знает Shield, посредством настроек onCascadeвнешних ключей таблицы. Вы можете удалить пользователя, как и любой другой объект.
        
        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider();
        
        // Чтобы получить полный объект пользователя с идентификатором, нам нужно получить из базы данных
        $user = $users->findById($users->getInsertID());

        $users->delete($user->id, true);
    }
}
