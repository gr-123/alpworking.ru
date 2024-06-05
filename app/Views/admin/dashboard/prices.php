<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('admin/dashboard/layout'); ?>
<?= $this->section('content'); ?>

<br>
<a href="<?= base_url('admin/prices/sealing') ?>">Герметизация м.п. швов</a>
<br>
<a href="<?= base_url('admin/prices/window_cleaning') ?>">Мойка окон</a>



<br>
<br>
<?= current_url(); ?><br>
<?= base_url('admin/prices'); ?>
<?= $this->endSection(); ?>