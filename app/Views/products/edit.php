<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<h2><?= esc($title_page . ": '$product->title'") ?></h2>

<div class="main">

    <!-- 
        session() 
            Функция session() используется для получения объекта Session, а 
            session()->getFlashdata('error') используется для 
            отображения пользователю ошибки, связанной с защитой CSRF. 
            Однако по умолчанию, если проверка CSRF не удалась, будет выдано исключение, поэтому оно пока не работает. 
            Дополнительную информацию см. в разделе «Перенаправление в случае сбоя». 
            https://codeigniter.com/user_guide/libraries/security.html#csrf-redirection-on-failure

        validation_list_errors()
            Функция validation_list_errors(), предоставляемая помощником формы, используется для 
            сообщения об ошибках, связанных с проверкой формы.
         -->
    <?= session()->getFlashdata('error') ?>
    <?= validation_list_errors() ?>


    <form action="/products/update/<?= $product->id ?>" method="post">
        <?= csrf_field() ?>

        <label for="title">Title</label><input type="input" name="title" value="<?= set_value('title', $product->title) ?>"><br>

        <label for="name">Name</label><?php echo form_input('name', set_value('name', $product->name)); ?><br>
        <!-- Третий (необязательный) параметр позволяет отключить HTML-экранирование значения, если вам нужно использовать эту функцию в сочетании с ie, form_input()и избежать двойного экранирования. -->        

        <label for="price">Price</label><?php echo form_input('price', set_value('price', $product->price), ['placeholder' => '0.00']); ?><br>

        <label for="content">Content</label><textarea name="content" cols="45" rows="4"><?= set_value('content', $product->content) ?></textarea><br>
        <!-- form_textarea .......................  -->

        <input type="submit" name="submit" value="Update products item">
    </form>

</div>

<?= $this->endSection() ?>
<?php // $this->section("scripts")?>
<?php // script_tag('public/assets/js/script.js') ?>
<?php // $this->endSection()?>