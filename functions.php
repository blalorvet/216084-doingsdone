<?php
include_once('mysql_helper.php');
/**
 * @param $template_path string - путь до файла
 * @param $template_data string - переменная в которую мы будем отправлять страницу
 * @return string - возвращает содержимое буфера
 */
function render(
    $template_path,
    $template_data
) // функция render с двумя аргументами - $template_path путь до файла, $template_data - переменная в которую мы будем отправлять страницу
{
    if (!file_exists($template_path)) { // осуществляем проверку для $template_path существует ли такой файл, если нет возвращаем пустую строчку ""
        return "";
    }
    extract($template_data); //если файл существует то с помощью функции extract - превращаем ассоциации массива в переменные
    ob_start(); // осуществляем буферизацию
    include_once $template_path; // путь к файлу буферизации
    return ob_get_clean();// возвращем содержимое буфера

}


/**
 * @param $template_path string - путь до файла
 * @param $template_data string - переменная в которую мы будем отправлять страницу
 * @return string - возвращает содержимое буфера
 */












//Функция для поиска e-mail пользователя в БД
function searchUserByEmail($email, $db_connect){
    $users =[];
  $sql = "SELECT * FROM users WHERE email = ?";
    $res = mysqli_prepare($db_connect, $sql);
    $stmt = db_get_prepare_stmt($db_connect, $sql, [$email]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
//    $users = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $users = mysqli_fetch_assoc($res);
//
//    $sql = "SELECT * FROM users WHERE email = '$email'";
//    $result_1 = mysqli_query($db_connect, $sql);
//    $users_1 = mysqli_fetch_assoc($result_1);

//   var_dump($result);
//    print('<br> $users_1 = ');
//
//    print('<br> $users = ');
//    var_dump($users);
    return $users;
}

function searchUserCategories($id_user, $db_connect){
    $categories= [];
    $sql = "SELECT * FROM categories WHERE user_id = ?";
    $res = mysqli_prepare($db_connect, $sql);
    $stmt = db_get_prepare_stmt($db_connect, $sql, [$id_user]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $name_categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
//    $name_categories = mysqli_fetch_assoc($res);
    foreach ($name_categories as $key =>  $item) {
        $categories[] = $item;
    
//    foreach ($name_categories as  $item) {
//        $categories[$item['id']] = $item['name'];

    }
//    var_dump($categories);
//    print('<br> $categories = ');
//    print_r($categories);
    return $categories;
}
//(name AS task_name, deadline AS task_date,  category_id AS task_category, date_end AS task_controls, )
//Функция поиска задач пользователя
function searchUserTasks($id_user, $db_connect){
    $tasks= [];
    $sql = "SELECT name AS task_name, deadline AS task_date,  category_id AS task_category, date_end AS task_controls FROM tasks WHERE user_id = ?";
    $res = mysqli_prepare($db_connect, $sql);
    $stmt = db_get_prepare_stmt($db_connect, $sql, [$id_user]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $name_tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
//    $name_categories = mysqli_fetch_assoc($res);
    foreach ($name_tasks as $key =>  $item) {
        $tasks[] = $item;
//        $tasks = $item;
    }

    return $tasks;
}

//Функция вывода категорий для пользователя
//function  list_categories ( $user_id,  $array_categories) {
//
//
//    $user_category=[];
//    foreach ($array_categories as $category);{
//        $user_category[]= $category['$user_id'];
//    }
//
//    return $user_category;
//
//}


/**
 * функция подсчитывае общее количество задачь
 * @param $massif_fun - в  эту переменную отправляется массив
 * @param $category_fun - в эту переменную отправляется ключ массива
 * @return int - возвращает обшее количество задачь
 */
function calc_category($massif_fun, $category_fun)
{
    $sum_fun = 0;
    if ($category_fun === 0) {
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


/**
 * Функция подсчета разницы между текущей датой и датой задачи
 * @param $task_data_calc string дата в формате d.m.Y
 * @return string возвращает название класса важной задачи task--important или пустую строку
 */
function get_important_task_class_name($task_data_calc)
{
    $result = "";
    if (!($task_date_calc = strtotime($task_data_calc)) === false) {
        $task_data = (strtotime($task_data_calc));
        $cur_data = (strtotime("now"));

        if ((($task_data - $cur_data) / 86400) <= 1) {

            $result = 'task--important';


        }

    }
    return $result;
}

