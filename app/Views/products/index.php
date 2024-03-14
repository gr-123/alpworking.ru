<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<h2><?= esc($title) ?></h2>

<?php 
// при перенаправлении из метода  delete() 
// return redirect()->to('/products')->withInput()->with('success', "product '$id' deleted.");
?>
<?php if (session()->has('success') && ! empty(session()->getFlashdata('success'))): ?>
    <h2> <?=esc(session()->getFlashdata('success')) ?> </h2>
<?php endif ?>

<?php if (! empty($products) && is_array($products)): ?>

    <?php foreach ($products as $item): ?><?php //echo '<pre>'; var_dump(is_array($products)); var_dump($item); die;?>

        <h3><?= esc($item->title) ?></h3>
        <div class="main">
            <?= esc($item->id) ?><br>
            <?= esc($item->title) ?><br>
            <?= esc($item->name) ?><br>
            <?= esc($item->price) ?><br>
            <?= esc($item->slug) ?><br>
            <?= esc($item->content) ?><br>
            <?= esc($item->updated_at) ?><br>
        </div>
        <p><a href="/products/show/<?= esc($item->id, 'url') ?>">View article</a></p>

    <?php endforeach ?>

<?php else: ?>

    <h3>No News</h3>
    <p>Unable to find any products for you.</p>

<?php endif ?>

<?= $this->endSection() ?>
  
<?php // $this->section("scripts")?>
<?php // script_tag('public/assets/js/script.js') ?>
<?php // $this->endSection()?>