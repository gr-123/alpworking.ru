<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('title') ?>Products<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="text-center mt-4 mb-4"><?= esc($title) ?></h2>

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

    //     echo '</div>';
    // } // << -- If --
    ?>

    <?php $validation =  \Config\Services::validation(); // validation()->listErrors(); 
    ?>

    <?php if (session()->has('success') && !empty(session()->getFlashdata('success'))) : ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif ?>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">Удалить выбранные элементы</div>
                <div class="col text-right"></div>
            </div>
        </div>
        <div class="card-body">

            <!-- Open Form: -->
            <?= form_open(base_url("products/delete/checkbox")) ?>
            <?= csrf_field() // Возвращает скрытый ввод с уже вставленной информацией CSRF: <input type="hidden" name="{csrf_token}" value="{csrf_hash}"> 
            ?>

            <div class="table-responsive">

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Выбрать</th>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>

                    <?php if (!empty($products) && is_array($products)) : ?>

                        <?php foreach ($products as $item) : ?><?php //echo '<pre>'; var_dump(is_array($products)); var_dump($item); die;
                                                                ?>

                        <tr>
                            <!-- 
                                set_checkbox https://codeigniter.com/user_guide/helpers/form_helper.html#set_checkbox 
                                form_checkbox https://codeigniter.com/user_guide/helpers/form_helper.html#form_checkbox
                                 -->
                            <td><?= form_checkbox('id_items[]', esc($item->id)) ?></td>
                            <td><?= esc($item->id) ?></td>
                            <td><?= esc($item->title) ?></td>
                            <td><?= esc($item->name) ?></td>
                            <td><?= esc($item->price) ?></td>
                        </tr>

                    <?php endforeach ?>
                <?php else : ?>
                    <h3>No products</h3>
                    <p>Unable to find any products for you.</p>
                <?php endif ?>
                </table>

            </div>

            <div>

                <?php

                if (isset($pager) && !empty($pager)) {
                    $pager->setPath('products/edit/delete');
                    echo $pager->links();
                }

                ?>

            </div>

            <div class="form-group">
                <?php
                $data = [
                    'name'    => 'products_button_delete',
                    'id'      => 'button',
                    'value'   => 'Delete products items',
                    'type'    => 'submit',
                    'class'   => 'btn btn-primary',
                    'content' => 'Удалить выбранные элементы',
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