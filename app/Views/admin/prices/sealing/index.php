<style type="text/css">
    .text-success {
        font-size: xx-large;
        font-weight: 700;
    }

    table {
        /* использовать 'border-collapse: collapse', это предотвратит двойную границу вашей границы, поскольку table, tr и td будут иметь границу */
        border-collapse: collapse;
        border: 1px solid black;
    }

    table td {
        border: 1px solid black;
        padding-left: 5px;
        padding-right: 5px;
        padding-bottom: 3px;
    }

    table th {
        border: 1px solid black;

        font-size: 25px;
        font-weight: bold;
        padding-left: 5px;
        padding-right: 5px;
        padding-bottom: 3px;
    }
</style>

<div class="container col-md-3 col-md-offset-4 weli">
    <a href="<?= route_to('admin.prices'); ?>">
        <p>Prices</p>
    </a>

    <?php
    // Успешный ответ обновления цен прайс-листа при перенаправлении из метода контроллера update()
    // return redirect()->route('admin.prices.sealing')->withInput()->with('success', 'Success! Update prices.')
    ?>
    <?php if (session()->has('success') && !empty(session()->getFlashdata('success'))) : ?>
        <div class="form-group">
            <div class="text-success"><?= esc(session()->getFlashdata('success')) ?></div>
        </div>
    <?php endif ?>

    <div class="form-group">
        <h2>Стоимость работ по герметизации межпанельных швов</h2>
    </div>

    <table id="table_1" summary="This table has both labels and values">
        <caption>1 п.м. (без стоимости материала)</caption>
        <tr>
            <th><?= esc($germ1) ?></th>
            <td>Герметизация 1-комп.герметиком</td>
        </tr>
        <tr>
            <th><?= esc($germ2) ?></th>
            <td>Герметизация 2-комп.герметиком</td>
        </tr>
        <tr>
            <th><?= esc($vilaterm) ?></th>
            <td>Укладка вилатерма</td>
        </tr>
        <tr>
            <th><?= esc($pena) ?></th>
            <td>Утепление монтажной пеной</td>
        </tr>
        <tr>
            <th><?= esc($primer) ?></th>
            <td>Грунтование швов перед герметизацией</td>
        </tr>
        <tr>
            <th><?= esc($breakdown) ?></th>
            <td>Разбивка межпанельного шва</td>
        </tr>
        <tr>
            <th><?= esc($drilling) ?></th>
            <td>Утепление через бурение с просверливанием отверстий в межпанельном шве</td>
        </tr>
        <tr>
            <th><?= esc($sctch_lenta) ?></th>
            <td>Ровные линии шва по малярному скотчу</td>
        </tr>
        <tr>
            <th><?= esc($mount_sctch_lenta1) ?></th>
            <td>Наклеивание скотч ленты с одной стороны</td>
        </tr>
        <tr>
            <th><?= esc($mount_sctch_lenta2) ?></th>
            <td>Наклеивание скотч ленты с двух сторон</td>
        </tr>
        <tr>
            <th><?= esc($remove_sctch_lenta1) ?></th>
            <td>Снятие скотч ленты с одной стороны</td>
        </tr>
        <tr>
            <th><?= esc($remove_sctch_lenta2) ?></th>
            <td>Снятие скотч ленты с двух сторон</td>
        </tr>
    </table>

    <br>
    <div class="form-group">
        <form action="<?= url_to('\App\Controllers\Admin\SealingpriceController::update') ?>">
            <button type="submit" value="update">Редактировать</button>
        </form>
    </div>

</div>