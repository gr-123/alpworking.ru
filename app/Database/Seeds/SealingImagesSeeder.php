<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use App\Models\SealingImagesModel;
use App\Entities\SealingImagesEntity;
use Faker\Generator;

// php spark make:seeder sealing_images --suffix
// php spark db:seed SealingImagesSeeder

class SealingImagesSeeder extends Seeder
{
    public function run()
    {
        $sealingImagesModel = new SealingImagesModel;
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $sealingImagesModel->save(
                  [
                      'name'        =>    \Faker\Provider\Image::imageUrl(800, 400),
                      'caption'     =>    $faker->sentence,
                  ]
              );
          }
    }
}
