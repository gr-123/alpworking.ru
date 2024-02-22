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
 ?>

<?php session()->getFlashdata() ?>
<!-- Эта функция вернет любые сообщения об ошибках, отправленные валидатором. 
Если сообщений нет, возвращается пустая строка. -->
<?= validation_list_errors() ?>
<?php
                // Это возвращает массив с именами полей и связанными с ними ошибками, который можно использовать для отображения всех ошибок в верхней части формы или для отображения их по отдельности:
                // <?php if (! empty($errors)): V>
                //     <div class="alert alert-danger">
                //     <?php foreach ($errors as $field => $error): V>
                //         <p><?= esc($error) V></p>
                //     <?php endforeach V>
                //     </div>
                // <?php endif v>
 ?>

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

<div class="card shadow">
    <div class="card-header">
        <h5 class="card-title">Загрузка нескольких файлов</h5>
                        </div>

                        <div class="card-body p-4">
                            <div class="form-group mb-3 has-validation">
                                <label class="form-label">Images</label>
                                <?php 
                                // $attributes = [
                                //     'class' => 'mycustomclass',
                                //     'style' => 'color: #000;',
                                // ];
                                // echo form_label('What is your Name', 'username', $attributes);
                                // Would produce:  <label for="username" class="mycustomclass" style="color: #000;">What is your Name</label> ?>
<?= form_upload('images[]','','multiple') ?>

<input type="file" class="form-control <?php if($validation->getError('images')): ?>is-invalid<?php endif ?>" name="fileimages[]" multiple="multiple"/>
                                <?php if ($validation->getError('images')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('images') ?>
                                    </div>                                
                                <?php endif; ?>
                            </div>
                        </div>

<div class="card-footer">
<button type="submit" class="btn btn-primary">Upload</button>
<?= form_submit('submit','Upload') ?>
                        </div>
                    </div>
<?= form_close() ?>
                <?php
                // $string = '</div></div>';
                // echo form_close($string);
                // Would produce:  </form> </div></div> ?>



                <form method="POST" action="<?= base_url('admin/image/upload') ?>" enctype="multipart/form-data">
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

                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="card-title">Upload Images</h5>
                        </div>

                        <div class="card-body p-4">
                            <div class="form-group mb-3 has-validation">
                                <label class="form-label">Images</label>
                                <input type="file" class="form-control <?php if($validation->getError('images')): ?>is-invalid<?php endif ?>" name="fileimages[]" multiple="multiple"/>
                                <?php if ($validation->getError('images')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('images') ?>
                                    </div>                                
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </form>

                
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





                <?php if(session()->getFlashdata('previewImage')):?>
                    <div class="form-group py-4">
                    <h5 class="py-2">Image Preview</h5>
                        <?php foreach(session()->getFlashdata('previewImage') as $image): ?>
                            <img src="<?php echo base_url('uploads/'.$image);?>" class="img-fluid" height="150px"/><br/><br/>
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

<?= $this->endSection(); ?>