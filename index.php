<?php

// показывать или нет выполненные задачи
//$show_complete_tasks = rand(0, 1);



$expire = strtotime("+30 days");
$path = "/";


if (isset($_GET['show_completed'])) {

    if (isset($_COOKIE['showcompl'])) {


        if ($_COOKIE['showcompl'] == 0) {
            $show_complete_tasks = '1';

        } else {
            $show_complete_tasks = '0';
        }
        setcookie("showcompl", $show_complete_tasks, $expire, $path);


    } else {
        setcookie("showcompl", $show_complete_tasks, $expire, $path);

    }

} else {

    if (isset($_COOKIE['showcompl'])) {
        $show_complete_tasks = $_COOKIE['showcompl'];

    }
//    $show_complete_tasks = 0;
//    setcookie("showcompl", $show_complete_tasks, $expire, $path);
}

print("<h1>$show_complete_tasks</h1>");



//Массив с категориями
$categories = ["Все", "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
//
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

$test_error = 'ошибки грузим';
$test_not_error = 'ошибки не загружаем';
$add_new_task = [];
$add_task = null;
$path = [];

$popap_add_task = '';
$errors = [];
$task_fields = [];


// Из запроса POST забираем обязательные для заполнения поля
if (isset($_POST['add_task'])) {

    $required = ['name', 'project'];
//В цикле проверяем заполнены поля или нет, елси не заполнены то передаем значение не заполненного поля в масси Errors
    foreach ($required as $key) {

        if (empty($_POST[$key])) {

            $errors[$key] = 'Это поле надо заполнить';

        } else {
            $task_fields[$key] = $_POST[$key];


        }

    }
    if (empty($errors)) {

        array_unshift($tasks, array(// добавляем новую задачу в начало массива задачь
                "task_name" => $_POST['name'],
                "task_date" => $_POST['date'],
                "task_category" => $_POST['project']
            )
        );

        if (isset($_FILES['preview']['name'])) { // Загрузка файла в корневую дирректорию

            $path = $_FILES['preview']['name'];
            $res = move_uploaded_file($_FILES['preview']['tmp_name'], '' . $path);

        }


    }


}


// Проверяем есть ли в строке запрос add_task и если есть то показываем попап
if (isset($_GET['add_task']) || (count($errors))) {
    $popap_add_task = render('templates/form_task.php', [
        'errors' => $errors,
        'categories' => $categories,
        'task_fields' => $task_fields
    ]);
}


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
$show_popap_add_task = render($popap_add_task, [

    'errors' => $errors,
    'categories' => $categories,
    'show_complete_tasks' => $show_complete_tasks,
    'test_not_error' => $test_not_error
]);


$page_content = render($way_to_page, [

    'tasks' => $filtered_task,
    'show_complete_tasks' => $show_complete_tasks

]);

//вызываем функцию render в первом аргументе указываем путь 'templates/layout.php' во втором аргументе передаем массив с данными и переменными, которые будут присутствовать в загружаемом шаблоне [    'content' => $page_content,     'categories' => $categories,    'title' => 'Дела в порядке',    'tasks' => $tasks]
$layout_content = render('templates/layout.php', [

    'body_overlay_class' => isset($_GET['add_task']) || (count($errors)) ? "overlay" : "",
    'popap_add_task' => $popap_add_task,
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Дела в порядке',
    'tasks' => $tasks,
    'category_get_id' => $category_get_id

]);
// выводим весь собраныый контент на страницу из шаблонов
print($layout_content);