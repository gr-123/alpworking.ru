<h3>Подтверждение удаления</h3>

"<?php echo esc($id, 'url'); ?>":

<!-- Open Form: -->
<?php echo form_open(base_url('products/delete/' . esc($id, 'url'))) ?>

    <?= csrf_field() ?>
    
    <?php
    $data = [
        'name'    => 'delete_item',
        'id'      => 'button',
        'value'   => '',
        'type'    => 'submit',
        'class'   => 'btn btn-primary',
        'content' => 'Delete Item',
    ];
    // Button submit:
    echo form_button($data);
    ?>

<!-- Close Form: -->
<?php echo form_close(); ?>



<?php // $this->section("scripts")?>
<?php // script_tag('public/assets/js/script.js') ?>
<?php // $this->endSection()
?>