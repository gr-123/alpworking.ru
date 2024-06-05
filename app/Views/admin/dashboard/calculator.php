<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('admin/dashboard/layout'); ?>
<?= $this->section('content'); ?>

<br>

<a href="<?= base_url('admin/calculator/sealing') ?>" class="btn btn-success">Герметизация межпанельных швов</a><br>
<!-- <a href="<?= base_url('admin/calculator/subtract') ?>" class="btn btn-success">Subtraction</a><br>
<a href="<?= base_url('admin/calculator/multiply') ?>" class="btn btn-success">Multiplication</a><br>
<a href="<?= base_url('admin/calculator/divide') ?>" class="btn btn-success">Division</a><br> -->

<br>
<br>
<?= current_url(); ?><br>
<?= base_url('admin/manager'); ?>
<?= $this->endSection(); ?>