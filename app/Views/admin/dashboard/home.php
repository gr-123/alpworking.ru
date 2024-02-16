<?=$this->extend('admin/dashboard/layout'); ?>
<?= $this->section('content'); ?>
    content...
    
    <br>
    <?= current_url(); ?><br>
    <?= base_url('admin'); ?>
    
    <h2>Users</h2>
    <?php
    helper('html');
    echo htmlTable($items,null,["border"=>1]);
    ?>
<?= $this->endSection(); ?>