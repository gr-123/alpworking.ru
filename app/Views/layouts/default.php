<!DOCTYPE html>
<html lang="en">

<!-- 
    Интеграция темы Bootstrap в CodeIgniter 4
    https://www.phpflow.com/php/bootstrap-theme-integration-into-codeigniter-4/

    https://www.webslesson.info/2020/10/codeigniter-4-crud-tutorial.html
 -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <title>Высотные работы | <?= $this->renderSection('title') ?></title>

    <!-- bootstrap <version> CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <!-- 
    ??
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"> -->

    <!-- <link rel="stylsheet" href="<?= base_url('public/assets/css/style.css') ?>"/> -->
    <?php // link_tag('public/assets/css/style.css') 
    ?>
</head>

<body>
    <!--Area for dynamic content -->
    <?= $this->renderSection("content"); ?>

    <!-- <script src="<?= base_url('public/assets/js/script.js') ?>"></script> -->
    <?php // script_tag('public/assets/js/script.js') 
    ?>
    <!-- bootstrap <version> bundle JS -->
    <!-- 
    ??
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script> -->
</body>

</html>

<style>
    .pagination li a {
        position: relative;
        display: block;
        padding: .5rem .75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }

    .pagination li.active a {
        z-index: 1;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
</style>