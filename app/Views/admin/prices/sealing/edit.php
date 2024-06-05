<style>
    .text-success {
        font-size: xx-large;
        font-weight: 700;
    }

    label:hover {
        background: #eee;
        cursor: pointer;
    }

    form input {
        font-size: 14pt;
        font-weight: bold;
        /* height: 150px; */
        width: 100px;
    }
</style>
<div class="container col-md-3 col-md-offset-4 weli">
    <h2>Стоимость работ по герметизации межпанельных швов</h2>

    <?= validation_list_errors() ?>

    <div class="form-group">
        <div class="alert alert-danger alert-dismissible">
            <?php if (isset($errors) && $errors !== []) : ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                <div class="errors" role="alert">
                    <ul>
                        <?php if (is_array($errors)) : ?>
                            <?php foreach ($errors as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        <?php else : ?>
                            <?php echo esc($errors); ?>
                        <?php endif ?>
                    </ul>
                </div>
            <?php endif ?>
        </div>
    </div>

    <form name="sealing_price" action=<?= base_url('admin/prices/sealing/update'); ?> method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <input type="number" class="form-control" name="germ1" id="germ1" placeholder=<?= esc($germ1) ?> />
            <label for="germ1">Герметизация 1-комп.герметиком</label>
        </div>
        <br>
        <div class="form-group">
            <input type="number" class="form-control" name="germ2" id="germ2" placeholder=<?= esc($germ2) ?> />
            <label for="germ2">Герметизация 2-комп.герметиком</label>
        </div>
        <br>
        <div class="form-group">
            <input type="number" class="form-control" name="vilaterm" id="vilaterm" placeholder=<?= esc($vilaterm) ?> />
            <label for="vilaterm">Укладка вилатерма</label>
        </div>
        <br>
        <div class="form-group">
            <input type="number" class="form-control" name="pena" id="pena" placeholder=<?= esc($pena) ?> />
            <label for="pena">Утепление монтажной пеной</label>
        </div>
        <br>
        <div class="form-group">
            <input type="number" class="form-control" name="primer" id="primer" placeholder=<?= esc($primer) ?> />
            <label for="primer">Грунтование швов перед герметизацией</label>
        </div>
        <br>
        <div class="form-group">
            <input type="number" class="form-control" name="breakdown" id="breakdown" placeholder=<?= esc($breakdown) ?> />
            <label for="breakdown">Разбивка межпанельного шва</label>
        </div>
        <br>
        <div class="form-group">
            <input type="number" class="form-control" name="drilling" id="drilling" placeholder=<?= esc($drilling) ?> />
            <label for="drilling">Утепление через бурение с просверливанием отверстий в межпанельном шве</label>
        </div>
        <br>
        <div class="form-group">
            <input type="number" class="form-control" name="sctch_lenta" id="sctch_lenta" placeholder=<?= esc($sctch_lenta) ?> />
            <label for="sctch_lenta">Ровные линии шва по малярному скотчу</label>
        </div>
        <br>
        <div class="form-group">
            <input type="number" class="form-control" name="mount_sctch_lenta1" id="mount_sctch_lenta1" placeholder=<?= esc($mount_sctch_lenta1) ?> />
            <label for="mount_sctch_lenta1">Наклеивание скотч ленты с одной стороны</label>
        </div>
        <br>
        <div class="form-group">
            <input type="number" class="form-control" name="mount_sctch_lenta2" id="mount_sctch_lenta2" placeholder=<?= esc($mount_sctch_lenta2) ?> />
            <label for="mount_sctch_lenta2">Наклеивание скотч ленты с двух сторон</label>
        </div>
        <br>
        <div class="form-group">
            <input type="number" class="form-control" name="remove_sctch_lenta1" id="remove_sctch_lenta1" placeholder=<?= esc($remove_sctch_lenta1) ?> />
            <label for="remove_sctch_lenta1">Снятие скотч ленты с одной стороны</label>
        </div>
        <br>
        <div class="form-group">
            <input type="number" class="form-control" name="remove_sctch_lenta2" id="remove_sctch_lenta2" placeholder=<?= esc($remove_sctch_lenta2) ?> />
            <label for="remove_sctch_lenta2">Снятие скотч ленты с двух сторон</label>
        </div>
        <br>

        <button type="submit" class="btn btn-default" name="add" value="Add">Submit</button>
    </form>
</div>