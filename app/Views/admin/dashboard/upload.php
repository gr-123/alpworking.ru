<?=$this->extend('admin/dashboard/layout'); ?>
<?php // $this->section("title");?>
<?php // $page_title;?>
<?php // $this->endSection();?>
<?= $this->section('content'); ?>
    content...

    <br>
    <?= current_url(); ?><br>
    <?= base_url('admin/image/upload'); ?>

    <div class="container py-4">
      <?php $validation =  \Config\Services::validation(); ?>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 m-auto">

<!-- почему бы не использовать некоторые встроенные функции 
вспомогательной библиотеки form, если вы создаете свой проект в CodeIgniter 4? -->
	<?php // form_open_multipart(base_url('home/forms'));?><!-- form_open_multipart() принимает до 3 параметров -->
	<?php // form_label('My File Upload', 'my_file');?>
	<br>
	<?php // form_upload(['id' => 'my_file', 'name' => 'my_file']);?><!-- form_upload() принимает до 3 параметров -->
	<?php // form_close();?>

<?php // d(session()->getFlashdata());?>


<?php 
    if(session()->has('message')) { session()->getFlashdata('message'); } ?>
<?php // File preview
if(session()->has('filename')){ ?>
<?php if(session()->getFlashdata('extension') == 'jpg' || session()->getFlashdata('extension') == 'jpeg'){ ?>
    <img src="<?= session()->getFlashdata('filename') ?>" with="200px" height="200px"><br>
<?php }else{ ?>
    <a href="<?= session()->getFlashdata('filename') ?>">Click Here..</a>
<?php } } ?>

<?php 
$name = $_SESSION['name'];
// or:
$name = $session->name;
// or:
$name = $session->get('name'); // Метод get()возвращает значение null, если элемент, к которому вы пытаетесь получить доступ, не существует.
// Или даже через вспомогательный метод сеанса:
$name = session('name');
// Если вы хотите получить все существующие данные сеанса
$userData = $_SESSION;
// or:
$userData = $session->get();
// Важный
// Метод get()БУДЕТ возвращать элементы flashdata или tempdata при получении одного элемента по ключу. Однако он не будет возвращать флэш-данные или временные данные при получении всех данных из сеанса.

// убедиться, что значение сеанса существует
if (isset($_SESSION['some_name'])) {
    // ...
}
// Или 
$session->has('some_name');
 ?>


                <form method="POST" action="<?= base_url('admin/image/upload') ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- display flash data message -->
                    <?php
                        if(session()->getFlashdata('success')):?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                                <?php echo session()->getFlashdata('success') ?>
                            </div>
                        <?php elseif(session()->getFlashdata('failed')):?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                                <?php echo session()->getFlashdata('failed') ?>
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

                <?php if(session()->getFlashdata('previewImage')):?>
                        <div class="form-group py-4">
                        <h5 class="py-2">Image Preview</h5>
                            <?php foreach(session()->getFlashdata('previewImage') as $image): ?>
                                <img src="<?php echo base_url('uploads/'.$image);?>" class="img-fluid" height="150px"/><br/><br/>
                            <?php endforeach; ?>
                        </div>
                <?php endif; ?>

                </div>
            </div>
        </div>
      </div>

<?= $this->endSection(); ?>