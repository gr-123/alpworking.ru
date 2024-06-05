<style>
    .text-success {
        font-size: xx-large;
        font-weight: 700;
    }

    label:hover {
        background: #eee;
        cursor: pointer;
    }
</style>
<div class="container col-md-3 col-md-offset-4 weli">
    <a href="<?= route_to('admin.calculator'); ?>">
        <p>Calculator</p>
    </a>

    <h2>Межпанельные швы</h2>

    <div class="form-group">
        <label for="ans">Answer</label>
        <div class="text-success"><?php echo (isset($ans)) ? $ans . ' руб./п.м.' : "Formula Calculator"; ?></div>
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

    <form name="sealing_price" action=<?= base_url('admin/calculator/sealing'); ?> method="post">
        <?= csrf_field() ?>
        <br>
        <div class="form-group">
            <label for="total_meters">Всего погонных метров:</label>
            <input type="number" class="form-control" name="total_meters" id="total_meters" placeholder="м.п." />
        </div>
        <div class="form-group">
            <label>Стоимость одного погонного метра (без стоимости материала):</label>
        </div>

        <p>
        <div class="form-group">
            <label><strong>Выбор герметика:</strong></label>
        </div>
        <div class="form-group">
            <input type="radio" name="germ" itemid="germ1" value="germ1" <?= set_radio('germ', 'germ1', true) ?> />
            <label for="germ1"><strong>1</strong> компонентный (<?= esc($germ1) ?>) руб./п.м.</label>
            <br>
            <input type="radio" name="germ" id="germ2" value="germ2" <?= set_radio('germ', 'germ2') ?> />
            <label for="germ2"><strong>2</strong>-х компонентный (<?= esc($germ2) ?>) руб./п.м.</label>
        </div>
        </p>

        <p>
        <div class="form-group">
            <label><strong>Выбор способа герметизации:</strong></label>
        </div>
        <div class="form-group">
            <input type="radio" name="repair_method" id="breakdown" value="breakdown" <?= set_radio('repair_method', 'breakdown', true) ?> />
            <label for="breakdown">С разбивкой швов (<?= esc($breakdown) ?>) руб./п.м.</label>
            <br>
            <input type="radio" name="repair_method" id="drilling" value="drilling" <?= set_radio('repair_method', 'drilling') ?> />
            <label for="drilling">Через сверление отверстий (<?= esc($drilling) ?>) руб./п.м.</label>
        </div>
        </p>

        <div class="form-group">
            <?php
            // echo form_checkbox('mycheckd', '1', false, set_checkbox('mycheckd', '1'));

            echo '<br>';
            echo form_checkbox(['name' => 'vilaterm', 'id' => 'vilaterm', 'style' => 'margin:10px',], 'vilaterm', false, set_checkbox('vilaterm', 'vilaterm', true));
            echo form_label("Вилатерм (" . esc($vilaterm) . ") руб./п.м.", 'vilaterm', ['class' => 'form-label', 'style' => '',]);

            echo form_checkbox(['name' => 'pena', 'id' => 'pena', 'style' => 'margin:10px',], 'pena', false, set_checkbox('pena', 'pena', true));
            echo form_label("Монтажная пена (" . esc($pena) . ") руб./п.м.", 'pena', ['class' => 'form-label', 'style' => '',]);

            echo "<p><strong>Опционально:</strong><br>";
            echo form_checkbox(['name' => 'sctch_lenta', 'id' => 'sctch_lenta', 'style' => 'margin:10px',], 'sctch_lenta', false, set_checkbox('sctch_lenta', 'sctch_lenta'));
            echo form_label("Скотч (" . esc($sctch_lenta) . ") руб./п.м.", 'sctch_lenta', ['class' => 'form-label', 'style' => '',]);

            echo form_checkbox(['name' => 'primer', 'id' => 'primer', 'style' => 'margin:10px',], 'primer', false, set_checkbox('primer', 'primer'));
            echo form_label("Грунтовка (" . esc($primer) . ") руб./п.м.", 'primer', ['class' => 'form-label', 'style' => '',]);
            echo '</p>';
            ?>

        </div>
</div>
<button type="submit" class="btn btn-default" name="add" value="Add">Submit</button>
</form>
</div>

<script>
    // Установка чекбоксов после выбора радио-кнопки для герметизации с разбивкой швов
    function checkBreakdown() {
        // Включаем:
        document.getElementById('pena').checked = true; // -- монтажная пена
        document.getElementById('vilaterm').checked = true; // -- вилатерм

        // Исключаем:
    }

    // Установка чекбоксов после выбора радио-кнопки для герметизации через сверление (без разбивки)
    function checkDrilling() {
        // Включаем:
        document.getElementById('pena').checked = true; // -- монтажная пена

        // Исключаем:
        document.getElementById('vilaterm').checked = false; // -- вилатерм

    }

    document.forms["sealing_price"].addEventListener('input', function(e) {
        switch (e.target.value) {
            case 'breakdown': // Если выбран пункт разбивка шва"
                checkBreakdown();
                break;
            case 'drilling': // Если выбран пункт "Утепление через сверление"
                checkDrilling();
                break;
        }
    });

    // if (document.querySelector('input[name="repair_method"]')) {
    //     // for
    //     for (let elem of document.querySelectorAll('input[type="radio"][name="repair_method"]')) {
    //         elem.addEventListener("input", function(e) {
    //             var item = event.target.value;
    //             console.log(item);
    //         });
    //     }
    //     // forEach
    //     document.querySelectorAll('input[name="repair_method"]').forEach((elem) => {
    //         elem.addEventListener("click", function(e) {
    //             var item = e.target.value;
    //             console.log(item);
    //         });
    //     });
    // }
</script>