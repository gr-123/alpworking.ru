<h3>Подтверждение удаления</h3>

"<?php echo esc($id, 'url'); ?>":

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
    'content' => 'Delete Item',
];
// Button submit:
echo form_button($data);
?>

<!-- Close Form: -->
<?php echo form_close(); ?>



<?php // $this->section("scripts")
?>
<?php // script_tag('public/assets/js/script.js') 
?>
<?php // $this->endSection()
?>