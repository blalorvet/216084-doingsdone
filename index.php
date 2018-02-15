<?php

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$categories = ["Все", "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
$tasks = [];
$tasks[] = array(
    "task_name" => "Собеседование в IT компании",
    "task_date" => "01.06.2018",
    "task_category" => "Работа",
    "task_controls" => "Нет"
);
$tasks[] = array(
    "task_name" => "Выполнить тестовое задание",
    "task_date" => "25.05.2018",
    "task_category" => "Работа",
    "task_controls" => "Нет"
);
$tasks[] = array(
    "task_name" => "Сделать задание первого раздела",
    "task_date" => "21.04.2018",
    "task_category" => "Учеба",
    "task_controls" => "Да"
);
$tasks[] = array(
    "task_name" => "Встреча с другом",
    "task_date" => "22.04.2018",
    "task_category" => "Входящие",
    "task_controls" => "Нет"
);
$tasks[] = array(
    "task_name" => "Купить корм для кота",
    "task_date" => "11.02.2018",
    "task_category" => "Домашние дела",
    "task_controls" => "Нет"
);
$tasks[] = array(
    "task_name" => "Заказать пиццу",
    "task_date" => "Нет",
    "task_category" => "Домашние дела",
    "task_controls" => "Нет"
);


require_once('functions.php');// вызваем файл с функциями

$filtered_task = [];
$way_to_page = 'templates/index.php';


if (!isset($_GET['category'])) {  // вернет истину если нет параметра или параметр равен null, ноль, пустая строка или строка из нуля Тут если запрос пустой то выводим все задачи
     $filtered_task = $tasks;
} else {

    $category_get_id = (int)$_GET['category'];// приводим  к целому числу


    if ($categories[$category_get_id] === $categories[0]) { // Если равно нулю, то выводим все задачи
        $filtered_task = $tasks;

    }


    foreach ($tasks as $key => $task) {

        if (in_array($categories[$category_get_id], $categories) != 1) {
            $way_to_page = 'templates/error.php';
            break;
        }


        if ($task['task_category'] === $categories[$category_get_id]) {
            $filtered_task[] = $task;


        }
    }


}

// вызываем функцию render в первом аргументе указываем путь 'templates/index.php' во втором аргументе передаем массив с данными которые будут присутствовать в загружаемом шаблоне 'tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks

$page_content = render($way_to_page, [
    'tasks' => $filtered_task,
    'show_complete_tasks' => $show_complete_tasks
]);

//вызываем функцию render в первом аргументе указываем путь 'templates/layout.php' во втором аргументе передаем массив с данными и переменными, которые будут присутствовать в загружаемом шаблоне [    'content' => $page_content,     'categories' => $categories,    'title' => 'Дела в порядке',    'tasks' => $tasks]

$layout_content = render('templates/layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Дела в порядке',
    'tasks' => $tasks,
    'category_get_id' => $category_get_id

]);

print($layout_content);
// выводим весь собраныый контент на страницу из шаблонов


