<?=$this->extend('admin/dashboard/layout'); ?>
<?= $this->section('content'); ?>
<?php //echo $this->include('sidebar')
// CodeIgniter\View\View второй параметр — массив опций, не массив данных:
/**
 * Used within layout views to include additional views.
 *
 * @param string     $view
 * @param array|null $options
 * @param null       $saveData
 *
 * @return string
 */
// public function include(string $view, array $options = null, $saveData = true): string
// {
//     return $this->render($view, $options, $saveData);
// }
?>
    <?= current_url(); ?><br>
    <?= base_url('admin/image/upload'); ?>
    app/Config/Validation.php: // 'max_size[images,2048]', 'max_dims[images,1024,768]',

<?php $validation =  \Config\Services::validation(); ?>
<div class="container py-4">
    <hr>
    <div class="clear-fix py-2"></div>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 m-auto">

<?php 
// функция вернет любые сообщения об ошибках, отправленные валидатором, хранящиеся в сеансе.
// print_r(validation_errors());
// print_r(validation_list_errors());
// <ul>
// foreach (session()->getFlashdata('failed') as $key => $var)
//     <li>echo esc($var)</li>
// endforeach
// </ul>

// Чтобы сохранить ошибки проверки в сеансе, вам необходимо использовать redirect() with withInput():
// if (! $this->validateData($data, $rules)) {
//     return redirect()->back()->withInput();
// }

// Flashdata: 
// доступны только для следующего запроса, а затем автоматически удаляются
if(session()->has('message')) { echo esc(session()->getFlashdata('message')); }
?>

<?php if(session()->getFlashdata('success')) : ?>
<div class="alert alert-success alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
    <b><?php echo esc(session()->getFlashdata('success')) ?></b>
</div>
<?php elseif(session()->getFlashdata('failed')) : ?>
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
    <?php echo esc(session()->getFlashdata('failed')) ?>
</div>
<?php elseif(! empty($errors)) : ?>
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
    <!-- if (isset($errors) && ! empty($errors) && is_array($errors) && $errors !==FALSE) :  -->
    <?php if ( ! empty($errors)) { foreach ($errors as $error) { ?><li><?= esc($error) ?></li><?php } ?><?php } ?>
</div>
<?php endif; ?>

<?php $class_err = ''; if($validation->getError('images')) { $class_err = ' is-invalid'; }; ?>



<!-- Open Form: -->
<?= form_open_multipart(base_url('admin/image/upload')) ?>
<?= csrf_field() ?>

<div class="card shadow">
    <div class="card-header">
        <h5 class="card-title">Загрузка нескольких файлов</h5>
    </div>

    <div class="card-body p-4">
        <div class="form-group mb-3 has-validation">

            <?php
            // Label:
            echo form_label('Images', '', ['class' => 'form-label',]);
            $attributes = [
                'name' => 'images[]',
                // 'accept' => 'image/jpg, image/jpeg, image/png',
                'multiple' => 'multiple',
                'class' => 'form-control' . $class_err,
            ];
            // Input upload:
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
            'content' => 'Загрузить',
        ];
        // Button submit:
        echo form_button($data);
        ?>
        
    </div>
</div>

<?php 
// Close Form:
echo form_close(); ?>

</div>

<div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
<div class="card rounded-0 shadow">
<div class="card-header">
    <div class="card-title h4 mb-0 fw-bolder">Uploaded Files</div>
</div>
<div class="card-body">
    <div class="container-fluid">
        <table class="table table-striped table-bordered">
            <colgroup>
                <col width="10%">
                <col width="20%">
                <col width="50%">
                <col width="20%">
            </colgroup>
            <thead>
                <tr class="bg-primary bg-gradient text-light">
                    <th class="p-1 text-center">№</th>
                    <th class="p-1 text-center">img</th>
                    <th class="p-1 text-center">name</th>
                    <th class="p-1 text-center"></th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($images) && ! empty($images)): ?>
                <?php 
                $i = 1;
                foreach($images as $img):
                ?>
                <tr>
                    <td class="px-2 py-1 align-middle text-center"><?= number_format($i++) ?></td>
                    <td class="px-2 py-1 align-middle"><img src="<?php echo base_url($thumbs . '/' . $img);?>" class="img-fluid" height="150px"/></td>
                    <td class="px-2 py-1 align-middle"><p class="m-0 text-truncate" title="<?= $img ?>"><?= $img ?></p></td>
                    <td class="px-2 py-1 align-middle text-center">
                        <a href="<?= $thumbs . '/' . $img ?>" class="text-muted text-decoration-none mx-2" target="_blank" title="View File"><i class="fa fa-external-link"></i></a>
                        <a href="<?= base_url($thumbs . '/' . $img) ?>" class="text-primary fw-bolder text-decoration-none mx-2" target="_blank" title="Download File" download="<?= $img ?>"><i class="fa fa-download"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                <?php if(!isset($images) || (isset($images) && count($images) <= 0)): ?>
                    <tr>
                        <th colspan="4" class="p-1 text-center">No records found</th>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
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
    <?= $this->section('javascript') ?>
       <!-- let a = 'a'; -->
    <?= $this->endSection() ?>
<?= $this->endSection(); ?>