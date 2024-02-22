<?=$this->extend('admin/dashboard/layout'); ?>
<?php // $this->section("title");?>
<?php // $page_title;?>
<?php // $this->endSection();?>
<?= $this->section('content'); ?>
    content...
    <?php // $session = \Config\Services::session(); ?>
    Welcome: <?php // $session->get('name'); ?>
    <a href="<?php // base_url('logout') ?>">Logout</a>
    
    <br>
    <?= current_url(); ?><br>
    <?= base_url('admin'); ?>
    
    <pre>
    <h2>User:</h2>
        <?php
    // print_r($user);
    print_r($entity);
    // print_r($items);
    ?>
    </pre>
<?= $this->endSection(); ?>