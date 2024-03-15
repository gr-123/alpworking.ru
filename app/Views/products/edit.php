<?= $this->extend('layouts/default') ?>
<?= $this->section('title') ?>Edit Product<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="text-center mt-4 mb-4"><?= esc($title_page . ": '$product->title'") ?></h2>

    <!-- 
session() 
    Функция session() используется для получения объекта Session, а 
    session()->getFlashdata('error') используется для 
    отображения пользователю ошибки, связанной с защитой CSRF. 
    Однако по умолчанию, если проверка CSRF не удалась, будет выдано исключение, поэтому оно пока не работает. 
    Дополнительную информацию см. в разделе «Перенаправление в случае сбоя». 
    https://codeigniter.com/user_guide/libraries/security.html#csrf-redirection-on-failure

validation_list_errors()
    Функция validation_list_errors(), предоставляемая помощником формы, используется для 
    сообщения об ошибках, связанных с проверкой формы.
    -->

    <?php if (session()->has('error') && !empty(session()->getFlashdata('error'))) : ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
            <?= validation_list_errors() ?>
        </div>
    <?php endif ?>

    <?php $validation =  \Config\Services::validation(); // validation()->listErrors(); 
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
                // Label:
                $title_label = [
                    'class' => 'form-label',
                    'style' => 'color: #000;',
                ];
                echo form_label('Title', 'title', $title_label);
                // Input:
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
                    'value' => set_value('name', $product->name),
                    'class' => 'form-control',
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
                    'value' => set_value('price', $product->price),
                    'class' => 'form-control',
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
                    'value' => set_value('content', $product->content),
                    'class' => 'form-control',
                    'cols' => '45',
                    'rows' => '4',
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