<?php
//Проект немного не закончен, можно проверять, все правки будут залиты после первой проверки


session_start(); // старт сессии
require_once('database.php');// файл для подключения БД
require_once('functions.php');// вызваем файл с функциями
require_once('mysql_helper.php');// файл для подключения БД


//Значения переменных по умолчанию
$layout_way_to_page = '';
$popap_add_task = '';
$filtered_task = [];
$way_to_page = 'templates/index.php';
$add_new_task = [];
$add_task = null;
$path = [];
$show_complete_tasks = '0';
$errors = [];
$cat_errors = [];
$tasks = [];
$task_fields = [];
$form = [];
$auth_form = '';
$user_first_name ='';
$show_popap_add_task = [];
$categories [] = array("id" => 0,
    "name" => "Все"  );
$user_sesion = [];
$auth_errors = [];
$reg_errors = [];
$category_get_id = 0;
$category_user_id =[];
$category_user_name =[];


//Форма авторизации - проверка на пустые поля, наличие почты и правильный пароль
if (isset($_POST['auth_form'])) {
    include_once 'auth_controller.php';
}



//проверяем существование сессии с пользователем. Сессия есть - значит пользователь залогинен и ему можно показать страницу приветствия. Сессии нет - показываем форму для входа на сайт.
if (isset($_SESSION['user'])) {
    $user_sesion = ($_SESSION['user']);

    $user_first_name = $user_sesion['first_name'];
    $categories = array_merge ($categories, searchUserCategories($user_sesion['id'], $db_connect ));
    $tasks = searchUserTasks ($user_sesion['id'], $db_connect );
    foreach($categories as $category){
        $category_user_id [] = $category['id'];
        $category_user_name[] = $category['name'];
    }

    $layout_way_to_page = 'templates/layout.php';

} else {
    $layout_way_to_page = 'templates/guest.php';

}



//Форма РЕГИСТРАЦИИ - проверка на пустые поля, наличие почты и правильный пароль
if (isset($_POST['reg_form'])) {
    include_once 'registration_controller.php';

}

//Добавление новой задачи  - Из запроса POST забираем обязательные для заполнения поля
if (isset($_POST['add_task'])) {
    include_once 'add_task_controller.php';
}

//Добавление новой КАТЕГОРИИ  - Из запроса POST забираем обязательные для заполнения поля
if (isset($_POST['add_category'])) {
    include_once 'add_category_controller.php';
}



// Добавляем куки чтобы отслеживать стоит галочка для отображения выполненных задач
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
        $show_complete_tasks = '1';
        setcookie("showcompl", $show_complete_tasks, $expire, $path);
    }
} else {
    if (($_COOKIE['showcompl'])) {
        $show_complete_tasks = $_COOKIE['showcompl'];

    }

}




// Аутентификации - Проверяем есть ли в строке запрос enter и если есть то показываем попап
if (isset($_GET['enter'])) {
    if (isset($_SESSION['user'])) {
        $layout_way_to_page = 'templates/layout.php';
    } else {
        $popap_add_task = render('templates/auth_form.php', [
            'auth_errors' => $auth_errors,
            'categories' => $categories,
            'task_fields' => $task_fields,
            'form' => $form
        ]);
    }

}

$path = "/";
if (isset($_GET['logout'])) {

    include_once 'templates/logout.php';

}


//Проверяем есть ли в строке запрос registration и если есть то показываем форму регистрации
if (isset($_GET['registration'])) {
    if (isset($_SESSION['user'])) {
        $layout_way_to_page = 'templates/layout.php';
    } else {

        $popap_add_task = render('templates/registration.php', [
            'reg_errors' => $reg_errors,
            'categories' => $categories,
            'task_fields' => $task_fields,
            'form' => $form
        ]);
    }

}


$sql = "";
$test = 'OK';






//Добавление новой КАТЕГОРИИИ  - Проверяем есть ли в строке запрос  и если есть то показываем попап, передаем ошибки если они есть, список возможных категорий и
if (isset($_GET['add_category']) || (count($errors))) {
    if (!isset($_SESSION['user'])) {
        $layout_way_to_page = 'templates/guest.php';

    } else {
        $popap_add_task = render('templates/add_category.php', [
            '$cat_errors' => $cat_errors
        ]);
    }

}





//Добавление новой задачи  - Проверяем есть ли в строке запрос add_task и если есть то показываем попап, передаем ошибки если они есть, список возможных категорий и
if (isset($_GET['add_task']) || (count($errors))) {
    if (!isset($_SESSION['user'])) {
        $layout_way_to_page = 'templates/guest.php';

    } else {
        $popap_add_task = render('templates/add_task.php', [
            'errors' => $errors,
            'categories' => $categories,
            'task_fields' => $task_fields
        ]);
    }

}








//Вывод задач в соответствии с выбранным проектом(категорией)
if (!isset($_GET['category'])) {  // вернет истину если нет параметра или параметр равен null, ноль, пустая строка или строка из нуля Тут если запрос пустой то выводим все задачи
    $filtered_task = $tasks;
} else {
    $category_get_id = (int)$_GET['category'];// приводим  к целому числу



    if ($categories[$category_get_id] === $categories[0]) { // Если равно нулю, то выводим все задачи
        $filtered_task = $tasks;
    }

    foreach ($tasks as $key => $task) {

        if (in_array($category_get_id, $category_user_id) != true) {

            $way_to_page = 'templates/error.php';
            break;
        }

            if ($task['task_category'] === $category_get_id) {
            $filtered_task[] = $task;


        }
    }


}


//$show_popap_add_task = render($popap_add_task, [
//    'errors' => $errors,
//    'categories' => $categories,
//    'show_complete_tasks' => $show_complete_tasks
//
//]);

// вызываем функцию render в первом аргументе указываем путь 'templates/index.php' во втором аргументе передаем массив с данными которые будут присутствовать в загружаемом шаблоне 'tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks
$page_content = render($way_to_page, [

    'tasks' => $filtered_task,
    'show_complete_tasks' => $show_complete_tasks

]);

//вызываем функцию render в первом аргументе указываем путь 'templates/layout.php' во втором аргументе передаем массив с данными и переменными, которые будут присутствовать в загружаемом шаблоне [    'content' => $page_content,     'categories' => $categories,    'title' => 'Дела в порядке',    'tasks' => $tasks]
//$layout_content = render('templates/layout.php', [
$layout_content = render($layout_way_to_page, [

    'body_overlay_class' => isset($_GET['add_task']) || (count($errors)) ? "overlay" : "",
    'body_overlay_class_guest' => isset($_GET['enter']) || (count($reg_errors)) ? "overlay" : "",
    'body_overlay_class_reg' => isset($_GET['registration']) || (count($auth_errors)) ? "overlay" : "",
    'body_overlay_class_add_category' => isset($_GET['add_category']) || (count($cat_errors)) ? "overlay" : "",
    'popap_add_task' => $popap_add_task,
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Дела в порядке',
    'tasks' => $tasks,
    'category_get_id' => $category_get_id,
    'user_first_name' => $user_first_name

]);
// выводим весь собраныый контент на страницу из шаблонов
print($layout_content);