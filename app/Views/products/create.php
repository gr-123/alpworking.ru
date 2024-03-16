<?= $this->extend('layouts/default') ?>
<?= $this->section('title') ?>Create Product<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="text-center mt-4 mb-4"><?= esc($title) ?></h2>

    <?php if (session()->has('error') && !empty(session()->getFlashdata('error'))) : ?>
        <div class="alert alert-danger">
            <?php
            echo esc(session()->getFlashdata('error'));
            // https://codeigniter.com/user_guide/helpers/form_helper.html#validation_errors
            // 
            // Возвращает ошибки проверки Validation::getErrors(), хранящиеся в сеансе, 
            // вам нужно использовать withInput() с redirect()
            // print_r(validation_errors());     // Return type: array
            // 
            // Возвращает визуализированный HTML-код ошибок проверки, 
            // используется validation_errors() внутренне, не работает с проверкой в ​​модели
            echo validation_list_errors();   // Return type: string
            // 
            // Возвращает одну ошибку для указанного поля в форматированном HTML, 
            // используется validation_errors() внутренне, не работает с проверкой в ​​модели
            // echo validation_show_error($field); // Return type: string
            // 
            // Получение ошибок проверки в ​​модели: 
            // https://codeigniter.com/user_guide/models/model.html#getting-validation-errors
            ?>
        </div>
    <?php endif ?>
    
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $field => $error) : ?>
                <p><?= esc($error) ?></p>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <?php $validation =  \Config\Services::validation(); // validation()->listErrors(); 
    ?>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col">Sample Data</div>
                <div class="col text-right"></div>
            </div>
        </div>

        <div class="card-body">

            <!-- Open Form: -->
            <?= form_open(base_url('products/create')) ?>
            <?= csrf_field() ?>

            <div class="form-group">
                <?php
                // Label:
                $title_label = [
                    'class' => 'form-label',
                    'style' => 'color: #000;',
                ];
                echo form_label('Title', 'title', $title_label);
                // Input:
                $title_input = [
                    'type'  => 'text', // ? input
                    'name'  => 'title',
                    'id'    => '',
                    'value' => set_value('title'),
                    'class' => 'form-control',
                    'placeholder' => 'Product Title'
                ];
                echo form_input($title_input); ?>
                <?php if ($validation->getError('title')) : ?>
                    <div class="alert alert-danger mt-2">
                        <?= $validation->getError('title') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php
                // Label:
                $name_label = [
                    'class' => 'form-label',
                    'style' => '',
                ];
                echo form_label('Name', 'name', $name_label);
                // Input:
                $name_input = [
                    'type'  => 'text',
                    'name'  => 'name',
                    'id'    => '',
                    'value' => set_value('name'),
                    'class' => 'form-control',
                    'placeholder' => 'Название, Product Name'
                ];
                echo form_input($name_input); ?>
                <?php if ($validation->getError('name')) : ?>
                    <div class="alert alert-danger mt-2">
                        <?= $validation->getError('name') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php
                // Label:
                $price_label = [
                    'class' => 'form-label',
                    'style' => '',
                ];
                echo form_label('Price', 'price', $price_label);
                // Input:
                $price_input = [
                    'type'  => 'text',
                    'name'  => 'price',
                    'id'    => '',
                    'value' => set_value('price'),
                    'class' => 'form-control',
                    'placeholder' => 'Product Price'
                ];
                echo form_input($price_input); ?>
                <?php if ($validation->getError('price')) : ?>
                    <div class="alert alert-danger mt-2">
                        <?= $validation->getError('price') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php
                // Label:
                $content_label = [
                    'class' => 'form-label',
                    'style' => '',
                ];
                echo form_label('Content', 'content', $content_label);
                // Textarea: идентична функции form_input()
                $content_input = [
                    'type'  => 'text',
                    'name'  => 'content',
                    'id'    => '',
                    'value' => set_value('content'),
                    'class' => 'form-control',
                    'cols' => '45',
                    'rows' => '4',
                    'placeholder' => 'Текст'
                ];
                echo form_textarea($content_input); ?>
                <!-- имя поля первый параметр. Второй (необязательный) значение по умолчанию Третий (необязательный) параметр позволяет отключить HTML-экранирование значения и избежать двойного экранирования. -->
                <?php if ($validation->getError('content')) : ?>
                    <div class="alert alert-danger mt-2">
                        <?= $validation->getError('content') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php
                $data = [
                    'name'    => 'product_create',
                    'id'      => 'button',
                    'value'   => 'Создать Продукт',
                    'type'    => 'submit',
                    'class'   => 'btn btn-primary',
                    'content' => 'Создать',
                ];
                // Button submit:
                echo form_button($data);
                ?>
            </div>

            <!-- Close Form: -->
            <?php echo form_close(); ?>

        </div>
    </div>
</div>



<?= $this->endSection() ?>
<?php // $this->section("scripts")
?>
<?php // script_tag('public/assets/js/script.js') 
?>
<?php // $this->endSection()
?>