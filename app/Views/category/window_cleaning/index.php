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
    if (session()->has('errors') && !empty(session()->getFlashdata('errors'))) {
        echo '<div class="alert alert-danger">';

        $data_errors = esc(session()->getFlashdata('errors'));
        // d(is_array($data_errors));
        // d(! empty($data_errors));

        if (is_array($data_errors) && !empty($data_errors)) {
            // if array
            foreach ($data_errors as $key => $value) {
                echo esc($value), '<br>'; // см. validation_list_errors();
            }
        } else {
            // if string
            echo $data_errors;
        }

        // Получение всех ошибок: https://codeigniter4.github.io/userguide/libraries/validation.html#getting-all-errors
        // https://codeigniter.com/user_guide/helpers/form_helper.html#validation_errors
        // 
        // Возвращает ошибки проверки Validation::getErrors(), хранящиеся в сеансе, 
        // вам нужно использовать withInput() с redirect()
        // print_r(validation_errors());     // Return type: array
        // 
        // Возвращает визуализированный HTML-код ошибок проверки, 
        // используется validation_errors() внутренне, не работает с проверкой в ​​модели
        echo validation_list_errors();   // Return type: string
        //   Отключим, т.к. здесь выводим ошибки под каждым полем формы
        // 
        // Возвращает одну ошибку для указанного поля в форматированном HTML, 
        // используется validation_errors() внутренне, не работает с проверкой в ​​модели
        // echo validation_show_error('title'); // Return type: string
        // 
        // Получение ошибок проверки в ​​модели: 
        // https://codeigniter.com/user_guide/models/model.html#getting-validation-errors

        echo '</div>';
    } // << -- If --
    ?>

    <?php if (session()->has('success') && !empty(session()->getFlashdata('success'))) : ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif ?>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">Данные продуктов</div>
                <div class="col text-right">
                    <a href="<?php echo base_url("products/new") ?>" class="btn btn-success btn-sm">Создать</a>
                    <a href="<?php echo base_url("products/remove/list") ?>" class="btn btn-success btn-sm">Выбрать</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Slug</th>
                        <th>Content</th>
                        <th>updated_at</th>
                        <th>Show</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>

                    <?php if (!empty($products) && is_array($products)) : ?>

                        <?php foreach ($products as $item) : ?><?php //echo '<pre>'; var_dump(is_array($products)); var_dump($item); die;
                                                                ?>

                        <tr>
                            <td><?= esc($item->id) ?></td>
                            <td><?= esc($item->title) ?></td>
                            <td><?= esc($item->name) ?></td>
                            <td><?= esc($item->price) ?></td>
                            <td><?= esc($item->slug) ?></td>
                            <td><?= esc($item->content) ?></td>
                            <td><?= esc($item->updated_at) ?></td>
                            <td><a href="/products/show/<?= esc($item->id, 'url') ?>" class="btn btn-outline-primary">View</a></td>
                            <td><a href="/products/edit/<?= esc($item->id, 'url') ?>" class="btn btn-outline-success">Edit</a></td>
                            <td><a href="/products/remove/<?= esc($item->id, 'url') ?>" class="btn btn-outline-danger">Delete</a>
                                <!-- <a href="/products/remove/<?= esc($item->id, 'url') ?>" class="btn btn-sm btn-warning">Delete</a> -->
                                <!-- <button type="button" onclick="delete_data(' . <?= esc($item->id, 'url') ?> . ')" class="btn btn-danger btn-sm">Delete</button> -->
                            </td>
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
                    $pager->setPath('products');
                    echo $pager->links();
                }

                ?>

            </div>
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