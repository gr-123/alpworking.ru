<?= $this->extend('layouts/default') ?>
<?= $this->section('title') ?>Edit Product<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="text-center mt-4 mb-4"><?= esc($title . ": '$product->title'") ?></h2>

    <?php
    // if (session()->has('errors') && !empty(session()->getFlashdata('errors'))) {
    //     echo '<div class="alert alert-danger">';

    //     $data_errors = esc(session()->getFlashdata('errors'));
    //     // d(is_array($data_errors));
    //     // d(! empty($data_errors));

    //     if (is_array($data_errors) && ! empty($data_errors)) {
    //         // if array
    //         foreach ($data_errors as $key => $value) {
    //             echo esc($value), '<br>'; // см. validation_list_errors();
    //         }
    //     }else {
    //         // if string
    //         echo $data_errors;
    //     }

    // Получение всех ошибок: https://codeigniter4.github.io/userguide/libraries/validation.html#getting-all-errors
    // https://codeigniter.com/user_guide/helpers/form_helper.html#validation_errors
    // 
    // Возвращает ошибки проверки Validation::getErrors(), хранящиеся в сеансе, 
    // вам нужно использовать withInput() с redirect()
    // print_r(validation_errors());     // Return type: array
    // 
    // Возвращает визуализированный HTML-код ошибок проверки, 
    // используется validation_errors() внутренне, не работает с проверкой в ​​модели
    // echo validation_list_errors();   // Return type: string
    //   Отключим, т.к. здесь выводим ошибки под каждым полем формы
    // 
    // Возвращает одну ошибку для указанного поля в форматированном HTML, 
    // используется validation_errors() внутренне, не работает с проверкой в ​​модели
    // echo validation_show_error('title'); // Return type: string
    // 
    // Получение ошибок проверки в ​​модели: 
    // https://codeigniter.com/user_guide/models/model.html#getting-validation-errors

    //     ecs< -- If --
    ?>

    <?php $validation = \Config\Services::validation(); // validation()->listErrors(); 
    ?>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col">Edit Data</div>
                <div class="col text-right"></div>
            </div>
        </div>

        <div class="card-body">

            <!-- Open Form: -->
            <?= form_open(base_url('products/update/' . $product->id)) ?>
            <?= csrf_field() ?>

            <div class="form-group">

                <?php
                // Title:
                $title_label = [
                    'class' => 'form-label',
                    'style' => 'color: #000;',
                ];
                echo form_label('Title', 'title', $title_label);
                $title_input = [
                    'type'  => 'text',
                    'name'  => 'title',
                    'id'    => '',
                    'value' => set_value('title', $product->title),
                    // 'value' => "<?php if($product->title): echo $product->title; else: set_value('title'); endif В>", ?? возможно прежние значения и так отображаются (см.выще строку)
                    'class' => 'form-control',
                    'placeholder' => 'uniq'
                ];
                echo form_input($title_input); ?>
                <?php if (validation_show_error('title')) : ?>
                    <div class="alert alert-danger mt-2">
                        <?= validation_show_error('title') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php
                // Name:
                $name_label = [
                    'class' => 'form-label',
                    'style' => '',
                ];
                echo form_label('Name', 'name', $name_label);
                $name_input = [
                    'type'  => 'text',
                    'name'  => 'name',
                    'id'    => '',
                    'value' => set_value('name', $product->name),
                    'class' => 'form-control',
                ];
                echo form_input($name_input); ?>
                <?php if (validation_show_error('name')) : ?>
                    <div class="alert alert-danger mt-2">
                        <?= validation_show_error('name') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php
                // Price:
                $price_label = [
                    'class' => 'form-label',
                    'style' => '',
                ];
                echo form_label('Price', 'price', $price_label);
                $price_input = [
                    'type'  => 'text',
                    'name'  => 'price',
                    'id'    => '',
                    'value' => set_value('price', $product->price),
                    'class' => 'form-control',
                ];
                echo form_input($price_input); ?>
                <?php if (validation_show_error('price')) : ?>
                    <div class="alert alert-danger mt-2">
                        <?= validation_show_error('price') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php
                // Content:
                $content_label = [
                    'class' => 'form-label',
                    'style' => '',
                ];
                echo form_label('Content', 'content', $content_label);
                $content_input = [
                    'type'  => 'text',
                    'name'  => 'content',
                    'id'    => '',
                    'value' => set_value('content', $product->content),
                    'class' => 'form-control',
                    'cols' => '45',
                    'rows' => '4',
                ];
                echo form_textarea($content_input); ?>
                <!-- имя поля первый параметр. Второй (необязательный) значение по умолчанию Третий (необязательный) параметр позволяет отключить HTML-экранирование значения и избежать двойного экранирования. -->
                <?php if (validation_show_error('content')) : ?>
                    <div class="alert alert-danger mt-2">
                        <?= validation_show_error('content') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <?php
                $data = [
                    'name'    => 'product_update',
                    'id'      => 'button',
                    'value'   => 'Update products item',
                    'type'    => 'submit',
                    'class'   => 'btn btn-primary',
                    'content' => 'Обновить / Update products item"',
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