<?= $this->extend('admin/dashboard/layout'); ?>
<?= $this->section('content'); ?>

<?php //echo $this->include('sidebar')
// CodeIgniter\View\View второй параметр — массив опций, не массив данных:
/**
 * Used within layout views to include additional views.
 * @param string     $view
 * @param array|null $options
 * @param null       $saveData
 * @return string
 */
// public function include(string $view, array $options = null, $saveData = true): string
// { return $this->render($view, $options, $saveData); }
?>

<?= current_url(); ?><br>
<?= base_url('admin/image/upload'); ?>
app/Config/Validation.php: // 'max_size[images,2048]', 'max_dims[images,1024,768]',



<?php $validation =  \Config\Services::validation(); // validation()->listErrors(); 
?>

<div class="container py-4">
    <hr>
    <div class="clear-fix py-2"></div>
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 m-auto">

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
                        // Input upload:
                        $class_err = '';
                        if ($validation->getError('images')) {
                            $class_err = ' is-invalid';
                        };
                        $attributes = [
                            'name' => 'images[]',
                            // 'accept' => 'image/jpg, image/jpeg, image/png',
                            'multiple' => 'multiple',
                            'class' => 'form-control' . $class_err,
                        ];
                        echo form_upload($attributes);
                        ?>

                        <?php if ($validation->getError('images')) : ?>
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

            <!-- Close Form: -->
            <?php echo form_close(); ?>
        </div>



        <?php // Если есть ошибки: 
        ?>

        <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
            <div class="card rounded-0 shadow">
                <div class="card-header">
                    <div class="card-title h4 mb-0 fw-bolder">

                        <?php
                        // функция вернет любые сообщения об ошибках, отправленные валидатором, хранящиеся в сеансе.
                        // print_r(validation_errors());
                        // print_r(validation_list_errors());

                        // Чтобы сохранить ошибки проверки в сеансе, вам необходимо использовать redirect() with withInput():
                        // if (! $this->validateData($data, $rules)) {
                        //     return redirect()->back()->withInput();
                        // }

                        // Flashdata: 
                        // доступны только для следующего запроса, а затем автоматически удаляются
                        ?>

                        <?php if (session()->getFlashdata('errors')) : ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                                <?php echo esc(session()->getFlashdata()) ?>
                            </div>
                        <?php elseif (!empty($errors)) : ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                                <!-- if (isset($errors) && ! empty($errors) && is_array($errors) && $errors !==FALSE) :  -->
                                                    
                                        <?php 
                                        if (is_array($errors)) {
                                            foreach ($errors as $error) { echo esc($error); }
                                        } else {
                                           echo esc($errors);
                                        }
                                         ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>