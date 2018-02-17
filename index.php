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

$test_error = 'ошибки грузим';
$test_not_error = 'ошибки не загружаем';


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

        }
        else{
            $task_fields[$key] = $_POST[$key];
//
            
        }
    }
    print('$_POST --');
    print_r( $_POST);
    print('<br>');

    print( '$_POST add_task --');
print_r( $_POST['add_task']);
    print('<br>');

    print( 'POST key --');
    print_r( $_POST[$key]);
    print('<br>');

    print( 'task_fields --');
    print_r( $task_fields[$key]);
}


// Проверяем есть ли в строке запрос add_task и если есть то показываем попап
if (isset($_GET['add_task']) || (count($errors))) {
    $popap_add_task = render('templates/form_task.php', [
        'errors' => $errors,
        'categories' => $categories,
        'task_fields' => $task_fields
    ]);
}



////        Проверим, был ли загружен файл. Поле для загрузки файла в форме называется 'gif_img', поэтому нам следует искать в массиве $_FILES одноименный ключ. Если таковой найден, то мы можем получить имя загруженного файла
//        if (isset($_FILES['preview']['name'])) {
//            $tmp_name = $_FILES['preview']['tmp_name'];
//            $path = $_FILES['preview']['name'];
////            С помощью стандартной функции finfo_ можно получить информацию о типе файле
//            $finfo = finfo_open(FILEINFO_MIME_TYPE);
//            $file_type = finfo_file($finfo, $tmp_name);
////            Если тип загруженного файла не является Gif-анимацией, то добавляем новую ошибку в список ошибок валидации
//            if ($file_type !== "image/gif") {
//                $errors['file'] = 'Загрузите картинку в формате GIF';
//            }
////            Если файл соответствует ожидаемому типу, то мы копируем его в директорию где лежат все гифки, а также добавляем путь к загруженной гифки в массив $gif
//            else {
//                move_uploaded_file($tmp_name, 'uploads/' . $path);
//                $gif['path'] = $path;
//            }
//
//
//        }
////        Загрузка файла - обязательное условие успешной валидации формы. Поэтому если он не был загружен, добавляем ошибку
//        else {
//            $errors['file'] = 'Вы не загрузили файл';
//        }
////        Здесь мы проверяем длину массива с ошибками. Если он не пустой, значит были ошибки и мы должны показать их пользователю вместе с формой. Для этого подключаем шаблон формы и передаем туда массив, где будут заполненные поля, а также список ошибок


//    if (count($errors)) {
//        print('<br> если ошибки есть передаем массив в попап<br>');
//        $show_popap_add_task = render($popap_add_task, [
//            'errors' => $errors,
//            'categories' => $categories,
//            'test_error' => $test_error
//        ]);
//        print_r($errors);
//    }







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