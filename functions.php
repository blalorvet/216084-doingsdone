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


//Функция для поиска e-mail пользователя в масиве

function searchUserByEmail($email, $db_connect){

    var_dump($email);
    print('<br>');


    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = db_get_prepare_stmt($db_connect, $sql, [$email]);
    var_dump($stmt);
    $result = mysqli_query($db_connect, $stmt);
    $users = mysqli_fetch_array($result);
//    $sql = "SELECT * FROM users WHERE email = '$email'";
//    $result = mysqli_query($db_connect, $sql);
//    $users = mysqli_fetch_array($result);




//   var_dump($result);
    print('<br>');
    var_dump($users);

}

//
//function searchUserByEmail($link, $email) {
//    $sql = "SELECT * FROM users WHERE email = '".$email."'";
//    $result = mysqli_query($link, $sql);
//    $user = mysqli_fetch_assoc($result);
//    return $user;
//    var_dump($user);
//}


//function searchUserByEmail($email,$link) {
//    $user = null;
//    $sql = "SELECT * FROM users WHERE email = '$email'";
//    $result = mysqli_query($link, $sql);
//    if ($result) {
//        $user = mysqli_fetch_assoc($result);
//    }
//    return $user;
//    var_dump($result);
// var_dump($resu);
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

