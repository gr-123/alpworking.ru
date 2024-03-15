<?= $this->extend('layouts/default') ?>
<?= $this->section('title') ?>Подтверждение об успешном создании<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="text-center mt-4 mb-4">Products item created successfully!</h2>

    <?php $session = \Config\Services::session(); // ?? 
    ?>

    <?php if (session()->has('success') && !empty(session()->getFlashdata('success'))) : ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif ?>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <p>Products item created successfully!</p>
                </div>
            </div>
        </div>
        <div class="card-body">
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