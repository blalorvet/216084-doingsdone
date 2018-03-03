<?php

$auth_errors = [];

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

                if (password_verify($form['password'], $user['password'])) {
                    $_SESSION['user'] = $user;

                } else {

                    $auth_errors['password'] = 'Неверный пароль';
                }

            } else {
                $auth_errors['email'] = 'Такой пользователь не найден';
                $layout_way_to_page = 'templates/guest.php';
                print('<br>');

            }

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
//}
//else {
//    if (isset($_SESSION['user'])) {
//
//        $layout_way_to_page = 'templates/layout.php';
//    } else {
//        $layout_way_to_page = 'templates/guest.php';
//
//    }