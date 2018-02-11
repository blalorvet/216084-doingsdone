<?php

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$categories = ["Все", "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
$tasks[] = array("task_name" => "Собеседование в IT компании", "task_date" => "01.06.2018", "task_category" => "Работа", "task_controls" => "Нет");
$tasks[] = array("task_name" => "Выполнить тестовое задание", "task_date" => "25.05.2018", "task_category" => "Работа", "task_controls" => "Нет");
$tasks[] = array("task_name" => "Сделать задание первого раздела", "task_date" => "21.04.2018", "task_category" => "Учеба", "task_controls" => "Да");
$tasks[] = array("task_name" => "Встреча с другом", "task_date" => "22.04.2018", "task_category" => "Входящие", "task_controls" => "Нет");
$tasks[] = array("task_name" => "Купить корм для кота", "task_date" => "11.02.2018", "task_category" => "Домашние дела", "task_controls" => "Нет");
$tasks[] = array("task_name" => "Заказать пиццу", "task_date" => "Нет", "task_category" => "Домашние дела", "task_controls" => "Нет");


require_once('functions.php');// вызваем файл с функциями

$page_content = render('templates/index.php', ['tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);// вызываем функцию render в первом аргументе указываем путь 'templates/index.php' во втором аргументе передаем массив с данными которые будут присутствовать в загружаемом шаблоне 'tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks

$layout_content = render('templates/layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Дела в порядке',
    'tasks' => $tasks
//вызываем функцию render в первом аргументе указываем путь 'templates/layout.php' во втором аргументе передаем массив с данными и переменными, которые будут присутствовать в загружаемом шаблоне [    'content' => $page_content,     'categories' => $categories,    'title' => 'Дела в порядке',    'tasks' => $tasks]

]);

print($layout_content); // выводим весь собраныый контент на страницу из шаблонов
