<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('title') ?>Show Product<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="text-center mt-4 mb-4"><?= esc($title) ?></h2>

    <?php
    // при перенаправлении из метода update()
    // redirect()->to(base_url("/products/show/$inserted_id"))->withInput()->with('success', 'Success! Update a products item.');
    ?>
    <?php if (session()->has('success') && !empty(session()->getFlashdata('success'))) : ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif ?>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col">Данные <?= esc($title . ": '$item->title'") ?></div>
                <div class="col text-right"></div>
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

                    <?php if (isset($item) && !empty($item)) : ?><?php //echo '<pre>'; var_dump(is_array($product)); die;
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

                <?php else : ?>
                    <h3>No product</h3>
                    <p>Unable to find any product for you.</p>
                <?php endif ?>

                </table>
            </div>
            <div></div>
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