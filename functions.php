<?php

function render($template_path, $template_data) // функция render с двумя аргументами - $template_path путь до файла, $template_data - переменная в которую мы будем отправлять страницу
{
    if (!file_exists($template_path)) { // осуществляем проверку для $template_path существует ли такой файл, если нет возвращаем пустую строчку ""
        return "";
    }
    extract($template_data); //если файл существует то с помощью функции extract - превращаем ассоциации массива в переменные
    ob_start(); // осуществляем буферизацию
    include_once $template_path; // путь к файлу буферизации
    return ob_get_clean();// возвращем содержимое буфера


}


function calc_category($massif_fun, $category_fun)

{
    $sum_fun = 0;
    if ($category_fun === "Все") {
        $sum_fun = count($massif_fun);
    } else {
        foreach ($massif_fun as $key => $item) {
            if ($item['task_category'] === $category_fun) {
                $sum_fun++;
            }
        }
    }
    return $sum_fun;
}

//функция фильтрации входящих данных
function html_sc($str)
{
    $text = htmlspecialchars($str);
    //$text = strip_tags($str);

    return $text;
}

//Функция подсчета разницы между текущей датой и датой задачи
function data_calc($task_data_calc)
{
    if (!($task_date_calc = strtotime($task_data_calc)) === false) {
        $task_data_floor = floor(strtotime($task_data_calc));
        $cur_data = floor(strtotime(date('d.m.y.')));

        if ((($task_data_floor - $cur_data) / 86400) <= 1) {

            return 'task--important';


        }
    }
}