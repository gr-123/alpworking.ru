<?= $this->extend('layouts/default') ?>
<?= $this->section('title') ?>Подтверждение удаления<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="text-center mt-4 mb-4">Подтверждение удаления</h2>

    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col">Item id: '<?php echo esc($id, 'url'); ?>'</div>
                <div class="col text-right">

                    <?php
                    // echo form_open('email/send',['class' => 'email', 'id' => 'myform']);           // attributes
                    // echo form_open('/u/sign-up', ['csrf_id' => 'my-id']);                          // csrf
                    // echo form_open('email/send', '', ['username' => 'Joe', 'member_id' => '234']); // hidden
                    // form_hidden('id', 1);                                                          // hidden
                    ?>
                    <!-- Open Form: -->
                    <?= form_open(base_url('products/delete/' . esc($id, 'url'))) ?>
                    <?= csrf_field() ?>
                    <?php
                    $data = [
                        'name'    => 'delete_item',
                        'id'      => 'button',
                        'value'   => '',
                        'type'    => 'submit',
                        'class'   => 'btn btn-primary',
                        'content' => 'Удалить',
                    ];
                    // Button submit:
                    echo form_button($data);
                    ?>
                    <!-- Close Form: -->
                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>

        <div class="card-body">
            <div></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?php // $this->section("scripts")
?>
<?php // script_tag('public/assets/js/script.js') 
?>
<?php // $this->endSection()
?>