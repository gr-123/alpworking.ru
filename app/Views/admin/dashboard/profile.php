<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?=$this->extend('admin/dashboard/layout'); ?>
<?= $this->section('content'); ?>
    content...

    <br>
    <?= current_url(); ?><br>
    <?= base_url('admin/profile'); ?>
<?= $this->endSection(); ?>