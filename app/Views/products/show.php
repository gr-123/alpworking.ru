<?= $this->extend('layouts/default') ?>
<?= $this->section('title') ?>Show Product<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="text-center mt-4 mb-4"><?= esc($title) ?></h2>

    <?php $session = \Config\Services::session(); // ?? 
    ?>

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
                <div class="col">Данные <?= esc($title . ": '$product->title'") ?></div>
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

                    <?php if (isset($product) && !empty($product)) : ?><?php //echo '<pre>'; var_dump(is_array($product)); die;
                                                                        ?>
                    <tr>
                        <td><?= esc($product->id) ?></td>
                        <td><?= esc($product->title) ?></td>
                        <td><?= esc($product->name) ?></td>
                        <td><?= esc($product->price) ?></td>
                        <td><?= esc($product->slug) ?></td>
                        <td><?= esc($product->content) ?></td>
                        <td><?= esc($product->updated_at) ?></td>
                        <td><a href="/products/show/<?= esc($product->id, 'url') ?>" class="btn btn-sm btn-warning">View</a></td>
                        <td><a href="/products/edit/<?= esc($product->id, 'url') ?>" class="btn btn-sm btn-warning">Edit</a></td>
                        <td><a href="/products/remove/<?= esc($product->id, 'url') ?>" class="btn btn-sm btn-warning">Delete</a></td>
                        <td><!-- <a href="/products/remove/<?= esc($product->id, 'url') ?>" class="btn btn-sm btn-warning">Delete</a> --></td>
                        <td><!-- <button type="button" onclick="delete_data(' . <?= esc($product->id, 'url') ?> . ')" class="btn btn-danger btn-sm">Delete</button> --></td>
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