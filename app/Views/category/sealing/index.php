<?php

/**
 * @var CodeIgniter\View\View $this
 */
?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="text-center mt-4 mb-4"><?= esc($title) ?></h2>

    <div class="card">
        <h5>Примеры выполнленных работ</h5>
        <?php
        $cols = 4; // столбцы
        $k = 0;
        ?>
        <table>
            <?php for ($i = 0; $i < \count($images); $i++) : ?>
                <?php $item = $images[$i]; // данные одного изображения            
                ?>
                <?php if ($k % $cols == 0) : ?>
                    <tr>
                    <?php endif; ?>
                    <td>
                        <figure class="images">
                            <p><a href='<?php echo $item->name; ?>'><img src='<?php echo $item->name; ?>' height="20" width="20" /></a></p>
                            <figcaption class="description">
                                <i><?php echo $item->caption; ?></i>
                            </figcaption>
                        </figure>
                    </td>
                    <?php /* Закрываем строку, если необходимое количество было выведено, либо данная итерация последняя */ ?>
                    <?php if ((($k + 1) % $cols == 0) || (($i + 1) == \count($images))) : ?>
                    </tr>
                <?php endif; ?>
                <?php $k++; ?>
            <?php endfor; ?>
        </table>
    </div>

    <?= $this->endSection() // 'content' 
    ?>
    <?php // $this->section("scripts")
    ?>
    <?php // script_tag('public/assets/js/script.js') 
    ?>
    <?php // $this->endSection()
    ?>