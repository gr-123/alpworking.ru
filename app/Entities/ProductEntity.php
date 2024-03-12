<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

// https://codeigniter.com/user_guide/models/entities.html

class ProductEntity extends Entity
{
    // attributesэто зарезервированное слово для внутреннего использования. Если вы используете его в качестве имени столбца, объект будет работать неправильно.
    protected $datamap = [];
    // определить, какие свойства преобразуются автоматически
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    // Теперь, когда любое из этих свойств установлено, они будут преобразованы в экземпляр Time с использованием текущего часового пояса приложения, как установлено в app/Config/App.php
    protected $casts   = [];

    // TODO: вроде необязательно, все присваивается автоматически. Попробовать закомментировать.
    protected $attributes = [
        // 'code' => null,
        'title'  => null,
        'name'  => null,
        'price' => null,
        'slug' => null,
        'content' => null,
        // 'amount' => null,
        // 'status' => null,
        // 'active' => null,
    ];
 
    //     // filter on create/update data if necessary
    // public function setCode(string $productCode): self
    // {
    //     $this->attributes['code'] = strtoupper($productCode);
    //     return $this;
    // }
 
    //     // filter on create/update data if necessary
    // public function setName(string $productName): self
    // {
    //     $this->attributes['name'] = ucwords($productName);
    //     return $this;
    // }
 
    // Свойство 'title'
    public function setTitle(string $title): self
    {
        try {

            $title = ucfirst($title);
            // заменить в 'title' первую букву на заглавную
            $this->attributes['title'] = $title;
            
            // Автоматически присвоим свойству 'slug' значение из значения свойства 'title'
            $this->setSlug($title);

            return $this;

        } catch (\Throwable $t) {
            exit( $t->getMessage() );
        }
    }
    
    // Свойство 'slug'
    public function setSlug(string $slug): self
    {
        // url_title (URL helper) - заменяет все пробелы тире (-) и гарантирует, что все будет в нижнем регистре
        $this->attributes['slug'] = url_title($slug, '-', true);
        return $this;
    }
}
