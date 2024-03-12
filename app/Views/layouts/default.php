<html>
<!-- 
    Интеграция темы Bootstrap в CodeIgniter 4
    https://www.phpflow.com/php/bootstrap-theme-integration-into-codeigniter-4/

    https://www.webslesson.info/2020/10/codeigniter-4-crud-tutorial.html
 -->
     <head>

        <title>Site Title</title>
        
        <!-- <link rel="stylsheet" href="<?= base_url('public/assets/css/style.css') ?>"/> -->
        <?php // link_tag('public/assets/css/style.css') ?>

     </head>

     <body>
        <!--Area for dynamic content -->
        <?= $this->renderSection("content"); ?>

  
        <!-- <script src="<?= base_url('public/assets/js/script.js') ?>"></script> -->
        <?php // script_tag('public/assets/js/script.js') ?>
     <body>

</html>