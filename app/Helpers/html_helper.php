<?php

// app/Helpers/html_helper.php # https://developerhowto.com/2022/12/27/create-a-codeigniter-4-application/




// См.также Класс таблицы HTML
// https://codeigniter.com/user_guide/outgoing/table.html#html-table-class



// расширяем HTML Helper (создание ), добавляя функции для создания HTML-таблиц на основе результатов базы данных (массива строк)

// Теперь мы можем использовать эти вспомогательные функции для изменения Userконтроллера ( app/Controllers/User.php) и возврата таблицы HTML вместо данных JSON:
// <?php
// namespace AppControllers;
// use AppControllersBaseController;
// class Users extends BaseController
// {
//     protected $helpers = ['html'];
//     public function index()
//     {
//         $model = new AppModelsUsers();
//         $items = $model->findAll();
//         return view('users/index',[
//             "items"=>$items
//         ]);
//     }
// }


/**
 * Generate HTML attributes from array
 */
function htmlAttributes($attrs=[]){ 
    $content = [];
    foreach($attrs as $attr=>$value){
        $content[] = "$attr=\"$value\"";
    }
    return implode(' ',$content);
}

/**
 * Generate HTML table cell (td or th)
 */
function htmlCell($cell,$cellTag="td"){
    return "<$cellTag>$cell</$cellTag>";
}

/**
 * Generate HTML table row (tr)
 */
function htmlRow($row,$cellTag="td"){
    if (!$row) return "";
    $cols = [];
    foreach($row as $col){
        $cols[] = htmlCell($col,$cellTag);
    }
    $content = implode("n",$cols);
    $template = "<tr>
        $content
    </tr>";
    return $template;
}

/**
 * Generate HTML table
 * @param array $columns Custom column names
 * @param array $attrs HTML Table attributes
 */
if(!function_exists('htmlTable')) {
    function htmlTable($data, $columns=null, $attrs=[]){
        if (!$columns){
            $columns = array_keys($data[0]);
        }
        $thead = htmlRow($columns,"th");
        $rows = [];
        foreach($data as $row){
            $rows[] = htmlRow($row);
        }
        $tbody = implode("n",$rows);
        $attrs = htmlAttributes($attrs);
        $template = "<table $attrs>
            <thead>$thead</thead>
            <tbody>$tbody</tbody>
        </table>";
        return $template;
    }
}