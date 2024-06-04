<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('admin/dashboard/layout'); ?>
<?= $this->section('content'); ?>

<br>
<a href="<?= base_url('admin/calculator') ?>" class="btn btn-success">Calculator</a>



<br>
<br>
<?= current_url(); ?><br>
<?= base_url('admin/manager'); ?>
<?= $this->endSection(); ?>