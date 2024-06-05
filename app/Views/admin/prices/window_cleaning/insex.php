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
    <h2>Межпанельные швы</h2>

    <div class="form-group">
        <label for="ans">Answer</label>
        <div class="text-success"><?php echo (isset($ans)) ? $ans : "Formula Calculator"; ?></div>
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

    <form name="sealing_price" action=<?= base_url('admin/calculator/add'); ?> method="post">
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
            <input type="radio" name="germ" itemid="germ1" value="germ1" checked=true />
            <label for="germ1"><strong>1</strong> компонентный (100 руб.)</label>
            <br>
            <input type="radio" name="germ" id="germ2" value="germ2" />
            <label for="germ2"><strong>2</strong>-х компонентный (195 руб.)</label>
        </div></p>

        <p>
        <div class="form-group">
            <label><strong>Выбор способа герметизации:</strong></label>
        </div>
            <div class="form-group">
                <input type="radio" name="repair_method" id="breakdown" value="breakdown" checked=true />
                <label for="breakdown">С разбивкой швов</label>
                <br>
                <input type="radio" name="repair_method" id="drilling" value="drilling" />
                <label for="drilling">Через сверление отверстий</label>
            </div></p>

        <div class="form-group">
            <?php
            echo form_checkbox(['name' => 'vilaterm', 'id' => 'vilaterm', 'value' => 'vilaterm', 'checked' => true, 'style' => 'margin:10px',]);
            echo form_label('Вилатерм руб./п.м.', 'vilaterm', ['class' => 'form-label', 'style' => '',]);

            echo form_checkbox(['name' => 'pena', 'id' => 'pena', 'value' => 'pena', 'checked' => true, 'style' => 'margin:10px',]);
            echo form_label('Монтажная пена руб./п.м.', 'pena', ['class' => 'form-label', 'style' => '',]);

            echo "<p><strong>Опционально:</strong><br>";
            echo form_checkbox(['name' => 'sctch_lenta', 'id' => 'sctch_lenta', 'value' => 'sctch_lenta', 'style' => 'margin:10px',]);
            echo form_label('Скотч', 'sctch_lenta', ['class' => 'form-label', 'style' => '',]);

            echo form_checkbox(['name' => 'primer', 'id' => 'primer', 'value' => 'primer', 'style' => 'margin:10px',]);
            echo form_label('Грунтовка', 'primer', ['class' => 'form-label', 'style' => '',]);
            echo '</p>';
            ?>
        </div>
</div>
<button type="submit" class="btn btn-default" name="add" value="Add">Submit</button>
</form>
</div>

<script>
    // Установка чекбоксов после выбора радиокнопки для герметизации с разбивкой швов
    function checkBreakdown() {
        // Включаем:
        document.getElementById('pena').checked = true; // -- монтажная пена
        document.getElementById('vilaterm').checked = true; // -- вилатерм

        // Исключаем:
    }

    // Установка чекбоксов после выбора радиокнопки для герметизации через сверление (без разбивки)
    function checkDrilling() {
        // Включаем:
        document.getElementById('pena').checked = true; // -- монтажная пена

        // Исключаем:
        document.getElementById('vilaterm').checked = false; // -- вилатерм

    }

    document.forms["sealing_price"].addEventListener('input', function(e) {
        switch (e.target.value) {
            case 'breakdown':
                // Если выбран пункт разбивка шва"
                checkBreakdown();
                break;
            case 'drilling':
                // Если выбран пункт "Утепление через сверление"
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