<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('admin/dashboard/layout'); ?>
<?= $this->section('content'); ?>

TODO:
<br>Вывод и редактирование категорий для прайса
<br>Создание новостей https://codeigniter.com/user_guide/tutorial/create_news_items.html
<br>
<br>

<br>
<br>
<?= current_url(); ?><br>
<?= base_url('admin/manager'); ?>
<?= $this->endSection(); ?>