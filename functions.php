<?php
/**
 * @param $template_path string - путь до файла
 * @param $template_data string - переменная в которую мы будем отправлять страницу
 * @return string - возвращает содержимое буфера
 */
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



/**
 * @param $template_path string - путь до файла
 * @param $template_data string - переменная в которую мы будем отправлять страницу
 * @return string - возвращает содержимое буфера
 */



//Функция для поиска e-mail пользователя в масиве
function searchUserByEmail($email, $connect){


    $result = null;
    $search_email='';
    $sql = "SELECT * FROM users WHERE email ='$email'";
    $result = (mysqli_query($connect, $sql));

    if ($result) {
        print('<br>03');
        $test_email = mysqli_fetch_all($result, MYSQLI_ASSOC);
        print_r($test_email);
    }
    else {
        print('<br>04');
       $error = mysqli_error($connect);
        print($error);

    }

    return $result;

}

//function search_user_by_email($db_connect, $email) {
//    $sql_query = "SELECT `email`, `password`, `name` FROM `users` WHERE `email` = ?";
//    $statement = mysqli_prepare($db_connect, $sql_query);
//    mysqli_stmt_bind_param($statement, "s", $email);
//    $execute = mysqli_stmt_execute($statement);
//    if (!$execute) {
//        print(mysqli_error($db_connect));
//        exit;
//    }
//    $result = mysqli_stmt_get_result($statement);
//    return mysqli_fetch_assoc($result);
//}








//    foreach ($users as $user) {
//        if ($user['email'] == $email) {
//            $result = $user;
//            break;
//
//        }
//    }






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


//function add_new_task_top()