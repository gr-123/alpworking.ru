<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<?php // при перенаправлении из update() метода  redirect()->to(base_url("/products/show/$inserted_id"))->withInput()->with('success', 'Success! Update a products item.')  ?>
<?php if (session()->has('success') && ! empty(session()->getFlashdata('success'))): ?>
    <h2> <?=esc(session()->getFlashdata('success')) ?> </h2>
<?php endif ?>
    
<h2><?= esc($title . ": '$product->title'") ?></h2>

<div class="main">
    <?= esc($product->id) ?><br>
    <?= esc($product->title) ?><br>
    <?= esc($product->name) ?><br>
    <?= esc($product->price) ?><br>
    <?= esc($product->slug) ?><br>
    <?= esc($product->content) ?><br>
    <?= esc($product->updated_at) ?><br>
</div>
<p><a href="/products/edit/<?= esc($product->id, 'url') ?>">Edit product</a></p>

<?= $this->endSection() ?>  
<?php // $this->section("scripts")?>
<?php // script_tag('public/assets/js/script.js') ?>
<?php // $this->endSection()?>