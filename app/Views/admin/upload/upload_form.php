<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('admin/dashboard/layout'); ?>
<?= $this->section('content'); ?>

<?= current_url(); ?><br>
<?= base_url('admin/image/upload'); ?><br>
app/Config/Validation.php: 'max_size[images,2048]', 'max_dims[images,1024,768]',

<style>
    output#preview {
        list-style: none;
        margin: 25px auto;
        padding: 0;
        display: block;
        max-width: 600px;
    }

    output#preview li {
        display: inline-block;
        margin: 0 10px 10px;
        max-width: 100px;
    }

    output#preview li img {
        width: 100%;
    }



    .item-photo__preview {
        width: 150px;
        height: 150px;
    }
</style>

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
                            'id' => 'files',
                            'name' => 'images[]',
                            // 'accept' => 'image/jpg, image/jpeg, image/png',
                            'accept' => 'image/*',
                            'multiple' => 'multiple',
                            'class' => 'form-control' . $class_err,
                        ];
                        echo form_upload($attributes);
                        ?>

                        <output id="preview"></output>

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
                                    foreach ($errors as $error) {
                                        echo esc($error);
                                    }
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

<script>
    function handleFileSelect(event) {
        // Check HTML5 File API Browser Support
        if (typeof window.File !== 'function' || typeof window.FileList !== 'function' || typeof window.FileReader !== 'function') {
            alert("Файловый API пока не поддерживается в этом браузере..");
        }

        var files = event.target.files; // FileList object
        var preview = document.getElementById("preview");
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (!file.type.match('image')) continue;
            var reader = new FileReader();
            reader.addEventListener("load", function(event) {
                var div = document.createElement("div");
                div.innerHTML = `
                        <img class='thumbnail' src='${event.target.result}' title='${escape(file.name)}'/>
                        <span>${file.name}</span>
                        `;
                preview.insertBefore(div, null);
            });
            reader.readAsDataURL(file);
        }
    }

    document.getElementById('files').addEventListener('change', handleFileSelect, false);
</script>

<?= $this->endSection(); ?>