<?php
session_start(); // старт сессии
require_once('userdata.php');// вызваем файл с массивом e-mail адресов и хэшей пароля пользователей
require_once('functions.php');// вызваем файл с функциями
require_once('database.php');// файл для подключения БД
require_once('mysql_helper.php');// файл для подключения БД
print_r($db_error);


//Массив с проекамаи(категориями)
$categories = ["Все", "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
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
$task_fields = [];
$form = [];
$auth_form = '';
$show_popap_add_task = [];
$auth_errors = [];
$reg_errors = [];
$category_get_id = 0;


//$show_complete_tasks = rand(0, 1);// показывать или нет выполненные задачи


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


//Форма авторизации - проверка на пустые поля, наличие почты и правильный пароль
if (isset($_POST['auth_form'])) {
    $form = $_POST;
    $required = ['email', 'password'];
    foreach ($required as $field) {
        if (empty($form[$field])) {
            $auth_errors[$field] = 'Это поле надо заполнить';

        }

    }


//Если в $auth_errors ошибок нет, то подключаемся к базе
    if (!count($auth_errors)) {

        $email_check = $form  ['email'];


        if ($user = searchUserByEmail($form['email'], $db_connect)) {



//                if (password_verify($form['password'], $user['password'])) {
//                    $_SESSION['user'] = $user;
//
//                } else {
//
//                    $auth_errors['password'] = 'Неверный пароль';
//                }
//
//            } else {
//                $auth_errors['email'] = 'Такой пользователь не найден';

        }


//            if ($user = searchUserByEmail($form['email'], $link)) {
//
//                Print($result);
//
//                if (password_verify($form['password'], $user['password'])) {
//                    $_SESSION['user'] = $user;
//
//                } else {
//
//                    $auth_errors['password'] = 'Неверный пароль';
//                }
////
//            } else {
//                $auth_errors['email'] = 'Такой пользователь не найден';

//            }


//        }


    }


    if (count($auth_errors)) {

        $layout_way_to_page = 'templates/guest.php';
        $popap_add_task = render('templates/auth_form.php',
            ['form' => $form, 'auth_errors' => $auth_errors, 'users' => $users]);
    } else {

//        header("Location: /index.php");
        $layout_way_to_page = 'templates/layout.php';

//        exit();
    }
//    Если форма не была отправлена, то проверяем существование сессии с пользователем. Сессия есть - значит пользователь залогинен и ему можно показать страницу приветствия. Сессии нет - показываем форму для входа на сайт.
} else {
    if (isset($_SESSION['user'])) {

        $layout_way_to_page = 'templates/layout.php';
    } else {
        $layout_way_to_page = 'templates/guest.php';

    }
}


// Аутентификации - Проверяем есть ли в строке запрос enter и если есть то показываем попап
//if (isset($_GET['enter']) || (count($errors))) {
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
    session_unset();
    $layout_way_to_page = 'templates/logout.php';

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
//Форма РЕГИСТРАЦИИ - проверка на пустые поля, наличие почты и правильный пароль
if (isset($_POST['reg_form'])) {
    $form = $_POST;
    $required = ['reg_email', 'reg_password', 'reg_name'];

    foreach ($required as $field) {
        if (empty($form[$field])) {
            $reg_errors[$field] = 'Это поле надо заполнить';

        }

    }
//    Проверка валидности e-mail адреса
    if (!(filter_var($form['reg_email'], FILTER_VALIDATE_EMAIL))) {
        $reg_errors['reg_email'] = "Введен некорректный e-mail адрес";
    }
//Если ошибок нет, то передаем данные полей в переменные
    if (!count($reg_errors)) {
        print(count($reg_errors));
        print('<br>');

        $db_reg_email = $form['reg_email'];
        $form['reg_password'] = password_hash($form['reg_password'], PASSWORD_DEFAULT); // Хэшированние пароля
        $db_reg_name = $form['reg_name'];
        $db_reg_data = '2018-02-23T11:30:00';
        $form['reg_data'] = $db_reg_data;
        print_r($form);
        print('<br>');print($form['reg_email']);
        print('<br>');print($form['reg_password']);
        print('<br>');print($form['reg_name']);
        print('<br>');print($form['reg_data']);


        $sql = "INSERT INTO users (email,  password, first_name, date_reg) VALUE (NOW(),?,?,?,?)";
        $stmt = db_get_prepare_stmt($db_error, $sql, [$form['reg_email'], $form['reg_password'], $form['reg_name'], $form['reg_data']]);
        $res = mysqli_stmt_execute($stmt);


        if ($res) {

            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db_connect);
        }


//ПОДКЛЮЧЕНИЕ К БД и проверка подключения
//        $sql = "INSERT INTO users (email,  password, first_name, date_reg)
//VALUE ('$db_reg_email', '$db_reg_password', '$db_reg_name', '$db_reg_data')";
//        if (mysqli_query($link, $sql)) {
//
//            echo "New record created successfully";
//        } else {
//            echo "Error: " . $sql . "<br>" . mysqli_error($link);
//        }


    }


    if (count($reg_errors)) {

        $layout_way_to_page = 'templates/guest.php';
        $popap_add_task = render('templates/registration.php',
            ['form' => $form, 'reg_errors' => $reg_errors, 'users' => $users]);
    } else {

//        header("Location: /index.php");
        $auth_errors = "error";
        $layout_way_to_page = 'templates/guest.php';
        $popap_add_task = render('templates/auth_form.php', [
            'auth_errors' => $auth_errors,
            'categories' => $categories,
            'task_fields' => $task_fields,
            'form' => $form
        ]);

//        exit();
    }
}


//Массив с задачами
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


//Добавление новой задачи  - Из запроса POST забираем обязательные для заполнения поля
if (isset($_POST['add_task'])) {

    $required = ['add_task_name', 'project'];
//В цикле проверяем заполнены поля или нет, если не заполнены то передаем значение не заполненного поля в масси Errors
    foreach ($required as $key) {

        if (empty($_POST[$key])) {

            $errors[$key] = 'Это поле надо заполнить';

        } else {

            $task_fields[$key] = $_POST[$key];

        }
    }
    if (empty($errors)) {

        array_unshift($tasks, array(// добавляем новую задачу в начало массива задачь
                "task_name" => $_POST['add_task_name'],
                "task_date" => $_POST['date'],
                "task_category" => $_POST['project']
            )
        );

        if (isset($_FILES['preview']['add_task_name'])) { // Загрузка файла в корневую дирректорию

            $path = $_FILES['preview']['add_task_name'];
            $res = move_uploaded_file($_FILES['preview']['tmp_name'], '' . $path);

        }
    }
}

//Добавление новой задачи  - Проверяем есть ли в строке запрос add_task и если есть то показываем попап, передаем ошибки если они есть, список возможных категорий и
if (isset($_GET['add_task']) || (count($errors))) {
    if (!isset($_SESSION['user'])) {
        $layout_way_to_page = 'templates/guest.php';

    } else {
        $popap_add_task = render('templates/form_task.php', [
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
        if (in_array($categories[$category_get_id], $categories) != 1) {
            $way_to_page = 'templates/error.php';
            break;
        }

        if ($task['task_category'] === $categories[$category_get_id]) {
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
    'popap_add_task' => $popap_add_task,
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Дела в порядке',
    'tasks' => $tasks,
    'category_get_id' => $category_get_id,
    'test_email' => $test_email

]);
// выводим весь собраныый контент на страницу из шаблонов
print($layout_content);