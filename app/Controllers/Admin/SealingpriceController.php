<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PricesModel;

// TODO: create Namespase '\\Admin\\Price(s)' and move to current controllers

// php spark make:controller Admin\\Sealingprice --suffix
class SealingpriceController extends BaseController
{
    protected $helpers = ['url', 'form'];
    public function index()
    {
        $data = array();
        $data['pageTitle'] = 'Прайс по герметизации м.п. швов';

        $priceModel = model(PricesModel::class);
        // все позиции прайса в базе данных для категории "Герметизация м.п. швов"
        $price = $priceModel->where(['category_id' => '1'])->findAll(); // Значение возвращается в формате, указанном в $returnType .

        foreach ($price as $value) {
            $data[$value->name] = $value->amount;
            // echo '<pre>', '...: '; var_dump($value->name, $value->amount); die;
        }

        return view('admin/prices/sealing/index', $data);
    }
    public function update()
    {
        // if ($this->request->is('post')) { echo 'post'; } elseif ($this->request->is('get')) { echo 'get'; }
        // var_dump($this->request->getMethod());
        // die;

        // Определение типа запроса
        // Если не post-запрос, тогда открываем страницу редактирования прайса
        if (!$this->request->is('post')) {
            $data = array();
            $data['pageTitle'] = 'Редактирование прайса по герметизации м.п. швов';

            $priceModel = model(PricesModel::class);
            // все позиции прайса в базе данных для категории "Герметизация м.п. швов"
            $price = $priceModel->where(['category_id' => '1'])->findAll(); // Значение возвращается в формате, указанном в $returnType .
    
            foreach ($price as $value) {
                $data[$value->name] = $value->amount;
                // echo '<pre>', '...: '; var_dump($value->name, $value->amount); die;
            }

            return view('admin/prices/sealing/edit', $data);
        }

        $priceModel = model(PricesModel::class);

        // POST-запрос. Вычисляем данные запроса. chkdsk /c: /f /r
        $post = $this->request->getPost();

        // var_export($post);
        // die;

        // TODO: возможно есть способ сохранения данных одной строкой после foreach или switch

        // POST-данные из формы
        foreach ($post as $key => $value) {
            // только если задано значения для поля в прайсе
            if ($value != '') {
                // поле прайса
                switch ($key) {
                    case "germ1": // 1-комп.герметик
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'germ1'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                    case "germ2": // 2-комп.герметик
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'germ2'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                    case "vilaterm": // вилатерм
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'vilaterm'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                    case "pena": // монтажная пена
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'pena'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                    case "breakdown": // разбивка межпанельного шва
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'breakdown'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                    case "drilling": // Утепление через бурение с просверливанием отверстий в межпанельном шве
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'drilling'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                    case "primer": // грунтовка
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'primer'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                    case "sctch_lenta": // скотч лента (Ровные линии шва по малярному скотчу)
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'sctch_lenta'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                    case "mount_sctch_lenta1": // Наклеивание скотч ленты с одной стороны
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'mount_sctch_lenta1'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                    case "mount_sctch_lenta2": // Наклеивание скотч ленты с двух сторо
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'mount_sctch_lenta2'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                    case "remove_sctch_lenta1": // Снятие скотч ленты с одной стороны
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'remove_sctch_lenta1'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                    case "remove_sctch_lenta2": // Снятие скотч ленты с двух сторо
                        $entity = $priceModel->where(['category_id' => '1', 'name' => 'remove_sctch_lenta2'])->first(); // App\Entities\PricesEntity
                        $data = ['id' => $entity->id, 'amount' => $value];
                        $entity->fill($data);
                        $priceModel->save($entity);
                        break;
                }
            }
        }

        // Перейти к указанному маршруту. «user_gallery» — это имя маршрута, а не путь URI.
        return redirect()->route('admin.prices.sealing')->withInput()->with('success', 'Success! Update prices.');
    }
}
