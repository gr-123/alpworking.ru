<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;
use App\Models\ProductModel;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Standard Query
        // https://codeigniter.com/user_guide/database/examples.html

        // $data = [
        //     'title'   => 'titleProduct',
        //     'name'    => 'Product 1',
        //     'price'   => '123.00',
        //     'slug'    => 'cafjdhj-nation-yes3',
        //     'content' => 'hfgh hjhjd hjkkj uilkryr klhkffbfgh',
        // ];

        // // Простые запросы
        // // $this->db->query('INSERT INTO products (title, name, price, slug, content) VALUES(:title:, :name:, :price:, :slug:, :content:)', $data);

        // // Использование Query Builder
        // $this->db->table('products')->insert($data);


        
        $productModel = new ProductModel;
        $generator = Factory::create();
        // https://github.com/fzaninotto/Faker#create-fake-data
        // $populator = new \Faker\ORM\Propel\Populator($generator);

        // $populator->addEntity('ProductEntity', 5, array(
        //     'created_at' => null,
        //     'updated_at' => null,
        //     'deleted_at' => null,
        //     // Если Faker неправильно интерпретирует имя столбца, вы все равно можете указать собственное замыкание, которое будет использоваться для заполнения определенного столбца, используя третий аргумент addEntity():
        //     // 'ISBN' => function() use ($generator) { return $generator->ean13(); }
        //   ));
        // $insertedPKs = $populator->execute();
        // print_r($insertedPKs);

        for ($i = 0; $i < 10; $i++) { 
            // $this->db->table('products')->insert($this->generateProducts($generator));
            $productModel->save($this->generateProducts($generator));
        }
    }

    private function generateProducts($generator): array
    {
        return [
            // 'code'        => $generator->unique()->swiftBicNumber, // 'RZTIAT22263' //ean8           // '73513537'
            'title'       => $generator->title,
            'name'        => $generator->name,
            'price'       => $generator->numberBetween(50, 200),
            'slug'        => $generator->unique()->slug,
            'content'     => $generator->realText($maxNbChars = 200, $indexSize = 2),
            // 'description' => $generator->sentence(6), // realText($maxNbChars = 200, $indexSize = 2)
            // 'amount'      => $generator->numberBetween(50, 200),
            // 'status'      => $generator->boolean(10),
            // 'active'      => $generator->randomElement([1, 0]),
        ];
    }
}

        // $generator = Factory::create(); // https://github.com/fzaninotto/Faker#create-fake-data
        // $populator = new \Faker\ORM\Propel\Populator($generator);
        // $populator->addEntity('ProductEntity', 5, array(
        //     'created_at' => null,
        //     'updated_at' => null,
        //     'deleted_at' => null,
        //     // Если Faker неправильно интерпретирует имя столбца, вы все равно можете указать собственное замыкание, которое будет использоваться для заполнения определенного столбца, используя третий аргумент addEntity():
        //     // 'ISBN' => function() use ($generator) { return $generator->ean13(); }
        //   ));
        // $insertedPKs = $populator->execute();
        // print_r($insertedPKs);
        // 'code'        => $generator->unique()->swiftBicNumber, // 'RZTIAT22263' //ean8           // '73513537'
        // 'name'        => $generator->unique()->name,
        // 'description' => $generator->sentence(6), // realText($maxNbChars = 200, $indexSize = 2)
        // 'amount'      => $generator->numberBetween(50, 200),
        // 'status'      => $generator->boolean(10),
        // 'active'      => $generator->randomElement([1, 0]),