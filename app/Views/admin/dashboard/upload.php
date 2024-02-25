<?=$this->extend('admin/dashboard/layout'); ?>
<?= $this->section('content'); ?>
    <?= current_url(); ?><br>
    <?= base_url('admin/image/upload'); ?>

    <div class="container py-4">
      <?php $validation =  \Config\Services::validation(); ?>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 m-auto">

<?php 
    // if(session()->has('message')) { session()->getFlashdata('message'); } ?>
<?php // File preview
// if(session()->has('filename')){ ?>
<?php //if(session()->getFlashdata('extension') == 'jpg' || session()->getFlashdata('extension') == 'jpeg'){ ?>
    <img src="<?php //session()->getFlashdata('filename') ?>" with="200px" height="200px"><br>
<?php // }else{ ?>
    <!-- <a href="<?php //session()->getFlashdata('filename') ?>">Click Here..</a> -->
<?php //} } ?>

<?php if(session()->has("message")){ echo session("message"); } // проверяем, существует ли ключ сообщения или нет.?>

<?php 
// $name = $_SESSION['name'];// or: 
// $name = $session->name; // or: 
// $name = $session->get('name'); // Метод get()возвращает значение null, если элемент, к которому вы пытаетесь получить доступ, не существует. Или даже через вспомогательный метод сеанса:
// $name = session('name');
// Если вы хотите получить все существующие данные сеанса
// $userData = $_SESSION; // or:
// $userData = $session->get();
// Важный
// Метод get()БУДЕТ возвращать элементы flashdata или tempdata при получении одного элемента по ключу. Однако он не будет возвращать флэш-данные или временные данные при получении всех данных из сеанса.

// убедиться, что значение сеанса существует
// if (isset($_SESSION['some_name'])) { // ... } // Или 
// $session->has('some_name');


                    // $session->set($data); // или по одному значению за раз: $session->set('some_name', 'some_value');
                    // $session->push('hobbies', ['sport' => 'tennis']); // добавить в массив новое значение
                    // Flashdata: 
                    // доступны только для следующего запроса, а затем автоматически удаляются
                    // метод getFlashdata(): если вы хотите быть уверены, что читаете «флэш-данные» (а не какие-либо другие)
                    // $session->getFlashdata('item'); // null, если элемент не найден
                    // $session->getFlashdata(); // массив со всеми флэш-данными
 ?>

<?php session()->getFlashdata() ?>
<!-- Эта функция вернет любые сообщения об ошибках, отправленные валидатором. 
Если сообщений нет, возвращается пустая строка. -->
<?= validation_list_errors() ?>
<!-- PHP ничего не разделяет между запросами. Поэтому при перенаправлении в случае сбоя проверки в перенаправленном 
запросе не будет ошибок проверки, поскольку проверка выполнялась в предыдущем запросе.

В этом случае вам нужно использовать вспомогательную функцию формы validation_errors()
и validation_list_errors(). validation_show_error()
Эти функции проверяют ошибки проверки, хранящиеся в сеансе.

Чтобы сохранить ошибки проверки в сеансе, вам необходимо использовать redirect() with withInput():
// In Controller.
if (! $this->validateData($data, $rules)) {
    return redirect()->back()->withInput();
}

Настройка отображения ошибок
https://codeigniter.com/user_guide/libraries/validation.html#customizing-error-display

-->
<!-- 
    Новое в версии 4.3.0.
    https://codeigniter4.github.io/userguide/helpers/form_helper.html#validation_errors

    <?php //$errors = validation_errors(); // validation_list_errors() // validation_show_error('username')
// не работает с проверкой в ​​модели . Если вы хотите получить ошибки проверки 
// при проверке модели           https://codeigniter4.github.io/userguide/models/model.html#in-model-validation 
// см. Получение ошибок проверки https://codeigniter4.github.io/userguide/models/model.html#model-getting-validation-errors

?>
-->
<!-- Настройка отображения ошибок https://codeigniter.com/user_guide/libraries/validation.html#customizing-error-display -->
<?php if (isset($error)) : ?>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
<?php endif; ?>

<!-- https://codeigniter.com/user_guide/helpers/form_helper.html#form_open -->
<!-- https://codeigniter4.github.io/userguide/helpers/form_helper.html#form_open_multipart -->
<?= form_open_multipart(base_url('admin/image/upload')) ?>
<?= csrf_field() ?>

<!-- display flash data message -->
<?php
    if(session()->getFlashdata('success')):?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
            <b><?php echo session()->getFlashdata('success') ?></b>
        </div>
    <?php elseif(session()->getFlashdata('failed')):?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
            <?php echo session()->getFlashdata('failed') ?>
            <ul>
            <?php foreach (session()->getFlashdata('failed')  as $field => $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
            </ul>
        </div>
<?php endif; ?>



<?php $class_err = ''; ?>
<?php if($validation->getError('images')) { $class_err = ' is-invalid'; }; ?>

<div class="card shadow">
    <div class="card-header">
        <h5 class="card-title">Загрузка нескольких файлов</h5>
    </div>

    <div class="card-body p-4">
        <div class="form-group mb-3 has-validation">

            <?php
            echo form_label('Images', '', ['class' => 'form-label',]);
            $attributes = [
                'name' => 'images[]',
                // 'accept' => 'image/jpg, image/jpeg, image/png',
                'multiple' => 'multiple',
                'class' => 'form-control' . $class_err,
            ];
            echo form_upload($attributes); 
            ?>
    
            <?php if ($validation->getError('images')): ?>
                <div class="invalid-feedback">
                    <?= $validation->getError('images') ?>
                </div>                                
            <?php endif; ?>
        </div>
    </div>

    <div class="card-footer">
        <?php
        $data = [
            'name'    => 'images_upload',
            'id'      => 'button',
            'value'   => 'Upload Images',
            'type'    => 'submit',
            'class'   => 'btn btn-primary',
            'content' => 'Upload',
        ];
        echo form_button($data);
        ?>
    </div>
</div>
<?php echo form_close(); ?>

<?php if(session()->getFlashdata('previewImage')):?>
    <div class="form-group py-4">
    <h5 class="py-2">Image Preview</h5>
        <?php foreach(session()->getFlashdata('previewImage') as $image): ?>
            <img src="<?php echo base_url('assets/images/thumbnails/'.$image);?>" class="img-fluid" height="150px"/><br/><br/>
        <?php endforeach; ?>
    </div>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Filename</th>
                <th>Filepath</th>
                <th>File Type</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach (session()->getFlashdata('previewImage') as $fileUpload):?>
            <tr>
                <td><?= $fileUpload->imagename ?></td>
                <td>filepath...</td>
                <td>type...</td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
<?php endif; ?>

            </div>
        </div>
    </div>
</div>
       
<!-- как получить горизонтальные продукты в Ci4, сэр, 😶я хочу отображать их в динамической сетке на главной странице?
.container
    .row
       your foreach loop
       . col-md-4
          product details. 
      /
    endforeach;
   /
/
 -->
<?= $this->endSection(); ?>